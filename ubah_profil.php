<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("Location: login.php");
    exit;

}


$id_user = $_SESSION['id'];


// ambil data user
$data = mysqli_query($conn,"
SELECT * FROM users 
WHERE id='$id_user'
");


$user = mysqli_fetch_assoc($data);



// SIMPAN DATA PROFIL

if(isset($_POST['simpan'])){


    $nama = mysqli_real_escape_string($conn,$_POST['nama']);

    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $no_hp = mysqli_real_escape_string($conn,$_POST['no_hp']);

    $alamat = mysqli_real_escape_string($conn,$_POST['alamat']);



    // foto lama
    $foto = $user['foto'];



    // jika user memilih foto baru
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){


        $fileFoto = $_FILES['foto']['tmp_name'];

        $ekstensi = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        
        $tipe = "image/jpeg";
        
        if ($ekstensi == "png") {
            $tipe = "image/png";
        } elseif ($ekstensi == "webp") {
            $tipe = "image/webp";
        } elseif ($ekstensi == "gif") {
            $tipe = "image/gif";
        }
        
        $foto = "data:$tipe;base64," . base64_encode(file_get_contents($fileFoto));    
    
    }


    $update = mysqli_query($conn,"
    
    UPDATE users SET

    nama='$nama',
    email='$email',
    no_hp='$no_hp',
    alamat='$alamat',
    foto='$foto'

    WHERE id='$id_user'

    ");



    if($update){


        $_SESSION['nama'] = $nama;


        echo "

        <script>

        alert('Profil berhasil diperbarui');

        window.location='profil.php';

        </script>

        ";


    }else{


        echo "

        <script>

        alert('Profil gagal diperbarui');

        </script>

        ";


    }


}



// jumlah keranjang

$jumlah_keranjang = 0;


$qKeranjang = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM keranjang
WHERE id_user='$id_user'
");


if($qKeranjang){

    $dataKeranjang = mysqli_fetch_assoc($qKeranjang);

    $jumlah_keranjang = $dataKeranjang['total'];

}


?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stickerin</title>
<link rel="stylesheet" href="stayle.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="mobile">

    <!-- HEADER -->
    <div class="header">

        <h1>STICKERIN</h1>

        <div class="navbar">

        
        <a href="dashboard.php">Beranda</a>

        <a href="kategori.php">Kategori</a>

        <a href="pesanan.php">Pesanan</a>




    </div>

        <div class="icon-group">

            <i class="fa-regular fa-bell"></i>

            <form action="cari.php" method="GET" class="search-box">

<input
type="text"
name="keyword"
placeholder="Cari stiker...">

<button type="submit">

<i class="fa-solid fa-magnifying-glass"></i>

</button>

</form>
        <a href="akun.php">
            <i class="fa-solid fa-user"></i>
        </a>

        <?php if(isset($_SESSION['id'])){ ?>

<a href="keranjang.php" class="cart">

    <i class="fa-solid fa-cart-shopping"></i>

    <?php if($jumlah_keranjang > 0){ ?>
        <span><?= $jumlah_keranjang; ?></span>
    <?php } ?>

</a>

<?php }else{ ?>

<a href="login.php" class="cart">

    <i class="fa-solid fa-cart-shopping"></i>

</a>

<?php } ?>

        </div>

    </div>

    <div class="ubah_profile">

<form method="POST" enctype="multipart/form-data">

<div class="sidebar-profile">

<?php if(!empty($user['foto'])){ ?>

<img
id="fotoProfil"
src="<?= $user['foto']; ?>"
alt="Foto Profil">

<?php }else{ ?>

<img 
id="fotoProfil"
src="img/default.png"
alt="Foto Profil">

<?php } ?>


<input 
type="file" 
name="foto"
id="uploadFoto"
accept="image/*"
hidden>


<button type="button" class="btn-foto"
onclick="document.getElementById('uploadFoto').click()">

Ganti Foto Profil

</button>


</div>

    <div class="content-profile">
<h1>ubah profil</h1>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input 
type="text" 
id="nama"
name="nama"
value="<?= $user['nama']; ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input 
type="email" 
id="email"
name="email"
value="<?= $user['email']; ?>"
readonly>        </div>

        <div class="form-group">
            <label>No. HP</label>
            <input 
type="text" 
id="nohp"
name="no_hp"
value="<?= $user['no_hp']; ?>">        </div>

<div class="form-group">

    <label>Alamat</label>

    <textarea name="alamat"><?= $user['alamat']; ?></textarea>

</div>

        <div class="password-section">
            <h2>Ubah Kata Sandi</h2>

            <div class="password-wrapper">

                <div class="password-form">

                    <div class="form-group">
                        <label>Kata Sandi Saat Ini</label>
                        <input type="password" id="oldPassword">
                    </div>

                    <div class="form-group">
                        <label>Kata Sandi Baru</label>
                        <input type="password" id="newPassword">
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="confirmPassword">
                    </div>

                </div>

                <div class="password-info">
                    <h3>Persyaratan Password</h3>

                    <ul>
                        <li>Minimal 8 karakter</li>
                        <li>Minimal 1 huruf besar</li>
                        <li>Minimal 1 angka</li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="action-buttons">
            <button class="btn-batal">Batal</button>
            <button 
type="submit"
name="simpan"
class="btn-simpan">

Simpan

</button>
</div>

</div>

</form>

<script>

document.getElementById('uploadFoto').addEventListener('change', function(){

    const file = this.files[0];

    if(file){

        const reader = new FileReader();

        reader.onload = function(e){

            document.getElementById('fotoProfil').src = e.target.result;

        }

        reader.readAsDataURL(file);

    }

});

</script>

<script src="script.js"></script>

</div>
</body>
</html>

