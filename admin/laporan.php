<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}

// total pendapatan
$pendapatan = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total_harga) as total
FROM pesanan
WHERE status='Selesai'
"));

// total pesanan
$jumlah = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM pesanan
"));

// total custom
$custom = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM custom_sticker
"));

// FILTER TANGGAL
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

$where = "";

if($tanggal_awal != "" && $tanggal_akhir != ""){

    $where = "
    WHERE DATE(pesanan.tanggal)
    BETWEEN '$tanggal_awal'
    AND '$tanggal_akhir'
    ";

}


// ambil data laporan
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

$where = "";

if($tanggal_awal != "" && $tanggal_akhir != ""){

    $where = "
    WHERE DATE(pesanan.tanggal)
    BETWEEN '$tanggal_awal'
    AND '$tanggal_akhir'
    ";

}


$query = mysqli_query($conn,"
SELECT
pesanan.*,
users.nama
FROM pesanan
JOIN users
ON pesanan.id_user=users.id
$where
ORDER BY tanggal DESC
");
?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Laporan</title>

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

<h2>📊 Laporan Penjualan</h2>

<p>Rekap seluruh transaksi Stickerin.</p>

</div>

<a href="cetak_laporan.php?tanggal_awal=<?= $tanggal_awal; ?>&tanggal_akhir=<?= $tanggal_akhir; ?>" class="btn-primary">
<i class="fa-solid fa-print"></i>
Cetak
</a>

</div>


<!-- FILTER TANGGAL -->

<form method="GET" class="filter-tanggal">

<label>Tanggal Awal</label>

<input 
type="date" 
name="tanggal_awal"
value="<?= $tanggal_awal; ?>">


<label>Tanggal Akhir</label>

<input 
type="date" 
name="tanggal_akhir"
value="<?= $tanggal_akhir; ?>">


<button type="submit">
🔍 Filter
</button>


<a href="laporan.php">
Reset
</a>

</form>


</div>

<div class="laporan-box">

<div class="card-laporan">

<h4>Total Pesanan</h4>

<h2><?= $jumlah['total']; ?></h2>

</div>

<div class="card-laporan">

<h4>Total Pendapatan</h4>

<h2>

Rp <?= number_format($pendapatan['total'],0,",","."); ?>

</h2>

</div>

<div class="card-laporan">

<h4>Custom Sticker</h4>

<h2><?= $custom['total']; ?></h2>

</div>

</div>

<div class="table-card">

<table>

<thead>

<tr>

<th>No</th>

<th>Tanggal</th>

<th>Pelanggan</th>

<th>Total</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php
$no=1;

while($d=mysqli_fetch_assoc($query)){
?>

<tr>

<td><?= $no++; ?></td>

<td><?= date("d M Y",strtotime($d['tanggal'])); ?></td>

<td><?= $d['nama']; ?></td>

<td>

Rp <?= number_format($d['total_harga'],0,",","."); ?>

</td>

<td>

<span class="badge success">

<?= $d['status']; ?>

</span>

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