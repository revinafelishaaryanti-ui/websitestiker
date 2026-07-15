<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}

$query = mysqli_query($conn,"SELECT * FROM users");
$keyword = "";

if(isset($_GET['keyword'])){

    $keyword = mysqli_real_escape_string($conn,$_GET['keyword']);

}

$query = mysqli_query($conn,"
SELECT *
FROM users
WHERE
nama LIKE '%$keyword%'
OR email LIKE '%$keyword%'
OR no_hp LIKE '%$keyword%'
OR alamat LIKE '%$keyword%'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Pelanggan</title>
<link rel="stylesheet" href="admin.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="content-header">

<h2>Data Pelanggan</h2>

<form method="GET" class="search-halaman">

<input
type="text"
name="keyword"
placeholder="Cari pelanggan..."
value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">

<button type="submit">

<i class="fa-solid fa-magnifying-glass"></i>
Cari

</button>

</form>

</div>

<table class="table-produk">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody id="tableBody">

        <?php
        $no=1;
        while($row=mysqli_fetch_assoc($query)){
        ?>

        <tr>

            <td><?= $no++; ?></td>

            <td><?= $row['nama']; ?></td>

            <td><?= $row['email']; ?></td>

            <td><?= $row['no_hp']; ?></td>

            <td><?= $row['alamat']; ?></td>

            <td>

                        <a href="detail_pelanggan.php?id=<?= $row['id']; ?>" class="btn-detail">
                Detail
            </a>

            <a href="hapus_pelanggan.php?id=<?= $row['id']; ?>"
            onclick="return confirm('Yakin ingin menghapus pelanggan ini?')"
            class="btn-delete">
                Hapus
            </a>

            </td>

        </tr>

        <?php } ?>

        </tbody>
    </table>
    </div>
    </div> <!-- content -->

</div> <!-- main -->


</body>
</html>