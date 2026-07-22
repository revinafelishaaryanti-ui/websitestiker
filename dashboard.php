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

    $dataKeranjang = mysqli_fetch_assoc($qKeranjang);

    $jumlah_keranjang = $dataKeranjang['total'];

}

$produk_rekomendasi = mysqli_query($conn,"
SELECT * FROM produk
WHERE rekomendasi='1'
ORDER BY id_produk DESC
LIMIT 3
");
if(!$produk_rekomendasi){
    die("Error Produk Rekomendasi : ".mysqli_error($conn));
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
        Selamat datang kembali di Stickerin.
    </p>

</div>

<?php }else{ ?>

<div class="welcome-box">

    <h2>
        Selamat Datang di Stickerin 👋
    </h2>

    <p>
        Login untuk mulai memesan stiker dan melihat status pesananmu.
    </p>

    <a href="login.php" class="btn-login-home">
        Login Sekarang
    </a>

</div>

<?php } ?>

    <!-- HEADER -->

<div class="header">

    <h1>STICKERIN</h1>


    <div class="icon-group">
    <form action="cari.php" method="GET" class="search-box">

<input
type="text"
name="keyword"
placeholder="Cari stiker...">

<button type="submit">

    <i class="fa-solid fa-magnifying-glass"></i>

</button>

</form>

        <a href="notifikasi.php">
            <i class="fa-solid fa-bell"></i>
        </a>


        <a href="akun.php">
            <i class="fa-solid fa-user"></i>
        </a>



        <?php if(isset($_SESSION['id'])){ ?>

        <a href="keranjang.php" class="cart">

            <i class="fa-solid fa-cart-shopping"></i>

            <?php if($jumlah_keranjang > 0){ ?>

            <span>
                <?= $jumlah_keranjang; ?>
            </span>

            <?php } ?>

        </a>

        <?php }else{ ?>


        <a href="login.php" class="cart">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>


        <?php } ?>


    </div>

</div>


<!-- MENU -->

<div class="navbar">


<a href="dashboard.php">
Beranda
</a>


<a href="kategori.php">
Kategori
</a>


<a href="costum.php">

Custom Sticker

</a>


<?php if(isset($_SESSION['id'])){ ?>

<a href="pesanan.php">
Pesanan
</a>

<?php } ?>


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

        <?php if(isset($_SESSION['id'])){ ?>

<a href="custom.php">

<?php }else{ ?>

<a href="login.php?redirect=custom_stiker.php">

<?php } ?>

<button>PESAN SEKARANG</button>

</a>
        </a>
    </div>

    <img src="img/maskotstiker.png" alt="Maskot">

</div>
<?php if(isset($_SESSION['id'])){ ?>

<?php } ?>


    <!-- PRODUK -->

<!-- PRODUK REKOMENDASI -->

<div class="section-title">

    <h3>Produk Rekomendasi</h3>

</div>


<div class="produk">

<?php while($p = mysqli_fetch_assoc($produk_rekomendasi)){ ?>


    <div class="card">

    <a href="detail_produk.php?id=<?= $p['id_produk']; ?>">

        <img src="img/<?= htmlspecialchars($p['gambar']); ?>" alt="">

        <h4><?= $p['nama_produk']; ?></h4>

        <p>
            Rp <?= number_format($p['harga'],0,",","."); ?>
        </p>

    </a>

    <a href="detail_produk.php?id=<?= $p['id_produk']; ?>">
    <button class="btn-detail">
        Lihat Detail
    </button>
</a>

    </div>

<?php } ?> <!-- Penutup while -->

</div> <!-- .produk -->

</div> <!-- .mobile -->
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
</body>
</html>