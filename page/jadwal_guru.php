<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Jadwal Mengajar Guru</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-body">
                <form action="" method="GET">
                    <input type="hidden" name="page" value="jadwal_guru">
                    <div class="row">
                        <div class="col-md-8">
                            <select name="kd_guru" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Guru untuk Melihat Jadwal --</option>
                                <?php
                                $g = mysqli_query($koneksi, "SELECT * FROM guru");
                                while ($rg = mysqli_fetch_array($g)) {
                                    $selected = (isset($_GET['kd_guru']) && $_GET['kd_guru'] ==$rg['kd_guru']) ? 'selected' : '';
                                    echo "<option value='".$rg['kd_guru']."' $selected>".$rg['nm_guru']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-block">Cari Jadwal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if (isset($_GET['kd_guru']) &&$_GET['kd_guru'] != "") {
            $kd_guru =$_GET['kd_guru'];
            $detail_guru = mysqli_query($koneksi, "SELECT * FROM guru WHERE kd_guru = '$kd_guru'");
            $dg = mysqli_fetch_array($detail_guru);
        ?>
            <div class="card">
                <div class="card-header bg-info">
                    <h5 class="card-title m-0">Jadwal Mengajar: <strong><?= $dg['nm_guru']; ?></strong> (<?=$dg['kd_guru']; ?>)</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>Jam Ke</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Semester / TA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            // Menampilkan jadwal berdasarkan guru pembimbing/wali di tabel jadwal utama
                            $query = mysqli_query($koneksi, "SELECT detailjadwal.*, mapel.nm_mapel, jadwal.semester, jadwal.tahun_ajaran 
                                                             FROM detailjadwal 
                                                             JOIN jadwal ON detailjadwal.kd_jadwal = jadwal.kd_jadwal 
                                                             JOIN mapel ON detailjadwal.kd_mapel = mapel.kd_mapel 
                                                             WHERE jadwal.nm_guru = '$kd_guru' 
                                                             ORDER BY detailjadwal.hari ASC, detailjadwal.jam ASC");
                            
                            if (mysqli_num_rows($query) > 0) {
                                while ($result = mysqli_fetch_array($query)) {$no++;
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $result['hari']; ?></td>
                                        <td><?= $result['jam']; ?></td>
                                        <td><?= $result['nm_mapel']; ?></td>
                                        <td><?= $result['kd_guru']; ?></td> <td><?= $result['semester']; ?> / <?=$result['tahun_ajaran']; ?></td>
                                    </tr>
                                <?php 
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Belum ada jadwal mengajar untuk guru ini.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>