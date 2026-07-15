<?php

session_start();

include 'koneksi.php';

$keyword = "";

if(isset($_GET['keyword'])){

    $keyword = mysqli_real_escape_string($conn,$_GET['keyword']);

}

if($keyword!=""){

$query = mysqli_query($conn,"

SELECT *

FROM produk

WHERE

nama_produk LIKE '%$keyword%'

OR deskripsi LIKE '%$keyword%'

");

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Pencarian</title>

<link rel="stylesheet" href="stayle.css">

</head>

<body>

<div class="mobile">

<h2>

Hasil Pencarian

</h2>

<p>

Kata kunci :

<b><?= htmlspecialchars($keyword); ?></b>

</p>


<div class="produk">

<?php

if($keyword == ""){

    echo "<h3>Silakan masukkan nama produk yang ingin dicari.</h3>";

}else{

    if(mysqli_num_rows($query) > 0){

        while($row = mysqli_fetch_assoc($query)){

?>

<div class="card">

<img src="img/<?= $row['gambar']; ?>">

<h3><?= $row['nama_produk']; ?></h3>

<p>Rp <?= number_format($row['harga']); ?></p>

<a href="detail_produk.php?id=<?= $row['id_produk']; ?>">

<button class="btn-detail">
Lihat Detail
</button>

</a>

</div>

<?php

        }

    }else{

        echo "<h3>Produk tidak ditemukan.</h3>";

    }

}

?>

</div>

</div>

</body>

</html>