<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}

$query = mysqli_query($conn,"SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Pelanggan</title>
<link rel="stylesheet" href="admin.css">
</head>

<body>

<?php include 'include/sidebar.php'; ?>

<div class="main">

<?php include 'include/navbar.php'; ?>

<div class="content">

<div class="page-header">

<div>
    <h2>👥 Data Pelanggan</h2>
    <p>Kelola seluruh data pelanggan Stickerin.</p>
</div>

<div class="page-actions">

    <a href="dashboard.php" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>

    <input type="text" id="search" placeholder="Cari pelanggan...">

</div>

</div>

    <table class="table">
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

    </div> <!-- content -->

</div> <!-- main -->

<script>
const search=document.getElementById("search");

search.addEventListener("keyup",function(){

let value=this.value.toLowerCase();

let rows=document.querySelectorAll("#tableBody tr");

rows.forEach(function(row){

let text=row.innerText.toLowerCase();

row.style.display=text.includes(value)?"":"none";

});

});
</script>

</body>
</html>