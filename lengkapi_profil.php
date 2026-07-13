<?php
session_start();

include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

$query = mysqli_query($conn,"
SELECT *
FROM users
WHERE id='$id_user'
");

$user = mysqli_fetch_assoc($query);


if(isset($_POST['simpan'])){

    $no_hp = mysqli_real_escape_string($conn,$_POST['no_hp']);
    $alamat = mysqli_real_escape_string($conn,$_POST['alamat']);


    mysqli_query($conn,"
    UPDATE users
    SET 
    no_hp='$no_hp',
    alamat='$alamat'
    WHERE id='$id_user'
    ");


    header("Location: checkout.php?id=".$_GET['id']);
    exit;

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Lengkapi Profil</title>

<link rel="stylesheet" href="stayle.css">

</head>


<body>


<div class="mobile">


<h2>
Lengkapi Data Pengiriman
</h2>


<form method="POST">


<label>No HP</label>

<input 
type="text"
name="no_hp"
value="<?= $user['no_hp']; ?>"
required>


<br><br>


<label>Alamat</label>

<textarea 
name="alamat"
required><?= $user['alamat']; ?></textarea>


<br><br>


<button 
name="simpan"
type="submit">

Simpan & Lanjut Checkout

</button>


</form>


</div>


</body>

</html>