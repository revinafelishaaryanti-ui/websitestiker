<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("location:login.php");
    exit;

}


$id_user = $_SESSION['id'];
$id_alamat = isset($_GET['id_alamat']) ? $_GET['id_alamat'] : '';

// ============================================
// MODE CHECKOUT
// 1. Dari keranjang  : tanpa id_produk -> semua item keranjang
// 2. Beli langsung   : ada id_produk    -> satu produk
// ============================================

$mode_keranjang = false;
$id_produk = isset($_GET['id_produk']) ? $_GET['id_produk'] : '';

if($id_produk != ''){

    // ---------- BELI LANGSUNG (satu produk) ----------

    // ambil data produk
    $query_produk = mysqli_query($conn,
    "SELECT * FROM produk 
    WHERE id_produk='$id_produk'");

    if(mysqli_num_rows($query_produk) == 0){
        die("Produk tidak ditemukan.");
    }

    $produk = mysqli_fetch_assoc($query_produk);

    $jumlah = isset($_GET['jumlah']) ? (int)$_GET['jumlah'] : 1;

    // daftar item checkout (satu produk)
    $items = array(
        array(
            'id_produk' => $produk['id_produk'],
            'nama_produk' => $produk['nama_produk'],
            'gambar' => $produk['gambar'],
            'harga' => $produk['harga'],
            'jumlah' => $jumlah,
            'subtotal' => $produk['harga'] * $jumlah
        )
    );

    $total_qty = $jumlah;

}else{

    // ---------- DARI KERANJANG (multi produk) ----------

    $mode_keranjang = true;

    $query_cart = mysqli_query($conn,"
    SELECT
    keranjang.id,
    keranjang.jumlah,
    produk.id_produk,
    produk.nama_produk,
    produk.gambar,
    produk.harga

    FROM keranjang

    JOIN produk
    ON keranjang.id_produk = produk.id_produk

    WHERE keranjang.id_user='$id_user'
    ORDER BY keranjang.id ASC
    ");

    if(mysqli_num_rows($query_cart) == 0){
        die("Keranjang masih kosong.");
    }

    $items = array();
    $total_qty = 0;

    while($row = mysqli_fetch_assoc($query_cart)){
        $items[] = array(
            'id_produk' => $row['id_produk'],
            'nama_produk' => $row['nama_produk'],
            'gambar' => $row['gambar'],
            'harga' => $row['harga'],
            'jumlah' => $row['jumlah'],
            'subtotal' => $row['harga'] * $row['jumlah']
        );
        $total_qty += $row['jumlah'];
    }

}


// Hitung total
$total = 0;
foreach($items as $item){
    $total += $item['subtotal'];
}

// Hitung ongkir (gratis jika total barang >= 5)
if($total_qty >= 5){
    $ongkir = 0;
}else{
    $ongkir = 10000;
}

$total_bayar = $total + $ongkir;


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


if(isset($_POST['buat_pesanan'])){

    $ekspedisi = isset($_POST['ekspedisi']) ? $_POST['ekspedisi'] : '';
    $pembayaran = isset($_POST['pembayaran']) ? $_POST['pembayaran'] : '';
    $bank = isset($_POST['bank']) ? $_POST['bank'] : '-';
    $catatan = isset($_POST['catatan']) ? mysqli_real_escape_string($conn, $_POST['catatan']) : '';


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
status_pembayaran,
catatan
)

    VALUES
(
'$id_user',
'$total_bayar',
'$ekspedisi',
'$pembayaran',
'$bank',
'$no_resi',
'Belum Dibayar',
'$catatan'
)

    ");


    if($simpan){

        $id_pesanan = mysqli_insert_id($conn);

        // Simpan semua item ke detail_pesanan
        foreach($items as $item){

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
            '".$item['id_produk']."',
            '".$item['jumlah']."',
            '".$item['harga']."'
            )
            ");

        }

        // Jika dari keranjang, kosongkan keranjang user
        if($mode_keranjang){
            mysqli_query($conn,"
            DELETE FROM keranjang
            WHERE id_user='$id_user'
            ");
        }

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


<?php foreach($items as $item){ ?>

<div class="product-card">


    <img src="img/<?= $item['gambar']; ?>" 
    class="product-image">


    <div class="product-info">


        <h3>
            <?= $item['nama_produk']; ?>
        </h3>


        <p class="product-price">
            Rp <?= number_format($item['harga']); ?>
        </p>


        <span>
        Jumlah : <?= $item['jumlah']; ?> Produk
            </span>


    </div>


</div>

<?php } ?>

</div>





<div class="card">


<form method="POST" action="" enctype="multipart/form-data">
<label>Data Pembeli</label>

<a href="pilih_alamat.php<?= $id_produk != '' ? '?id_produk='.$id_produk : ''; ?>" class="data-pembeli">
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


<a href="pilih_alamat.php<?= $id_produk != '' ? '?id_produk='.$id_produk : ''; ?>" class="btn-alamat">
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
<textarea
name="catatan"
rows="4"
placeholder="Contoh: Tolong jangan dilipat, kirim sore hari, atau catatan lainnya..."
class="catatan-pesanan"></textarea>

<br><br>

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

