
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


    <div class="profile-card">

<div class="profile-header">

    <div class="title-section">
        <div class="icon-circle">
            👤
        </div>

        <div>
            <h1>Profil Saya</h1>
            <p>Kelola informasi pribadi dan akun Anda.</p>
        </div>
    </div>

    <div class="mascot">
        <img src="img/maskotstiker.png" alt="Maskot">
    </div>

</div>

<div class="profile-body">

    <h3>Informasi Akun</h3>

    <div class="form-row">
        <div class="label-icon">👤</div>
        <label>Nama Lengkap</label>
        <input type="text" value="Kaila Queen Alexsander Vina">
    </div>

    <div class="form-row">
        <div class="label-icon">✉️</div>
        <label>Email</label>
        <input type="email" value="user@gmail.com">
    </div>

    <div class="form-row">
        <div class="label-icon">📞</div>
        <label>No. HP</label>
        <input type="text" value="0812-3456-7890">
    </div>

    <div class="form-row">
        <div class="label-icon">🔒</div>
        <label>Password</label>
        <input type="password" value="12345678">
    </div>

    <div class="button-group">
        <a href="ubah_profil.php" class="btn-primary" >
            ✏ Ubah Profil
</a>

        <button class="btn-outline">
            🔒 Ubah Password
        </button>
    </div>

</div>

</div>