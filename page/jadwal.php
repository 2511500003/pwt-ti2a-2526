<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                
                <div class="mb-3">
                    <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-sm">Tambah Jadwal</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead>
                            <tr style="white-space: nowrap; background-color: #f4f6f9;">
                                <th style="width: 50px;">NO</th>
                                <th>Kd Jadwal</th>
                                <th>Nama Guru Pengampu</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Hari</th>
                                <th>Jam Pelajaran</th>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            
                            // Query JOIN lengkap untuk menarik 9 kolom informasi ke halaman depan
                            $query = mysqli_query($koneksi, "
                                SELECT 
                                    j.kd_jadwal,
                                    j.semester,
                                    j.tahun_ajaran,
                                    j.nm_guru AS kelas,
                                    g.nm_guru AS nama_guru,
                                    m.nm_mapel AS mata_pelajaran,
                                    dj.hari,
                                    dj.jam
                                FROM jadwal j
                                LEFT JOIN detail_jadwal dj ON j.kd_jadwal = dj.kd_jadwal
                                LEFT JOIN guru g ON dj.kd_guru = g.kd_guru
                                LEFT JOIN mapel m ON dj.kd_mapel = m.kd_mapel
                                ORDER BY j.kd_jadwal DESC
                            ");

                            if (!$query) {
                                die("Query Error: " . mysqli_error($koneksi));
                            }

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                    <tr style="white-space: nowrap;">
                                        <td><?= $no++; ?></td>
                                        <td><strong><?= $row['kd_jadwal']; ?></strong></td>
                                        <td class="text-left"><?= $row['nama_guru'] ? $row['nama_guru'] : '<span class="text-muted">Belum diplot</span>'; ?></td>
                                        <td><?= $row['kelas']; ?></td>
                                        <td class="text-left"><?= $row['mata_pelajaran'] ? $row['mata_pelajaran'] : '<span class="text-muted">-</span>'; ?></td>
                                        <td><?= $row['hari'] ? $row['hari'] : '<span class="text-muted">-</span>'; ?></td>
                                        <td><?= $row['jam'] ? $row['jam'] : '<span class="text-muted">-</span>'; ?></td>
                                        <td><?= $row['semester']; ?></td>
                                        <td><?= $row['tahun_ajaran']; ?></td>
                                        <td>
                                            <a href="index.php?page=detail_jadwal&id=<?= $row['kd_jadwal']; ?>" class="btn btn-info btn-xs">Detail</a>
                                            <a href="index.php?page=hapus_jadwal&id=<?= $row['kd_jadwal']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">Hapus</a>
                                        </td>
                                    </tr>
                            <?php 
                                } 
                            } else { 
                                echo "<tr><td colspan='10' class='text-center text-muted py-4'>Belum ada data jadwal yang tersimpan.</td></tr>";
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>