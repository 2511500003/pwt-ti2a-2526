<?php
// Proses Penyimpanan Data Form saat tombol dipos
if (isset($_POST['simpan_jadwal'])) {
    $kd_jadwal    = $_POST['kd_jadwal'];
    $id_kelas     = $_POST['id_kelas']; // Menyimpan Rombel Kelas ke nm_guru di tabel utama
    $semester     = $_POST['semester'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    
    $kd_mapel     = $_POST['kd_mapel'];
    $kd_guru      = $_POST['kd_guru'];
    $hari         = $_POST['hari'];
    $jam          = $_POST['jam'];

    // 1. Insert ke tabel utama 'jadwal'
    $insert_utama = mysqli_query($koneksi, "INSERT INTO jadwal (kd_jadwal, nm_guru, semester, tahun_ajaran) VALUES ('$kd_jadwal', '$id_kelas', '$semester', '$tahun_ajaran')");

    if ($insert_utama) {
        // 2. Insert ke tabel 'detail_jadwal'
        $insert_detail = mysqli_query($koneksi, "INSERT INTO detail_jadwal (kd_jadwal, kd_mapel, kd_guru, hari, jam) VALUES ('$kd_jadwal', '$kd_mapel', '$kd_guru', '$hari', '$jam')");
        
        if ($insert_detail) {
            echo "<div class='alert alert-success'>Jadwal Berhasil Disimpan Secara Otomatis!</div>";
            echo "<script>window.location='index.php?page=jadwal';</script>";
        } else {
            echo "<div class='alert alert-warning'>Jadwal utama tersimpan, namun beberapa baris detail gagal dimasukkan: " . mysqli_error($koneksi) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Gagal insert ke tabel jadwal: " . mysqli_error($koneksi) . "</div>";
    }
}

// Membuat otomatisasi Kode Jadwal Baru (Contoh: J-007)
$query_code = mysqli_query($koneksi, "SELECT max(kd_jadwal) as maxKode FROM jadwal");
$data_code  = mysqli_fetch_array($query_code);
$kodeBaru   = $data_code['maxKode'];
$noUrut     = (int) substr($kodeBaru, 2, 3);
$noUrut++;
$char       = "J-";
$kodeOtomatis = $char . sprintf("%03s", $noUrut);
?>

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0 text-dark">Tambah Jadwal Baru</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <form action="" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Jadwal (Otomatis)</label>
                                <input type="text" name="kd_jadwal" class="form-control" value="<?= $kodeOtomatis; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Semester</label>
                                <select name="semester" class="form-control" required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pilih Kelas (ID Kelas)</label>
                                <select name="id_kelas" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="9a">9a</option>
                                    <option value="9b">9b</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <select name="tahun_ajaran" class="form-control" required>
                                    <option value="">-- Pilih TA --</option>
                                    <option value="2024-2025">2024-2025</option>
                                    <option value="2025-2026">2025-2026</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5>Komponen Baris Pelajaran</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select name="kd_mapel" class="form-control" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    <?php
                                    $m = mysqli_query($koneksi, "SELECT * FROM mapel");
                                    while($rm = mysqli_fetch_array($m)){
                                        echo "<option value='".$rm['kd_mapel']."'>".$rm['nm_mapel']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Guru Pengampu</label>
                                <select name="kd_guru" class="form-control" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php
                                    $g = mysqli_query($koneksi, "SELECT * FROM guru");
                                    while($rg = mysqli_fetch_array($g)){
                                        echo "<option value='".$rg['kd_guru']."'>".$rg['nm_guru']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Hari</label>
                                <select name="hari" class="form-control" required>
                                    <option value="">-- Pilih Hari --</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Jam Pelajaran</label>
                                <select name="jam" class="form-control" required>
                                    <option value="">-- Pilih Jam --</option>
                                    <option value="07.30-09.00">07.30-09.00</option>
                                    <option value="09.00-10.30">09.00-10.30</option>
                                    <option value="10.30-12.00">10.30-12.00</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="simpan_jadwal" class="btn btn-success">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>