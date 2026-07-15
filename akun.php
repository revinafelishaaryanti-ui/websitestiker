<?php
session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("Location: login.php?redirect=akun.php");
    exit;

}


$id_user = $_SESSION['id'];


// jumlah keranjang
$jumlah_keranjang = 0;


$qKeranjang = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM keranjang
    WHERE id_user='$id_user'
");


if($qKeranjang){

    $dataKeranjang = mysqli_fetch_assoc($qKeranjang);

    $jumlah_keranjang = $dataKeranjang['total'];

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

        <?php if(isset($_SESSION['id'])){ ?>

<a href="pesanan.php">Pesanan</a>

<?php } ?>

    </div>

        <div class="icon-group">

        <a href="notifikasi.php">
    <i class="fa-regular fa-bell"></i>
</a>
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
</a>

        </div>

    </div>

    <!-- AKUN -->
    <div class="akun-container">

        <div class="akun-banner">

            <div>
                <h2>Akun Saya</h2>
                <p>Kelola informasi akun dan aktivitas Anda</p>
            </div>

            <img src="img/maskotstiker.png">

        </div>

        <a href="profil.php" class="menu-akun">
            <div class="menu-kiri">
                <i class="fa-regular fa-user"></i>
                <div>
                    <h4>Profil Saya</h4>
                    <p>Lihat dan edit informasi profil Anda</p>
                </div>
            </div>


            <i class="fa-solid fa-chevron-right"></i>
        </a>

        <a href="penganturan.php" class="menu-akun">
            <div class="menu-kiri">
                <i class="fa-solid fa-gear"></i>
                <div>
                    <h4>Pengaturan</h4>
                    <p>Atur preferensi akun</p>
                </div>
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>
        

        <a href="logout.php" class="menu-akun">
            <div class="menu-kiri">
                <i class="fa-solid fa-right-from-bracket"></i>
                <div>
                    <h4>Keluar</h4>
                    <p>Keluar dari akun Anda</p>
                </div>
            </div>

            <i class="fa-solid fa-chevron-right"></i>
        </a>

    </div>

</div>

</body>
</html>