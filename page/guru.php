<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data guru</h1>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_GET['action'])) {
    if ($_GET['action'] == "hapus") {
        $kd = $_GET['kd'];
        $query = mysqli_query($koneksi, "DELETE FROM guru where kd_guru = '$kd' ");
        if ($query) {
            echo '
            <div class="alert alert-warning alert-dismissible">
                Berhasil Di Hapus
            </div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=guru">';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <a href="index.php?page=tambah_guru" class="btn btn-primary btn-sm">
                Tambah guru
            </a>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Kd guru</th>
                        <th>Nama guru</th>
                        <th>jenis kelamin</th>
                        <th>pendidikan terakhir</th>
                        <th>hp</th>
                        <th>alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 0;
                    $query = mysqli_query($koneksi, "SELECT * FROM guru");

                    while ($result = mysqli_fetch_array($query)) {
                        $no++;
                    ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $result['kd_guru']; ?></td>
                            <td><?= $result['nm_guru']; ?></td>
                            <td><?= $result['jenkel']; ?></td>
                            <td><?= $result['pend_terakhir']; ?></td>
                            <td><?= $result['hp']; ?></td>
                            <td><?= $result['alamat']; ?></td>
                            
                            <td>
                                <a href="index.php?page=guru&action=hapus&kd=<?= $result['kd_guru'] ?>" title="">
                                    <span class="badge badge-danger">Hapus</span>
                                </a>

                                <a href="index.php?page=edit_guru&kd=<?= $result['kd_guru'] ?>" title="">
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