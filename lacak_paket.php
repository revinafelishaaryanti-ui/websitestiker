<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];
$id_custom = (int)$_GET['id'];

$query = mysqli_query($conn,"
SELECT *
FROM custom_sticker
WHERE id_custom='$id_custom'
AND id='$id_user'
");

if(mysqli_num_rows($query)==0){
    die("Data tidak ditemukan.");
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Lacak Paket</title>

<link rel="stylesheet" href="stayle.css">
<link rel="stylesheet" href="tracking.css">

</head>

<body>

<div class="mobile">

<h2>🚚 Lacak Paket</h2>

<div class="tracking-card">

<h3><?= htmlspecialchars($data['kurir']); ?></h3>

<p><b>Nomor Resi</b></p>

<p><?= htmlspecialchars($data['nomor_resi']); ?></p>

<p><b>Estimasi Tiba</b></p>

<p><?= htmlspecialchars($data['estimasi']); ?></p>

<p><b>Lokasi Terakhir</b></p>

<p><?= htmlspecialchars($data['lokasi']); ?></p>

<div class="timeline">

<div class="step done">

<div class="circle"></div>

<div class="text">

Pesanan dibuat

</div>

</div>

<div class="step done">

<div class="circle"></div>

<div class="text">

Sedang diproses

</div>

</div>

<div class="step done">

<div class="circle"></div>

<div class="text">

Dikemas

</div>

</div>

<div class="step <?= $data['status']=="Dikirim" || $data['status']=="Selesai" ? "done" : ""; ?>">

<div class="circle"></div>

<div class="text">

Paket dikirim

</div>

</div>

<div class="step <?= $data['status']=="Selesai" ? "done" : ""; ?>">

<div class="circle"></div>

<div class="text">

Paket diterima

</div>

</div>

</div>

<br>

<a href="pesanan.php" class="btn-back">

← Kembali

</a>

</div>

</div>

</body>

</html>