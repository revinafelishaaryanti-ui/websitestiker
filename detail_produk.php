<?php
session_start();

include 'koneksi.php';

if(!isset($_GET['id'])){
    die("Produk tidak ditemukan.");
}

$id = (int)$_GET['id'];

$query = mysqli_query($conn,"
SELECT *
FROM produk
WHERE id_produk='$id'
");

if(mysqli_num_rows($query)==0){
    die("Produk tidak ditemukan.");
}

$produk = mysqli_fetch_assoc($query);

$qTerjual = mysqli_query($conn,"
SELECT IFNULL(SUM(jumlah),0) AS total
FROM detail_pesanan
WHERE id_produk='$id'
");

$terjual = mysqli_fetch_assoc($qTerjual);

// sementara
$rating = 5.0;
$jumlahKomentar = 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title><?= $produk['nama_produk']; ?></title>

<link rel="stylesheet" href="stayle.css">
<link rel="stylesheet" href="detail_produk.css">

</head>

<body>

<div class="mobile">

<div class="detail-container">
<div class="top-back">

<a href="javascript:history.back()" class="btn-back-top">

← Kembali

</a>

</div>

<div class="detail-flex">

<div class="detail-img">

<img src="img/<?= htmlspecialchars($produk['gambar']); ?>" alt="">

</div>

<div class="detail-info">

<h2><?= $produk['nama_produk']; ?></h2>

<div class="rating">

⭐ <?= number_format($rating,1); ?>

<span>💬 <?= $jumlahKomentar; ?> Komentar</span>

<span>🛒 <?= $terjual['total']; ?> Terjual</span>

</div>

<div class="harga">

Rp <?= number_format($produk['harga'],0,',','.'); ?>

</div>

<div class="deskripsi">

<h3>Deskripsi Produk</h3>

<p>

<?= nl2br($produk['deskripsi']); ?>

</p>

</div>

<div class="button-area">

<a href="tambah_keranjang.php?id=<?= $produk['id_produk']; ?>" class="btn btn-cart">

🛒 Masukkan Keranjang

</a>

<?php

if(isset($_SESSION['id'])){


    $cek_user = mysqli_query($conn,"
    SELECT no_hp,alamat
    FROM users
    WHERE id='".$_SESSION['id']."'
    ");


    $data_user = mysqli_fetch_assoc($cek_user);


    if(empty($data_user['no_hp']) || empty($data_user['alamat'])){

        $link_beli = "lengkapi_profil.php?id=".$produk['id_produk'];

    }else{

        $link_beli = "checkout.php?id=".$produk['id_produk'];

    }


}else{


    $link_beli = "login.php?redirect=checkout&id=".$produk['id_produk'];


}

?>

<a href="<?= $link_beli; ?>" class="btn btn-buy">

⚡ Beli Sekarang

</a>

</div>

</div>

</div>

</div>

</div>

</body>

</html>