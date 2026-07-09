<?php
session_start();
include '../koneksi.php';


?>

<!DOCTYPE html>
<html>
<head>
<title>Chat Pelanggan</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="chat.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="chat-container">

<h2>💬 Chat Pelanggan</h2>


<?php

$query = mysqli_query($conn,"
SELECT 
id_custom,
MAX(waktu) AS terakhir
FROM chat
GROUP BY id_custom
ORDER BY terakhir DESC
");


while($data=mysqli_fetch_assoc($query)){

?>


<div class="customer">

<div>

<h3>
👤 Pelanggan #<?= $data['id_custom']; ?>
</h3>


<p>
Pesanan Stickerin
</p>


</div>


<a href="room.php?id_custom=<?= $data['id_custom']; ?>">
Buka Chat →
</a>


</div>


<?php } ?>


</div>


</body>
</html>