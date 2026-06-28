<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$query = mysqli_query($conn,"SELECT * FROM kategori ORDER BY id_kategori ASC");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Data Kategori</title>

<link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="content-header">

<h2>Data Kategori</h2>

<a href="tambah_kategori.php" class="btn-tambah">

+ Tambah Kategori

</a>

</div>

<table>

<tr>

<th>No</th>

<th>Nama Kategori</th>

<th width="180">Aksi</th>

</tr>

<?php

$no=1;

while($row=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= $row['nama_kategori'] ?></td>

<td>

<a href="edit_kategori.php?id=<?= $row['id_kategori'] ?>" class="edit">

Edit</a>

<a href="hapus_kategori.php?id=<?= $row['id_kategori'] ?>" class="hapus"
onclick="return confirm('Yakin ingin menghapus?')">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>