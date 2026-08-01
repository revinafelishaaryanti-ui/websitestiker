<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$query = mysqli_query($conn,"SELECT * FROM kategori ORDER BY id_kategori ASC");
$keyword = "";

if(isset($_GET['keyword'])){

    $keyword = mysqli_real_escape_string($conn,$_GET['keyword']);

}

$query = mysqli_query($conn,"
SELECT *
FROM kategori
WHERE nama_kategori LIKE '%$keyword%'
ORDER BY id_kategori DESC
");
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

<div class="content-header">

<h2>Data Kategori</h2>

<a href="tambah_kategori.php" class="btn-tambah">

+ Tambah Kategori

</a>

</div>
<div class="table-card">
<form method="GET" class="search-halaman">

<input
type="text"
name="keyword"
placeholder="Cari kategori..."
value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">

<button type="submit">

<i class="fa-solid fa-magnifying-glass"></i>

Cari

</button>

</form>
<table class="table-produk">
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