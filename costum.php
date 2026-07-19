<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

if(isset($_POST['pesan'])){

    $id_produk = $_POST['id_produk'];
    $ukuran = $_POST['ukuran'];
    $jumlah = $_POST['jumlah'];
    $catatan = mysqli_real_escape_string($conn,$_POST['catatan']);

    $ekspedisi = $_POST['ekspedisi'];

// SIMPAN GAMBAR KE DATABASE

$logo = "";

if(isset($_FILES['file_logo']) && $_FILES['file_logo']['tmp_name']!=""){

    $logo = base64_encode(
        file_get_contents($_FILES['file_logo']['tmp_name'])
    );

}


$referensi = "";

if(isset($_FILES['file_referensi']) && $_FILES['file_referensi']['tmp_name']!=""){

    $referensi = base64_encode(
        file_get_contents($_FILES['file_referensi']['tmp_name'])
    );

}

    mysqli_query($conn,"
    INSERT INTO custom_sticker
(
    id,
    id_produk,
    ukuran,
    jumlah,
    catatan,
    ekspedisi,
    file_logo,
    file_referensi,
    metode_pembayaran,
    bank,
    latitude,
    longitude,
    lokasi
)
VALUES
(
    '$id_user',
    '$id_produk',
    '$ukuran',
    '$jumlah',
    '$catatan',
    '$ekspedisi',
    '$logo',
    '$referensi',
    '$pembayaran',
    '$bank'
    NULL,
    NULL,
    'Pesanan sedang diproses'
)
    ");

    echo "<script>
    alert('Pesanan Custom Berhasil Dibuat');
    window.location='pesanan.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Custom Sticker</title>

<link rel="stylesheet" href="stayle.css">
<link rel="stylesheet" href="custom_sticker.css">
</head>

<body>

<div class="custom-wrapper">

<div class="custom-card">

<h2>🎨 Custom Sticker</h2>

<p class="subjudul">
Buat stiker sesuai desain kamu sendiri
</p>

<form
method="POST"
enctype="multipart/form-data">

<label>Produk</label>

<select name="id_produk" required>

<option value="">-- Pilih Produk --</option>

<?php

$produk = mysqli_query($conn,"SELECT * FROM produk");

while($p=mysqli_fetch_assoc($produk)){

?>

<option value="<?= $p['id_produk']; ?>">
    <?= $p['nama_produk']; ?>
</option>

<?php } ?>

</select>

<br><br>

<label>Ukuran</label>

<input
type="text"
name="ukuran"
placeholder="Contoh : 5 x 5 cm"
required>

<br><br>

<label>Jumlah</label>

<input
type="number"
name="jumlah"
required>

<br><br>

<label>Catatan</label>

<textarea
name="catatan"></textarea>

<br><br>
<br><br>
<label>Metode Pembayaran</label>

<select name="pembayaran" required>

<option value="">
-- Pilih Pembayaran --
</option>

<option value="QRIS">
QRIS
</option>

<option value="Transfer Bank">
Transfer Bank
</option>

<option value="COD">
COD
</option>

</select>

<br><br>


<label>Pilih Bank</label>

<select name="bank">

<option value="-">
-- Pilih Bank --
</option>

<option value="BCA">
BCA
</option>

<option value="BRI">
BRI
</option>

<option value="BNI">
BNI
</option>

<option value="Mandiri">
Mandiri
</option>

</select>

<br><br>
<label>Ekspedisi Pengiriman</label>

<select name="ekspedisi" required>

<option value="">
-- Pilih Ekspedisi --
</option>

<option value="JNE">
JNE
</option>

<option value="J&T">
J&T
</option>

<option value="SiCepat">
SiCepat
</option>

<option value="AnterAja">
AnterAja
</option>

<option value="Pos Indonesia">
Pos Indonesia
</option>

</select>
<label>Upload Logo</label>

<div class="upload-area">

<input
type="file"
name="file_logo">

<span>
Masukkan logo kamu
</span>

</div>
<br><br>

<label>Upload Referensi Desain</label>

<div class="upload-area">

<input
type="file"
name="file_referensi">

<span>
Masukkan contoh desain
</span>

</div>

<br><br>
<a href="dashboard.php" class="btn-kembali">
    ← Kembali
</a>

<button
class="btn-custom"
name="pesan">

Kirim Pesanan Custom

</button>

</form>

</div>

</div>

</body>

</html>