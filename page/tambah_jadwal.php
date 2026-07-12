<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Jadwal Baru</h1>
            </div>
        </div>
    </div>
</div>

<?php
// =========================================================
// 1. KODE JADWAL OTOMATIS (J-001, J-002, dst)
// =========================================================
$carikode = mysqli_query($koneksi, "SELECT MAX(kd_jadwal) FROM jadwal") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if ($datakode && $datakode[0] != null) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "J-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "J-001";
}

// =========================================================
// 2. PROSES SIMPAN DATA JADWAL (UTAMA & DETAIL)
// =========================================================
if (isset($_POST['tambah'])) {
    $kd_jadwal    = $_POST['kd_jadwal'];
    $kd_guru      = $_POST['kd_guru']; 
    $semester     = $_POST['semester'];
    $tahun_ajaran = $_POST['tahun_ajaran'];

    $insertjadwal = mysqli_query($koneksi, "INSERT INTO jadwal (kd_jadwal, nm_guru, semester, tahun_ajaran) VALUES ('$kd_jadwal', '$kd_guru', '$semester', '$tahun_ajaran')");

    if ($insertjadwal) {
        $kd_mapel = $_POST['kd_mapel'];
        $hari     = $_POST['hari'];
        $jam      = $_POST['jam'];
        $kelas    = $_POST['kelas']; 

        $total = count($kd_mapel);
        $allSuccess = true;

        for ($i = 0; $i < $total; $i++) {
            $insert_detail = mysqli_query($koneksi, "INSERT INTO detailjadwal (kd_jadwal, kd_mapel, kd_guru, hari, jam) VALUES ('$kd_jadwal', '$kd_mapel[$i]', '$kelas[$i]', '$hari[$i]', '$jam[$i]')");
            if (!$insert_detail) {
                $allSuccess = false;
            }
        }

        if ($allSuccess) {
            echo '<div class="alert alert-success">Jadwal Berhasil Disimpan Secara Otomatis!</div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
        } else {
            echo '<div class="alert alert-warning">Jadwal utama tersimpan, namun beberapa baris detail gagal dimasukkan.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Gagal insert ke tabel jadwal: ' . mysqli_error($koneksi) . '</div>';
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Jadwal (Otomatis)</label>
                                <input type="text" name="kd_jadwal" value="<?= $hasilkode; ?>" class="form-control" readonly style="background-color: #e9ecef;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Guru / Wali Kelas</label>
                                <select name="kd_guru" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Guru --</option>
                                    <?php
                                    $guru = mysqli_query($koneksi, "SELECT * FROM guru");
                                    while ($g = mysqli_fetch_array($guru)) {
                                        echo "<option value='".$g['kd_guru']."'>".$g['nm_guru']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Semester</label>
                                <select name="semester" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Semester --</option>
                                    <option>Ganjil</option>
                                    <option>Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <select name="tahun_ajaran" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih TA --</option>
                                    <option>2024-2025</option>
                                    <option>2025-2026</option>
                                    <option>2026-2027</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="text-secondary mb-3">Komponen Baris Pelajaran</h5>
                    
                    <div id="wadah-baris">
                        
                        <div class="row mb-3 item-jadwal">
                            <div class="col-md-3">
                                <label class="small text-muted">Mata Pelajaran</label>
                                <select name="kd_mapel[]" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Mapel --</option>
                                    <?php
                                    $mapel = mysqli_query($koneksi, "SELECT * FROM mapel");
                                    while ($m = mysqli_fetch_array($mapel)) {
                                        echo "<option value='".$m['kd_mapel']."'>".$m['nm_mapel']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted">Pilih Kelas</label>
                                <select name="kelas[]" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Kelas --</option>
                                    <?php
                                    $kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                                    while ($k = mysqli_fetch_array($kelas)) {
                                        echo "<option value='".$k['nm_kelas']."'>".$k['nm_kelas']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted">Hari</label>
                                <select name="hari[]" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Hari --</option>
                                    <option>Senin</option>
                                    <option>Selasa</option>
                                    <option>Rabu</option>
                                    <option>Kamis</option>
                                    <option>Jumat</option>
                                    <option>Sabtu</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted">Jam Pelajaran</label>
                                <select name="jam[]" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Jam --</option>
                                    <option>08.00-10.00</option>
                                    <option>10.30-12.00</option>
                                    <option>12.30-14.00</option>
                                </select>
                            </div>
                        </div>

                    </div> <div class="mt-2 mb-3">
                        <button type="button" class="btn btn-info btn-sm" onclick="tambahBaris()">+ Tambah Baris Mapel</button>
                    </div>
                    
                    <hr>
                    <input type="submit" class="btn btn-primary" name="tambah" value="Simpan Jadwal">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function tambahBaris() {
    // Ambil element murni wadah penampung baris
    let container = document.getElementById('wadah-baris');
    
    // Ambil baris pertama pelajaran
    let firstRow = container.firstElementChild;
    
    // Kloning baris murni pelajaran beserta data dropdown di dalamnya
    let newRow = firstRow.cloneNode(true);
    
    // Kembalikan semua dropdown di baris baru ke posisi default ("-- Pilih --")
    let selects = newRow.getElementsByTagName('select');
    for (let i = 0; i < selects.length; i++) {
        selects[i].selectedIndex = 0;
    }
    
    // Masukkan baris baru murni ke bagian bawah wadah
    container.appendChild(newRow);
}
</script>