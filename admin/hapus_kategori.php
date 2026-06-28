<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$id = (int)$_GET['id'];

mysqli_query($conn, "DELETE FROM kategori
WHERE id_kategori='$id'");

header("Location: kategori.php");
exit;
?>