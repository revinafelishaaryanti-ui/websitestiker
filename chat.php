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
$id_costum = isset($_GET['id_costum']) ? (int)$_GET['id_costum'] : 0;

// Ambil semua chat
$query = mysqli_query($conn,"
SELECT *
FROM chat
WHERE id_costum='$id_costum'
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

<?= nl2br($row['pesan']); ?>

<?php
if($row['file']!=""){
?>

<br><br>

<img src="uploads/chat/<?= $row['file']; ?>">

<?php } ?>

</div>

</div>

<?php }else{ ?>

<div class="chat-admin">

<div class="bubble-admin">

<?= nl2br($row['pesan']); ?>

<?php
if($row['file']!=""){
?>

<br><br>

<img src="uploads/chat/<?= $row['file']; ?>">

<?php } ?>

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