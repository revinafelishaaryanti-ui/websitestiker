<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$jml_produk = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM produk"));
$jml_kategori = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM kategori"));
$jml_user = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));
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

            <h4>Total Produk</h4>

            <h2><?= $jml_produk ?></h2>

            <small>Produk tersedia</small>

        </div>

    </div>

    <div class="stat-card pendapatan">

        <div class="stat-icon">
            <i class="fa-solid fa-sack-dollar"></i>
        </div>

        <div class="stat-info">

            <h4>Pendapatan Hari Ini</h4>

            <h2>Rp 0</h2>

            <small>Belum ada transaksi</small>

        </div>

    </div>

    <div class="stat-card pesanan">

        <div class="stat-icon">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>

        <div class="stat-info">

            <h4>Total Pesanan</h4>

            <h2>0</h2>

            <small>Pesanan masuk</small>

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

            <li>✅ Produk baru ditambahkan</li>

            <li>✅ Kategori diperbarui</li>

            <li>✅ Pesanan baru masuk</li>

            <li>✅ Sistem berjalan normal</li>

        </ul>

    </div>

</div>

</div> <!-- Penutup .main pindahkan ke sini -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('salesChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [{
            label: 'Penjualan',
            data: [12, 19, 8, 15, 25, 20, 30],
            borderWidth: 3,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>
</body>

</html>