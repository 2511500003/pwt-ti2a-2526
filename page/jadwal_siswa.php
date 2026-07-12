<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Jadwal Pelajaran Siswa</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-body">
                <form action="" method="GET">
                    <input type="hidden" name="page" value="jadwal_siswa">
                    <div class="row">
                        <div class="col-md-8">
                            <select name="kelas" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Kelas untuk Melihat Jadwal Pelajaran --</option>
                                <?php
                                // Mengambil daftar kelas unik yang ada di tabel kelas Anda
                                $k = mysqli_query($koneksi, "SELECT * FROM kelas");
                                while ($rk = mysqli_fetch_array($k)) {
                                    $selected = (isset($_GET['kelas']) && $_GET['kelas'] == $rk['nm_kelas']) ? 'selected' : '';
                                    echo "<option value='".$rk['nm_kelas']."' $selected>".$rk['nm_kelas']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-block">Lihat Jadwal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if (isset($_GET['kelas']) && $_GET['kelas'] != "") {
            $pilih_kelas = $_GET['kelas'];
        ?>
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title m-0">Daftar Mata Pelajaran Kelas: <strong><?= $pilih_kelas; ?></strong></h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>Jam Pelajaran</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru Pengampu</th>
                                <th>Semester / TA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            // Menampilkan jadwal berdasarkan isian kolom kelas (yang tersimpan di field detailjadwal.kd_guru)
                            $query = mysqli_query($koneksi, "SELECT detailjadwal.*, mapel.nm_mapel, jadwal.semester, jadwal.tahun_ajaran, guru.nm_guru 
                                                             FROM detailjadwal 
                                                             JOIN jadwal ON detailjadwal.kd_jadwal = jadwal.kd_jadwal 
                                                             JOIN mapel ON detailjadwal.kd_mapel = mapel.kd_mapel
                                                             JOIN guru ON jadwal.nm_guru = guru.kd_guru
                                                             WHERE detailjadwal.kd_guru = '$pilih_kelas' 
                                                             ORDER BY detailjadwal.hari ASC, detailjadwal.jam ASC");
                            
                            if (mysqli_num_rows($query) > 0) {
                                while ($result = mysqli_fetch_array($query)) {
                                    $no++;
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $result['hari']; ?></td>
                                        <td><?= $result['jam']; ?></td>
                                        <td><?= $result['nm_mapel']; ?></td>
                                        <td><?= $result['nm_guru']; ?></td>
                                        <td><?= $result['semester']; ?> / <?= $result['tahun_ajaran']; ?></td>
                                    </tr>
                                <?php 
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Belum ada data jadwal pelajaran untuk kelas ini.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>