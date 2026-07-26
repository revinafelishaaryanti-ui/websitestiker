<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

if(isset($_POST['pesan'])){

    $id_produk = $_POST['id_produk'];
    $ukuran = $_POST['ukuran'];
    $jumlah = $_POST['jumlah'];
    $catatan = mysqli_real_escape_string($conn,$_POST['catatan']);



    // AMBIL HARGA PRODUK
    $get_harga = mysqli_query($conn,"
    SELECT harga 
    FROM produk
    WHERE id_produk='$id_produk'
    ");

    $data_harga = mysqli_fetch_assoc($get_harga);

    $harga_produk = $data_harga['harga'];



    // TAMBAHAN HARGA UKURAN

    if($ukuran=="5 x 5 cm"){

        $tambahan_ukuran = 0;

    }elseif($ukuran=="10 x 10 cm"){

        $tambahan_ukuran = 5000;

    }elseif($ukuran=="15 x 15 cm"){

        $tambahan_ukuran = 10000;

    }else{

        $tambahan_ukuran = 15000;

    }


    $total_harga = ($harga_produk + $tambahan_ukuran) * $jumlah;



    $ekspedisi = $_POST['ekspedisi'];
    $jenis_desain = $_POST['jenis_desain'];
    $pembayaran = $_POST['pembayaran'];
    if(empty($_FILES['bukti_pembayaran']['tmp_name'])){

        echo "<script>
        alert('Silakan upload bukti pembayaran');
        </script>";
    
        exit;
    
    }
$bank = isset($_POST['bank']) ? $_POST['bank'] : "";
$ewallet = isset($_POST['ewallet']) ? $_POST['ewallet'] : "";

if($pembayaran=="E-Wallet"){
    $bank = $ewallet;
}
    // AMBIL HARGA PRODUK

$get_harga = mysqli_query($conn,"
SELECT harga 
FROM produk
WHERE id_produk='$id_produk'
");


$data_harga = mysqli_fetch_assoc($get_harga);


$harga_produk = $data_harga['harga'];


// BIAYA DESAIN

if($jenis_desain=="buat"){

    $biaya_desain = 50000;

}else{

    $biaya_desain = 10000;

}


// TOTAL HARGA

$total_harga = ($harga_produk + $biaya_desain) * $jumlah;

// SIMPAN GAMBAR KE DATABASE

$logo = "";

if(isset($_FILES['file_logo']) && $_FILES['file_logo']['tmp_name']!=""){

    $logo = base64_encode(
        file_get_contents($_FILES['file_logo']['tmp_name'])
    );

}


$referensi = "";

if(isset($_FILES['file_referensi']) && $_FILES['file_referensi']['tmp_name']!=""){

    $referensi = base64_encode(
        file_get_contents($_FILES['file_referensi']['tmp_name'])
    );

}

$bukti = "";


if(isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['tmp_name']!=""){


    $bukti = base64_encode(
        file_get_contents($_FILES['bukti_pembayaran']['tmp_name'])
    );


}

$simpan = mysqli_query($conn,"
INSERT INTO custom_sticker
(
    id,
    id_produk,
    ukuran,
    jumlah,
    jenis_desain,
    total_harga,
    catatan,
    ekspedisi,
    file_logo,
    file_referensi,
    metode_pembayaran,
    bank,
    bukti_pembayaran,
    latitude,
    longitude,
    lokasi_terakhir,
    status_pembayaran
)
VALUES
(
    '$id_user',
    '$id_produk',
    '$ukuran',
    '$jumlah',
    '$jenis_desain',
    '$total_harga',
    '$catatan',
    '$ekspedisi',
    '$logo',
    '$referensi',
    '$pembayaran',
    '$bank',
    '$bukti',
    NULL,
    NULL,
    'Pesanan sedang diproses',
    'Belum Dibayar'
)
");

if($simpan){

    $id_custom = mysqli_insert_id($conn);

    echo "<script>
    alert('Pesanan Custom Berhasil Dibuat');
    window.location='pembayaran_custom.php?id=".$id_custom."';
    </script>";

}else{

    echo "Pesanan gagal : ".mysqli_error($conn);

}

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Custom Sticker</title>

<link rel="stylesheet" href="stayle.css">
<link rel="stylesheet" href="custom_sticker.css">
</head>

<body>

<div class="custom-wrapper">

<div class="custom-card">

<h2>🎨 Custom Sticker</h2>

<p class="subjudul">
Buat stiker sesuai desain kamu sendiri
</p>

<form
method="POST"
enctype="multipart/form-data">

<label>Produk</label>

<select name="id_produk" required>

<option value="">-- Pilih Produk --</option>

<?php

$produk = mysqli_query($conn,"SELECT * FROM produk");

while($p=mysqli_fetch_assoc($produk)){

?>

<option value="<?= $p['id_produk']; ?>">
    <?= $p['nama_produk']; ?>
</option>

<?php } ?>

</select>

<br><br>

<label>Ukuran</label>

<select name="ukuran" required>

<option value="">
-- Pilih Ukuran --
</option>

<option value="5 x 5 cm">
5 x 5 cm
</option>

<option value="10 x 10 cm">
10 x 10 cm
</option>

<option value="15 x 15 cm">
15 x 15 cm
</option>

<option value="A4">
A4
</option>

</select>

<br><br>

<label>Jumlah</label>

<input
type="number"
name="jumlah"
required>

<br><br>

<label>Total Harga</label>

<input 
type="text"
id="tampil_harga"
value="Rp 0"
readonly>

<br><br>

<label>Catatan</label>

<textarea
name="catatan"></textarea>

<br><br>
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

</select>

<br><br>


<div id="pilihanBank" style="display:none;">

<label>Pilih Bank</label>

<select
name="bank"
id="bank"
onchange="ubahBank()">

<option value="">
-- Pilih Bank --
</option>

<option value="BCA">BCA</option>
<option value="BRI">BRI</option>
<option value="BNI">BNI</option>
<option value="Mandiri">Mandiri</option>

</select>

</div>

<div id="pilihanEwallet" style="display:none;">

<label>Pilih E-Wallet</label>

<select
name="ewallet"
id="ewallet"
onchange="ubahEwallet()">

<option value="">
-- Pilih E-Wallet --
</option>

<option value="Dana">Dana</option>
<option value="OVO">OVO</option>
<option value="GoPay">GoPay</option>
<option value="ShopeePay">ShopeePay</option>

</select>

</div>

<div id="infoPembayaran" style="display:none;">

<div id="bankInfo" style="display:none;">

<p>Silakan transfer ke:</p>

<b id="namaBank"></b>

<p>No Rekening :
<b id="nomorRekening"></b></p>

<p>a.n Stickerin</p>

</div>

<div id="ewalletInfo" style="display:none;">

<p>Kirim ke akun:</p>

<b id="namaEwallet"></b>

<p>Nomor :</p>

<b id="nomorEwallet"></b>

<p>a.n Stickerin</p>

</div>

</div>

<br><br>

<label>
Upload Bukti Pembayaran
</label>

<div class="upload-area">

<input
type="file"
name="bukti_pembayaran"
accept="image/*">

<span>
Masukkan bukti pembayaran
</span>

</div>

<br><br>
<label>Ekspedisi Pengiriman</label>

<select name="ekspedisi" required>

<option value="">
-- Pilih Ekspedisi --
</option>

<option value="JNE">
JNE
</option>

<option value="J&T">
J&T
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

</select>
<label>Pilihan Desain</label>

<select name="jenis_desain" required>

<option value="">
-- Pilih Desain --
</option>

<option value="buat">
Buatkan Desain (+Rp50.000)
</option>

<option value="sendiri">
Saya Kirim Desain (+Rp10.000)
</option>

</select>

<br><br>
<label>Upload Logo</label>

<div class="upload-area">

<input
type="file"
name="file_logo">

<span>
Masukkan logo kamu
</span>

</div>
<br><br>

<label>Upload Referensi Desain</label>

<div class="upload-area">

<input
type="file"
name="file_referensi">

<span>
Masukkan contoh desain
</span>

</div>

<br><br>
<a href="dashboard.php" class="btn-kembali">
    ← Kembali
</a>

<button
class="btn-custom"
name="pesan">

Kirim Pesanan Custom

</button>

</form>

</div>

</div>
<script>
function tampilPembayaran(){

document.getElementById("pilihanBank").style.display="none";
document.getElementById("pilihanEwallet").style.display="none";

document.getElementById("infoPembayaran").style.display="none";
document.getElementById("bankInfo").style.display="none";
document.getElementById("ewalletInfo").style.display="none";

let metode=document.getElementById("metodePembayaran").value;

if(metode=="Transfer Bank"){

document.getElementById("pilihanBank").style.display="block";

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

function hitungHarga(){

    let produk = document.querySelector('[name="id_produk"]').value;
    let ukuran = document.querySelector('[name="ukuran"]').value;
    let jumlah = document.querySelector('[name="jumlah"]').value;

    if(jumlah==""){
        jumlah = 0;
    }


    let harga = 0;


    // contoh harga berdasarkan ukuran
    if(ukuran=="5 x 5 cm"){
        harga = 5000;
    }
    else if(ukuran=="10 x 10 cm"){
        harga = 10000;
    }
    else if(ukuran=="15 x 15 cm"){
        harga = 15000;
    }
    else if(ukuran=="A4"){
        harga = 20000;
    }


    let total = harga * jumlah;


    document.getElementById("tampil_harga").value =
    "Rp " + total.toLocaleString("id-ID");

}



document.querySelector('[name="ukuran"]')
.addEventListener("change",hitungHarga);


document.querySelector('[name="jumlah"]')
.addEventListener("keyup",hitungHarga);


</script>
</body>

</html>