<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$query = mysqli_query($conn,"
SELECT produk.*, kategori.nama_kategori
FROM produk
LEFT JOIN kategori
ON produk.id_kategori = kategori.id_kategori
ORDER BY id_produk DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Data Produk</title>

<link rel="stylesheet" href="assets/css/admin.css">

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

<table>

<tr>

<th>Gambar</th>

<th>Nama Produk</th>

<th>Kategori</th>

<th>Harga</th>

<th>Stok</th>

<th>Aksi</th>

</tr>

<?php while($row=mysqli_fetch_assoc($query)){ ?>

<tr>

<td>

<img src="../uploads/produk/<?= $row['gambar']; ?>" width="70">

</td>

<td><?= $row['nama_produk']; ?></td>

<td><?= $row['nama_kategori']; ?></td>

<td>Rp <?= number_format($row['harga']); ?></td>

<td><?= $row['stok']; ?></td>

<td>

<a class="edit"
href="edit_produk.php?id=<?= $row['id_produk']; ?>">

Edit

</a>

<a class="hapus"
onclick="return confirm('Hapus Produk?')"
href="hapus_produk.php?id=<?= $row['id_produk']; ?>">

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