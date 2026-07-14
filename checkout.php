<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("location:login.php");
    exit;

}


$id_user = $_SESSION['id'];


// ambil id produk dari tombol beli

if(isset($_GET['id_produk'])){

    $id_produk = $_GET['id_produk'];

}else{

    die("Produk belum dipilih.");

}



// ambil data produk

$query_produk = mysqli_query($conn,

"SELECT * FROM produk 
WHERE id_produk='$id_produk'");


if(mysqli_num_rows($query_produk) == 0){

    die("Produk tidak ditemukan.");

}


$produk = mysqli_fetch_assoc($query_produk);





// ambil data user

$query_user = mysqli_query($conn,

"SELECT * FROM users 
WHERE id='$id_user'");


$user = mysqli_fetch_assoc($query_user);



$total = $produk['harga'];

if(isset($_POST['buat_pesanan'])){


    $pembayaran = isset($_POST['pembayaran']) ? $_POST['pembayaran'] : '';
    $bank = isset($_POST['bank']) ? $_POST['bank'] : '-';


    $simpan = mysqli_query($conn,"

    INSERT INTO pesanan
    (
    id_user,
    id_produk,
    jumlah,
    total_harga,
    metode_pembayaran,
    bank
    )

    VALUES
    (
    '$id_user',
    '$id_produk',
    '1',
    '$total',
    '$pembayaran',
    '$bank'
    )

    ");



    if($simpan){

        header("location:pesanan.php");
        exit;
    
    }else{
    
        echo "Pesanan gagal disimpan : ";
        echo mysqli_error($conn);
    
    }


}
?>

<!DOCTYPE html>
<html>

<head>

<title>Checkout Stickerin</title>

<link rel="stylesheet" href="checkout.css">

</head>


<body>



<div class="checkout-header">

<h1>Checkout Stickerin</h1>

</div>



<a href="produk.php" class="back">
← Kembali
</a>




<div class="checkout-container">



<div class="card">


<h2>Produk Dibeli</h2>



<div class="product-card">


    <img src="img/<?= $produk['gambar']; ?>" 
    class="product-image">


    <div class="product-info">


        <h3>
            <?= $produk['nama_produk']; ?>
        </h3>


        <p class="product-price">
            Rp <?= number_format($produk['harga']); ?>
        </p>


        <span>
            Jumlah : 1 Produk
        </span>


    </div>


</div>
</div>







<div class="card">


<form method="POST" action="">

<h2>Data Pembeli</h2>



<label>Nama</label>

<input type="text"
value="<?= $user['nama']; ?>">



<label>No HP</label>

<input type="text"
value="<?= $user['no_hp']; ?>">



<label>Alamat</label>

<textarea>

<?= $user['alamat']; ?>

</textarea>





<label>Metode Pembayaran</label>

<select id="metodePembayaran" name="pembayaran" onchange="tampilBank()">

    <option value="">
        Pilih Metode Pembayaran
    </option>

    <option value="QRIS">
        QRIS
    </option>

    <option value="Transfer Bank">
        Transfer Bank
    </option>

    <option value="COD">
        COD
    </option>

</select>




<div id="bankContainer" class="bank-box">

<label>Pilih Bank</label>

<select name="bank">

<option value="BCA">
BCA
</option>

<option value="BRI">
BRI
</option>

<option value="BNI">
BNI
</option>

<option value="Mandiri">
Mandiri
</option>

</select>

</div>





<div class="total">


<h3>Total</h3>


<h2>
Rp <?= number_format($total); ?>
</h2>


</div>




<button 
type="submit" 
name="buat_pesanan"
class="btn-order">

Buat Pesanan

</button>


</form>


</div>


</div>

<script>

function tampilBank(){

    let metode = document.getElementById("metodePembayaran").value;

    let bank = document.getElementById("bankContainer");


    if(metode == "Transfer Bank"){

        bank.style.display = "block";

    }else{

        bank.style.display = "none";

    }

}


</script>

</body>

</html>