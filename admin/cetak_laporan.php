<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}

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
ON pesanan.id_user = users.id
$where
ORDER BY pesanan.tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Cetak Laporan</title>

<style>

body{
    font-family:Arial,sans-serif;
    padding:30px;
}

h2{
    text-align:center;
    margin-bottom:5px;
}

p{
    text-align:center;
    margin-bottom:30px;
    color:#555;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    border:1px solid #000;
    padding:10px;
    text-align:center;
}

table th{
    background:#eee;
}

.back-btn{
    text-align:center;
    margin-top:30px;
}

.back-btn a{
    display:inline-block;
    padding:12px 25px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
}

.back-btn a:hover{
    background:#1d4ed8;
}

/* Tombol tidak ikut tercetak */
@media print{
    .back-btn{
        display:none;
    }
}

</style>

</head>

<body>

<h2>LAPORAN PENJUALAN STICKERIN</h2>

<?php if($tanggal_awal != "" && $tanggal_akhir != ""){ ?>

<p>
Periode :
<?= date('d-m-Y',strtotime($tanggal_awal)); ?>
s/d
<?= date('d-m-Y',strtotime($tanggal_akhir)); ?>
</p>

<?php }else{ ?>

<p>
Semua Periode - <?= date('d F Y'); ?>
</p>

<?php } ?>
<table>

<tr>

<th>No</th>
<th>Pelanggan</th>
<th>Total</th>
<th>Status</th>
<th>Tanggal</th>

</tr>

<?php
$no=1;

while($d=mysqli_fetch_assoc($query)){
?>

<tr>

<td><?= $no++; ?></td>

<td><?= $d['nama']; ?></td>

<td>
Rp <?= number_format($d['total_harga'],0,",","."); ?>
</td>

<td><?= $d['status']; ?></td>

<td><?= date('d-m-Y',strtotime($d['tanggal'])); ?></td>

</tr>

<?php } ?>

</table>
<div class="back-btn">
    <a href="laporan.php">
        ← Kembali ke Laporan
    </a>
</div>
<script>
window.print();
</script>

</body>
</html>