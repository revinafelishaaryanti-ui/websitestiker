<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$id = (int)$_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori='$id'");
$kategori = mysqli_fetch_assoc($data);

if (!$kategori) {
    header("Location: kategori.php");
    exit;
}

if (isset($_POST['update'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

    mysqli_query($conn, "UPDATE kategori
                         SET nama_kategori='$nama'
                         WHERE id_kategori='$id'");

    header("Location: kategori.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<h2>Edit Kategori</h2>

<form method="POST">

<label>Nama Kategori</label>

<input
type="text"
name="nama"
value="<?= $kategori['nama_kategori']; ?>"
required>

<br><br>

<button class="btn-tambah" name="update">

Update

</button>

</form>

</div>

</div>

</body>

</html>