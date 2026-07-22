<?php
session_start();
include 'koneksi.php';


if(!isset($_SESSION['id'])){
    header("location:login.php");
    exit;
}


$id_user = $_SESSION['id'];



if(isset($_POST['simpan'])){


    $nama = mysqli_real_escape_string($conn,$_POST['nama']);

    $no_hp = mysqli_real_escape_string($conn,$_POST['no_hp']);

    $provinsi = mysqli_real_escape_string($conn,$_POST['provinsi']);

    $kabupaten = mysqli_real_escape_string($conn,$_POST['kabupaten']);

    $kecamatan = mysqli_real_escape_string($conn,$_POST['kecamatan']);

    $desa = mysqli_real_escape_string($conn,$_POST['desa']);

    $rt_rw = mysqli_real_escape_string($conn,$_POST['rt_rw']);

    $dusun = mysqli_real_escape_string($conn,$_POST['dusun']);

    $patokan = mysqli_real_escape_string($conn,$_POST['patokan']);

    $kode_pos = mysqli_real_escape_string($conn,$_POST['kode_pos']);


    mysqli_query($conn,"
        INSERT INTO alamat_user
(
id_user,
nama_penerima,
no_hp,
provinsi,
kabupaten,
kecamatan,
desa,
rt_rw,
dusun,
patokan,
kode_pos
)

VALUES
(
'$id_user',
'$nama',
'$no_hp',
'$provinsi',
'$kabupaten',
'$kecamatan',
'$desa',
'$rt_rw',
'$dusun',
'$patokan',
'$kode_pos'
)
    ");



    header("location:pilih_alamat.php");
    exit;

}


?>


<!DOCTYPE html>
<html>

<head>

<title>Tambah Alamat Baru</title>


<style>


body{

font-family:Arial;
background:#f5f5f5;

}



.container{

width:420px;

margin:40px auto;

background:white;

padding:25px;

border-radius:15px;

}



h2{

text-align:center;

}



label{

font-weight:bold;

}



input,
textarea{


width:100%;

padding:12px;

margin-top:8px;

margin-bottom:15px;

border:1px solid #ddd;

border-radius:10px;

box-sizing:border-box;


}



textarea{

height:120px;

resize:none;

}



button{


width:100%;

padding:12px;

background:#ff6b35;

color:white;

border:none;

border-radius:10px;

font-weight:bold;

cursor:pointer;


}



.kembali{

display:block;

text-align:center;

margin-top:15px;

color:#555;

text-decoration:none;


}


</style>


</head>


<body>


<div class="container">


<h2>
Tambah Alamat Baru
</h2>



<form method="POST">



<label>
Nama Penerima
</label>


<input 
type="text"
name="nama"
required>



<label>
Nomor HP
</label>


<input 
type="text"
name="no_hp"
required>



<label>
Provinsi
</label>

<input type="text" name="provinsi" required>



<label>
Kabupaten
</label>

<input type="text" name="kabupaten" required>



<label>
Kecamatan
</label>

<input type="text" name="kecamatan" required>



<label>
Desa
</label>

<input type="text" name="desa" required>



<label>
RT/RW
</label>

<input type="text" name="rt_rw" required>



<label>
Dusun
</label>

<input type="text" name="dusun">



<label>
Patokan Alamat
</label>

<textarea name="patokan"></textarea>



<label>
Kode Pos
</label>

<input type="text" name="kode_pos" required>




<button type="submit" name="simpan">

Simpan Alamat

</button>



<a href="pilih_alamat.php" class="kembali">

← Kembali

</a>



</form>


</div>


</body>

</html>