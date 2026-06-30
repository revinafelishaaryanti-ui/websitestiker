<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];

$query = mysqli_query($conn,"
SELECT
custom_sticker.*,
produk.nama_produk,
produk.gambar
FROM custom_sticker
LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk
WHERE custom_sticker.id='$id_user'
ORDER BY id_custom DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Pesanan Saya</title>

<link rel="stylesheet" href="stayle.css">

</head>

<body>

<div class="mobile">

<h2>Pesanan Saya</h2>

<?php
if(mysqli_num_rows($query)>0){

while($row=mysqli_fetch_assoc($query)){
?>

<div class="card pesanan-card">

<img
src="img/<?= $row['gambar']; ?>"
class="gambar-pesanan">

<h3><?= $row['nama_produk']; ?></h3>

<p><b>Ukuran :</b> <?= $row['ukuran']; ?></p>

<p><b>Jumlah :</b> <?= $row['jumlah']; ?></p>

<p><b>Status :</b> <?= $row['status']; ?></p>


<a class="btn-detail"
href="detail_pesanan.php?id=<?= $row['id_custom']; ?>">

Detail

</a>

<a class="btn-chat"
href="chat_user.php?id_custom=<?= $row['id_custom']; ?>">

💬 Chat Admin

</a>

</div>

<br>

<?php

}

}else{

echo "<div class='card'>Belum ada pesanan.</div>";

}

?>

</div>

</body>
</html>