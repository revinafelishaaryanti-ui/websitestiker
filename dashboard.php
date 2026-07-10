<?php
session_start();

include 'koneksi.php';

$produk_rekomendasi = mysqli_query($conn,"
SELECT * FROM produk
WHERE rekomendasi='1'
ORDER BY id_produk DESC
LIMIT 3
");

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

            <?php if(isset($_SESSION['id'])){ ?>

<a href="akun.php">
<i class="fa-solid fa-user"></i>
</a>

<?php }else{ ?>

<a href="login.php">
<i class="fa-solid fa-user"></i>
</a>

<?php } ?>
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



    <!-- PRODUK -->

<!-- PRODUK REKOMENDASI -->

<div class="section-title">

    <h3>Produk Rekomendasi</h3>

</div>


<div class="produk">

<?php while($p = mysqli_fetch_assoc($produk_rekomendasi)){ ?>


<div class="card">

    <a href="detail_produk.php?id=<?= $p['id_produk']; ?>">


        <img 
        src="uploads/produk/<?= $p['gambar']; ?>"
        style="width:140px;height:auto;display:block;margin:0 auto;">


        <h4>
        <?= $p['nama_produk']; ?>
        </h4>


        <p>
        Rp <?= number_format($p['harga'],0,",","."); ?>
        </p>
<?php if(isset($_SESSION['id'])){ ?>

<a href="keranjang.php?id=<?= $p['id_produk']; ?>">
    <button>
        Beli Sekarang
    </button>
</a>


<?php }else{ ?>


<a href="login.php">
    <button>
        Beli Sekarang
    </button>
</a>


<?php } ?>

    </a>

</div>


<?php } ?>


</div>

    </div>

</div>
</body>
</html>