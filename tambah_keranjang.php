<?php
session_start();
include 'koneksi.php';

// Pastikan user login
if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];
$id_produk = (int)$_GET['id'];

// Cek apakah produk sudah ada di keranjang
$cek = mysqli_query($conn,"
SELECT *
FROM keranjang
WHERE id_user='$id_user'
AND id_produk='$id_produk'
");

if(mysqli_num_rows($cek)>0){

    // Jika sudah ada, tambah jumlah
    mysqli_query($conn,"
    UPDATE keranjang
    SET jumlah=jumlah+1
    WHERE id_user='$id_user'
    AND id_produk='$id_produk'
    ");

}else{

    // Jika belum ada, simpan baru
    mysqli_query($conn,"
    INSERT INTO keranjang
    (id_user,id_produk,jumlah)
    VALUES
    ('$id_user','$id_produk','1')
    ");

}

// Kembali ke halaman sebelumnya
header("Location:keranjang.php");
exit;
?>