<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];

$id = $_GET['id'];
$tipe = $_GET['tipe'];


// PESANAN CUSTOM
if($tipe=="custom"){

$query = mysqli_query($conn,"
SELECT
custom_sticker.*,
produk.nama_produk,
produk.gambar,
produk.harga

FROM custom_sticker

LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk

WHERE 
custom_sticker.id_custom='$id'
AND custom_sticker.id='$id_user'
");


}


// PESANAN PRODUK BIASA
else{


$query = mysqli_query($conn,"
SELECT
pesanan.*,
detail_pesanan.jumlah,
detail_pesanan.harga,
produk.nama_produk,
produk.gambar

FROM pesanan

JOIN detail_pesanan
ON pesanan.id_pesanan = detail_pesanan.id_pesanan

JOIN produk
ON detail_pesanan.id_produk = produk.id_produk

WHERE 
pesanan.id_pesanan='$id'
");


}


if(mysqli_num_rows($query)==0){

    die("Pesanan tidak ditemukan.");

}


$data=mysqli_fetch_assoc($query);
?>
<?php
if($tipe=="custom"){

    $total_harga = $data['harga'] * $data['jumlah'];

}else{

    $total_harga = $data['harga'] * $data['jumlah'];

}
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

<?php if($tipe=="custom"){ ?>

<p>
<b>Ukuran :</b> 
<?= $data['ukuran']; ?>
</p>

<p>
<b>Catatan :</b>
</p>

<p>
<?= $data['catatan']; ?>
</p>

<?php } ?>


<p>
<b>Jumlah :</b> 
<?= $data['jumlah']; ?>
</p>


<p>
<b>Status :</b> 
<?= $data['status']; ?>
</p>

<?php if($tipe=="custom" && $data['file_logo']!=""){ ?>

<p><b>Logo :</b></p>

<a href="uploads/custom/<?= $data['file_logo']; ?>" target="_blank">

Lihat Logo

</a>

<?php } ?>

<br><br>

<?php if($tipe=="custom" && $data['file_referensi']!=""){ ?>

<p><b>Referensi :</b></p>

<a href="uploads/custom/<?= $data['file_referensi']; ?>" target="_blank">

Lihat Referensi

</a>

<?php } ?>

<br><br>

<?php
if($tipe=="custom" && $data['file_desain']!=""){?>

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
href="chat_user.php?id_order=<?= $id; ?>&tipe=<?= $tipe; ?>">

💬 Chat Admin

</a>

</div>

</div>

</div>

</body>
</html>