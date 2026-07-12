<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $hapus_detail = mysqli_query($koneksi, "DELETE FROM detail_jadwal WHERE kd_jadwal = '$id'");

    if ($hapus_detail) {
        $hapus_utama = mysqli_query($koneksi, "DELETE FROM jadwal WHERE kd_jadwal = '$id'");

        if ($hapus_utama) {
            echo "<script>alert('Data jadwal berhasil dihapus!'); window.location='index.php?page=jadwal';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data utama: " . mysqli_error($koneksi) . "'); window.location='index.php?page=jadwal';</script>";
        }
    } else {
        echo "<script>alert('Gagal menghapus komponen detail jadwal: " . mysqli_error($koneksi) . "'); window.location='index.php?page=jadwal';</script>";
    }
} else {
    echo "<script>window.location='index.php?page=jadwal';</script>";
}
?>