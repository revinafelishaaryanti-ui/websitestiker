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
    $rekomendasi = $_POST['rekomendasi'];
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
    
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>📦 Tambah Produk</h1>

            <p>Tambahkan produk baru ke katalog Stickerin.</p>

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
                    placeholder="Masukkan nama produk..."
                    required>

                </div>

                <div class="input-group">

                    <label>Kategori</label>

                    <select name="id_kategori" required>

                        <option value="">-- Pilih Kategori --</option>

                        <?php while($k=mysqli_fetch_assoc($kategori)){ ?>

                        <option value="<?= $k['id_kategori']; ?>">

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
                    placeholder="Masukkan harga..."
                    required>

                </div>

                <div class="input-group">

                    <label>Stok</label>

                    <input
                    type="number"
                    name="stok"
                    placeholder="Masukkan stok..."
                    required>

                </div>

            </div>

            <div class="input-group">

                <label>Deskripsi Produk</label>

                <textarea
                name="deskripsi"
                rows="5"
                placeholder="Masukkan deskripsi produk..."></textarea>

            </div>

            <div class="input-group">

                <label>Upload Gambar Produk</label>

                <input
                type="file"
                name="gambar"
                id="gambar"
                accept="image/*"
                onchange="previewImage(event)"
                required>

            </div>

            <div class="input-group">

                <img
                id="preview"
                src="../img/default.png"
                class="preview-produk">

            </div>
            <div class="input-group">

<label>
Produk Rekomendasi
</label>

<select name="rekomendasi">

<option value="0">
Tidak
</option>

<option value="1">
Ya
</option>

</select>

</div>

            <div class="button-group">

                <a
                href="produk.php"
                class="btn-back">

                    ← Kembali

                </a>

                <button
                type="submit"
                name="simpan"
                class="btn-save">

                    💾 Simpan Produk

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function previewImage(event){

    let reader=new FileReader();

    reader.onload=function(){

        document.getElementById("preview").src=reader.result;

    }

    reader.readAsDataURL(event.target.files[0]);

}

</script>
</body>
</html>