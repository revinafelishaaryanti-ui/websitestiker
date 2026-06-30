<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}

$query = mysqli_query($conn,"
SELECT
custom_sticker.*,
users.nama,
produk.nama_produk,
produk.gambar
FROM custom_sticker
LEFT JOIN users
ON custom_sticker.id = users.id
LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk
ORDER BY id_custom DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Pesanan Custom</title>

<link rel="stylesheet" href="../stayle.css">
<link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<h2>Pesanan Custom</h2>

<table>

<tr>

<th>Foto</th>

<th>User</th>

<th>Produk</th>

<th>Ukuran</th>

<th>Jumlah</th>

<th>Status</th>

<th>Aksi</th>

</tr>

<?php while($row=mysqli_fetch_assoc($query)){ ?>

<tr>

<td>

<img
src="../uploads/produk/<?= $row['gambar']; ?>"
width="80">

</td>

<td>

<?= htmlspecialchars($row['nama']); ?>

</td>

<td>

<?= htmlspecialchars($row['nama_produk']); ?>

</td>

<td>

<?= htmlspecialchars($row['ukuran']); ?>

</td>

<td>

<?= $row['jumlah']; ?>

</td>

<td>

<?= htmlspecialchars($row['status']); ?>

</td>

<td>

<a
class="edit"
href="chat_admin.php?id_custom=<?= $row['id_custom']; ?>">

💬 Chat

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>