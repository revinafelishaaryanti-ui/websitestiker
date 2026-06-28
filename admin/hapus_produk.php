<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$id = (int)$_GET['id'];

$data = mysqli_query($conn,"SELECT gambar FROM produk WHERE id_produk='$id'");
$row = mysqli_fetch_assoc($data);

if($row && file_exists("../uploads/produk/".$row['gambar'])){
    unlink("../uploads/produk/".$row['gambar']);
}

mysqli_query($conn,"DELETE FROM produk WHERE id_produk='$id'");

echo "<script>
alert('Produk berhasil dihapus');
window.location='produk.php';
</script>";

?>