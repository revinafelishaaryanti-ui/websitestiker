
<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

// Ambil pesanan custom milik user
$query = mysqli_query($conn,"
SELECT *
FROM custom_sticker
WHERE id='$id_user'
ORDER BY tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Pesanan Saya</title>

<link rel="stylesheet" href="stayle.css">

</head>

<body>

<div class="mobile">

<h2>Pesanan Saya</h2>

<?php
if(mysqli_num_rows($query)>0){
?>

<?php
while($row=mysqli_fetch_assoc($query)){
?>

<div class="card">

<h3>🎨 Custom Sticker</h3>

<p>
<b>ID Pesanan :</b>
<?= $row['id_custom']; ?>
</p>

<p>
<b>Ukuran :</b>
<?= $row['ukuran']; ?>
</p>

<p>
<b>Jumlah :</b>
<?= $row['jumlah']; ?>
</p>

<p>
<b>Status :</b>
<?= $row['status']; ?>
</p>

<br>

<a
href="chat_user.php?id_custom=<?= $row['id_custom']; ?>"
class="auth-btn">

💬 Chat Admin

</a>

</div>

<br>

<?php
}
?>

<?php
}else{
?>

<div class="card">

<p>Belum ada pesanan custom.</p>

</div>

<?php
}
?>

</div>

</body>

</html>