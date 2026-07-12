<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit siswa</h1>
            </div>
        </div>
    </div>
</div>

<?php
$kd = $_GET['kd'];
$edit = mysqli_fetch_array(mysqli_query($koneksi, "
    SELECT * FROM siswa WHERE nis='$kd'
"));

if (isset($_POST['tambah'])) {
    $nis = $_POST['nis'];
    $nm_siswa = $_POST['nm_siswa'];
    $jenkel = $_POST['jenkel'];
    $hp = $_POST['hp'];
    $id_kelas= $_POST['id_kelas'];
   
    $insert = mysqli_query($koneksi, "
        UPDATE siswa 
        SET nis='$nis', nm_siswa='$nm_siswa', jenkel='$jenkel', hp='$hp', id_kelas='$id_kelas'
        WHERE nis='$nis'
    ");

    if ($insert) {
        echo '
        <div class="alert alert-info-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Berhasil Disimpan</h4>
        </div>';
        
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=siswa">';
    } else {
        echo '
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Gagal Disimpan</h4>
        </div>';
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
    <label for="nis">nis</label>
    <input type="text" name="nis" 
           value="<?= $edit['nis']; ?>" 
           class="form-control" readonly>
</div>

<div class="form-group">
    <label for="nm_siswa">Nama siswa</label>
    <input type="text" name="nm_siswa" 
           value="<?= $edit['nm_siswa']; ?>" 
           id="nm_siswa" 
           placeholder="Nama siswa" 
           class="form-control">
</div>

                        <label for="jenkel">Jenis Kelamin</label>
                        <select class="form-control" name="jenkel" id="jenkel">
                            <option disabled selected>-- Pilih Jenis Kelamin -- </option>
                            <option value="Laki-laki" <?= ($edit['jenkel'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= ($edit['jenkel'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>


<div class="form-group">
    <label for="hp">hp</label>
    <input type="text" name="hp" 
           value="<?= $edit['hp']; ?>" 
           id="hp" 
           placeholder="hp" 
           class="form-control">
</div>

<div class="form-group">
                        <label for="id_kelas">id_Kelas</label>
                        <select class="form-control" name="id_kelas" id="id_kelas">
                            <option disabled selected>-- Pilih Kelas --</option>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                            while ($k = mysqli_fetch_array($query)) {
                                echo "<option value='$k[id_kelas]'" . ($edit['id_kelas'] == $k['id_kelas'] ? 'selected' : '') . ">$k[nm_kelas]</option>";
                            }
                            ?>
                        </select>
                    </div>

<div class="card-footer">
    <input type="submit" 
           class="btn btn-primary" 
           name="tambah" 
           value="simpan">
</div>

</form>
</div>
</div>
</div>
</div>
</section>