<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

include '../koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM pelanggan");
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

<div class="content">

    <div class="page-header">
        <h2>👥 Data Pelanggan</h2>

        <input type="text" id="search" placeholder="Cari pelanggan...">
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

                <a href="detail_pelanggan.php?id=<?= $row['id_pelanggan']; ?>" class="btn-detail">
                    Detail
                </a>

                <a href="hapus_pelanggan.php?id=<?= $row['id_pelanggan']; ?>"
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