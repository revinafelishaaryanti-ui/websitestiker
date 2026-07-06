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

    $logo = "";
    $referensi = "";

    // Upload Logo
    if($_FILES['file_logo']['name']!=""){

        $logo = time()."_".$_FILES['file_logo']['name'];

        move_uploaded_file(
            $_FILES['file_logo']['tmp_name'],
            "uploads/custom/".$logo
        );
    }

    // Upload Referensi
    if($_FILES['file_referensi']['name']!=""){

        $referensi = time()."_".$_FILES['file_referensi']['name'];

        move_uploaded_file(
            $_FILES['file_referensi']['tmp_name'],
            "uploads/custom/".$referensi
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
        file_logo,
        file_referensi
    )
    VALUES
    (
        '$id_user',
        '$id_produk',
        '$ukuran',
        '$jumlah',
        '$catatan',
        '$logo',
        '$referensi'
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

</head>

<body>

<div class="mobile">

<h2>Custom Sticker</h2>

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

<label>Upload Logo</label>

<input
type="file"
name="file_logo">

<br><br>

<label>Upload Referensi</label>

<input
type="file"
name="file_referensi">

<br><br>

<button
class="auth-btn"
name="pesan">

Kirim Pesanan

</button>

</form>

</div>

</body>

</html>