<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];


// ambil data user
$query = mysqli_query($conn,"
    SELECT nama, no_hp, alamat 
    FROM users 
    WHERE id='$id_user'
");

$user = mysqli_fetch_assoc($query);


// simpan perubahan
if(isset($_POST['simpan'])){

    $nama = mysqli_real_escape_string($conn,$_POST['nama']);
    $no_hp = mysqli_real_escape_string($conn,$_POST['no_hp']);
    $alamat = mysqli_real_escape_string($conn,$_POST['alamat']);


    mysqli_query($conn,"
        UPDATE users SET
        nama='$nama',
        no_hp='$no_hp',
        alamat='$alamat'
        WHERE id='$id_user'
    ");


    header("Location: checkout.php");
    exit;

}

?>


<!DOCTYPE html>
<html>
<head>

<title>Ubah Data Pembeli</title>

<style>

body{
    font-family:Arial, sans-serif;
    background:#f5f5f5;
}


/* kotak utama */
.container{

    width:420px;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);

}


/* judul */

h2{

    text-align:center;
    margin-bottom:25px;
    color:#222;

}


/* label */

label{

    font-weight:bold;
    display:block;
    margin-bottom:8px;
    color:#333;

}



/* input */

input,
textarea{

    width:100%;
    padding:13px;
    margin-bottom:18px;
    border:1px solid #ddd;
    border-radius:12px;
    font-size:14px;
    box-sizing:border-box;
    outline:none;

}


input:focus,
textarea:focus{

    border-color:#ff6b35;

}


textarea{

    height:120px;
    resize:none;

}



/* tombol simpan */

button{

    width:100%;
    padding:13px;

    background:#ff6b35;

    color:white;

    border:none;

    border-radius:12px;

    font-size:15px;

    font-weight:bold;

    cursor:pointer;

}


button:hover{

    opacity:0.9;

}



/* kembali */

.kembali{

    display:block;

    text-align:center;

    margin-top:18px;

    text-decoration:none;

    color:#555;

}


/* preview data pembeli */

.preview-data{

    background:#fff;

    border:1px solid #ddd;

    border-radius:12px;

    padding:15px;

    margin-bottom:20px;

}


.preview-header{

    display:flex;

    justify-content:space-between;

    font-weight:bold;

}


.preview-alamat{

    margin-top:10px;

    color:#555;

    line-height:1.5;

}


</style>

</head>


<body>


<div class="container">


<h2>
Ubah Data Pembeli
</h2>

<div class="preview-data">

    <div class="preview-header">

        <span>
        <?= htmlspecialchars($user['nama']); ?>
        </span>


        <span>
        <?= htmlspecialchars($user['no_hp']); ?>
        </span>

    </div>


    <div class="preview-alamat">

        <?= nl2br(htmlspecialchars($user['alamat'])); ?>

    </div>


</div>

<form method="POST">


<label>
Nama Lengkap
</label>

<input type="text" 
name="nama"
value="<?= htmlspecialchars($user['nama']); ?>"
required>


<label>
Nomor HP
</label>

<input type="text"
name="no_hp"
value="<?= htmlspecialchars($user['no_hp']); ?>"
required>


<label>
Alamat Pengiriman
</label>

<textarea name="alamat" required><?= htmlspecialchars($user['alamat']); ?></textarea>


<button type="submit" name="simpan">
Simpan Perubahan
</button>


<a href="checkout.php" class="kembali">
← Kembali ke Checkout
</a>


</form>


</div>


</body>
</html>