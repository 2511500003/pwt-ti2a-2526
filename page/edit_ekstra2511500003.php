<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
$kd = $_GET['kd'];
$edit = mysqli_fetch_array(mysqli_query($koneksi, "
    SELECT * FROM ekstra_2511500003 WHERE id_ekstra003='$kd'
"));

if (isset($_POST['tambah'])) {
    $id_ekstra003 = $_POST['id_ekstra003'];
    $nama_ekstra003 = $_POST['nama_ekstra003'];
    $ket003     = $_POST['ket003'];
    $semester003   = $_POST['semester003'];
    $thn_ajaran003  = $_POST['thn_ajaran003'];

    $insert = mysqli_query($koneksi, "
        UPDATE ekstra_2511500003 
        SET id_ekstra003='$id_ekstra003', nama_ekstra003 = '$nama_ekstra003', ket003 = '$ket003', semester003 ='$semester003', thn_ajaran003 = '$thn_ajaran003'
        WHERE id_ekstra003='$id_ekstra003'
    ");

    if ($insert) {
        echo '
        <div class="alert alert-info-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Berhasil Disimpan</h4>
        </div>';
        
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra_2511500003">';
    } else {
        echo '
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Gagal Disimpan</h4>
        </div>';
        die(mysqli_error($koneksi));
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
    <label for="id_ekstra003">id_ekstra003</label>
    <input type="text" name="id_ekstra003" 
           value="<?= $edit['id_ekstra003']; ?>" 
           class="form-control" readonly>
</div>

<div class="form-group">
    <label for="nama_ekstra003">Nama_ekstra003</label>
    <input type="text" name="nama_ekstra003" 
           value="<?= $edit['nama_ekstra003']; ?>" 
           id="nama_ekstra003" 
           placeholder="nama_ekstra003" 
           class="form-control">
</div>

<div class="form-group">
    <label for="ket003">ket003</label>
    <input type="text" name="ket003" 
           value="<?= $edit['ket003']; ?>" 
           id="kkm" 
           placeholder="Ket003" 
           class="form-control">
</div>
<div class="form-group">
    <label for="semester003">semester003</label>
    <input type="text" name="semester003" 
           value="<?= $edit['semester003']; ?>" 
           id="semester003" 
           placeholder="semester003" 
           class="form-control">
</div>

    <label for="thn_ajaran003">thn_ajaran003</label>
    <input type="text" name="thn_ajaran003" 
           value="<?= $edit['thn_ajaran003']; ?>" 
           id="thn_ajaran003" 
           placeholder="thn_ajaran003" 
           class="form-control">
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