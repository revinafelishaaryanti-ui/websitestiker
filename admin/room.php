<?php
session_start();
include '../koneksi.php';


if(!isset($_GET['id_custom'])){
    echo "Pelanggan tidak ditemukan";
    exit;
}


$id_custom = $_GET['id_custom'];


// Ambil data chat pelanggan
$query = mysqli_query($conn,"
    SELECT * FROM chat
    WHERE id_custom='$id_custom'
    ORDER BY waktu ASC
");


// tandai pesan user sudah dibaca
mysqli_query($conn,"
    UPDATE chat 
    SET dibaca='1'
    WHERE id_custom='$id_custom'
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

<a href="chat.php" class="back">
←
</a>


<div>

<h3>
👤 Pelanggan #<?= $id_custom; ?>
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


<?php if($data['file']!=""){ ?>

<br>

<img src="../img/<?= $data['file']; ?>">
<?php } ?>


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


<input type="hidden" name="id_custom" value="<?= $id_custom; ?>">


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


</form>



</div>


</body>
</html>