<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id_custom'])) {
    die("Pesanan tidak ditemukan.");
}

$id_custom = (int)$_GET['id_custom'];

/* Ambil data pesanan */
$pesanan = mysqli_query($conn,"
SELECT
custom_sticker.*,
users.nama,
produk.nama_produk
FROM custom_sticker
LEFT JOIN users
ON custom_sticker.id = users.id
LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk
WHERE custom_sticker.id_custom='$id_custom'
");

if(mysqli_num_rows($pesanan)==0){
    die("Pesanan tidak ditemukan.");
}

$data = mysqli_fetch_assoc($pesanan);

/* Ambil chat */

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

<title>Chat User</title>

<link rel="stylesheet" href="../stayle.css">
<link rel="stylesheet" href="assets/css/chat_admin.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<h2>

Chat User

</h2>

<p>

<b>Nama :</b>

<?= htmlspecialchars($data['nama']) ?>

</p>

<p>

<b>Produk :</b>

<?= htmlspecialchars($data['nama_produk']) ?>

</p>

<hr>

<div class="chat-body">

<?php while($row=mysqli_fetch_assoc($chat)){ ?>

<?php if($row['pengirim']=="admin"){ ?>

<div class="chat-admin">

<div class="bubble-admin">

<?= nl2br(htmlspecialchars($row['pesan'])) ?>

<?php if($row['file']!=""){ ?>

<br><br>

<img
src="../uploads/chat/<?= htmlspecialchars($row['file']) ?>"
width="200">

<?php } ?>

</div>

</div>

<?php }else{ ?>

<div class="chat-user">

<div class="bubble-user">

<?= nl2br(htmlspecialchars($row['pesan'])) ?>

<?php if($row['file']!=""){ ?>

<br><br>

<img
src="../uploads/chat/<?= htmlspecialchars($row['file']) ?>"
width="200">

<?php } ?>

</div>

</div>

<?php } ?>

<?php } ?>

</div>

<form
action="kirim_chat_admin.php"
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
placeholder="Tulis balasan..."
required>

<br><br>

<input
type="file"
name="file">

<br><br>

<button
type="submit">

Kirim

</button>

</form>

<hr>

<h3>Upload Hasil Desain</h3>

<form
action="upload_desain.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id_custom"
value="<?= $id_custom ?>">

<input
type="file"
name="desain"
required>

<br><br>

<button>

Upload Desain

</button>

</form>

</div>

</div>

</body>

</html>