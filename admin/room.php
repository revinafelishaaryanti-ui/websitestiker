<?php
session_start();
include '../koneksi.php';


$tipe = isset($_GET['tipe']) ? $_GET['tipe'] : 'produk';

$id_order = isset($_GET['id_order']) ? (int)$_GET['id_order'] : 0;


// Ambil nama pelanggan
if($tipe=="custom"){

    $q_user = mysqli_query($conn,"
        SELECT users.nama
        FROM custom_sticker
        INNER JOIN users 
        ON custom_sticker.id = users.id
        WHERE custom_sticker.id_custom='$id_order'
    ");

}else{

    $q_user = mysqli_query($conn,"
        SELECT users.nama
        FROM pesanan
        INNER JOIN users 
        ON pesanan.id_user = users.id
        WHERE pesanan.id_pesanan='$id_order'
    ");

}


if(!$q_user){
    die("Query user gagal : ".mysqli_error($conn));
}


$data_user = mysqli_fetch_assoc($q_user);


if(isset($data_user['nama'])){
    $nama_pelanggan = $data_user['nama'];
}else{
    $nama_pelanggan = "Pelanggan";
}



// tentukan kolom chat
if($tipe=="custom"){

    $kolom = "id_custom";

}else{

    $kolom = "id_pesanan";

}


// Ambil data chat pelanggan
$query = mysqli_query($conn,"
    SELECT * FROM chat
    WHERE $kolom='$id_order'
    ORDER BY waktu ASC
");


// tandai pesan user sudah dibaca
mysqli_query($conn,"
    UPDATE chat 
    SET dibaca='1'
    WHERE $kolom='$id_order'
    AND pengirim='user'
");

?>


<!DOCTYPE html>
<html>
<head>

<title>Room Chat</title>

<link rel="stylesheet" href="chat.css">

</head>


<body>


<div class="chat-container">


<!-- Header Chat -->

<div class="chat-header">

<a href="<?= $tipe=="custom" ? 'detail_costum.php?id='.$id_order : 'detail_pesanan.php?id='.$id_order; ?>" class="back">
←
</a>

<div>

<h3>
👤 <?= htmlspecialchars($nama_pelanggan); ?>
</h3>

<span class="online">
● Online
</span>

</div>


</div>



<!-- Isi Chat -->

<div class="chat-box">


<?php

while($data = mysqli_fetch_assoc($query)){


if($data['pengirim']=="admin"){

?>


<div class="pesan-admin">

    <div class="isi-pesan">
        <?= htmlspecialchars($data['pesan']); ?>
    </div>


    <?php if($data['file']!=""){ ?>

    <br>

    <img src="../img/<?= $data['file']; ?>" width="200">

    <?php } ?>


    <div class="jam-chat">
    <?= date('H:i', strtotime($data['waktu'])); ?>
    </div>

</div>


<?php


}else{


?>


<div class="pesan-user">


<?= htmlspecialchars($data['pesan']); ?>


<?php
if(!empty($data['file'])){
?>

<br>

<img 
src="data:image/png;base64,<?= trim($data['file']); ?>"
width="200"
style="border-radius:10px;">

<?php
}
?>


<small>
<?= $data['waktu']; ?>
</small>


</div>


<?php

}

}

?>


</div>



<!-- Form Kirim -->

<form action="kirim_chat.php" method="POST" enctype="multipart/form-data" class="chat-form">


<input type="hidden" name="id_order" value="<?= $id_order; ?>">

<input type="hidden" name="tipe" value="<?= $tipe; ?>">

<input 
type="text" 
name="pesan"
placeholder="Tulis pesan..."
required
>


<input 
type="file"
name="file"
>


<button type="submit">
Kirim
</button>

<a class="btn"
href="cetak_resi_custom.php?id=<?= $data['id_custom']; ?>"
target="_blank">

<i class="fa-solid fa-print"></i>

Cetak Resi

</a>
</form>



</div>


</body>
</html>