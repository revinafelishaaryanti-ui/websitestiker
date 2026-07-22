<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("location:login.php");
    exit;

}


$id_user = $_SESSION['id'];
$id_alamat = isset($_GET['id_alamat']) ? $_GET['id_alamat'] : '';

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

if($id_alamat != ''){


    $query_user = mysqli_query($conn,"
    SELECT 
    nama_penerima AS nama,
    no_hp,
    provinsi,
    kabupaten,
    kecamatan,
    desa,
    rt_rw,
    dusun,
    patokan,
    kode_pos
    
    FROM alamat_user
    
    WHERE id_alamat='$id_alamat'
    ");
    
    
    }else{
    
    
    $query_user = mysqli_query($conn,"
    SELECT *
    FROM users
    WHERE id='$id_user'
    ");
    
    
    }
    
    
    $user = mysqli_fetch_assoc($query_user);





$jumlah = isset($_GET['jumlah']) ? (int)$_GET['jumlah'] : 1;

$total = $produk['harga'] * $jumlah;
// Hitung ongkir
if($jumlah >= 5){

    $ongkir = 0;

}else{

    $ongkir = 10000;

}

$total_bayar = $total + $ongkir;
if(isset($_POST['buat_pesanan'])){

    $ekspedisi = isset($_POST['ekspedisi']) ? $_POST['ekspedisi'] : '';
    $pembayaran = isset($_POST['pembayaran']) ? $_POST['pembayaran'] : '';
    $bank = isset($_POST['bank']) ? $_POST['bank'] : '-';


    $no_resi = "INV".date("YmdHis");


    $simpan = mysqli_query($conn,"

    INSERT INTO pesanan
(
id_user,
total_harga,
ekspedisi,
metode_pembayaran,
bank,
no_resi,
status_pembayaran
)

    VALUES
(
'$id_user',
'$total_bayar',
'$ekspedisi',
'$pembayaran',
'$bank',
'$no_resi',
'Belum Dibayar'
)

    ");


    if($simpan){

        $id_pesanan = mysqli_insert_id($conn);

        mysqli_query($conn,"
        INSERT INTO detail_pesanan
        (
        id_pesanan,
        id_produk,
        jumlah,
        harga
        )

        VALUES
        (
        '$id_pesanan',
        '$id_produk',
        '$jumlah',
        '".$produk['harga']."'
        )
        ");

        header("location:pembayaran.php?id=".$id_pesanan);
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



<a href="kategori.php" class="back">
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
        Jumlah : <?= $jumlah; ?> Produk
            </span>


    </div>


</div>
</div>







<div class="card">


<form method="POST" action="" enctype="multipart/form-data">
<label>Data Pembeli</label>

<a href="pilih_alamat.php?id_produk=<?= $id_produk; ?>" class="data-pembeli">
    <div class="nama-hp">

        <b>
        <?= htmlspecialchars($user['nama']); ?>
        </b>

        <b class="nohp">
        <?= htmlspecialchars($user['no_hp']); ?>
        </b>

    </div>


    <div class="alamat-user">

<?php if($id_alamat != ''){ ?>

    <?= htmlspecialchars($user['desa']); ?>,
    <?= htmlspecialchars($user['kecamatan']); ?>,
    <?= htmlspecialchars($user['kabupaten']); ?>,
    <?= htmlspecialchars($user['provinsi']); ?>,
    RT/RW <?= htmlspecialchars($user['rt_rw']); ?>,
    <?= htmlspecialchars($user['dusun']); ?>,
    <?= htmlspecialchars($user['patokan']); ?>,
    <?= htmlspecialchars($user['kode_pos']); ?>


<?php }else{ ?>

    <?= !empty($user['alamat']) 
    ? nl2br(htmlspecialchars($user['alamat'])) 
    : "Belum ada alamat."; ?>

<?php } ?>

</div>

</a>


<a href="pilih_alamat.php?id_produk=<?= $id_produk; ?>" class="btn-alamat">
    + Tambah 
</a>

<label>Jasa Ekspedisi</label>

<select name="ekspedisi" required>

<option value="">
-- Pilih Ekspedisi --
</option>

<option value="JNE">
JNE
</option>

<option value="J&T Express">
J&T Express
</option>

<option value="SiCepat">
SiCepat
</option>

<option value="AnterAja">
AnterAja
</option>

<option value="Pos Indonesia">
Pos Indonesia
</option>

<option value="Ninja Xpress">
Ninja Xpress
</option>

</select>

<br><br>

<label>Metode Pembayaran</label>

<select 
name="pembayaran" 
id="metodePembayaran"
onchange="tampilPembayaran()"
required>

<option value="">
-- Pilih Pembayaran --
</option>

<option value="Transfer Bank">
Transfer Bank
</option>

<option value="E-Wallet">
E-Wallet
</option>

<option value="COD">
COD
</option>

</select>

<br><br>


<div id="pilihanBank" style="display:none;">

<label>Pilih Bank</label>

<select name="bank" id="bank" onchange="ubahBank()">

<option value="">
-- Pilih Bank --
</option>

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

<div id="pilihanEwallet" style="display:none;">

<label>Pilih E-Wallet</label>

<select name="ewallet" id="ewallet" onchange="ubahEwallet()">

<option value="">
-- Pilih E-Wallet --
</option>

<option value="Dana">
Dana
</option>

<option value="OVO">
OVO
</option>

<option value="GoPay">
GoPay
</option>

<option value="ShopeePay">
ShopeePay
</option>

</select>

</div>

<div id="infoPembayaran" style="display:none">

<h3>Informasi Pembayaran</h3>

<div id="bankInfo" style="display:none">

<p>Silakan transfer ke:</p>

<p><b id="namaBank"></b></p>

<p>No Rekening :
<b id="nomorRekening"></b></p>

<p>a.n Stickerin</p>

</div>

<div id="ewalletInfo" style="display:none">

<p>Kirim ke akun:</p>

<p><b id="namaEwallet"></b></p>

<p>Nomor :</p>

<b id="nomorEwallet"></b>

<p>a.n Stickerin</p>

</div>


</div>

<br><br>

<div id="uploadBukti" style="display:none;">

<label>
Upload Bukti Pembayaran
</label>

<br>

<input 
type="file"
name="bukti_pembayaran"
accept="image/*">

</div>
<br><br>

</div>





<div class="total">


<h3>Subtotal</h3>

<h2>
Rp <?= number_format($total,0,",","."); ?>
</h2>

<hr>

<h3>Ongkir</h3>

<h2>

<?php if($ongkir == 0){ ?>

Gratis Ongkir

<?php }else{ ?>

Rp <?= number_format($ongkir,0,",","."); ?>

<?php } ?>

</h2>

<hr>

<h3>Total Bayar</h3>

<h2>
Rp <?= number_format($total_bayar,0,",","."); ?>
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

function tampilPembayaran(){
    document.getElementById("uploadBukti").style.display="none";
let metode=document.getElementById("metodePembayaran").value;

document.getElementById("pilihanBank").style.display="none";
document.getElementById("pilihanEwallet").style.display="none";

document.getElementById("infoPembayaran").style.display="none";
document.getElementById("bankInfo").style.display="none";
document.getElementById("ewalletInfo").style.display="none";

if(metode=="Transfer Bank"){

document.getElementById("pilihanBank").style.display="block";

document.getElementById("uploadBukti").style.display="block";

}

if(metode=="E-Wallet"){

document.getElementById("pilihanEwallet").style.display="block";

}

}

function ubahBank(){

let bank=document.getElementById("bank").value;

document.getElementById("infoPembayaran").style.display="block";
document.getElementById("bankInfo").style.display="block";

document.getElementById("namaBank").innerHTML=bank;

let rekening="";

if(bank=="BCA") rekening="1234567890";
if(bank=="BRI") rekening="9876543210";
if(bank=="BNI") rekening="1122334455";
if(bank=="Mandiri") rekening="5566778899";

document.getElementById("nomorRekening").innerHTML=rekening;

}

function ubahEwallet(){

let ewallet=document.getElementById("ewallet").value;

document.getElementById("infoPembayaran").style.display="block";
document.getElementById("ewalletInfo").style.display="block";

document.getElementById("namaEwallet").innerHTML=ewallet;

let nomor="";

if(ewallet=="Dana") nomor="081234567890";
if(ewallet=="OVO") nomor="081234567891";
if(ewallet=="GoPay") nomor="081234567892";
if(ewallet=="ShopeePay") nomor="081234567893";

document.getElementById("nomorEwallet").innerHTML=nomor;

}

</script>

</body>

</html>