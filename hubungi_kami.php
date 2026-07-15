<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("Location: login.php");
    exit;

}


$id_user = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Hubungi Kami</title>

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


<h2>Hubungi Kami</h2>


</div>



<div class="hubungi-container">


<div class="hubungi-header">


<div class="hubungi-icon">

<i class="fa-solid fa-headset"></i>

</div>


<div>

<h1>Hubungi Kami</h1>

<p>Kami siap membantu kebutuhan Anda.</p>

</div>


</div>



<div class="hubungi-content">


<div class="kontak-item">

<div class="kontak-icon">
<i class="fa-brands fa-whatsapp"></i>
</div>

<div>

<h3>WhatsApp</h3>

<p>0859-6117-0391</p>

</div>

</div>




<div class="kontak-item">

<div class="kontak-icon">
<i class="fa-solid fa-envelope"></i>
</div>

<div>

<h3>Email</h3>

<p>support@stickerin.com</p>

</div>

</div>




<div class="kontak-item">

<div class="kontak-icon">
<i class="fa-brands fa-instagram"></i>
</div>

<div>

<h3>Instagram</h3>

<p>@stickerin.id</p>

</div>

</div>



<div class="pesan-box">

<h3>Kirim Pesan</h3>

<p>
Jika ada pertanyaan, kendala pemesanan,
atau membutuhkan bantuan, silakan hubungi kami.
</p>


<a href="https://wa.me/6281234567890" class="btn-hubungi">

<i class="fa-brands fa-whatsapp"></i>
Chat WhatsApp

</a>


</div>



</div>



</div>


</div>


</body>

</html>