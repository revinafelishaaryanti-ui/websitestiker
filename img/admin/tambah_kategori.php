<?php
session_start();
include '../koneksi.php';

if(isset($_POST['simpan'])){

$nama=mysqli_real_escape_string($conn,$_POST['nama']);

mysqli_query($conn,"INSERT INTO kategori(nama_kategori)
VALUES('$nama')");

header("Location:kategori.php");

}
?>

<!DOCTYPE html>

<html>

<head>

<title>Tambah Kategori</title>

<link rel="stylesheet" href="admin.css">
</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>Tambah Kategori</h1>

            <p>Tambahkan kategori baru untuk produk Stickerin.</p>

        </div>

    </div>

    <div class="kategori-wrapper">

        <div class="kategori-form">

            <h2>Form Kategori</h2>

            <form method="POST">

                <label>Nama Kategori</label>

                <input
                type="text"
                name="nama"
                placeholder="Masukkan nama kategori..."
                required>

                <div class="btn-group">

                    <a
                    href="kategori.php"
                    class="btn-batal">

                        ← Kembali

                    </a>

                    <button
                    type="submit"
                    name="simpan"
                    class="btn-simpan">

                        Simpan Kategori

                    </button>

                </div>

            </form>

        </div>

        <div class="info-card">

            <h3>Informasi</h3>

            <ul>

                <li>Gunakan nama kategori yang jelas.</li>

                <li>Kategori akan tampil pada halaman user.</li>

                <li>Pastikan tidak ada nama kategori yang sama.</li>

                <li>Nama kategori bisa diedit kembali.</li>

            </ul>

        </div>

    </div>

</div>

</body>

</html>