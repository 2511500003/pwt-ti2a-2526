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
if (isset($_GET['action'])) {
    if ($_GET['action'] == "hapus") {
        $kd = $_GET['kd'];

        $query = mysqli_query($koneksi, "DELETE FROM ekstra_2511500003 WHERE id_ekstra003='$kd'");

        if ($query) {
            echo '
            <div class="alert alert-warning alert-dismissible">
                Berhasil Dihapus
            </div>';

            echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra_2511500003">';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <a href="index.php?page=tambah_ekstra2511500003" class="btn btn-primary btn-sm">
                    Tambah Ekstrakurikuler
                </a>

                <br><br>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Ekstrakurikuler</th>
                            <th>Nama Ekstrakurikuler</th>
                            <th>Keterangan</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM ekstra_2511500003");

                        while ($result = mysqli_fetch_array($query)) {
                        ?>

                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $result['id_ekstra003']; ?></td>
                            <td><?= $result['nama_ekstra003']; ?></td>
                            <td><?= $result['ket003']; ?></td>
                            <td><?= $result['semester003']; ?></td>
                            <td><?= $result['thn_ajaran003']; ?></td>
                            <td>
                                <a href="index.php?page=ekstra_2511500003&action=hapus&kd=<?= $result['id_ekstra003']; ?>">
                                    <span class="badge badge-danger">Hapus</span>
                                </a>

                                <a href="index.php?page=edit_ekstra2511500003&kd=<?= $result['id_ekstra003']; ?>">
                                    <span class="badge badge-warning">Edit</span>
                                </a>
                            </td>
                        </tr>

                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>