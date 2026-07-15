<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$keyword = "";

if(isset($_GET['keyword'])){

    $keyword = mysqli_real_escape_string($conn,$_GET['keyword']);

}


$query = mysqli_query($conn,"
SELECT produk.*, kategori.nama_kategori
FROM produk

LEFT JOIN kategori
ON produk.id_kategori = kategori.id_kategori

WHERE produk.nama_produk LIKE '%$keyword%'
OR kategori.nama_kategori LIKE '%$keyword%'

ORDER BY id_produk DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Data Produk</title>

<link rel="stylesheet" href="admin.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="content-header">

<h2>Data Produk</h2>

<a href="tambah_produk.php" class="btn-tambah">

+ Tambah Produk

</a>

</div>

<div class="table-card">
<form method="GET" class="search-halaman">

<input 
type="text"
name="keyword"
placeholder="Cari produk..."
value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">

<button type="submit">
<i class="fa-solid fa-magnifying-glass"></i>
Cari
</button>

</form>
<table class="table-produk">

<thead>

<tr>

<th>Gambar</th>
<th>Nama Produk</th>
<th>Kategori</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($query)){ ?>

<tr>

<td>

<img src="../img/<?= $row['gambar']; ?>">

</td>

<td><?= $row['nama_produk']; ?></td>

<td><?= $row['nama_kategori']; ?></td>

<td>

Rp <?= number_format($row['harga'],0,',','.'); ?>

</td>

<td>

<?php if($row['stok']>0){ ?>

<span class="badge-stok">

<?= $row['stok']; ?>

</span>

<?php }else{ ?>

<span class="badge-habis">

Habis

</span>

<?php } ?>

</td>

<td>

<a href="edit_produk.php?id=<?= $row['id_produk']; ?>" class="btn-edit">

<i class="fa-solid fa-pen"></i>

</a>

<a href="hapus_produk.php?id=<?= $row['id_produk']; ?>" class="btn-delete">

<i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>
</body>

</html>