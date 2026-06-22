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