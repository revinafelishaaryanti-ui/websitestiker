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
    $kurir = mysqli_real_escape_string($conn,$_POST['kurir']);
    $nomor_resi = mysqli_real_escape_string($conn,$_POST['nomor_resi']);
    $estimasi = mysqli_real_escape_string($conn,$_POST['estimasi']);
    $lokasi = mysqli_real_escape_string($conn,$_POST['lokasi_terakhir']);

    $namaFile = "";

    if(!empty($_FILES['file_desain']['name'])){

        $namaFile = time()."_".$_FILES['file_desain']['name'];

        move_uploaded_file(
            $_FILES['file_desain']['tmp_name'],
            "../uploads/desain/".$namaFile
        );

        mysqli_query($conn,"
        UPDATE custom_sticker
        SET
        file_desain='$namaFile'
        WHERE id_custom='$id_custom'
        ");
    }

    mysqli_query($conn,"
    UPDATE custom_sticker
    SET

    status='$status',

    kurir='$kurir',

    nomor_resi='$nomor_resi',

    estimasi='$estimasi',

    lokasi_terakhir='$lokasi'

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

<div class="detail-custom-container">

<!-- ========================= -->
<!-- DATA PELANGGAN -->
<!-- ========================= -->

<div class="detail-card">

<h3>

<i class="fa-solid fa-user"></i>

Data Pelanggan

</h3>

<table class="table-detail">

<tr>

<td>Nama</td>

<td><?= $data['nama']; ?></td>

</tr>

<tr>

<td>Email</td>

<td><?= $data['email']; ?></td>

</tr>

<tr>

<td>No HP</td>

<td><?= $data['no_hp']; ?></td>

</tr>

<tr>

<td>Alamat</td>

<td><?= $data['alamat']; ?></td>

</tr>

</table>

</div>

<!-- ========================= -->
<!-- DATA PRODUK -->
<!-- ========================= -->

<div class="detail-card">

<h3>

<i class="fa-solid fa-box"></i>

Produk

</h3>

<div class="produk-admin">

<img src="../img/<?= $data['gambar']; ?>">

<div>

<h2><?= $data['nama_produk']; ?></h2>

<h3>

Rp <?= number_format($data['harga'],0,",","."); ?>

</h3>

<p>

Jumlah :
<b><?= $data['jumlah']; ?></b>

</p>

<p>

Ukuran :
<b><?= $data['ukuran']; ?></b>

</p>

</div>

</div>

</div>

<!-- ========================= -->
<!-- CATATAN -->
<!-- ========================= -->

<div class="detail-card">

<h3>

<i class="fa-solid fa-note-sticky"></i>

Catatan Pelanggan

</h3>

<p>

<?= nl2br($data['catatan']); ?>

</p>

</div>

<!-- ========================= -->
<!-- FILE LOGO -->
<!-- ========================= -->

<div class="detail-card">

<h3>

Logo

</h3>

<?php

if($data['file_logo']!=""){

?>

<img
class="preview-custom"
src="../uploads/custom_logo/<?= $data['file_logo']; ?>">

<?php

}else{

echo "Tidak ada logo.";

}

?>

</div>

<!-- ========================= -->
<!-- FILE REFERENSI -->
<!-- ========================= -->

<div class="detail-card">

<h3>

Referensi

</h3>

<?php

if($data['file_referensi']!=""){

?>

<img
class="preview-custom"
src="../uploads/custom_referensi/<?= $data['file_referensi']; ?>">

<?php

}else{

echo "Tidak ada referensi.";

}

?>

</div>

<!-- ========================= -->
<!-- FILE DESAIN -->
<!-- ========================= -->

<div class="detail-card">

<h3>

Hasil Desain

</h3>

<?php

if($data['file_desain']!=""){

?>

<img
class="preview-custom"
src="../uploads/desain/<?= $data['file_desain']; ?>">

<?php

}else{

?>

<p>

Belum ada desain dari admin.

</p>

<?php } ?>

</div>

<!-- ========================= -->
<!-- FORM ADMIN -->
<!-- ========================= -->

<div class="detail-card setting-card">

<h3>
<i class="fa-solid fa-gear"></i>
Pengaturan Pesanan
</h3>

<!-- KONFIRMASI PEMBAYARAN -->

<div class="detail-card">

<h3>
<i class="fa-solid fa-money-bill"></i>
Pembayaran
</h3>


<p>
Status Pembayaran :
<b>
<?= $data['status_pembayaran']; ?>
</b>
</p>



<?php if(!empty($data['bukti_pembayaran'])){ ?>

<p>
Bukti Pembayaran :
</p>


<img 
src="../uploads/pembayaran/<?= $data['bukti_pembayaran']; ?>"
width="250">


<br><br>


<?php if($data['status_pembayaran']=="Menunggu Konfirmasi"){ ?>

<form method="POST">

<button 
name="konfirmasi_bayar"
class="btn-simpan">

Konfirmasi Pembayaran

</button>

</form>

<?php } ?>


<?php }else{ ?>


<p style="color:red">

Belum ada bukti pembayaran

</p>


<?php } ?>


</div>

<form method="POST" enctype="multipart/form-data">

<label>Status</label>

<select 
name="status"
<?= $data['status_pembayaran']!="Lunas" ? "disabled" : ""; ?>
>

<?php if($data['status_pembayaran']!="Lunas"){ ?>

<input 
type="hidden"
name="status"
value="<?= $data['status']; ?>">

<?php } ?>
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
<?= $data['status']==$s?'selected':'' ?>>

<?= $s ?>

</option>

<?php } ?>

</select>

<label>Upload Hasil Desain</label>

<input
type="file"
name="file_desain">

<label>Kurir</label>

<input
type="text"
name="kurir"
value="<?= $data['kurir']; ?>">

<label>Nomor Resi</label>

<input
type="text"
name="nomor_resi"
value="<?= $data['nomor_resi']; ?>">

<label>Estimasi</label>

<input
type="date"
name="estimasi"
value="<?= $data['estimasi']; ?>">

<label>Lokasi Terakhir</label>

<textarea
name="lokasi_terakhir"><?= $data['lokasi_terakhir']; ?></textarea>

<button
type="submit"
name="simpan"
class="btn-simpan">

<i class="fa-solid fa-floppy-disk"></i>

Simpan Perubahan

</button>



<a href="room.php?id_order=<?= $data['id_custom']; ?>&tipe=custom" class="btn-chat-admin">

<i class="fa-solid fa-comments"></i>

Chat Pelanggan

</a>
<a 
href="cetak_resi_custom.php?id=<?= $data['id_custom']; ?>"
target="_blank"
class="btn-cetak-resi">

<i class="fa-solid fa-print"></i>

Cetak Resi

</a>
</form>

</div>

</div>

</div>

</div>

</body>

</html>