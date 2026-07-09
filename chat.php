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
$id_custom = isset($_GET['id_custom']) ? (int)$_GET['id_custom'] : 0;


// Ambil semua chat
$query = mysqli_query($conn,"
SELECT *
FROM chat
WHERE id_custom='$id_custom'
ORDER BY waktu ASC
");

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
if($row['file']!=""){
?>

<br>

<img src="img/<?= $row['file']; ?>">

<?php } ?>


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
if($row['file']!=""){
?>

<br>

<img src="uploads/chat/<?= $row['file']; ?>">


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
name="id_custom"
value="<?= $id_custom ?>">



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