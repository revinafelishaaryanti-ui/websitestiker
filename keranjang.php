<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("Location: login.php");
    exit;

}


$id_user = $_SESSION['id'];



$query = mysqli_query($conn,"
SELECT 
keranjang.id,
keranjang.jumlah,

produk.id_produk,
produk.nama_produk,
produk.harga,
produk.gambar

FROM keranjang

JOIN produk 
ON keranjang.id_produk = produk.id_produk

WHERE keranjang.id_user='$id_user'
");



$subtotal = 0;


?>
if(isset($_POST['tambah'])){

    $produk = [
        "id" => $_POST['id_produk'],
        "nama" => $_POST['nama_produk'],
        "harga" => $_POST['harga'],
        "gambar" => $_POST['gambar'],
        "qty" => 1
    ];

    $_SESSION['keranjang'][] = $produk;

}

}

include 'koneksi.php';

/* Qty awal */
if(!isset($_SESSION['qty1'])) $_SESSION['qty1'] = 1;
if(!isset($_SESSION['qty2'])) $_SESSION['qty2'] = 1;
if(!isset($_SESSION['qty3'])) $_SESSION['qty3'] = 1;

/* Tombol + dan - */
if(isset($_GET['aksi']) && isset($_GET['id'])){

    $id = $_GET['id'];

    if($_GET['aksi'] == 'tambah'){
        $_SESSION['qty'.$id]++;
    }

    if($_GET['aksi'] == 'kurang'){
        if($_SESSION['qty'.$id] > 1){
            $_SESSION['qty'.$id]--;
        }
    }

}

/* Harga */
$harga1 = 10000;
$harga2 = 12000;
$harga3 = 15000;

$total1 = $harga1 * $_SESSION['qty1'];
$total2 = $harga2 * $_SESSION['qty2'];
$total3 = $harga3 * $_SESSION['qty3'];

$subtotal = $total1 + $total2 + $total3;
$ongkir = 10000;
$total = $subtotal + $ongkir;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Keranjang</title>

<link rel="stylesheet" href="stayle.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="container">

<div class="topbar">

<a href="dashboard.php">
<i class="fa fa-arrow-left"></i>
</a>

<h2>Keranjang</h2>

<a href="keranjang.php?reset=1">
<i class="fa fa-trash"></i>
</a>

</div>

<hr>

<div class="ringkasan">

<div>
<span>Subtotal</span>
<span id="subtotalBayar">Rp 0</span>
</div>

<div>
<span>Ongkos Kirim</span>
<span id="ongkirBayar">Rp <?= number_format($ongkir); ?></span>
</div>

<div class="total">
<span>Total</span>
<span id="totalBayar">Rp 0</span>
</div>

</div>

<a href="checkout.php" class="checkout-btn">
Lanjut ke Pemesanan
</a>

</div>

<script>

function hitungTotal(){

    let subtotal = 0;

    document.querySelectorAll(".produk-item").forEach(function(item){

        let cek = item.querySelector(".pilih-produk");

        if(cek.checked){

            let harga = parseInt(item.dataset.harga);

            let qty = parseInt(item.querySelector(".jumlah").innerText);

            subtotal += harga * qty;
        }

    });

    let ongkir = <?= $ongkir ?>;
    let total = subtotal;

    if(subtotal > 0){
        total += ongkir;
    }

    document.getElementById("subtotalBayar").innerHTML =
        "Rp " + subtotal.toLocaleString("id-ID");

    document.getElementById("totalBayar").innerHTML =
        "Rp " + total.toLocaleString("id-ID");
}

document.querySelectorAll(".pilih-produk").forEach(function(cb){

    cb.addEventListener("change", hitungTotal);

});

window.onload = hitungTotal;

</script>

</body>
</html>