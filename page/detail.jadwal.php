<?php
$kd = $_GET['kd'];
$jadwalUtama = mysqli_query($koneksi, "SELECT * FROM jadwal JOIN guru ON jadwal.nm_guru = guru.kd_guru WHERE kd_jadwal = '$kd'");
$data = mysqli_fetch_array($jadwalUtama);
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Rincian Jadwal: <?= $kd; ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-body">
                <strong>Guru Pembimbing/Wali:</strong> <?= $data['nm_guru']; ?> <br>
                <strong>Tahun Ajaran / Semester:</strong> <?= $data['tahun_ajaran']; ?> (<?= $data['semester']; ?>)
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>Hari</th>
                            <th>Jam Ke</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        // Join detailjadwal ke tabel mapel
                        $q_detail = mysqli_query($koneksi, "SELECT * FROM detailjadwal JOIN mapel ON detailjadwal.kd_mapel = mapel.kd_mapel WHERE kd_jadwal = '$kd'");
                        while ($r_detail = mysqli_fetch_array($q_detail)) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $r_detail['nm_mapel']; ?></td>
                                <td><?= $r_detail['hari']; ?></td>
                                <td><?= $r_detail['jam']; ?></td>
                                <td><?= $r_detail['kd_guru']; ?></td> </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="index.php?page=jadwal" class="btn btn-secondary btn-sm mt-2">Kembali</a>
            </div>
        </div>
    </div>
</div>