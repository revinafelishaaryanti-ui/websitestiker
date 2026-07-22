<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}


if(!isset($_GET['id'])){
    die("Data pesanan tidak ditemukan.");
}


$id_custom = (int)$_GET['id'];



$query = mysqli_query($conn,"
SELECT

custom_sticker.*,

users.nama,
users.no_hp,
users.alamat,

produk.nama_produk,
produk.harga

FROM custom_sticker

LEFT JOIN users
ON custom_sticker.id = users.id

LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk

WHERE custom_sticker.id_custom='$id_custom'

");


if(!$query){

    die(mysqli_error($conn));

}


$data = mysqli_fetch_assoc($query);


if(!$data){

    die("Data tidak ditemukan.");

}


?>


<!DOCTYPE html>
<html>
<head>

<title>Cetak Resi Custom Sticker</title>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

</head>


<style>

body{
    font-family: Arial, sans-serif;
    background:#eee;
    padding:20px;
}


.resi{

    width:700px;
    margin:auto;
    background:white;
    padding:25px;
    border:1px solid #000;

}


.header{

    display:flex;
    justify-content:space-between;
    align-items:center;

}


.toko{

    font-size:26px;
    font-weight:bold;

}


.judul{

    font-size:18px;
    font-weight:bold;

}


hr{

    border:0;
    border-top:2px solid #000;

}


.box{

    border:1px solid #000;
    padding:15px;
    margin-top:15px;

}


table{

    width:100%;
    border-collapse:collapse;

}


td{

    padding:8px;

}


.label{

    width:150px;
    font-weight:bold;

}


.resi-number{

    font-size:25px;
    font-weight:bold;
    letter-spacing:2px;

}


.produk{

    border:1px solid #000;

}


.produk td{

    border:1px solid #000;

}


.footer{

    margin-top:30px;

    display:flex;
    justify-content:space-between;

}


.ttd{

    text-align:center;
    width:200px;

}


button{

    margin-top:20px;

    background:#000;

    color:white;

    border:none;

    padding:12px 30px;

    cursor:pointer;

}


@media print{

button{

display:none;

}


body{

background:white;

}


.resi{

border:none;

}

}

#barcode{

display:block;
margin:20px auto;

}

</style>


</head>


<body>


<div class="resi">


<h2>
STICKERIN
</h2>


<hr>


<p>
<b>Nomor Resi :</b>
<?= $data['nomor_resi'] ? $data['nomor_resi'] : '-'; ?>
</p>


<svg id="barcode"></svg>


<p>
<b>Status :</b>
<?= $data['status']; ?>
</p>


<table>


<tr>

<td>
Nama
</td>

<td>
:
<?= $data['nama']; ?>
</td>

</tr>


<tr>

<td>
No HP
</td>

<td>
:
<?= $data['no_hp']; ?>
</td>

</tr>


<tr>

<td>
Alamat
</td>

<td>
:
<?= $data['alamat']; ?>
</td>

</tr>


<tr>

<td>
Produk
</td>

<td>
:
<?= $data['nama_produk']; ?>
</td>

</tr>


<tr>

<td>
Jumlah
</td>

<td>
:
<?= $data['jumlah']; ?>
</td>

</tr>


<tr>

<td>
Ukuran
</td>

<td>
:
<?= $data['ukuran']; ?>
</td>

</tr>





<tr>

<td>
Estimasi
</td>

<td>
:
<?= $data['estimasi']; ?>
</td>

</tr>


</table>


<hr>


<p style="text-align:center">

Terima kasih sudah berbelanja di Stickerin ❤️

</p>


<button 
class="btn-print"
onclick="window.print()">

Cetak

</button>


</div>
<script>

JsBarcode("#barcode",
"<?= $data['nomor_resi'] ? $data['nomor_resi'] : 'STICKERIN'; ?>",
{

format:"CODE128",

width:2,

height:70,

displayValue:true

});

</script>

</body>


</html>