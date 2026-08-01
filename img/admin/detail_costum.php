<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}

if(!isset($_GET['id'])){
    die("Pesanan tidak ditemukan.");
}

$id_custom = (int)$_GET['id'];

/* ===========================
   SIMPAN PERUBAHAN
=========================== */

if(isset($_POST['konfirmasi_bayar'])){


    mysqli_query($conn,"
    UPDATE custom_sticker
    
    SET status_pembayaran='Lunas'
    
    WHERE id_custom='$id_custom'
    ");
    
    
    echo "
    <script>
    alert('Pembayaran berhasil dikonfirmasi');
    location='detail_costum.php?id=$id_custom';
    </script>
    ";
    
    
    }
    
if(isset($_POST['simpan'])){

    $status = mysqli_real_escape_string($conn,$_POST['status']);
    $nomor_resi = mysqli_real_escape_string($conn,$_POST['nomor_resi']);

$kurir = "Lainnya";

if(stripos($nomor_resi,"JNE")===0){
    $kurir="JNE";
}
elseif(stripos($nomor_resi,"JT")===0){
    $kurir="J&T";
}
elseif(stripos($nomor_resi,"SICEPAT")===0){
    $kurir="SiCepat";
}
elseif(stripos($nomor_resi,"SPX")===0){
    $kurir="Shopee Express";
}
elseif(stripos($nomor_resi,"POS")===0){
    $kurir="Pos Indonesia";
}
elseif(stripos($nomor_resi,"ID")===0){
    $kurir="ID Express";
}
    $estimasi = mysqli_real_escape_string($conn,$_POST['estimasi']);

    $namaFile = "";

    if(!empty($_FILES['file_desain']['tmp_name'])){

        $file_desain = base64_encode(
            file_get_contents($_FILES['file_desain']['tmp_name'])
        );
    
        mysqli_query($conn,"
        UPDATE custom_sticker
        SET
        file_desain='$file_desain'
        WHERE id_custom='$id_custom'
        ");
    
    }

    mysqli_query($conn,"
UPDATE custom_sticker
SET
status='$status',
kurir='$kurir',
nomor_resi='$nomor_resi',
estimasi='$estimasi'
WHERE id_custom='$id_custom'
");

    echo "<script>

    alert('Data berhasil diperbarui');

    location='detail_costum.php?id=$id_custom';

    </script>";

}


/* ===========================
   AMBIL DATA PESANAN
=========================== */

$query = mysqli_query($conn,"
SELECT

custom_sticker.*,

users.nama,
users.email,
users.no_hp,
users.alamat,

produk.nama_produk,
produk.gambar,
produk.harga

FROM custom_sticker

LEFT JOIN users
ON custom_sticker.id = users.id

LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk

WHERE custom_sticker.id_custom='$id_custom'
");

if(mysqli_num_rows($query)==0){

    die("Data tidak ditemukan.");

}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Detail Custom Sticker</title>

<link rel="stylesheet" href="admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="page-header">

    <div>
        <h2>🎨 Detail Custom Sticker</h2>
        <p>Informasi lengkap pesanan custom pelanggan.</p>
    </div>

    <a href="customsticker.php" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>

</div>


<div class="detail-wrapper">

<!-- ================= DATA ================= -->

<div class="detail-card">

<h3>
<i class="fa-solid fa-user"></i>
Data Pelanggan
</h3>

<div class="customer-grid">

<div class="customer-box">
<b>Nama</b> :
<span><?= $data['nama']; ?></span>
</div>

<div class="customer-box">
<b>No HP</b> :
<span><?= $data['no_hp']; ?></span>
</div>

<div class="customer-box">
<b>Email</b> :
<span><?= $data['email']; ?></span>
</div>

<div class="customer-box">
<b>Alamat</b> :
<span><?= $data['alamat']; ?></span>
</div>

</div>

</div>



<div class="detail-card">

    <h3>
        <i class="fa-solid fa-box"></i>
        Produk
    </h3>

    <div class="produk-box">

        <img
        src="../img/<?= $data['gambar']; ?>"
        class="produk-img">

        <div class="produk-info">

            <h2><?= $data['nama_produk']; ?></h2>

            <div class="info-item">
                <span>Harga</span>
                <strong>
                    Rp <?= number_format($data['harga'],0,",","."); ?>
                </strong>
            </div>

            <div class="info-item">
                <span>Jumlah</span>
                <strong><?= $data['jumlah']; ?> pcs</strong>
            </div>

            <div class="info-item">
                <span>Ukuran</span>
                <strong><?= $data['ukuran']; ?></strong>
            </div>

        </div>

    </div>

</div>



<!-- ================= FILE ================= -->

<div class="grid-2">

<div class="detail-card">

<h3>🖼 Logo</h3>

<?php if($data['file_logo']!=""){ ?>

    <img
class="preview-big"
src="data:image/png;base64,<?= $data['file_logo']; ?>">

<?php }else{ ?>

<div class="empty-box">

Belum upload logo

</div>

<?php } ?>

</div>



<div class="detail-card">

<h3>🖼 Referensi</h3>

<?php if($data['file_referensi']!=""){ ?>

    <img
class="preview-big"
src="data:image/png;base64,<?= $data['file_referensi']; ?>">

<?php }else{ ?>

<div class="empty-box">

Belum upload referensi

</div>

<?php } ?>

</div>

</div>



<!-- ================= CATATAN ================= -->

<div class="detail-card">

<h3>
📝 Catatan Pelanggan
</h3>

<div class="catatan-box">

<?= nl2br($data['catatan']); ?>

</div>

</div>



<!-- ================= HASIL DESAIN ================= -->

<div class="detail-card">

<h3>

🎨 Hasil Desain

</h3>
<?php if(!empty($data['file_desain'])){ ?>

<img
class="preview-desain"
src="data:image/png;base64,<?= $data['file_desain']; ?>">

<?php }else{ ?>

<div class="empty-box">

Belum ada desain.

</div>

<?php } ?>
</div>

<!-- ================= PEMBAYARAN ================= -->

<div class="detail-card">

<h3>
💳 Pembayaran
</h3>

<div class="info-item">
<span>Status Pembayaran</span>

<strong>

<?= $data['status_pembayaran']; ?>

</strong>

</div>

<br>

<?php if(!empty($data['bukti_pembayaran'])){ ?>

<p><b>Bukti Pembayaran</b></p>

<img
src="../uploads/pembayaran/<?= $data['bukti_pembayaran']; ?>"
class="preview-big">

<br><br>

<?php if($data['status_pembayaran']=="Menunggu Konfirmasi"){ ?>

<form method="POST">

<button
type="submit"
name="konfirmasi_bayar"
class="btn-konfirmasi">

<i class="fa-solid fa-circle-check"></i>

Konfirmasi Pembayaran

</button>

</form>

<?php } ?>

<?php }else{ ?>

<div class="empty-box">

Belum ada bukti pembayaran

</div>

<?php } ?>

</div>



<!-- ================= PENGATURAN ================= -->

<div class="detail-card">

<h3>

⚙ Pengaturan Pesanan

</h3>

<form method="POST" enctype="multipart/form-data">

<label>Status Pesanan</label>

<select
name="status"
<?= $data['status_pembayaran']!="Lunas" ? "disabled" : ""; ?>>

<?php

$statusList=[
"Menunggu",
"Menunggu Persetujuan",
"Diproses",
"Dikirim",
"Selesai"
];

foreach($statusList as $s){

?>

<option
value="<?= $s ?>"
<?= $data['status']==$s ? "selected" : ""; ?>>

<?= $s ?>

</option>

<?php } ?>

</select>

<?php if($data['status_pembayaran']!="Lunas"){ ?>

<input
type="hidden"
name="status"
value="<?= $data['status']; ?>">

<?php } ?>

<label>Upload Hasil Desain</label>

<input
type="file"
name="file_desain">

<label>Nomor Resi</label>

<input
type="text"
name="nomor_resi"
value="<?= $data['nomor_resi']; ?>"
placeholder="Contoh : JNE123456789">

<label>Estimasi Sampai</label>

<input
type="date"
name="estimasi"
value="<?= $data['estimasi']; ?>">

<div class="button-group">

<button
type="submit"
name="simpan"
class="btn-simpan">

💾 Simpan

</button>

<a
href="room.php?id_order=<?= $data['id_custom']; ?>&tipe=custom"
class="btn-chat-admin">

💬 Chat

</a>

<a href="cetak_resi_custom.php?id=<?= $data['id_custom']; ?>" target="_blank">
    Cetak Resi
</a>

</div>

</form>

</div>

</div>

</div>

</body>

</html>
