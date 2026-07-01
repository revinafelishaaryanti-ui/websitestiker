<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];
$status = "";

if(isset($_GET['status'])){
    $status = mysqli_real_escape_string($conn,$_GET['status']);
}

if($status==""){

    $query = mysqli_query($conn,"
    SELECT
    custom_sticker.*,
    produk.nama_produk,
    produk.gambar
    FROM custom_sticker
    LEFT JOIN produk
    ON custom_sticker.id_produk=produk.id_produk
    WHERE custom_sticker.id='$id_user'
    ORDER BY id_custom DESC
    ");
    
    }else{
    
    $query = mysqli_query($conn,"
    SELECT
    custom_sticker.*,
    produk.nama_produk,
    produk.gambar
    FROM custom_sticker
    LEFT JOIN produk
    ON custom_sticker.id_produk=produk.id_produk
    WHERE
    custom_sticker.id='$id_user'
    AND status='$status'
    ORDER BY id_custom DESC
    ");
    
    }
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

<div class="header-page">

    <a href="dashboard.php" class="back-btn">
        ←
    </a>

    <h2>Pesanan Saya</h2>

</div>
<div class="filter-status">

<a href="pesanan.php"
class="<?= $status==''?'aktif':'' ?>">
Semua
</a>

<a href="pesanan.php?status=Diproses"
class="<?= $status=='Diproses'?'aktif':'' ?>">
Diproses
</a>

<a href="pesanan.php?status=Dikemas"
class="<?= $status=='Dikemas'?'aktif':'' ?>">
Dikemas
</a>

<a href="pesanan.php?status=Dikirim"
class="<?= $status=='Dikirim'?'aktif':'' ?>">
Dikirim
</a>

<a href="pesanan.php?status=Selesai"
class="<?= $status=='Selesai'?'aktif':'' ?>">
Selesai
</a>

</div>

    <!-- INI YANG AKU MAKSUD WADAH -->
    <div class="daftar-pesanan">

<?php
if(mysqli_num_rows($query)>0){

while($row=mysqli_fetch_assoc($query)){

$progress=10;

switch($row['status']){

case "Menunggu":
    $progress=10;
break;

case "Menunggu Persetujuan":
    $progress=20;
break;

case "Diproses":
    $progress=40;
break;

case "Dikemas":
    $progress=60;
break;

case "Dikirim":
    $progress=80;
break;

case "Selesai":
    $progress=100;
break;

}
?>

<div class="pesanan-card">

    <div class="produk-kiri">

    <img src="img/<?= htmlspecialchars($row['gambar']); ?>" class="gambar-pesanan">

    </div>

    <div class="produk-kanan">

        <h3><?= htmlspecialchars($row['nama_produk']); ?></h3>
        <?= $row['gambar']; ?>

        <p><b>Ukuran :</b> <?= htmlspecialchars($row['ukuran']); ?></p>

        <p><b>Jumlah :</b> <?= $row['jumlah']; ?></p>

        <span class="status-badge">

            <?= htmlspecialchars($row['status']); ?>

        </span>

        <div class="progress">

            <div
            class="progress-bar"
            style="width:<?= $progress ?>%;">

            </div>

        </div>

        <div class="aksi">

            <a
            href="detail_pesanan.php?id=<?= $row['id_custom']; ?>"
            class="btn-detail">

                Detail

            </a>

            <a
            href="chat_user.php?id_custom=<?= $row['id_custom']; ?>"
            class="btn-chat">

                💬 Chat Admin

            </a>

            <?php if($row['status']=="Dikirim"){ ?>

            <a
            href="lacak_paket.php?id=<?= $row['id_custom']; ?>"
            class="btn-lacak">

                🚚 Lacak Paket

            </a>

            <?php } ?>

            <?php if($row['status']=="Selesai"){ ?>

            <a
            href="rating.php?id=<?= $row['id_custom']; ?>"
            class="btn-rating">

                ⭐ Nilai Produk

            </a>

            <?php } ?>

        </div>

    </div>

</div>

<?php

}

}else{

echo "<div class='kosong'>Belum ada pesanan.</div>";

}

?>

</div>
</div>

</body>
</html>