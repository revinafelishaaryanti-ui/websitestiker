
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

            <form action="cari.php" method="GET" class="search-box">

<input
type="text"
name="keyword"
placeholder="Cari stiker...">

<button type="submit">

<i class="fa-solid fa-magnifying-glass"></i>

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

    <div class="settings-page">

<div class="settings-header">
    <h2>Pengaturan</h2>
    <p>Kelola informasi akun dan preferensi aplikasi Anda</p>
</div>

<div class="settings-card">

<a href="ubah_profil.php" class="setting-item">
    <div class="setting-left">
        <div class="icon-box">👤</div>
        <div>
            <h4>Ubah Profil</h4>
            <p>Ubah informasi profil akun Anda seperti foto profil, nama, dan lainnya.</p>
        </div>
    </div>
    <span>›</span>
</a>

    <div class="setting-item">
        <div class="setting-left">
            <div class="icon-box">🛡️</div>
            <div>
                <h4>Kebijakan Privasi</h4>
                <p>Baca kebijakan privasi kami untuk melindungi data Anda.</p>
            </div>
        </div>
        <span>›</span>
    </div>

    <a href="syarat_ketentuan.php" class="setting-item">

    <div class="setting-left">

        <div class="icon-box">📄</div>

        <div>
            <h4>Syarat & Ketentuan</h4>
            <p>Baca syarat dan ketentuan penggunaan aplikasi Stickerin.</p>
        </div>

    </div>

    <span>›</span>

</a>

<a href="hubungi_kami.php" class="setting-item">

<div class="setting-left">

<div class="icon-box">📞</div>

<div>
<h4>Hubungi Kami</h4>
<p>Hubungi kami jika membutuhkan bantuan.</p>
</div>

</div>

<span>›</span>

</a>

<a href="tentang_aplikasi.php" class="setting-item">

<div class="setting-left">

<div class="icon-box">ℹ️</div>

<div>
<h4>Tentang Aplikasi</h4>

<p>Informasi mengenai aplikasi Stickerin.</p>

</div>

</div>

<span>›</span>

</a>

<div class="logout-card">
    <div class="setting-left">
        <div class="icon-box logout-icon">↪</div>
        <div>
            <h4 class="logout-text">Keluar</h4>
            <p>Keluar dari akun Anda.</p>
        </div>
    </div>
    <span>›</span>
</div>

</div>