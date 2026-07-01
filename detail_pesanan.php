<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];
$id_custom = $_GET['id'];

$query = mysqli_query($conn,"
SELECT
custom_sticker.*,
produk.nama_produk,
produk.gambar,
produk.harga
FROM custom_sticker
LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk
WHERE custom_sticker.id_custom='$id_custom'
AND custom_sticker.id='$id_user'
");

if(mysqli_num_rows($query)==0){
    die("Pesanan tidak ditemukan.");
}

$data=mysqli_fetch_assoc($query);
?>
<?php
$total_harga = $data['harga'] * $data['jumlah'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Detail Pesanan</title>

<link rel="stylesheet" href="stayle.css">

</head>

<body>

<div class="mobile">

<div class="detail-card">

    <div class="produk-kiri">
        <img src="img/<?= htmlspecialchars($data['gambar']); ?>" class="detail-img">
    </div>

    <div class="detail-info">
        
<h2><?= $data['nama_produk']; ?></h2>

<p><b>Harga Satuan :</b> Rp <?= number_format($data['harga'],0,',','.'); ?></p>

<p><b>Total Harga :</b> Rp <?= number_format($total_harga,0,',','.'); ?></p>

<p><b>Ukuran :</b> <?= $data['ukuran']; ?></p>

<p><b>Jumlah :</b> <?= $data['jumlah']; ?></p>

<p><b>Status :</b> <?= $data['status']; ?></p>

<p><b>Catatan :</b></p>

<p><?= $data['catatan']; ?></p>

<?php if($data['file_logo']!=""){ ?>

<p><b>Logo :</b></p>

<a href="uploads/custom/<?= $data['file_logo']; ?>" target="_blank">

Lihat Logo

</a>

<?php } ?>

<br><br>

<?php if($data['file_referensi']!=""){ ?>

<p><b>Referensi :</b></p>

<a href="uploads/custom/<?= $data['file_referensi']; ?>" target="_blank">

Lihat Referensi

</a>

<?php } ?>

<br><br>

<?php
if($data['file_desain']!=""){
?>


<?php
}
?>

<?php
if($data['status']=="Menunggu Persetujuan"){
?>

<br><br>

<?php
}
?>


<a class="btn-detail" href="pesanan.php">

← Kembali

</a>

<a class="btn-chat"
href="chat_user.php?id_custom=<?= $data['id_custom']; ?>">

💬 Chat Admin

</a>


</div>

</div>

</div>

</body>
</html>