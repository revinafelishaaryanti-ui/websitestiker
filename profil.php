<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("Location: login.php");
    exit;

}


$id_user = $_SESSION['id'];


// ambil data user
$dataUser = mysqli_query($conn,"
SELECT * FROM users
WHERE id='$id_user'
");


$user = mysqli_fetch_assoc($dataUser);

if(!$user){
    die("Data user tidak ditemukan");
}

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



    <div class="profile-header">


<div class="foto-profil-box">

<?php if(!empty($user['foto']) && $user['foto'] != "default.png"){ ?>

    <img 
id="fotoProfil"
src="<?= $user['foto']; ?>"
alt="Foto Profil">
<?php }else{ ?>

<img 
src="img/default.png"
alt="Foto Profil">

<?php } ?>

</div>


            <div class="title-section">

                <div class="icon-circle">
                    👤
                </div>


                <div>

                    <h1>Profil Saya</h1>

                    <p>
                    Kelola informasi pribadi dan akun Anda.
                    </p>

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

                <input 
                type="text" 
                value="<?= $user['nama']; ?>">

            </div>



            <div class="form-row">

                <div class="label-icon">✉️</div>

                <label>Email</label>

                <input 
                type="email" 
                value="<?= $user['email']; ?>">

            </div>



            <div class="form-row">

                <div class="label-icon">📞</div>

                <label>No. HP</label>

                <input 
                type="text" 
                value="<?= $user['no_hp']; ?>">

            </div>



            <div class="form-row">

                <div class="label-icon">🔒</div>

                <label>Password</label>

                <input 
                type="password" 
                value="********">

            </div>



            <div class="button-group">

                <a href="ubah_profil.php" class="btn-primary">
                    ✏ Ubah Profil
                </a>

            </div>


        </div>


    </div>


</div>

</body>
</html>