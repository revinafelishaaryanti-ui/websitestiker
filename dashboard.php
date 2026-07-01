
<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stickerin</title>
<link rel="stylesheet" href="stayle.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="mobile">

    <!-- HEADER -->
    <div class="header">

        <h1>STICKERIN</h1>

        <div class="navbar">

        <a href="dashboard.php">Beranda</a>

        <a href="kategori.php">Kategori</a>

        <a href="pesanan.php">Pesanan</a>


    </div>

        <div class="icon-group">

            <i class="fa-regular fa-bell"></i>

            <i class="fa-solid fa-magnifying-glass"></i>

        <a href="akun.php">
            <i class="fa-solid fa-user"></i>
        </a>

            <a href="keranjang.php" class="cart">
    <i class="fa-solid fa-cart-shopping"></i>
    <span>3</span>
</a>

        </div>

    </div>


    <!-- BANNER -->

   <div class="banner">

    <div class="banner-text">
        <h2>
            CUSTOM STIKER<br>
            SESUAI GAYAMU!
        </h2>

        <p>
            Bebas desain, berbagai pilihan bahan dan ukuran
        </p>

        <a href="custom_stiker.php">
            <button>PESAN SEKARANG</button>
        </a>
    </div>

    <img src="img/maskotstiker.png" alt="Maskot">

</div>

    <!-- KATEGORI -->

    <div class="section-title">

        <h3>Kategori</h3>

        <a href="kategori.php">
            Lihat semua >
        </a>

    </div>

    <div class="kategori">

        <div class="item">
            <div class="icon">+</div>
            <p>Semua</p>
        </div>

        <div class="item">
            <img src="img/hologram.jpeg">
            <p>Hologram</p>
        </div>

        <div class="item">
            <img src="img/transparan.png">
            <p>Transparan</p>
        </div>

        <div class="item">
            <img src="img/vinyl.png">
            <p>Vinyl</p>
        </div>

        <div class="item">
            <img src="img/semuaa.png">
            <p>Lainnya</p>
        </div>

    </div>

    <!-- PRODUK -->

    <div class="section-title">

        <h3>Produk Populer</h3>

    </div>

    <div class="produk">

        <div class="card">
            <a href="detail_vinyl.php">
                <img src="img/stiker vinyl.png" class="img vinyl" style="width:140px; height:auto; display:block; margin:0 auto;">

                <h4>Stiker Vinyl</h4>
                <p>Rp 10.000</p>
            </a>
        </div>

        <div class="card">
            <a href="detail_hologram.php">
             <img src="img/stiker-hologram.png" class="img-hologram" style="width:140px; height:auto; display:block; margin:0 auto;">

                <h4>Stiker Hologram</h4>
                <p>Rp 12.000</p>
            </a>
        </div>

        <div class="card">
            <a href="detail_transparan.php">
                                <img src="img/stiker-transparan.png" class="img-transparan" style="width:140px; height:auto; display:block; margin:0 auto;">
                <h4>Stiker Transparan</h4>
                <p>Rp 9.000</p>
            </a>
        </div>

    </div>

</div>
</body>
</html>