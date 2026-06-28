<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['kirim'])){

    $id_user = $_SESSION['id'];
    $nama_produk = mysqli_real_escape_string($conn,$_POST['nama_produk']);
    $ukuran = mysqli_real_escape_string($conn,$_POST['ukuran']);
    $jumlah = $_POST['jumlah'];
    $catatan = mysqli_real_escape_string($conn,$_POST['catatan']);

    $logo = $_FILES['logo']['name'];
    $tmpLogo = $_FILES['logo']['tmp_name'];

    $referensi = $_FILES['referensi']['name'];
    $tmpReferensi = $_FILES['referensi']['tmp_name'];

    move_uploaded_file($tmpLogo,"uploads/custom_logo/".$logo);
    move_uploaded_file($tmpReferensi,"uploads/custom_referensi/".$referensi);

    mysqli_query($conn,"INSERT INTO custom_sticker
    (id_user,nama_produk,ukuran,jumlah,catatan,file_logo,file_referensi)
    VALUES
    ('$id_user','$nama_produk','$ukuran','$jumlah','$catatan','$logo','$referensi')");

    echo "<script>
    alert('Pesanan custom berhasil dikirim');
    window.location='custom.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Custom Sticker</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<h2>Custom Sticker</h2>

<form method="POST" enctype="multipart/form-data">

<label>Nama Produk</label>

<input
type="text"
name="nama_produk"
required>

<label>Ukuran</label>

<input
type="text"
name="ukuran"
placeholder="10 x 10 cm"
required>

<label>Jumlah</label>

<input
type="number"
name="jumlah"
required>

<label>Catatan</label>

<textarea
name="catatan"
rows="5"></textarea>

<label>Upload Logo</label>

<input
type="file"
name="logo"
accept=".png,.jpg,.jpeg"
required>

<label>Upload Referensi</label>

<input
type="file"
name="referensi"
accept=".png,.jpg,.jpeg"
required>

<br><br>

<button
name="kirim">

Kirim Pesanan

</button>

</form>

</body>

</html>