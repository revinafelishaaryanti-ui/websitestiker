<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

if (!isset($_GET['id'])) {
    die("ID pesanan tidak ditemukan.");
}

$id_custom = (int)$_GET['id'];

// Pastikan pesanan milik user yang login
$cek = mysqli_query($conn,"
SELECT *
FROM custom_sticker
WHERE id_custom='$id_custom'
AND id='$id_user'
");

if(mysqli_num_rows($cek)==0){
    die("Pesanan tidak ditemukan.");
}

// Ubah status menjadi Diproses
mysqli_query($conn,"
UPDATE custom_sticker
SET status='Diproses'
WHERE id_custom='$id_custom'
");

header("Location: detail_pesanan.php?id=".$id_custom);
exit;
?>