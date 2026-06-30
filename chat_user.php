<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

if (!isset($_GET['id_custom'])) {
    die("Pesanan tidak ditemukan.");
}

$id_custom = (int) $_GET['id_custom'];

// Cek apakah pesanan ini milik user yang login
$cek = mysqli_query($conn, "SELECT * FROM custom_sticker 
WHERE id_custom='$id_custom' AND id='$id_user'");

if(mysqli_num_rows($cek)==0){
    die("Pesanan tidak ditemukan.");
}

// Ambil semua chat
$chat = mysqli_query($conn,"
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

<?php while($row=mysqli_fetch_assoc($chat)){ ?>

<?php if($row['pengirim']=="user"){ ?>

<div class="chat-user">

<div class="bubble-user">

<?= nl2br(htmlspecialchars($row['pesan'])) ?>

<?php if($row['file']!=""){ ?>

<br><br>

<img src="uploads/chat/<?= htmlspecialchars($row['file']) ?>">

<?php } ?>

</div>

</div>

<?php }else{ ?>

<div class="chat-admin">

<div class="bubble-admin">

<?= nl2br(htmlspecialchars($row['pesan'])) ?>

<?php if($row['file']!=""){ ?>

<br><br>

<img src="uploads/chat/<?= htmlspecialchars($row['file']) ?>">

<?php } ?>

</div>

</div>

<?php } ?>

<?php } ?>

</div>

<form
action="kirim_chat_user.php"
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