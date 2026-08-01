<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("Location: login.php");
    exit;

}


$id_user = $_SESSION['id'];


// Hapus semua keranjang
if(isset($_GET['reset'])){

    mysqli_query($conn,"
        DELETE FROM keranjang 
        WHERE id_user='$id_user'
    ");

    header("Location: keranjang.php");
    exit;

}


// Ambil data keranjang user
$query = mysqli_query($conn,"
SELECT 
keranjang.id,
keranjang.jumlah,

produk.id_produk,
produk.nama_produk,
produk.harga,
produk.gambar

FROM keranjang

JOIN produk 
ON keranjang.id_produk = produk.id_produk

WHERE keranjang.id_user='$id_user'
");


$subtotal = 0;

// Hitung jumlah semua barang
$total_qty = 0;

$qJumlah = mysqli_query($conn,"
    SELECT SUM(jumlah) AS total_barang
    FROM keranjang
    WHERE id_user='$id_user'
");

$dataJumlah = mysqli_fetch_assoc($qJumlah);

if($dataJumlah['total_barang'] == NULL){
    $total_qty = 0;
}else{
    $total_qty = $dataJumlah['total_barang'];
}


// Ambil alamat user
$qUser = mysqli_query($conn,"
    SELECT alamat
    FROM users
    WHERE id='$id_user'
");

$user = mysqli_fetch_assoc($qUser);

$alamat = strtolower($user['alamat']);


// ongkir awal
$ongkir = 10000;


?>


<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Keranjang</title>


<link rel="stylesheet" href="stayle.css">


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


</head>


<body>


<div class="container">



<div class="topbar">


<a href="dashboard.php">

<i class="fa fa-arrow-left"></i>

</a>



<h2>Keranjang</h2>



<a href="keranjang.php?reset=1">

<i class="fa fa-trash"></i>

</a>


</div>



<hr>


<div class="daftar-keranjang">

<?php while($produk = mysqli_fetch_assoc($query)){ ?>

<div class="produk-item" 
data-harga="<?= $produk['harga']; ?>"
data-jumlah="<?= $produk['jumlah']; ?>">


<input 
type="checkbox"
class="pilih-produk"
checked>


<div class="produk-img">

<img 
src="img/<?= $produk['gambar']; ?>"
width="100">

</div>



<div class="detail-produk">


<h3>
<?= $produk['nama_produk']; ?>
</h3>


<p>
Rp <?= number_format($produk['harga'],0,",","."); ?>
</p>



<div class="jumlah">


<a href="ubah_keranjang.php?id=<?= $produk['id']; ?>&aksi=kurang">
-
</a>


<span>
<?= $produk['jumlah']; ?>
</span>



<a href="ubah_keranjang.php?id=<?= $produk['id']; ?>&aksi=tambah">
+
</a>


</div>


</div>


</div>


<?php } ?>

</div>
</div>
<div class="ringkasan">


<div>

<span>Subtotal</span>

<span>
<span id="subtotalBayar">
Rp 0
</span></span>

</div>



<div>

<span>Ongkos Kirim</span>

<span id="ongkirBayar">
Rp 10.000
</span>


</div>




<div class="total">


<span>Total</span>


<span>

<span id="totalBayar">
Rp 0
</span>
</span>


</div>



</div>





<a href="checkout.php" class="checkout-btn">

Lanjut ke Pemesanan

</a>

<!-- Dari keranjang, checkout.php tanpa id_produk akan memuat
     SEMUA produk yang ada di keranjang -->




</div>
<script>

function hitungTotal(){

let subtotal = 0;
let jumlahBarang = 0;


document.querySelectorAll(".produk-item").forEach(function(item){


let cek = item.querySelector(".pilih-produk");


if(cek.checked){


let harga = parseInt(item.dataset.harga);

let jumlah = parseInt(item.dataset.jumlah);


subtotal += harga * jumlah;

jumlahBarang += jumlah;


}


});



let ongkir = 10000;


if(jumlahBarang >= 5){

    ongkir = 0;

}


document.getElementById("ongkirBayar").innerHTML =
"Rp " + ongkir.toLocaleString("id-ID");



let total = subtotal + ongkir;



document.getElementById("subtotalBayar").innerHTML =
"Rp " + subtotal.toLocaleString("id-ID");



document.getElementById("totalBayar").innerHTML =
"Rp " + total.toLocaleString("id-ID");



}


document.querySelectorAll(".pilih-produk").forEach(function(cb){

cb.addEventListener("change",hitungTotal);

});


window.onload = function(){
    hitungTotal();
};

</script>



</body>

</html>