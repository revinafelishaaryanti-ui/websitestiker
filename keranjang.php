

<?php
session_start();

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

<!-- PRODUK 1 -->

<div class="produk-item">

<input type="checkbox" name="pilih[]" value="1" class="pilih-produk">

<img src="img/stiker_aes.jpeg">

<div class="detail">

<h3>Stiker Aesthetic</h3>

<p>Vinyl • 5 cm</p>

<b>Rp <?= number_format($total1); ?></b>

<div class="qty">

<a href="keranjang.php?aksi=kurang&id=1">-</a>

<span><?= $_SESSION['qty1']; ?></span>

<a href="keranjang.php?aksi=tambah&id=1">+</a>

</div>

</div>

<div class="harga">
Rp <?= number_format($total1); ?>
</div>

</div>

<!-- PRODUK 2 -->

<div class="produk-item">

<input type="checkbox" name="pilih[]" value="2" class="pilih-produk">

<img src="img/custum_holo1.jpeg">

<div class="detail">

<h3>Stiker Hologram Logo</h3>

<p>Hologram • 5 cm</p>

<b>Rp <?= number_format($total2); ?></b>

<div class="qty">

<a href="keranjang.php?aksi=kurang&id=2">-</a>

<span><?= $_SESSION['qty2']; ?></span>

<a href="keranjang.php?aksi=tambah&id=2">+</a>

</div>

</div>

<div class="harga">
Rp <?= number_format($total2); ?>
</div>

</div>

<!-- PRODUK 3 -->

<div class="produk-item">

<input type="checkbox" name="pilih[]" value="3" class="pilih-produk">

<img src="img/custum_krj.jpeg">

<div class="detail">

<h3>Custom Sticker</h3>

<p>Vinyl • 7 cm</p>

<b>Rp <?= number_format($total3); ?></b>

<div class="qty">

<a href="keranjang.php?aksi=kurang&id=3">-</a>

<span><?= $_SESSION['qty3']; ?></span>

<a href="keranjang.php?aksi=tambah&id=3">+</a>

</div>

</div>

<div class="harga">
Rp <?= number_format($total3); ?>
</div>

</div>


<hr>

<div class="ringkasan">

<div>
<span>Subtotal</span>
<span>Rp <?= number_format($subtotal); ?></span>
</div>

<div>
<span>Ongkos Kirim</span>
<span>Rp <?= number_format($ongkir); ?></span>
</div>

<div class="total">
<span>Total</span>
<span>Rp <?= number_format($total); ?></span>
</div>

</div>

<a href="checkout.php" class="checkout-btn">
Lanjut ke Pemesanan
</a>

</div>

</body>
</html>