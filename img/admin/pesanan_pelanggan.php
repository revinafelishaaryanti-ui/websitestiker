<?php
session_start();
include '../koneksi.php';

// FILTER TANGGAL
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

$whereTanggal = "";

if($tanggal_awal != "" && $tanggal_akhir != ""){

    $whereTanggal = "
    AND DATE(pesanan.tanggal) 
    BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ";

}

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}

$query = mysqli_query($conn,"
SELECT
pesanan.*,
users.nama
FROM pesanan
JOIN users
ON pesanan.id_user = users.id
WHERE 1=1
$whereTanggal
ORDER BY pesanan.id_pesanan DESC
");

if(!$query){
    die(mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Pesanan Pelanggan</title>

<link rel="stylesheet" href="admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="page-header">

<div>

<h2>📦 Pesanan Pelanggan</h2>

<p>Kelola seluruh pesanan pelanggan Stickerin.</p>

</div>

</div>

<!-- Filter Form -->
<div class="filter-card">
<div class="filter-tanggal">

<form method="GET">

<label>
<i class="fa-solid fa-calendar"></i>
Dari Tanggal
</label>

<input type="date" name="tanggal_awal" 
value="<?= $tanggal_awal ?>">

<label>
Sampai Tanggal
</label>

<input type="date" name="tanggal_akhir" 
value="<?= $tanggal_akhir ?>">

<button type="submit">
<i class="fa-solid fa-filter"></i>
Filter
</button>


<a href="pesanan_pelanggan.php">
<i class="fa-solid fa-rotate-right"></i>
Reset
</a>

</form>

</div>
</div>

<div class="table-card">

<table>

<thead>

<tr>

<th>No</th>
<th>Pelanggan</th>
<th>Total</th>
<th>Status</th>
<th>Tanggal</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($d=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $d['nama']; ?></td>

<td>

Rp <?= number_format($d['total_harga'],0,',','.'); ?>

</td>

<td>

<?php

if($d['status']=="Menunggu"){

echo "<span class='badge warning'>Menunggu</span>";

}elseif($d['status']=="Diproses"){

echo "<span class='badge primary'>Diproses</span>";

}elseif($d['status']=="Dikirim"){

echo "<span class='badge success'>Dikirim</span>";

}else{

echo "<span class='badge'>$d[status]</span>";

}

?>

</td>

<td>

<?= date('d M Y',strtotime($d['tanggal'])); ?>

</td>

<td>

<a href="detail_pesanan.php?id=<?= $d['id_pesanan']; ?>" class="btn-detail">

<i class="fa-solid fa-eye"></i>

Detail

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>
