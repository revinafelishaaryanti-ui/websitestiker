<?php
session_start();
include '../koneksi.php';

// ==========================
// CEK LOGIN ADMIN
// ==========================
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// ==========================
// FILTER TANGGAL
// ==========================
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : "";
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : "";

$wherePesanan = "";
$whereCustom = "";

if($tanggal_awal != "" && $tanggal_akhir != ""){
    $wherePesanan = "
    AND DATE(pesanan.tanggal)
    BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ";
    $whereCustom = "
    AND DATE(custom_sticker.tanggal)
    BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ";
}

// ==========================
// QUERY PESANAN BIASA
// ==========================
$queryPesanan = "
SELECT
    pesanan.id_pesanan AS id_order,
    users.nama AS nama,
    'Pesanan Produk' AS jenis,
    pesanan.total_harga AS total,
    pesanan.metode_pembayaran,
    pesanan.status,
    pesanan.tanggal
FROM pesanan
JOIN users ON pesanan.id_user = users.id
WHERE pesanan.status='Selesai'
$wherePesanan
";

// ==========================
// QUERY CUSTOM STIKER
// ==========================
$queryCustom = "
SELECT
    custom_sticker.id_custom AS id_order,
    users.nama AS nama,
    'Custom Sticker' AS jenis,
    custom_sticker.total_harga AS total,
    custom_sticker.metode_pembayaran,
    custom_sticker.status,
    custom_sticker.tanggal
FROM custom_sticker
JOIN users ON custom_sticker.id = users.id
WHERE custom_sticker.status='Selesai'
$whereCustom
";

// ==========================
// GABUNG DATA
// ==========================
$query = $queryPesanan . "
UNION ALL
" . $queryCustom . "
ORDER BY tanggal DESC
";

$data = mysqli_query($conn,$query);
if(!$data){
    die("Query Error : ".mysqli_error($conn));
}

// ==========================
// HITUNG TOTAL
// ==========================
$totalPendapatan = 0;
while($row=mysqli_fetch_assoc($data)){
    $totalPendapatan += $row['total'];
}
mysqli_data_seek($data,0);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendapatan Admin</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<?php include 'include/sidebar.php'; ?>

<div class="main">
    <?php include 'include/navbar.php'; ?>

    <div class="content">

        <!-- HEADER + TOTAL PENDAPATAN -->
        <div class="pendapatan-header">
            <div class="pendapatan-header-left">
                <h2><i class="fa-solid fa-chart-line"></i> Laporan Pendapatan</h2>
                <p>Total seluruh pendapatan dari pesanan produk & custom sticker.</p>
            </div>
            <div class="pendapatan-total-box">
                <span>Total Pendapatan</span>
                <h3>Rp <?=number_format($totalPendapatan,0,',','.');?></h3>
            </div>
        </div>

        <!-- FILTER TANGGAL -->
        <div class="filter-tanggal">
            <form method="GET">
                <label><i class="fa-regular fa-calendar"></i> Dari</label>
                <input type="date" name="tanggal_awal" value="<?=$tanggal_awal;?>">
                <label><i class="fa-regular fa-calendar"></i> Sampai</label>
                <input type="date" name="tanggal_akhir" value="<?=$tanggal_akhir;?>">
                <button type="submit"><i class="fa-solid fa-search"></i> Cari</button>
                <a href="pendapatan.php"><i class="fa-solid fa-rotate-left"></i> Reset</a>
            </form>
        </div>

        <!-- TABEL PENDAPATAN -->
        <div class="tabel-pendapatan">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pelanggan</th>
                        <th>Jenis</th>
                        <th>Total Harga</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($data)>0){ ?>
                        <?php while($row=mysqli_fetch_assoc($data)){ ?>
                            <tr>
                                <td><?=$row['id_order'];?></td>
                                <td><?=htmlspecialchars($row['nama']);?></td>
                                <td><span class="badge jenis-badge <?=($row['jenis']=='Custom Sticker')?'badge-custom':'badge-produk';?>"><?=$row['jenis'];?></span></td>
                                <td class="harga-td">Rp <?=number_format($row['total'],0,',','.');?></td>
                                <td><?=$row['metode_pembayaran'];?></td>
                                <td><span class="badge badge-success"><?=$row['status'];?></span></td>
                                <td><?=date('d-m-Y',strtotime($row['tanggal']));?></td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr><td colspan="7" class="empty-data">Belum ada data pendapatan</td></tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3" class="total-label">Total Pendapatan</td>
                        <td class="total-value" colspan="4">Rp <?=number_format($totalPendapatan,0,',','.');?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>
</body>
</html>
