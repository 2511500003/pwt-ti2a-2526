<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Kode otomatis
$carikode = mysqli_query($koneksi, "SELECT MAX(id_ekstra003) FROM ekstra_2511500003") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if ($datakode) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int)$nilaikode;
    $kode = $kode + 1;
    $hasilkode = "E-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "E-001";
}

$_SESSION["KODE"] = $hasilkode;

if (isset($_POST['tambah'])) {

    // Ambil data dari form
    $id_ekstra003 = $_POST['id_ekstra003'];
    $nama_ekstra003 = $_POST['nama_ekstra003'];
    $ket003 = $_POST['ket003'];
    $semester003 = $_POST['semester003'];
    $thn_ajaran003 = $_POST['thn_ajaran003'];

    // Simpan ke database
    $insert = mysqli_query($koneksi, "INSERT INTO ekstra_2511500003
    (id_ekstra003, nama_ekstra003, ket003, semester003, thn_ajaran003)
    VALUES
    ('$id_ekstra003','$nama_ekstra003','$ket003','$semester003','$thn_ajaran003')");

    if ($insert) {

        echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            Data Berhasil Disimpan.
        </div>';

        echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra_2511500003">';

    } else {

        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h5><i class="icon fas fa-times"></i> Gagal</h5>';
        echo mysqli_error($koneksi);
        echo '</div>';

    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-body p-2">

                    <form method="POST" action="">

                        <div class="form-group">
                            <label for="id_ekstra003">ID Ekstrakurikuler</label>
                            <input
                                type="text"
                                name="id_ekstra003"
                                id="id_ekstra003"
                                value="<?= $hasilkode; ?>"
                                class="form-control"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label for="nama_ekstra003">Nama Ekstrakurikuler</label>
                            <input
                                type="text"
                                name="nama_ekstra003"
                                id="nama_ekstra003"
                                class="form-control"
                                placeholder="Masukkan Nama Ekstrakurikuler"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="ket003">Keterangan</label>
                            <input
                                type="text"
                                name="ket003"
                                id="ket003"
                                class="form-control"
                                placeholder="Masukkan Keterangan"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="semester003">Semester</label>
                            <input
                                type="text"
                                name="semester003"
                                id="semester003"
                                class="form-control"
                                placeholder="Semester"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="thn_ajaran003">Tahun Ajaran</label>
                            <input
                                type="text"
                                name="thn_ajaran003"
                                id="thn_ajaran003"
                                class="form-control"
                                placeholder="2025/2026"
                                required>
                        </div>

                        <div class="card-footer">
                            <input
                                type="submit"
                                class="btn btn-primary"
                                name="tambah"
                                value="Simpan">
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</section>