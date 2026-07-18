<?php
session_start();
include '../koneksi.php';

if(!isset($_GET['id'])){
    header("location:pesanan.php");
    exit;
}

$id_pesanan = $_GET['id'];


// UPDATE STATUS
if(isset($_POST['update_status'])){

    $status = $_POST['status'];

    $update = mysqli_query($conn,"
        UPDATE pesanan 
        SET status='$status'
        WHERE id_pesanan='$id_pesanan'
    ");

    if(!$update){
        die(mysqli_error($conn));
    }

    header("location:detail_pesanan.php?id=$id_pesanan");
    exit;
}

// update nomor resi
if(isset($_POST['simpan_resi'])){

    $no_resi = $_POST['no_resi'];

    mysqli_query($conn,"
        UPDATE pesanan
        SET no_resi='$no_resi'
        WHERE id_pesanan='$id_pesanan'
    ");

    header("location:detail_pesanan.php?id=$id_pesanan");
    exit;
}

$query_pesanan = mysqli_query($conn,"
    SELECT 
        pesanan.*,
        users.nama,
        users.no_hp,
        users.alamat
    FROM pesanan
    JOIN users ON pesanan.id_user = users.id
    WHERE pesanan.id_pesanan='$id_pesanan'
");

$data_pesanan = mysqli_fetch_assoc($query_pesanan);


$query_detail = mysqli_query($conn,"
    SELECT 
        detail_pesanan.id_detail,
        detail_pesanan.jumlah,
        detail_pesanan.harga AS harga_pesan,
        produk.nama_produk,
        produk.gambar
    FROM detail_pesanan
    JOIN produk 
    ON detail_pesanan.id_produk = produk.id_produk
    WHERE detail_pesanan.id_pesanan='$id_pesanan'
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Detail Pesanan</title>

<link rel="stylesheet" href="admin.css">

</head>

<body>


<div class="container">

<h2>Detail Pesanan #<?= $id_pesanan ?></h2>


<div class="info">

<p>
<b>Nama Pelanggan :</b>
<?= $data_pesanan['nama']; ?>
</p>

<p>
<b>No HP :</b>
<?= $data_pesanan['no_hp']; ?>
</p>

<p>
<b>Alamat :</b>
<?= $data_pesanan['alamat']; ?>
</p>

<p>
<b>Status :</b>
<?= $data_pesanan['status']; ?>
</p>
<p>
<b>No Resi :</b>
<?= $data_pesanan['no_resi']; ?>
</p>
</div>
<div class="ubah-status">


<label>
<b>update status </b>
</label>

<br>
<form method="POST">

<select name="status">

<option value="Menunggu"
<?= $data_pesanan['status']=="Menunggu" ? "selected" : "" ?>>
Menunggu
</option>


<option value="Diproses"
<?= $data_pesanan['status']=="Diproses" ? "selected" : "" ?>>
Diproses
</option>


<option value="Dikirim"
<?= $data_pesanan['status']=="Dikirim" ? "selected" : "" ?>>
Dikirim
</option>


<option value="Selesai"
<?= $data_pesanan['status']=="Selesai" ? "selected" : "" ?>>
Selesai
</option>

</select>


<button type="submit" name="update_status">
Update Status
</button>

</form>

</div>


<table>

<tr>
<th>Gambar</th>
<th>Produk</th>
<th>Jumlah</th>
<th>Harga</th>
<th>Subtotal</th>
</tr>


<?php

$total = 0;

while($detail = mysqli_fetch_assoc($query_detail)){

    $subtotal = $detail['jumlah'] * $detail['harga_pesan'];

$total += $subtotal;
?>

<tr>

<td>
    <img src="../img/<?= $detail['gambar']; ?>" width="100">
</td>

<td>
<?= $detail['nama_produk']; ?>
</td>

<td>
<?= $detail['jumlah']; ?>
</td>

<td>
Rp <?= number_format($detail['harga_pesan']); ?></td>

<td>
Rp <?= number_format($subtotal); ?>
</td>

</tr>

<?php } ?>


<tr>
<td colspan="4">
<b>Total</b>
</td>

<td>
<b>
Rp <?= number_format($data_pesanan['total_harga']); ?>
</b>
</td>
</tr>


</table>


</table>


<a class="btn" 
href="cetak_resi.php?id=<?= $id_pesanan; ?>" 
target="_blank">

Cetak Resi

</a>


<a class="btn" href="pesanan_pelanggan.php">
← Kembali
</a>

</div>


</body>
</html>