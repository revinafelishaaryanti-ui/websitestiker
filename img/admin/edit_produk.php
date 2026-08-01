<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$id = (int)$_GET['id'];

$produk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id'");
$data = mysqli_fetch_assoc($produk);

$kategori = mysqli_query($conn, "SELECT * FROM kategori");

if(isset($_POST['update'])){

    $nama = mysqli_real_escape_string($conn,$_POST['nama_produk']);
    $id_kategori = $_POST['id_kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn,$_POST['deskripsi']);

    if($_FILES['gambar']['name'] != ""){

        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($tmp,"../uploads/produk/".$gambar);

        mysqli_query($conn,"UPDATE produk SET
            id_kategori='$id_kategori',
            nama_produk='$nama',
            harga='$harga',
            stok='$stok',
            deskripsi='$deskripsi',
            gambar='$gambar'
            WHERE id_produk='$id'");

    }else{

        mysqli_query($conn,"UPDATE produk SET
            id_kategori='$id_kategori',
            nama_produk='$nama',
            harga='$harga',
            stok='$stok',
            deskripsi='$deskripsi'
            WHERE id_produk='$id'");
    }

    echo "<script>
    alert('Produk berhasil diupdate');
    window.location='produk.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Produk</title>

<link rel="stylesheet" href="admin.css">

</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>✏️ Edit Produk</h1>

            <p>Perbarui informasi produk Stickerin.</p>

        </div>

    </div>

    <div class="form-card">

        <form method="POST" enctype="multipart/form-data">

            <div class="form-grid">

                <div class="input-group">

                    <label>Nama Produk</label>

                    <input
                    type="text"
                    name="nama_produk"
                    value="<?= $data['nama_produk']; ?>"
                    required>

                </div>

                <div class="input-group">

                    <label>Kategori</label>

                    <select name="id_kategori" required>

                        <?php while($k=mysqli_fetch_assoc($kategori)){ ?>

                        <option
                        value="<?= $k['id_kategori']; ?>"
                        <?= $data['id_kategori']==$k['id_kategori'] ? 'selected' : ''; ?>>

                            <?= $k['nama_kategori']; ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

            </div>

            <div class="form-grid">

                <div class="input-group">

                    <label>Harga</label>

                    <input
                    type="number"
                    name="harga"
                    value="<?= $data['harga']; ?>"
                    required>

                </div>

                <div class="input-group">

                    <label>Stok</label>

                    <input
                    type="number"
                    name="stok"
                    value="<?= $data['stok']; ?>"
                    required>

                </div>

            </div>

            <div class="input-group">

                <label>Deskripsi</label>

                <textarea
                name="deskripsi"
                rows="5"><?= $data['deskripsi']; ?></textarea>

            </div>

            <div class="input-group">

                <label>Foto Produk Saat Ini</label>

                <br><br>

                <img
                src="../img/<?= $data['gambar']; ?>"
                class="preview-produk">

            </div>

            <div class="input-group">

                <label>Ganti Foto Produk</label>

                <input
                type="file"
                name="gambar">

            </div>

            <div class="button-group">

                <a
                href="produk.php"
                class="btn-back">

                    ← Kembali

                </a>

                <button
                type="submit"
                name="update"
                class="btn-save">

                    💾 Update Produk

                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>