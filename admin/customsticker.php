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
produk.nama_produk
FROM custom_sticker
LEFT JOIN users
ON custom_sticker.id = users.id
LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk
ORDER BY custom_sticker.id_custom DESC
");

$keyword = "";

if(isset($_GET['keyword'])){

    $keyword = mysqli_real_escape_string($conn,$_GET['keyword']);

}

$query = mysqli_query($conn,"
SELECT
custom_sticker.*,
users.nama,
produk.nama_produk
FROM custom_sticker
LEFT JOIN users
ON custom_sticker.id = users.id
LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk
WHERE
users.nama LIKE '%$keyword%'
OR produk.nama_produk LIKE '%$keyword%'
OR custom_sticker.ukuran LIKE '%$keyword%'
OR custom_sticker.status LIKE '%$keyword%'
ORDER BY custom_sticker.id_custom DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Custom Sticker</title>

<link rel="stylesheet" href="admin.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="header-kategori">

<h2>🎨 Custom Sticker</h2>

</div>

<div class="table-card">
<div class="content-header">

<h2>Data Custom Stiker</h2>

<form method="GET" class="search-halaman">

<input
type="text"
name="keyword"
placeholder="Cari custom stiker..."
value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">

<button type="submit">

<i class="fa-solid fa-magnifying-glass"></i>

Cari

</button>

</form>

</div>
<table>

<thead>

<tr>

<th>No</th>
<th>Pelanggan</th>
<th>Produk</th>
<th>Ukuran</th>
<th>Jumlah</th>
<th>Referensi</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php
$no = 1;

while($row = mysqli_fetch_assoc($query)){
?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama']; ?></td>

<td><?= $row['nama_produk']; ?></td>

<td><?= $row['ukuran']; ?></td>

<td><?= $row['jumlah']; ?></td>

<td>

<?php
if($row['file_referensi'] != ""){
?>

<a href="../uploads/custom_referensi/<?= $row['file_referensi']; ?>" target="_blank">

<img
src="../uploads/custom_referensi/<?= $row['file_referensi']; ?>"
style="width:70px;height:70px;object-fit:cover;border-radius:10px;">

</a>

<?php
}else{
    echo "-";
}
?>

</td>

<td>

<?php

$status = $row['status'];

if($status=="Menunggu"){
    echo "<span class='badge badge-warning'>Menunggu</span>";
}
elseif($status=="Diproses"){
    echo "<span class='badge badge-primary'>Diproses</span>";
}
elseif($status=="Selesai"){
    echo "<span class='badge badge-success'>Selesai</span>";
}
else{
    echo "<span class='badge'>$status</span>";
}

?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>