<?php
session_start();
include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Chat Pelanggan</title>

<link rel="stylesheet" href="admin.css">
<link rel="stylesheet" href="chat.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

    <!-- Header -->
    <div class="page-header">

        <div>

            <h2>💬 Chat Pelanggan</h2>

            <p>Kelola percakapan pelanggan Stickerin.</p>

        </div>

    </div>

    <!-- Daftar Chat -->
    <div class="chat-container">

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

            <div class="customer-info">

                <h3>
                    <i class="fa-solid fa-user"></i>
                    Pelanggan #<?= $data['id_custom']; ?>
                </h3>

                <p>Pesanan Stickerin</p>

            </div>

            <a href="room.php?id_custom=<?= $data['id_custom']; ?>" class="btn-detail">
                <i class="fa-solid fa-comments"></i>
                Buka Chat
            </a>

        </div>

<?php } ?>

    </div>

</div>

</div>

</body>
</html>