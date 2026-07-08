<?php
session_start();
include '../koneksi.php';

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

<title>pesanan Pelanggan</title>

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

<a href="#" class="btn-primary">

<i class="fa-solid fa-filter"></i>

Filter

</a>

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