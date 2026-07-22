<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("location:login.php");
    exit;
}


$id_user=$_SESSION['id'];


// Ambil alamat lama dari users
$query_user = mysqli_query($conn,"
    SELECT nama, no_hp, alamat
    FROM users
    WHERE id='$id_user'
");

$user = mysqli_fetch_assoc($query_user);


// Ambil alamat tambahan dari alamat_user
$query_alamat = mysqli_query($conn,"
    SELECT *
    FROM alamat_user
    WHERE id_user='$id_user'
");



?>


<!DOCTYPE html>
<html>

<head>

<title>Pilih Alamat</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
}


.container{
width:500px;
margin:40px auto;
background:white;
padding:25px;
border-radius:15px;
}


.alamat{
border:1px solid #ddd;
padding:15px;
border-radius:10px;
margin-bottom:15px;
}


.tambah{

display:block;
margin-top:20px;
color:#000;
font-weight:bold;
text-decoration:none;

}

button{

background:#000;
color:white;
border:none;
padding:10px 20px;
border-radius:8px;

}

.alamat{

display:block;
border:1px solid #ddd;
padding:15px;
border-radius:10px;
margin-bottom:15px;
text-decoration:none;
color:black;

}

.alamat span{

color:#000;
font-size:13px;

}

.aksi a{

display:inline-block;
padding:8px 15px;
border-radius:8px;
text-decoration:none;
font-size:14px;
font-weight:bold;
}


.pilih{

background:#000;
color:white;

}


.edit{

background:#ddd;
color:#000;

}
</style>

</head>


<body>


<div class="container">


<h2>
Pilih Alamat Pengiriman
</h2>



<div class="alamat">


<div>

<b>
<?= htmlspecialchars($user['nama']); ?>
</b>


&nbsp;&nbsp;


<b>
<?= htmlspecialchars($user['no_hp']); ?>
</b>

</div>


<br>


<?= nl2br(htmlspecialchars($user['alamat'])); ?>


<br><br>


<div class="aksi">

<a class="pilih"
href="checkout.php?id_produk=<?= $_GET['id_produk']; ?>&alamat=lama">

Pilih

</a>


<a class="edit"
href="edit_alamat.php">

Edit

</a>

</div>


</div>
<br>

<?php while($row=mysqli_fetch_assoc($query_alamat)){ ?>


<div class="alamat">


<div>

<b>
<?= htmlspecialchars($row['nama_penerima']); ?>
</b>


&nbsp;&nbsp;


<b>
<?= htmlspecialchars($row['no_hp']); ?>
</b>

</div>


<br>


<?= htmlspecialchars($row['desa']); ?>,
<?= htmlspecialchars($row['kecamatan']); ?>,
<?= htmlspecialchars($row['kabupaten']); ?>,
<?= htmlspecialchars($row['provinsi']); ?>


<br>

RT/RW <?= htmlspecialchars($row['rt_rw']); ?>,
<?= htmlspecialchars($row['dusun']); ?>


<br>

<?= htmlspecialchars($row['patokan']); ?>,
<?= htmlspecialchars($row['kode_pos']); ?>


<br><br>


<div class="aksi">

<a class="pilih"
href="checkout.php?id_produk=<?= $_GET['id_produk']; ?>&id_alamat=<?= $row['id_alamat']; ?>">

Pilih

</a>


<a class="edit"
href="edit_alamat.php?id=<?= $row['id_alamat']; ?>">

Edit

</a>


</div>


</div>


<?php } ?>
<a href="tambah_alamat.php?id_produk=<?= $_GET['id_produk']; ?>" class="tambah">
    + Tambah Alamat Baru
</a>
<a href="javascript:history.back();">
Kembali ke Checkout
</a>

</div>


</body>

</html>