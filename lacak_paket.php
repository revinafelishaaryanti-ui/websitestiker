<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];

if(!isset($_GET['id'])){
    die("Pesanan tidak ditemukan.");
}

$id_pesanan = (int)$_GET['id'];


$query = mysqli_query($conn,"
SELECT 
    pesanan.*,
    users.nama
FROM pesanan
JOIN users ON pesanan.id_user = users.id
WHERE pesanan.id_pesanan='$id_pesanan'
AND pesanan.id_user='$id_user'
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

<h3>
    <?= htmlspecialchars($data['metode_pembayaran']); ?>
</h3>

<p><b>Nomor Resi</b></p>

<p>
<?= !empty($data['no_resi']) 
? htmlspecialchars($data['no_resi']) 
: "Belum tersedia"; ?>
</p>

<p><b>Estimasi Tiba</b></p>

<p>
Estimasi mengikuti proses pengiriman.
</p>

<p><b>Lokasi Terakhir</b></p>

<p>
<?= !empty($data['lokasi']) 
? htmlspecialchars($data['lokasi']) 
: "Pesanan sedang diproses"; ?>
</p>

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