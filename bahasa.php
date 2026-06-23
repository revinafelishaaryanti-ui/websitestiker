<?php

session_start();

if(!isset($_SESSION['lang'])){
    $_SESSION['lang'] = 'id';
}

$teks = [

'id' => [

'beranda' => 'Beranda',
'kategori' => 'Kategori',
'pesanan' => 'Pesanan',
'profil' => 'Profil',
'pengaturan' => 'Pengaturan',
'ubah_profil' => 'Ubah Profil',
'simpan' => 'Simpan Perubahan',
'batal' => 'Batal',
'bahasa' => 'Bahasa'

],

'en' => [

'beranda' => 'Home',
'kategori' => 'Category',
'pesanan' => 'Orders',
'profil' => 'Profile',
'pengaturan' => 'Settings',
'ubah_profil' => 'Edit Profile',
'simpan' => 'Save Changes',
'batal' => 'Cancel',
'bahasa' => 'Language'

]

];

$lang = $_SESSION['lang'];
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

            <a href="dashboard.php">
    <?= $teks[$lang]['beranda']; ?>
    </a>

    <a href="kategori.php">
    <?= $teks[$lang]['kategori']; ?>
    </a>

    <a href="pesanan.php">
    <?= $teks[$lang]['pesanan']; ?>
    </a>


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

<div class="bahasa-card" onclick="toggleBahasa()">

    <div class="bahasa-icon">
        🌐
    </div>

    <div class="bahasa-text">
        <h3>Bahasa</h3>
        <p>Pilih bahasa yang digunakan di aplikasi</p>
    </div>

</div>

<div id="bahasaMenu" class="bahasa-menu">
    <button onclick="gantiBahasa('id')">🇮🇩 Bahasa Indonesia</button>
    <button onclick="gantiBahasa('en')">🇺🇸 English</button>
    <button onclick="gantiBahasa('jp')">🇯🇵 Jepang</button>
    <button onclick="gantiBahasa('kr')">🇰🇷 Korea</button>
</div>

<script>
function toggleBahasa() {
    let menu = document.getElementById("bahasaMenu");

    if(menu.style.display === "block"){
        menu.style.display = "none";
    }else{
        menu.style.display = "block";
    }
}

function gantiBahasa(lang){

    localStorage.setItem("bahasa", lang);

    alert("Bahasa berhasil diubah ke: " + lang);

    location.reload();
}
</script>