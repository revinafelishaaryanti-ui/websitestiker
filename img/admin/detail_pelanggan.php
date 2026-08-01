<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location:pelanggan.php");
    exit;
}

$id = (int)$_GET['id'];

// Ambil data pelanggan
$query = mysqli_query($conn,"
SELECT *
FROM users
WHERE id='$id'
");

$data = mysqli_fetch_assoc($query);

if(!$data){
    die("Data pelanggan tidak ditemukan.");
}

// Hitung total pesanan custom
// Hitung pesanan produk biasa
$qProduk = mysqli_query($conn,"
SELECT COUNT(*) AS jumlah
FROM pesanan
WHERE id_user='$id'
");

$dataProduk = mysqli_fetch_assoc($qProduk);

// Hitung pesanan custom
$qCustom = mysqli_query($conn,"
SELECT COUNT(*) AS jumlah
FROM custom_sticker
WHERE id='$id'
");

$dataCustom = mysqli_fetch_assoc($qCustom);

// Total keseluruhan
$totalPesanan = $dataProduk['jumlah'] + $dataCustom['jumlah'];
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Detail Pelanggan</title>

<link rel="stylesheet" href="admin.css">

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

<h2>👤 Detail Pelanggan</h2>

<p>Informasi lengkap pelanggan Stickerin.</p>

</div>

<a href="pelanggan.php" class="btn-back">

<i class="fa-solid fa-arrow-left"></i>

Kembali

</a>

</div>

<div class="detail-card">

<table class="table-detail">

<tr>
    <th>Data</th>
    <th>Informasi</th>
</tr>

<tr>
    <td>Nama</td>
    <td><?= $data['nama']; ?></td>
</tr>

<tr>
    <td>Email</td>
    <td><?= $data['email']; ?></td>
</tr>

<tr>
    <td>No Handphone</td>
    <td><?= $data['no_hp']; ?></td>
</tr>

<tr>
    <td>Alamat</td>
    <td><?= $data['alamat']; ?></td>
</tr>

<tr>
    <td>Total Pesanan</td>
    <td><?= $totalPesanan; ?> Pesanan</td>
</tr>

</table>

</div>

</body>
</html>