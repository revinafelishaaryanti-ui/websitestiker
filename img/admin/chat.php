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

    <!-- Daftar Chat -->
    <div class="chat-container">

<?php

// Ambil chat dari custom sticker (group by user)
$query_custom = mysqli_query($conn,"
SELECT 
    chat.id_pengirim AS user_id,
    MAX(chat.waktu) AS terakhir,
    users.nama AS nama_pelanggan
FROM chat 
LEFT JOIN users ON chat.id_pengirim = users.id
WHERE chat.id_custom IS NOT NULL AND chat.pengirim = 'user'
GROUP BY chat.id_pengirim
");

$all = [];
while($row = mysqli_fetch_assoc($query_custom)){
    $all[] = $row;
}

// Ambil chat dari pesanan produk (group by user)
$query_produk = mysqli_query($conn,"
SELECT 
    chat.id_pengirim AS user_id,
    MAX(chat.waktu) AS terakhir,
    users.nama AS nama_pelanggan
FROM chat
LEFT JOIN users ON chat.id_pengirim = users.id
WHERE chat.id_pesanan IS NOT NULL AND chat.pengirim = 'user'
GROUP BY chat.id_pengirim
");

while($row = mysqli_fetch_assoc($query_produk)){
    $found = false;
    foreach($all as $k => $v){
        if($v['user_id'] == $row['user_id']){
            if(!empty($row['terakhir']) && $row['terakhir'] > $v['terakhir']){
                $all[$k]['terakhir'] = $row['terakhir'];
            }
            $found = true;
            break;
        }
    }
    if(!$found){
        $all[] = $row;
    }
}

// Urutkan berdasarkan waktu terakhir
usort($all, function($a, $b){
    return strtotime($b['terakhir']) - strtotime($a['terakhir']);
});

foreach($all as $data){

    $nama = !empty($data['nama_pelanggan']) ? $data['nama_pelanggan'] : 'Pelanggan';
    $user_id = $data['user_id'];
    
    // Cari id_order dan tipe terakhir
    $q_last = mysqli_query($conn,"SELECT id_custom, id_pesanan FROM chat WHERE id_pengirim='$user_id' AND pengirim='user' ORDER BY waktu DESC LIMIT 1");
    $last = mysqli_fetch_assoc($q_last);
    
    if(!empty($last['id_custom'])){
        $link_order = $last['id_custom'];
        $link_tipe = 'custom';
    } else {
        $link_order = $last['id_pesanan'];
        $link_tipe = 'produk';
    }

?>

        <div class="customer">

            <div class="customer-info">

                <h3>
                    <i class="fa-solid fa-user"></i>
                    <?= htmlspecialchars($nama); ?>
                </h3>

                <p>Pesanan Stickerin</p>

            </div>

            <a href="room.php?id_order=<?= $link_order; ?>&tipe=<?= $link_tipe; ?>" class="btn-detail">
                <i class="fa-solid fa-comments"></i>
                Buka Chat
            </a>

        </div>

<?php } ?>

    </div>

</div>

</body>
</html>
