<?php
// Mengambil parameter ID dari URL dengan aman
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data utama jadwal (menggunakan variabel $id yang benar)
    $query_utama = mysqli_query($koneksi, "SELECT *, nm_guru AS kelas FROM jadwal WHERE kd_jadwal = '$id'");
    $data_utama  = mysqli_fetch_array($query_utama);

    // Proteksi jika data ternyata tidak ada di database
    if (!$data_utama) {
        echo "<div class='alert alert-danger m-3'>Data jadwal dengan kode <strong>$id</strong> tidak ditemukan di database.</div>";
        echo "<a href='index.php?page=jadwal' class='btn btn-secondary btn-sm ml-3'>Kembali</a>";
        exit;
    }
} else {
    // Jika diakses tanpa parameter id, balikkan ke halaman tabel utama
    echo "<script>window.location='index.php?page=jadwal';</script>";
    exit;
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Rincian Jadwal: <strong><?= $data_utama['kd_jadwal']; ?></strong></h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="index.php?page=jadwal" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali ke Jadwal
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        
        <div class="card card-outline card-info mb-4">
            <div class="card-header">
                <h3 class="card-title">Informasi Utama</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Kelas / Rombel:</strong>
                        <p class="text-muted text-uppercase"><?= $data_utama['kelas']; ?></p>
                    </div>
                    <div class="col-md-4">
                        <strong>Semester:</strong>
                        <p class="text-muted"><?= $data_utama['semester']; ?></p>
                    </div>
                    <div class="col-md-4">
                        <strong>Tahun Ajaran:</strong>
                        <p class="text-muted"><?= $data_utama['tahun_ajaran']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title">Daftar Mata Pelajaran & Guru Pengampu</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr style="background-color: #f4f6f9;">
                                <th style="width: 50px;">NO</th>
                                <th>Nama Guru Pengampu</th>
                                <th>Mata Pelajaran</th>
                                <th>Hari</th>
                                <th>Jam Pelajaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // Menarik sub-data rincian pelajaran dari detail_jadwal berdasarkan kd_jadwal
                            $query_detail = mysqli_query($koneksi, "
                                SELECT 
                                    dj.hari, 
                                    dj.jam, 
                                    g.nm_guru, 
                                    m.nm_mapel 
                                FROM detail_jadwal dj
                                LEFT JOIN guru g ON dj.kd_guru = g.kd_guru
                                LEFT JOIN mapel m ON dj.kd_mapel = m.kd_mapel
                                WHERE dj.kd_jadwal = '$id'
                            ");

                            if (mysqli_num_rows($query_detail) > 0) {
                                while ($row = mysqli_fetch_array($query_detail)) {
                            ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="text-left"><?= $row['nm_guru'] ? $row['nm_guru'] : '-'; ?></td>
                                        <td class="text-left"><?= $row['nm_mapel'] ? $row['nm_mapel'] : '-'; ?></td>
                                        <td><?= $row['hari']; ?></td>
                                        <td><span class="badge badge-success"><?= $row['jam']; ?></span></td>
                                    </tr>
                            <?php 
                                } 
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-muted py-3'>Tidak ada komponen pelajaran dinamis untuk jadwal ini.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>