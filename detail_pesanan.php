<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];
$id = $_GET['id'];
$tipe = $_GET['tipe'];

// PESANAN CUSTOM
if($tipe=="custom"){
    $query = mysqli_query($conn,"
        SELECT
        custom_sticker.*,
        produk.nama_produk,
        produk.gambar,
        produk.harga
        FROM custom_sticker
        LEFT JOIN produk ON custom_sticker.id_produk = produk.id_produk
        WHERE custom_sticker.id_custom='$id'
        AND custom_sticker.id='$id_user'
    ");
}
// PESANAN PRODUK BIASA
else{
    $query = mysqli_query($conn,"
        SELECT
        pesanan.*,
        detail_pesanan.jumlah,
        detail_pesanan.harga,
        produk.nama_produk,
        produk.gambar
        FROM pesanan
        JOIN detail_pesanan ON pesanan.id_pesanan = detail_pesanan.id_pesanan
        JOIN produk ON detail_pesanan.id_produk = produk.id_produk
        WHERE pesanan.id_pesanan='$id'
    ");
}

if(mysqli_num_rows($query)==0){
    die("Pesanan tidak ditemukan.");
}

$data = mysqli_fetch_assoc($query);
$total_harga = $data['harga'] * $data['jumlah'];

// Fungsi untuk badge status
function getStatusBadge($status){
    $classes = [
        'Menunggu' => 'badge-menunggu',
        'Menunggu Persetujuan' => 'badge-persetujuan',
        'Diproses' => 'badge-diproses',
        'Dikemas' => 'badge-dikemas',
        'Dikirim' => 'badge-dikirim',
        'Selesai' => 'badge-selesai'
    ];
    $class = isset($classes[$status]) ? $classes[$status] : 'badge-menunggu';
    return "<span class='status-badge $class'>$status</span>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="stayle.css">
    <style>
        /* ========================
           DETAIL PESANAN USER - MODERN
        ======================== */
        .detail-page {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header dengan tombol back */
        .detail-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .detail-header .back-btn {
            width: 45px;
            height: 45px;
            background: #f0f0ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #6C3BD1;
            font-size: 20px;
            transition: .3s;
            flex-shrink: 0;
        }

        .detail-header .back-btn:hover {
            background: #6C3BD1;
            color: #fff;
            transform: translateX(-3px);
        }

        .detail-header h1 {
            font-size: 24px;
            color: #222;
            margin: 0;
        }

        .detail-header h1 span {
            font-size: 14px;
            color: #888;
            font-weight: normal;
            display: block;
            margin-top: 3px;
        }

        /* Card utama */
        .detail-main-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
            margin-bottom: 20px;
        }

        /* Section produk (gambar + info) */
        .detail-produk-section {
            display: flex;
            gap: 25px;
            padding: 25px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .detail-produk-section .gambar-wrapper {
            width: 180px;
            height: 180px;
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid #f0f0ff;
            flex-shrink: 0;
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail-produk-section .gambar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .detail-produk-section .info-wrapper {
            flex: 1;
            min-width: 250px;
        }

        .detail-produk-section .info-wrapper h2 {
            font-size: 24px;
            color: #222;
            margin-bottom: 18px;
        }

        /* Grid info */
        .detail-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .detail-info-item {
            padding: 14px 16px;
            background: #f8f9ff;
            border-radius: 12px;
            border: 1px solid #f0f0ff;
        }

        .detail-info-item .label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .detail-info-item .value {
            font-size: 16px;
            color: #222;
            font-weight: 600;
        }

        .detail-info-item .value.harga {
            color: #6C3BD1;
            font-size: 18px;
        }

        .detail-info-item.full {
            grid-column: 1 / -1;
        }

        .detail-info-item .catatan-text {
            font-size: 14px;
            color: #555;
            font-weight: 400;
            line-height: 1.6;
            margin-top: 4px;
        }

        /* Status bar */
        .detail-status-section {
            padding: 0 25px 25px;
        }

        .status-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #f8f9ff, #f0f0ff);
            padding: 18px 22px;
            border-radius: 15px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .status-bar .status-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .status-bar .status-left .status-icon {
            width: 48px;
            height: 48px;
            background: #6C3BD1;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 22px;
            flex-shrink: 0;
        }

        .status-bar .status-left .status-label {
            font-size: 13px;
            color: #888;
        }

        .status-bar .status-left .status-label strong {
            color: #222;
            display: block;
            margin-top: 4px;
            font-size: 15px;
        }

        /* Badge status */
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
        }
        .badge-menunggu { background: #f59e0b; }
        .badge-persetujuan { background: #f97316; }
        .badge-diproses { background: #3b82f6; }
        .badge-dikemas { background: #8b5cf6; }
        .badge-dikirim { background: #06b6d4; }
        .badge-selesai { background: #10b981; }

        /* File section (custom) */
        .file-section {
            padding: 0 25px 25px;
        }

        .file-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .file-card {
            background: #f8f9ff;
            border: 1px solid #f0f0ff;
            border-radius: 14px;
            padding: 16px;
            text-align: center;
        }

        .file-card i {
            font-size: 32px;
            color: #6C3BD1;
            margin-bottom: 10px;
        }

        .file-card h4 {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
        }

        .file-card .file-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            background: #6C3BD1;
            color: #fff;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: .3s;
        }

        .file-card .file-link:hover {
            background: #5b2db3;
            transform: translateY(-2px);
        }

        /* Tombol aksi */
        .action-section {
            display: flex;
            gap: 12px;
            padding: 0 25px 25px;
            flex-wrap: wrap;
        }

        .action-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 20px;
            border-radius: 14px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            transition: .3s;
            min-width: 140px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .btn-kembali {
            background: #f0f0ff;
            color: #6C3BD1;
        }
        .btn-kembali:hover {
            background: #e0e0ff;
            box-shadow: 0 5px 15px rgba(108,59,209,.15);
        }

        .btn-chat-admin {
            background: linear-gradient(135deg, #ff9800, #f57c00);
            color: #fff;
        }
        .btn-chat-admin:hover {
            box-shadow: 0 5px 15px rgba(255,152,0,.3);
        }

        .btn-lacak {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: #fff;
        }
        .btn-lacak:hover {
            box-shadow: 0 5px 15px rgba(6,182,212,.3);
        }

        /* Responsive */
        @media (max-width: 600px) {
            .detail-page { padding: 15px; }
            .detail-produk-section { flex-direction: column; align-items: center; text-align: center; }
            .detail-produk-section .gambar-wrapper { width: 150px; height: 150px; }
            .detail-info-grid { grid-template-columns: 1fr; }
            .file-grid { grid-template-columns: 1fr; }
            .action-section { flex-direction: column; }
            .action-btn { min-width: auto; }
            .detail-header h1 { font-size: 20px; }
        }
    </style>
</head>
<body>

<div class="mobile">
    <div class="detail-page">

        <!-- HEADER -->
        <div class="detail-header">
            <a href="pesanan.php" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1>
                Detail Pesanan
                <span>#<?= htmlspecialchars($id); ?></span>
            </h1>
        </div>

        <!-- CARD UTAMA -->
        <div class="detail-main-card">

            <!-- PRODUK -->
            <div class="detail-produk-section">
                <div class="gambar-wrapper">
                    <img src="img/<?= htmlspecialchars($data['gambar']); ?>" alt="<?= htmlspecialchars($data['nama_produk']); ?>">
                </div>
                <div class="info-wrapper">
                    <h2><?= htmlspecialchars($data['nama_produk']); ?></h2>

                    <div class="detail-info-grid">
                        <div class="detail-info-item">
                            <div class="label">Harga Satuan</div>
                            <div class="value harga">Rp <?= number_format($data['harga'],0,',','.'); ?></div>
                        <div class="detail-info-item">
                            <div class="label">Jumlah</div>
                            <div class="value"><?= $data['jumlah']; ?> pcs</div>
                        <div class="detail-info-item">
                            <div class="label">Total Harga</div>
                            <div class="value harga">Rp <?= number_format($total_harga,0,',','.'); ?></div>
                        <div class="detail-info-item">
                            <div class="label">Tipe Pesanan</div>
                            <div class="value"><?= $tipe == 'custom' ? 'Custom Sticker' : 'Produk Reguler'; ?></div>

                        <?php if($tipe=="custom"){ ?>
                        <div class="detail-info-item">
                            <div class="label">Ukuran</div>
                            <div class="value"><?= htmlspecialchars($data['ukuran']); ?></div>
                        <?php } ?>

                        <?php if($tipe=="custom" && !empty($data['catatan'])){ ?>
                        <div class="detail-info-item full">
                            <div class="label">Catatan</div>
                            <div class="catatan-text"><?= nl2br(htmlspecialchars($data['catatan'])); ?></div>
                        <?php } ?>
                    </div>
            </div>

            <!-- STATUS -->
            <div class="detail-status-section">
                <div class="status-bar">
                    <div class="status-left">
                        <div class="status-icon">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="status-label">
                            Status Pesanan
                            <strong><?= htmlspecialchars($data['status']); ?></strong>
                        </div>
                    <?= getStatusBadge($data['status']); ?>
                </div>

            <!-- FILE CUSTOM -->
            <?php if($tipe=="custom"){ ?>
            <div class="file-section">
                <div class="file-grid">
                    <?php if(!empty($data['file_logo'])){ ?>
                    <div class="file-card">
                        <i class="fa-solid fa-image"></i>
                        <h4>Logo</h4>
                        <a href="uploads/custom/<?= $data['file_logo']; ?>" target="_blank" class="file-link">
                            <i class="fa-solid fa-eye"></i> Lihat Logo
                        </a>
                    </div>
                    <?php } ?>

                    <?php if(!empty($data['file_referensi'])){ ?>
                    <div class="file-card">
                        <i class="fa-solid fa-link"></i>
                        <h4>Referensi</h4>
                        <a href="uploads/custom/<?= $data['file_referensi']; ?>" target="_blank" class="file-link">
                            <i class="fa-solid fa-eye"></i> Lihat Referensi
                        </a>
                    </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <!-- TOMBOL AKSI -->
            <div class="action-section">
                <a href="pesanan.php" class="action-btn btn-kembali">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <a href="chat.php?id_order=<?= $id; ?>&tipe=<?= $tipe; ?>" class="action-btn btn-chat-admin">
                    <i class="fa-solid fa-comments"></i> Chat Admin
                </a>
                <?php if($data['status']=="Dikirim"){ ?>
                <a href="lacak_paket.php?id=<?= $id; ?>&tipe=<?= $tipe; ?>" class="action-btn btn-lacak">
                    <i class="fa-solid fa-truck"></i> Lacak Paket
                </a>
                <?php } ?>
            </div>
    </div>

</body>
</html>
