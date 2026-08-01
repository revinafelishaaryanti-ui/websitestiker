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

<meta charset="UTF-8">

<title>Edit Kategori</title>

<link rel="stylesheet" href="admin.css?v=1">

<link rel="stylesheet"

href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="form-card">

<div class="form-title">

<h2>
<i class="fa-solid fa-pen-to-square"></i>
Edit Kategori
</h2>

<p>Edit data kategori Stickerin.</p>

</div>

<form method="POST">

<div class="input-group">

<label>Nama Kategori</label>

<input
type="text"
name="nama"
value="<?= $kategori['nama_kategori']; ?>"
required>

</div>

<div class="button-group">

<button
type="submit"
name="update"
class="btn-save">

<i class="fa-solid fa-floppy-disk"></i>

Update

</button>

<a href="kategori.php" class="btn-back">

<i class="fa-solid fa-arrow-left"></i>

Kembali

</a>

</div>

</form>

</div>

</div>

</body>

</html>