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

$id = (int)$_GET['id'];
$tipe = isset($_GET['tipe']) ? $_GET['tipe'] : 'produk';

if($tipe=="custom"){

$query = mysqli_query($conn,"
SELECT *
FROM custom_sticker
WHERE id_custom='$id'
AND id='$id_user'
");

}else{

$query = mysqli_query($conn,"
SELECT
pesanan.*,
users.nama
FROM pesanan
JOIN users
ON pesanan.id_user=users.id
WHERE pesanan.id_pesanan='$id'
AND pesanan.id_user='$id_user'
");

}

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
<?php
if($tipe=="custom"){
    echo "Pesanan Custom Sticker";
}else{
    echo htmlspecialchars($data['metode_pembayaran']);
}
?>
</h3>

<p><b>Nomor Resi</b></p>

<p>
<?php
if($tipe=="custom"){
    $resi = !empty($data['nomor_resi']) ? $data['nomor_resi'] : "Belum tersedia";
}else{
    $resi = !empty($data['no_resi']) ? $data['no_resi'] : "Belum tersedia";
}
echo htmlspecialchars($resi);
?>

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

<?php if(
    ($data['status']=="Dikirim" || $data['status']=="Selesai")
    && !empty($data['latitude'])
    && !empty($data['longitude'])
){ ?>

<div class="map-box">

<iframe
width="100%"
height="300"
style="border:0;"
loading="lazy"
allowfullscreen
src="https://maps.google.com/maps?q=<?= $data['latitude']; ?>,<?= $data['longitude']; ?>&z=15&output=embed">
</iframe>

</div>

<?php } ?>

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