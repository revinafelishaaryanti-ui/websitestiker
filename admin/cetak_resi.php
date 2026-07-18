<?php

include '../koneksi.php';

$id_pesanan = $_GET['id'];

$query = mysqli_query($conn,"
SELECT 
pesanan.*,
users.nama,
users.no_hp,
users.alamat
FROM pesanan
JOIN users 
ON pesanan.id_user = users.id
WHERE id_pesanan='$id_pesanan'
");

$data = mysqli_fetch_assoc($query);


// ambil produk
$detail = mysqli_query($conn,"
SELECT 
detail_pesanan.*,
produk.nama_produk
FROM detail_pesanan
JOIN produk
ON detail_pesanan.id_produk = produk.id_produk
WHERE id_pesanan='$id_pesanan'
");

?>


<!DOCTYPE html>
<html>

<head>

<title>Resi Pesanan</title>


<style>

body{
    font-family: Arial, sans-serif;
    background:#eee;
    padding:30px;
}


.resi{
    width:420px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:10px;
    border:1px solid #ddd;
}


.header{
    text-align:center;
    border-bottom:2px dashed #333;
    padding-bottom:15px;
}


.header h1{
    margin:0;
    font-size:28px;
}


.header p{
    margin:5px;
    font-size:13px;
}



.nomor-resi{

    margin:20px 0;
    padding:15px;
    background:#f5f5f5;
    text-align:center;
    border-radius:8px;

}


.nomor-resi h2{
    margin:5px 0;
    letter-spacing:2px;
}



.box{

    border-bottom:2px dashed #333;
    padding:15px 0;

}



.judul{

    font-weight:bold;
    margin-bottom:8px;

}



table{

    width:100%;
    border-collapse:collapse;

}



td{

    padding:5px 0;
    font-size:14px;

}



.total{

    font-size:18px;
    font-weight:bold;

}



.footer{

    text-align:center;
    margin-top:20px;
    font-size:12px;

}



@media print{

body{
    background:white;
}

.resi{
    border:none;
}

}


</style>


</head>


<body onload="window.print()">



<div class="resi">


<div class="header">

<h1>STICKERIN</h1>

<p>Custom Sticker & Label</p>

<p>Terima kasih sudah berbelanja</p>

</div>



<div class="nomor-resi">

<p>NO RESI</p>

<h2>
<?= $data['no_resi']; ?>
</h2>

</div>




<div class="box">

<div class="judul">
PENGIRIM
</div>

<p>
<b>STICKERIN</b><br>
Indonesia
</p>

</div>





<div class="box">

<div class="judul">
PENERIMA
</div>


<p>

<b><?= $data['nama']; ?></b><br>

<?= $data['no_hp']; ?><br>

<?= $data['alamat']; ?>

</p>


</div>





<div class="box">


<div class="judul">
DETAIL PESANAN
</div>


<table>


<?php while($d=mysqli_fetch_assoc($detail)){ ?>

<tr>

<td>
<?= $d['nama_produk']; ?>
</td>


<td align="right">

<?= $d['jumlah']; ?> pcs

</td>

</tr>


<?php } ?>


</table>


</div>





<div class="box">


<table>


<tr>

<td>Status</td>

<td align="right">
<?= $data['status']; ?>
</td>

</tr>


<tr>

<td>Metode</td>

<td align="right">
<?= $data['metode_pembayaran']; ?>
</td>

</tr>


<tr>

<td>Total</td>

<td align="right" class="total">

Rp <?= number_format($data['total_harga']); ?>

</td>

</tr>


</table>


</div>




<div class="footer">

<p>
Barang sudah dicek sebelum dikirim
</p>

<p>
STICKERIN © 2026
</p>

</div>



</div>


</body>

</html>