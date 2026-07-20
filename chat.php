<?php
session_start();
include 'koneksi.php';

// Pastikan user login
if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

// Ambil id custom dari URL
$id_order = isset($_GET['id_order']) ? (int)$_GET['id_order'] : 0;
$tipe = isset($_GET['tipe']) ? $_GET['tipe'] : 'produk';

if($tipe=="custom"){

    $query = mysqli_query($conn,"
    SELECT *
    FROM chat
    WHERE id_custom='$id_order'
    ORDER BY waktu ASC
    ");

}else{

    $query = mysqli_query($conn,"
    SELECT *
    FROM chat
    WHERE id_pesanan='$id_order'
    ORDER BY waktu ASC
    ");

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Chat Admin</title>

<link rel="stylesheet" href="stayle.css">
<link rel="stylesheet" href="chat.css">

</head>


<body>


<div class="mobile">


<div class="chat-header">

<a href="pesanan.php" class="btn-kembali">
    ←
</a>

<h2>Chat Admin Stickerin</h2>

</div>



<div class="chat-body">


<?php while($row=mysqli_fetch_assoc($query)){ ?>


<?php if($row['pengirim']=="user"){ ?>


<div class="chat-user">

<div class="bubble-user">


<div class="isi-chat">

<?= nl2br($row['pesan']); ?>

</div>



<?php
if(!empty($row['file'])){

    // cek apakah file berupa base64
    if(strpos($row['file'], 'iVBOR') === 0 || strpos($row['file'], '/9j/') === 0){

        $mime = "image/png";

        if(strpos($row['file'], '/9j/') === 0){
            $mime = "image/jpeg";
        }

?>

<br>

<img 
src="data:<?= $mime ?>;base64,<?= trim($row['file']); ?>"
style="max-width:220px;border-radius:10px;">

<?php

    }else{

        // kalau data lama berupa nama file
?>

<br>

<img 
src="img/<?= $row['file']; ?>"
style="max-width:220px;border-radius:10px;">

<?php
    }
}
?>


<div class="jam-chat">

<?= date('H:i', strtotime($row['waktu'])); ?>

</div>


</div>

</div>



<?php }else{ ?>


<div class="chat-admin">


<div class="bubble-admin">


<div class="isi-chat">

<?= nl2br($row['pesan']); ?>

</div>



<?php
if(!empty($row['file'])){

    $mime = "image/png";

    if(substr($row['file'],0,4)=="/9j/"){
        $mime = "image/jpeg";
    }
?>

<br>

<img 
src="data:<?= $mime ?>;base64,<?= trim($row['file']); ?>"
style="max-width:220px;border-radius:10px;">

<?php } ?>


<div class="jam-chat">

<?= date('H:i', strtotime($row['waktu'])); ?>

</div>


</div>


</div>



<?php } ?>


<?php } ?>


</div>



<form
action="kirim_chat.php"
method="POST"
enctype="multipart/form-data"
class="chat-form">


<input
type="hidden"
name="id_order"
value="<?= $id_order; ?>">

<input
type="hidden"
name="tipe"
value="<?= $tipe; ?>">


<input
type="text"
name="pesan"
placeholder="Tulis pesan..."
required>



<input
type="file"
name="file">



<button type="submit">

Kirim

</button>


</form>


</div>


</body>

</html>