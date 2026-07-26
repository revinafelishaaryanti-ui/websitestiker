<?php
session_start();
include '../koneksi.php';


// ==========================
// CEK LOGIN ADMIN
// ==========================
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}



// ==========================
// FILTER TANGGAL
// ==========================

$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : "";

$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : "";


$wherePesanan = "";

$whereCustom = "";


if($tanggal_awal != "" && $tanggal_akhir != ""){


    $wherePesanan = "
    AND DATE(pesanan.tanggal)
    BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ";


    $whereCustom = "
    AND DATE(custom_sticker.tanggal)
    BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ";


}

// ==========================
// QUERY PESANAN BIASA
// ==========================

$queryPesanan = "

SELECT

pesanan.id_pesanan AS id_order,

users.nama AS nama,

'Pesanan Produk' AS jenis,

pesanan.total_harga AS total,

pesanan.metode_pembayaran,

pesanan.status,

pesanan.tanggal


FROM pesanan


JOIN users

ON pesanan.id_user = users.id



WHERE pesanan.status='Selesai'

$wherePesanan



";





// ==========================
// QUERY CUSTOM STIKER
// ==========================

$queryCustom = "

SELECT

custom_sticker.id_custom AS id_order,

users.nama AS nama,

'Custom Sticker' AS jenis,

custom_sticker.total_harga AS total,

custom_sticker.metode_pembayaran,

custom_sticker.status,

custom_sticker.tanggal


FROM custom_sticker


JOIN users

ON custom_sticker.id = users.id


WHERE custom_sticker.status='Selesai'


$whereCustom

";





// ==========================
// GABUNG DATA
// ==========================

$query = $queryPesanan . "

UNION ALL

" . $queryCustom . "

ORDER BY tanggal DESC
";




$data = mysqli_query($conn,$query);



if(!$data){

    die("Query Error : ".mysqli_error($conn));

}





// ==========================
// HITUNG TOTAL
// ==========================

$totalPendapatan = 0;


while($row=mysqli_fetch_assoc($data)){


    $totalPendapatan += $row['total'];


}



mysqli_data_seek($data,0);



?>



<!DOCTYPE html>
<html>

<head>

<title>Pendapatan Admin</title>
<link rel="stylesheet" href="admin.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="content-header">

<div class="container">


<div class="pendapatan-card">

<h2>
💰 Laporan Pendapatan
</h2>


<p>Total Pendapatan</p>


<div class="pendapatan-total">

Rp <?=number_format($totalPendapatan,0,',','.');?>

</div>

</div>





<div class="pendapatan-card">

<h3>
Filter Data
</h3>


<div class="filter">

<form method="GET">


<label>
Tanggal Awal
</label>

<input type="date" name="tanggal_awal">


<label>
Tanggal Akhir
</label>

<input type="date" name="tanggal_akhir">


<button type="submit">

Cari

</button>


</form>


</div>

</div>






<div class="card">


<table class="table-pendapatan">

<tr>

<th>ID</th>

<th>Nama Pelanggan</th>

<th>Jenis</th>

<th>Total Harga</th>

<th>Pembayaran</th>

<th>Status</th>

<th>Tanggal</th>


</tr>





<?php if(mysqli_num_rows($data)>0){ ?>


<?php while($row=mysqli_fetch_assoc($data)){ ?>


<tr>


<td>
<?=$row['id_order'];?>
</td>



<td>
<?=$row['nama'];?>
</td>



<td>
<?=$row['jenis'];?>
</td>



<td>

Rp <?=number_format($row['total'],0,',','.');?>

</td>



<td>

<?=$row['metode_pembayaran'];?>

</td>



<td class="status">

<?=$row['status'];?>

</td>



<td>

<?=date('d-m-Y',strtotime($row['tanggal']));?>

</td>



</tr>



<?php } ?>



<?php }else{ ?>


<tr>

<td colspan="7">

Belum ada data pendapatan

</td>

</tr>


<?php } ?>


<tr>
    <td colspan="3">
        <b>Total Pendapatan</b>
    </td>

    <td>
        <b>
        Rp <?=number_format($totalPendapatan,0,',','.');?>
        </b>
    </td>

    <td colspan="3"></td>
</tr>

</table>


</div> <!-- container -->
</div> <!-- main-content -->
</div> <!-- content -->
</div> <!-- main -->

</body>
</html>