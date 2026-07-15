<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("Location: login.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tentang Aplikasi</title>

<link rel="stylesheet" href="stayle.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>


<body>


<div class="mobile">


<div class="topbar">

<a href="akun.php">

<i class="fa-solid fa-arrow-left"></i>

</a>

<h2>Tentang Aplikasi</h2>

</div>



<div class="tentang-container">



<div class="tentang-header">


<div class="tentang-icon">

<i class="fa-solid fa-store"></i>

</div>


<div>

<h1>Stickerin</h1>

<p>Aplikasi pemesanan stiker custom.</p>

</div>


</div>




<div class="tentang-content">


<h3>Tentang Stickerin</h3>

<p>
Stickerin merupakan aplikasi yang menyediakan berbagai macam
stiker menarik dan berkualitas. Pengguna dapat melihat produk,
memilih kategori, melakukan pemesanan, serta membeli stiker
sesuai kebutuhan.
</p>



<h3>Tujuan Aplikasi</h3>

<p>
Stickerin dibuat untuk memudahkan pengguna dalam mencari dan
membeli stiker secara online dengan proses yang lebih mudah,
cepat, dan praktis.
</p>



<h3>Fitur Aplikasi</h3>


<ul>

<li>
<i class="fa-solid fa-check"></i>
Melihat berbagai produk stiker
</li>


<li>
<i class="fa-solid fa-check"></i>
Memilih kategori stiker
</li>


<li>
<i class="fa-solid fa-check"></i>
Keranjang belanja
</li>


<li>
<i class="fa-solid fa-check"></i>
Pemesanan dan pembayaran
</li>


<li>
<i class="fa-solid fa-check"></i>
Mengelola informasi akun
</li>


</ul>




<div class="versi-box">

<p>
Versi Aplikasi
</p>

<h2>Stickerin v1.0</h2>

</div>



</div>


</div>



</div>


</body>

</html>