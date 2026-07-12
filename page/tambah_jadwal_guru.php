<?php
// Membuat otomatis kode jadwal berikutnya
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

// PROSES SIMPAN DATA (Hanya berjalan jika tombol submit benar-benar ditekan)
if (isset($_POST['simpan_jadwal_btn'])) {
    $kd_jadwal    = mysqli_real_escape_string($koneksi, $_POST['kd_jadwal']);
    $id_kelas     = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    $semester     = mysqli_real_escape_string($koneksi, $_POST['semester']);
    $tahun_ajaran = mysqli_real_escape_string($koneksi, $_POST['tahun_ajaran']);

    // Ambil data array komponen pelajaran
    $kd_mapel = isset($_POST['kd_mapel']) ? $_POST['kd_mapel'] : [];
    $kd_guru  = isset($_POST['kd_guru']) ? $_POST['kd_guru'] : [];
    $hari     = isset($_POST['hari']) ? $_POST['hari'] : [];
    $jam      = isset($_POST['jam']) ? $_POST['jam'] : [];

    // 1. Simpan ke tabel master: jadwal
    $insertjadwal = mysqli_query($koneksi, "INSERT INTO jadwal (kd_jadwal, id_kelas, semester, tahun_ajaran) VALUES ('$kd_jadwal', '$id_kelas', '$semester', '$tahun_ajaran')");

    if ($insertjadwal) {
        $allSuccess = true;

        // 2. Loop simpan ke tabel detail_jadwal
        for ($i = 0; $i < count($kd_mapel); $i++) {
            $mapel_id = mysqli_real_escape_string($koneksi, $kd_mapel[$i]);
            $guru_id  = mysqli_real_escape_string($koneksi, $kd_guru[$i]);
            $hri      = mysqli_real_escape_string($koneksi, $hari[$i]);
            $jm       = mysqli_real_escape_string($koneksi, $jam[$i]);

            $insert_detail = mysqli_query($koneksi, "INSERT INTO detail_jadwal (kd_jadwal, kd_mapel, kd_guru, hari, jam) VALUES ('$kd_jadwal', '$mapel_id', '$guru_id', '$hri', '$jm')");
            
            if (!$insert_detail) {
                $allSuccess = false;
                echo "<div class='alert alert-warning'>Gagal menyimpan baris pelajaran ke-" . ($i+1) . " : " . mysqli_error($koneksi) . "</div>";
            }
        }

        if ($allSuccess) {
            echo '<div class="alert alert-success">
                    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                    Data jadwal sukses disimpan sepenuhnya.
                  </div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>
                <h5><i class='icon fas fa-ban'></i> Gagal Menyimpan Master Jadwal!</h5>
                <strong>Pesan Error Database:</strong> " . mysqli_error($koneksi) . "
              </div>";
    }
}
?>

<div class="content">
    <div class="container-fluid pt-3">
        <div class="card">
            <div class="card-body">
                <h3>Tambah Jadwal Baru</h3>
                
                <form method="POST" action="">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Kode Jadwal</label>
                            <input type="text" name="kd_jadwal" value="<?= $hasilkode ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Pilih Kelas (ID Kelas)</label>
                            <select name="id_kelas" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Kelas --</option>
                                <?php
                                $kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                                while ($k = mysqli_fetch_assoc($kelas)) {
                                    echo "<option value='" . $k['id_kelas'] . "'>" . $k['id_kelas'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Semester</label>
                            <select name="semester" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Semester --</option>
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tahun Ajaran</label>
                            <select name="tahun_ajaran" class="form-control" required>
                                <option value="" selected disabled>-- Pilih TA --</option>
                                <option value="2024-2025">2024-2025</option>
                                <option value="2025-2026">2025-2026</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <h5>Komponen Baris Pelajaran</h5>
                    <div id="detail-jadwal">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <label>Mata Pelajaran</label>
                                <select name="kd_mapel[]" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Mapel --</option>
                                    <?php
                                    $mapel = mysqli_query($koneksi, "SELECT * FROM mapel");
                                    while ($m = mysqli_fetch_assoc($mapel)) {
                                        echo "<option value='" . $m['kd_mapel'] . "'>" . $m['nm_mapel'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Guru Pengampu</label>
                                <select name="kd_guru[]" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Guru --</option>
                                    <?php
                                    $guru = mysqli_query($koneksi, "SELECT * FROM guru");
                                    while ($g = mysqli_fetch_assoc($guru)) {
                                        echo "<option value='" . $g['kd_guru'] . "'>" . $g['nm_guru'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Hari</label>
                                <select name="hari[]" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Hari --</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Jam Pelajaran</label>
                                <select name="jam[]" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Jam --</option>
                                    <option value="08-10">08:00 - 10:00</option>
                                    <option value="10-12">10:30 - 12:00</option>
                                    <option value="12-14">12:30 - 14:00</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-info btn-sm mt-2 mb-4" onclick="tambahBaris()">+ Tambah Baris Mapel</button>
                    <br>
                    <button type="submit" name="simpan_jadwal_btn" class="btn btn-primary">Simpan Jadwal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function tambahBaris() {
    let container = document.getElementById('detail-jadwal');
    let row = container.firstElementChild.cloneNode(true);
    row.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
    container.appendChild(row);
}
</script>