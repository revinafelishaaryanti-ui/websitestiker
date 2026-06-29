<?php

$produk = isset($_GET['produk']) ? $_GET['produk'] : '';

$data = [];

switch($produk){

case "vinyl_glossy":
$data = [
"gambar"=>"img/vinyl.png",
"nama"=>"Sticker Vinyl Glossy",
"harga"=>"10000",
"deskripsi"=>"Sticker vinyl glossy tahan air dan tahan cuaca, cocok untuk motor, mobil, laptop, dan kebutuhan outdoor.",
"stok"=>"100"
];
break;

case "vinyl_matte":
$data = [
"gambar"=>"img/stiker_vinyl2.png",
"nama"=>"Sticker Vinyl Matte",
"harga"=>"12000",
"deskripsi"=>"Sticker vinyl dengan finishing doff premium sehingga terlihat elegan.",
"stok"=>"80"
];
break;

case "vinyl_premium":
$data = [
"gambar"=>"img/stiker_vinyl3.png",
"nama"=>"Sticker Vinyl Premium",
"harga"=>"15000",
"deskripsi"=>"Kualitas premium dengan warna tajam dan daya tahan tinggi.",
"stok"=>"50"
];
break;

default:
echo "Produk tidak ditemukan.";
exit;

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title><?= $data['nama']; ?></title>

<link rel="stylesheet" href="admin.css">

</head>

<body>

<div class="mobile">

<div class="detail-box">

<img src="<?= $data['gambar']; ?>">

<div class="info">

<h2><?= $data['nama']; ?></h2>

<div class="harga">

Rp <?= number_format($data['harga']); ?>

</div>

<p>

<?= $data['deskripsi']; ?>

</p>

<p>

<b>Stok :</b>

<?= $data['stok']; ?>

</p>

<br>

<a href="#" class="btn keranjang">

🛒 Tambah Keranjang

</a>

<a href="custom.php?produk=<?= $produk; ?>" class="btn custom">

🎨 Custom Desain

</a>

</div>

</div>

</div>

</body>

</html>