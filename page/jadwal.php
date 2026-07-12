<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_GET['action']) &&$_GET['action'] == "hapus") {
    $kd_jadwal =$_GET['kd'];
    
    // Hapus detail jadwal terlebih dahulu karena berelasi
    mysqli_query($koneksi, "DELETE FROM detailjadwal WHERE kd_jadwal = '$kd_jadwal'");
    
    // Kemudian hapus data utamanya
    $hapus = mysqli_query($koneksi, "DELETE FROM jadwal WHERE kd_jadwal = '$kd_jadwal'");
    
    if ($hapus) {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Data jadwal berhasil dihapus.
        </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-sm mb-3">
                    Tambah Jadwal
                </a>

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Kd Jadwal</th>
                            <th>Nama Guru</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        // Menggunakan JOIN antara tabel jadwal dan guru berdasarkan kolom nm_guru/kd_guru Anda
                        $query = mysqli_query($koneksi, "SELECT * FROM jadwal JOIN guru ON jadwal.nm_guru = guru.kd_guru");
                        while ($result = mysqli_fetch_array($query)) {$no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $result['kd_jadwal']; ?></td>
                                <td><?= $result['nm_guru']; ?></td>
                                <td><?= $result['semester']; ?></td>
                                <td><?= $result['tahun_ajaran']; ?></td>
                                <td>
                                    <a href="index.php?page=detail_jadwal&kd=<?= $result['kd_jadwal'] ?>" class="badge badge-info">Detail</a>
                                    <a href="index.php?page=jadwal&action=hapus&kd=<?= $result['kd_jadwal'] ?>" onclick="return confirm('Yakin ingin menghapus jadwal ini?')" class="badge badge-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>