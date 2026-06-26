<?php

if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
} else {
    $kategori = '';
}

echo "Kategori = " . $kategori;

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

<h2 class="judul"><?= ucfirst($kategori); ?></h2>

<div class="produk-container">

<?php if($kategori=="vinyl"){ ?>

<div class="card">
    <img src="img/vinyl.png" alt="">
    <h3>Sticker Vinyl Glossy</h3>
    <p>Tahan air dan cuaca.</p>
    <span>Rp10.000</span>
    <button>Lihat Detail</button>
</div>

<div class="card">
    <img src="img/stiker_vinyl2.png" alt="">
    <h3>Sticker Vinyl Matte</h3>
    <p>Finishing doff premium.</p>
    <span>Rp12.000</span>
    <button>Lihat Detail</button>
</div>

<div class="card">
    <img src="img/stiker_vinyl3.png" alt="">
    <h3>Sticker Vinyl Premium</h3>
    <p>Premium Quality.</p>
    <span>Rp15.000</span>
    <button>Lihat Detail</button>
</div>

<?php } ?>

<?php if($kategori=="hologram"){ ?>

<div class="card">
    <img src="img/hologram.jpeg" alt="">
    <h3>Hologram Silver</h3>
    <p>Efek mengkilap.</p>
    <span>Rp12.000</span>
    <button>Lihat Detail</button>
</div>

<div class="card">
    <img src="img/stiker-hologram2.png" alt="">
    <h3>Hologram Gold</h3>
    <p>Premium.</p>
    <span>Rp15.000</span>
    <button>Lihat Detail</button>
</div>

<?php } ?>

</div>

</div>

</body>
</html>