<?php

session_start();

if(!isset($_SESSION['admin_id'])){

header("Location: login.php");

exit;

}

include '../koneksi.php';

$jml_produk = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM produk"));
$jml_kategori = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM kategori"));
$jml_user = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));
?>

<!DOCTYPE html>
<html>

<head>

<title>Dashboard Admin</title>

<link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="cards">

<div class="card">

<h3>Produk</h3>

<h1><?= $jml_produk ?></h1>

</div>

<div class="card">

<h3>Kategori</h3>

<h1><?= $jml_kategori ?></h1>

</div>

<div class="card">

<h3>Pelanggan</h3>

<h1><?= $jml_user ?></h1>

</div>

<div class="card">

<h3>Pesanan</h3>

<h1>0</h1>

</div>

</div>

</div>

<div class="cards">

<div class="card">

<h4>Total Produk</h4>

<h1><?= $jml_produk ?></h1>

</div>

<div class="card">

<h4>Total Kategori</h4>

<h1><?= $jml_kategori ?></h1>

</div>

<div class="card">

<h4>Total Pelanggan</h4>

<h1><?= $jml_user ?></h1>

</div>

<div class="card">

<h4>Total Pesanan</h4>

<h1>0</h1>

</div>

</div>

</body>

</html>

