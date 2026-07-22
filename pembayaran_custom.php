<?php
session_start();
include 'koneksi.php';


if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}


if(!isset($_GET['id'])){
    die("Pesanan tidak ditemukan");
}


$id_custom = (int)$_GET['id'];


// ambil data custom
$query = mysqli_query($conn,"
SELECT 
custom_sticker.*,
produk.nama_produk,
produk.harga

FROM custom_sticker

LEFT JOIN produk
ON custom_sticker.id_produk = produk.id_produk

WHERE id_custom='$id_custom'
");


$data = mysqli_fetch_assoc($query);


if(!$data){
    die("Data tidak ditemukan");
}




// simpan bukti pembayaran

if(isset($_POST['kirim_bukti'])){


    $bukti="";


    if($_FILES['bukti']['name']!=""){


        $bukti=time()."_".$_FILES['bukti']['name'];


        move_uploaded_file(
            $_FILES['bukti']['tmp_name'],
            "uploads/pembayaran/".$bukti
        );


    }



    mysqli_query($conn,"
    UPDATE custom_sticker

    SET

    bukti_pembayaran='$bukti',

    status_pembayaran='Menunggu Konfirmasi'

    WHERE id_custom='$id_custom'
    ");



    echo "
    <script>
    alert('Bukti pembayaran berhasil dikirim');
    window.location='pesanan.php';
    </script>
    ";

}

?>



<!DOCTYPE html>
<html>

<head>

<title>Pembayaran Custom Sticker</title>

<link rel="stylesheet" href="stayle.css">

</head>


<body>


<div class="custom-card">


<h2>
Pembayaran Custom Sticker
</h2>


<h3>
<?= $data['nama_produk']; ?>
</h3>


<p>
Total Pembayaran
</p>

<h2>
Rp <?= number_format($data['harga']*$data['jumlah']); ?>
</h2>



<hr>



<?php if($data['metode_pembayaran']=="Transfer Bank"){ ?>


<h3>
Transfer Bank <?= $data['bank']; ?>
</h3>


<p>
Silahkan transfer ke:
</p>


<h2>

<?php

if($data['bank']=="BCA"){

echo "BCA : 1234567890";

}elseif($data['bank']=="BRI"){

echo "BRI : 9876543210";

}elseif($data['bank']=="BNI"){

echo "BNI : 111222333";

}elseif($data['bank']=="Mandiri"){

echo "Mandiri : 444555666";

}

?>

</h2>



<?php } ?>

<hr>



<form method="POST" enctype="multipart/form-data">


<label>
Upload Bukti Pembayaran
</label>


<br>


<input 
type="file"
name="bukti"
required>



<br><br>


<button 
name="kirim_bukti">
Kirim Bukti Pembayaran

</button>


</form>


</div>


</body>

</html>