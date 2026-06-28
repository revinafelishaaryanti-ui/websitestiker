<?php
session_start();
include '../koneksi.php';

if(isset($_POST['simpan'])){

$nama=mysqli_real_escape_string($conn,$_POST['nama']);

mysqli_query($conn,"INSERT INTO kategori(nama_kategori)
VALUES('$nama')");

header("Location:kategori.php");

}
?>

<!DOCTYPE html>

<html>

<head>

<title>Tambah Kategori</title>

<link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<h2>Tambah Kategori</h2>

<form method="POST">

<input
type="text"
name="nama"
placeholder="Nama Kategori"
required>

<br><br>

<button
name="simpan"
class="btn-tambah">

Simpan

</button>

</form>

</div>

</div>

</body>

</html>