<div class="content-header">
    <div class="container-fluid">
    </div>
</div>

<?php
    if(isset($_POST['tambah'])){
        $pl = $_POST['pl'];
        $pb = $_POST['pb'];
        $username = $_SESSION['username'];
        $cek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'"));

        if($cek){
            $update = mysqli_query($koneksi, "UPDATE users SET password = '$pb' WHERE password = '$pl' AND username = '$username'");
            if($update){
                if (mysqli_affected_rows($koneksi) > 0) {
                    echo '
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">X</button>
                        <h5><i class="icon fas fa-info"></i> Info</h5>
                        <h4>Berhasil Disimpan</h4>
                    </div>';
                    echo '<meta http-equiv="refresh" content="1;url=index.php">';
                } else {
                    echo '
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">X</button>
                        <h5><i class="icon fas fa-info"></i> Info</h5>
                        <h4>Password lama salah</h4>
                    </div>';
                }
                
            }

        }
    }
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-2">

                <form method="POST" action="">

                    <div class="form-group">
                        <label for="nm_siswa">Password Lama</label>
                        <input 
                            type="text" 
                            name="pl" 
                            id="pl"
                            placeholder="MasukkanPassword Lama" 
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="pb">Password Baru</label>
                        <input 
                            type="text" 
                            name="pb" 
                            id="pb"
                            placeholder="Masukkan Password Baru" 
                            class="form-control">
                    </div>

                    <div class="card-footer">
                        <input 
                            type="submit" 
                            class="btn btn-primary" 
                            name="tambah" 
                            value="Simpan">
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>