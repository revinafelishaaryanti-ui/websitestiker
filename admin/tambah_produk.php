<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

// Ambil data kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $id_kategori = $_POST['id_kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "../uploads/produk/" . $gambar);

    mysqli_query($conn, "INSERT INTO produk
    (id_kategori, nama_produk, harga, deskripsi, gambar, stok)
    VALUES
    ('$id_kategori','$nama','$harga','$deskripsi','$gambar','$stok')");

    echo "<script>
            alert('Produk berhasil ditambahkan');
            window.location='produk.php';
          </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<h2>Tambah Produk</h2>

<form method="POST" enctype="multipart/form-data">

<label>Nama Produk</label>
<input type="text" name="nama_produk" required>

<label>Kategori</label>
<select name="id_kategori" required>
    <option value="">-- Pilih Kategori --</option>

    <?php while($k = mysqli_fetch_assoc($kategori)){ ?>

    <option value="<?= $k['id_kategori']; ?>">
        <?= $k['nama_kategori']; ?>
    </option>

    <?php } ?>

</select>

<label>Harga</label>
<input type="number" name="harga" required>

<label>Stok</label>
<input type="number" name="stok" required>

<label>Deskripsi</label>
<textarea name="deskripsi" rows="5"></textarea>

<label>Gambar Produk</label>
<input type="file" name="gambar" required>

<br><br>

<button class="btn-tambah" name="simpan">
    Simpan Produk
</button>

</form>

</div>

</div>

</body>
</html>