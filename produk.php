<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    die("Kategori tidak ditemukan.");
}

$id = (int)$_GET['id'];

// Ambil nama kategori
$kategori = mysqli_query($conn,"
SELECT *
FROM kategori
WHERE id_kategori='$id'
");

$dataKategori = mysqli_fetch_assoc($kategori);

// Ambil semua produk pada kategori tersebut
$query = mysqli_query($conn,"
SELECT *
FROM produk
WHERE id_kategori='$id'
ORDER BY id_produk DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Produk</title>

<link rel="stylesheet" href="stayle.css">

</head>

<body>

<div class="mobile">

<h2 class="judul">

<?= $dataKategori['nama_kategori']; ?>

</h2>

<div class="produk-container">

<?php

if(mysqli_num_rows($query)>0){

while($row=mysqli_fetch_assoc($query)){

?>

<div class="card">

<img src="uploads/produk/<?= $row['gambar']; ?>" alt="">

<h3>

<?= $row['nama_produk']; ?>

</h3>

<p>

<?= $row['deskripsi']; ?>

</p>

<span>

Rp <?= number_format($row['harga']); ?>

</span>

<br><br>

<a href="detail_produk.php?id=<?= $row['id_produk']; ?>">

<button class="btn-detail">

Lihat Detail

</button>

</a>

</div>

<?php

}

}else{

echo "<h3>Produk belum tersedia.</h3>";

}

?>

</div>

</div>

<div class="mobile">

<h2 class="judul"><?= ucfirst($kategori); ?></h2>

<div class="produk-container">

<?php if($kategori=="vinyl"){ ?>

<div class="card">
    <img src="img/vinyl.png" alt="">
    <h3>Sticker Vinyl Glossy</h3>
    <p>Tahan air dan cuaca.</p>
    <span>Rp10.000</span>
    <a href="detail_produk.php?produk=vinyl_glossy">
    <button>Lihat Detail</button>
</a>
</div>

<div class="card">
    <img src="img/stiker_vinyl2.png" alt="">
    <h3>Sticker Vinyl Matte</h3>
    <p>Finishing doff premium.</p>
    <span>Rp12.000</span>
    <a href="detail_produk.php?produk=vinyl_matte">
    <button>Lihat Detail</button>
</a>
</div>

<div class="card">
    <img src="img/stiker_vinyl3.png" alt="">
    <h3>Sticker Vinyl Premium</h3>
    <p>Premium Quality.</p>
    <span>Rp15.000</span>
    <a href="detail_produk.php?produk=vinyl_premium">
    <button>Lihat Detail</button>
</a>
</div>

<?php } ?>

<?php if($kategori=="hologram"){ ?>

<div class="card">
    <img src="img/hologram.jpeg" alt="">
    <h3>Hologram Silver</h3>
    <p>Efek mengkilap.</p>
    <span>Rp12.000</span>
    <a href="detail_produk.php?produk=hologram_silver">
    <button>Lihat Detail</button>
</a>
</div>

<div class="card">
    <img src="img/stiker-hologram2.png" alt="">
    <h3>Hologram Gold</h3>
    <p>Premium.</p>
    <span>Rp15.000</span>
    <a href="detail_produk.php?produk=hologram_gold">
    <button>Lihat Detail</button>
</a>
</div>

<?php } ?>

</body>

</html>