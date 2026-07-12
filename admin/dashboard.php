<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include '../koneksi.php';
$today = date('Y-m-d');
// Aktivitas hari ini
$aktivitas = mysqli_query($conn,"
SELECT 
'Pesanan baru masuk' AS aktivitas,
tanggal
FROM pesanan
WHERE DATE(tanggal)='$today'

UNION ALL

SELECT
'Produk baru ditambahkan' AS aktivitas,
tanggal
FROM produk
WHERE DATE(tanggal)='$today'

ORDER BY tanggal DESC
LIMIT 5
");

// Jumlah pelanggan hari ini
$query_pelanggan = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM users
WHERE DATE(tanggal)='$today'
");

$data_pelanggan = mysqli_fetch_assoc($query_pelanggan);

$jml_pelanggan = $data_pelanggan['total'];

if($jml_pelanggan==""){
    $jml_pelanggan = 0;
}
// ===============================
// TOTAL PRODUK TERJUAL HARI INI
// ===============================

$today = date('Y-m-d');

$data_produk = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(jumlah) AS total
FROM detail_pesanan dp
JOIN pesanan p ON dp.id_pesanan = p.id_pesanan
WHERE DATE(p.tanggal)='$today'
"));

$produk_terjual = $data_produk['total'];

if($produk_terjual==""){
    $produk_terjual = 0;
}
$query_kategori = mysqli_query($conn,"SELECT * FROM kategori");

if(!$query_kategori){
    die("Error kategori : ".mysqli_error($conn));
}

$jml_kategori = mysqli_num_rows($query_kategori);
$query_user = mysqli_query($conn,"SELECT * FROM users");

if(!$query_user){
    die("Error user : ".mysqli_error($conn));
}

$jml_user = mysqli_num_rows($query_user);
// ===============================
// DATA HARI INI (UNTUK CARD)
// ===============================

$today = date('Y-m-d');

// Produk hari ini
$query_produk = mysqli_query($conn,"
SELECT *
FROM produk
WHERE DATE(tanggal)='$today'
");

if(!$query_produk){
    die("Error produk : ".mysqli_error($conn));
}

$produk_hari_ini = mysqli_num_rows($query_produk);

// Pesanan hari ini
$pesanan_hari_ini = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE DATE(tanggal)='$today'
"));

// Pendapatan hari ini
$data_pendapatan = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total_harga) AS total
FROM pesanan
WHERE DATE(tanggal)='$today'
"));

$pendapatan_hari_ini = $data_pendapatan['total'];

if($pendapatan_hari_ini==""){
    $pendapatan_hari_ini = 0;
}
// ===============================
// DATA GRAFIK PENJUALAN 7 HARI TERAKHIR
// ===============================

$label = [];
$data = [];

$queryChart = mysqli_query($conn,"
SELECT
DATE_FORMAT(tanggal,'%d/%m') AS hari,
SUM(total_harga) AS total
FROM pesanan
GROUP BY DATE(tanggal)
ORDER BY DATE(tanggal) ASC
LIMIT 7
");

while($row = mysqli_fetch_assoc($queryChart)){

    $label[] = $row['hari'];
    $data[] = $row['total'];

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Dashboard Admin</title>

<link rel="stylesheet" href="admin.css?v=1">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="welcome-box">

    <div class="welcome-text">

        <h2>👋 Halo, <?= $_SESSION['admin_nama']; ?>!</h2>

        <p>
            Selamat datang di Dashboard Stickerin.
            Kelola produk, pesanan, pelanggan, dan custom sticker dengan mudah.
        </p>

    </div>

    <div class="welcome-image">

        <img src="../img/admin-dashboard.png" alt="">

    </div>

</div>


<div class="cards">

    <div class="stat-card produk">

        <div class="stat-icon">
            <i class="fa-solid fa-box"></i>
        </div>

        <div class="stat-info">

        <h4>Produk Terjual</h4>

<h2><?= $produk_terjual ?></h2>

<small>Produk terjual hari ini</small>
        </div>

    </div>

    <div class="stat-card pendapatan">

        <div class="stat-icon">
            <i class="fa-solid fa-sack-dollar"></i>
        </div>

        <div class="stat-info">

            <h4>Pendapatan Hari Ini</h4>

            <h2>Rp <?= number_format($pendapatan_hari_ini,0,",","."); ?></h2>

<small>Pendapatan hari ini</small>

        </div>

    </div>

    <div class="stat-card pesanan">

        <div class="stat-icon">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>

        <div class="stat-info">

        <h4>Pesanan Hari Ini</h4>

<h2><?= $pesanan_hari_ini ?></h2>

<small>Pesanan masuk hari ini</small>

        </div>

    </div>
    <div class="stat-card pelanggan">

    <div class="stat-icon">
        <i class="fa-solid fa-users"></i>
    </div>

    <div class="stat-info">

        <h4>Jumlah Pelanggan</h4>

        <h2><?= $jml_pelanggan ?></h2>

        <small>Total pelanggan terdaftar</small>

    </div>

</div>

</div>


<div class="dashboard-grid">

    <div class="chart-card">

        <h3>📈 Statistik Penjualan</h3>

        <canvas id="salesChart"></canvas>

    </div>

    <div class="activity-card">

        <h3>📝 Aktivitas Terbaru</h3>

        <ul>

<?php if(mysqli_num_rows($aktivitas) > 0): ?>

<?php while($a = mysqli_fetch_assoc($aktivitas)): ?>

<li>
    ✅ <?= $a['aktivitas']; ?>
</li>

<?php endwhile; ?>

<?php else: ?>

<li>
    Tidak ada aktivitas hari ini
</li>

<?php endif; ?>

</ul>

    </div>

</div>

</div> <!-- Penutup .main pindahkan ke sini -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('salesChart');

new Chart(ctx,{

    type:'line',

    data:{

        labels: <?= json_encode($label); ?>,

        datasets:[{

            label:'Penjualan',

            data: <?= json_encode($data); ?>,

            borderColor:'#4F7CFF',

            backgroundColor:'rgba(79,124,255,.2)',

            borderWidth:3,

            fill:true,

            tension:0.4

        }]

    },

    options:{

        responsive:true,

        scales:{
            y:{
                beginAtZero:true
            }
        }

    }

});

</script>

</body>
</html>
</body>

</html>