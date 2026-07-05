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

<link rel="stylesheet" href="admin.css?v=2">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="page-header">

    <div>

        <h2>📂 Kategori Sticker</h2>

        <p>Kelola semua kategori Stickerin.</p>

    </div>

    

</div>

<div class="header-kategori">
   
    <a href="tambah_kategori.php" class="btn-tambah">
        <i class="fa-solid fa-plus"></i>
        Tambah Kategori
    </a>
</div>

<div class="table-card">

<table>

<thead>

<tr>

<th>No</th>

<th>Nama Kategori</th>

<th width="180">Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($row=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= $row['nama_kategori']; ?></td>

<td>

<a href="edit_kategori.php?id=<?= $row['id_kategori']; ?>" class="btn-edit">

<i class="fa-solid fa-pen"></i>

</a>

<a href="hapus_kategori.php?id=<?= $row['id_kategori']; ?>" class="btn-delete"
onclick="return confirm('Yakin ingin menghapus?')">

<i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>

</html>