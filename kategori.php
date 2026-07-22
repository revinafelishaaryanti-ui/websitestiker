<?php
session_start();
include 'koneksi.php';

$jumlah_keranjang = 0;

if(isset($_SESSION['id'])){

    $id_user = $_SESSION['id'];

    $qKeranjang = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM keranjang
    WHERE id_user='$id_user'
    ");

    if($qKeranjang){
        $dataKeranjang = mysqli_fetch_assoc($qKeranjang);
        $jumlah_keranjang = $dataKeranjang['total'];
    }

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
    <?php if(isset($_SESSION['id'])){ ?>

<div class="welcome-box">

    <h2>
        Halo, <?= htmlspecialchars($_SESSION['nama']); ?> 👋
    </h2>

    <p>
        Pilih kategori stiker yang ingin kamu pesan.
    </p>

</div>

<?php }else{ ?>

<div class="welcome-box">

    <h2>
        Selamat Datang di Stickerin 👋
    </h2>

    <p>
        Login untuk mulai memesan stiker dan menikmati semua fitur Stickerin.
    </p>

    <a href="login.php" class="btn-login-home">
        Login Sekarang
    </a>

</div>

<?php } ?>

    <!-- HEADER -->
    <div class="header">

        <h1>STICKERIN</h1>

        <div class="navbar">

        <a href="dashboard.php">Beranda</a>

        <a href="kategori.php">Kategori</a>

        <a href="costum.php">
        Custom Sticker
    </a>


        <?php if(isset($_SESSION['id'])){ ?>

<a href="pesanan.php">Pesanan</a>

<?php } ?>


    </div>

        <div class="icon-group">

            <i class="fa-regular fa-bell"></i>

            <form action="cari.php" method="GET" class="search-box">

<input
type="text"
name="keyword"
placeholder="Cari stiker...">

<button type="submit">

<a href="cari.php" class="search-icon">
    <i class="fa-solid fa-magnifying-glass"></i>
</a>
</button>

</form>
        <a href="akun.php">
            <i class="fa-solid fa-user"></i>
        </a>

        <?php if(isset($_SESSION['id'])){ ?>

<a href="keranjang.php" class="cart">

    <i class="fa-solid fa-cart-shopping"></i>

    <?php if($jumlah_keranjang > 0){ ?>
        <span><?= $jumlah_keranjang; ?></span>
    <?php } ?>

</a>

<?php }else{ ?>

<a href="login.php" class="cart">

    <i class="fa-solid fa-cart-shopping"></i>

</a>

<?php } ?>

        </div>

    </div>

    <div class="layout">

    <!-- Content -->
    <div class="main-content">

        <div class="heading">
            <h1>Kategori Stiker</h1>
            <p>Pilih kategori stiker</p>
        </div>


        <div class="category-grid">


            <!-- Card 1 -->
            <a href="produk.php?id=1" class="kategori-link">

                <div class="card">

                    <div class="card-image">
                        <img src="img/stiker_vin.png">
                    </div>

                    <div class="card-body">
                        <h3>Sticker Vinyl</h3>

                        <p>
                            Tahan air dan cuaca untuk kebutuhan outdoor.
                        </p>

                    </div>

                </div>

            </a>

        <!-- Card 2 -->
        <a href="produk.php?id=2" class="kategori-link">

        <div class="card">

            <div class="card-image">
            <img src="img/stiker_holo.png" alt="">
                    </div>
            <div class="card-body">
                <h3>Sticker Hologram</h3>

                <p>
                    Efek hologram premium yang menarik.
                </p>
            </div>

        </div>

        </a>

        <!-- Card 3 -->
        <a href="produk.php?id=3" class="kategori-link">

        <div class="card">

            <div class="card-image">
            <img src="img/stiker_trans.png" alt="">
            </div>

            <div class="card-body">
                <h3>Sticker Transparan</h3>

                <p>
                    Tampilan elegan dan modern.
                </p>

            </div>

                </div>
                <!-- Card 4 -->
                <a href="produk.php?id=4" class="kategori-link">

                <div class="card">

                <div class="card-image">
                <img src="img/stiker_kertas.png" alt="">
                </div>

                <div class="card-body">
                    <h3>Sticker kertas</h3>

                    <p>
                        pilihan ekonomis untuk kebutuhan label dan brending.
                    </p>

                </div>
                    </div>
                    </a>
                <!-- Card 5 -->
                <a href="produk.php?id=5" class="kategori-link">

                <div class="card">

                <div class="card-image">
                <img src="img/stiker_die.png" alt="">
                </div>

                <div class="card-body">
                <h3>Sticker Die Cut</h3>

                <p>
                dipotong mengikuti bentuk desain,lebih fleksibel.
                </p>

                </div>

                </div>
                </a>

            <!-- Card 6 -->
            <a href="produk.php?id=6" class="kategori-link">

            <div class="card">

            <div class="card-image">
            <img src="img/stiker_bulat.png" alt="">
            </div>
            <div class="card-body">
            <h3>Sticker bulat</h3>

            <p>
            bentuk bulat klasik untuk berbagai kebutuhan.
            </p>

            </div>

            </div>
            </a>


            <!-- Card 7 -->
            <a href="produk.php?id=7" class="kategori-link">

                <div class="card">

            <div class="card-image">
            <img src="img/stiker_kotak.png" alt="">
            </div>

            <div class="card-body">
            <h3>Sticker kotak</h3>

            <p>
                bentuk kotak rapi untuk tampilan profesional.
            </p>

            </div>
            </div>
            </a>

            <!-- Card 8 -->
            <a href="produk.php?id=8" class="kategori-link">

            <div class="card">

            <div class="card-image">
            <img src="img/stiker_persegi.png" alt="">
            </div>

            <div class="card-body">
            <h3>Sticker persegi</h3>

            <p>
            bentuk persegi panjangn untuk informasi yang lebih detail.
            </p>

            </div>
            </div>
            </a>

            <!-- Card 9 -->
            <a href="produk.php?id=9" class="kategori-link">

                <div class="card">

            <div class="card-image">
            <img src="img/stiker_label.png" alt="">
            </div>

            <div class="card-body">
            <h3>Sticker label</h3>

            <p>
            lebih khusu untuk produk,harga, atau barcode.
            </p>

            </div>
            </div>
            </a>

            <!-- Card 10 -->
            <a href="produk.php?id=10" class="kategori-link">

            <div class="card">

            <div class="card-image">
            <img src="img/stiker_promosi.png" alt="">
            </div>

            <div class="card-body">
            <h3>Sticker promosi</h3>

            <p>
            tingkatkan promosi dengan sticker menarik dan eye-catching.
            </p>

            </div>
            </div>
            </a>

            <!-- Card 11 -->
            <a href="produk.php?id=11" class="kategori-link">

                <div class="card">

            <div class="card-image">
            <img src="img/aksesoris_ctak.png" alt="">
            </div>

            <div class="card-body">
            <h3>aksesoris cetak</h3>

            <p>
            gantungan kunci,pin,dan aksesoris custum lainnya.
            </p>

            </div>
            </div>
            </a>


</main>

</div>

<footer class="footer">

    <div class="footer-content">

        <div class="footer-box">
            <h3>Stickerin</h3>
            <p>
                Platform custom sticker yang membantu kamu membuat
                desain sticker sesuai keinginan dengan mudah dan cepat.
            </p>
        </div>

        <div class="footer-box">
            <h4>Menu</h4>
            <a href="dashboard.php">Beranda</a>
            <a href="kategori.php">Kategori</a>
            <a href="keranjang.php">Keranjang</a>
            <a href="pesanan.php">Pesanan</a>
        </div>

        <div class="footer-box">
            <h4>Bantuan</h4>
            <a href="#">Cara Pemesanan</a>
            <a href="#">Pembayaran</a>
            <a href="#">Pengiriman</a>
            <a href="#">Hubungi Kami</a>
        </div>

        <div class="footer-box">
            <h4>Kontak</h4>
            <p>📍 Indonesia</p>
            <p>📱 WhatsApp : 08xxxxxxxxxx</p>
            <p>✉ Email : stickerin@gmail.com</p>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 Stickerin. Semua Hak Dilindungi.
    </div>

</footer>