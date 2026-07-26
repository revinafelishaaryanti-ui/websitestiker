<?php
session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){
    header("location:login.php");
    exit;
}


$id_pesanan = $_GET['id'];

$query = mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE id_pesanan='$id_pesanan'
");


$data = mysqli_fetch_assoc($query);

if(isset($_POST['upload'])){

    $bukti = "";

    if(isset($_FILES['bukti']) && $_FILES['bukti']['tmp_name']!=""){

        $bukti = base64_encode(
            file_get_contents($_FILES['bukti']['tmp_name'])
        );

        mysqli_query($conn,"
        UPDATE pesanan
        SET
        bukti_pembayaran='$bukti',
        status_pembayaran='Menunggu Verifikasi'
        WHERE id_pesanan='$id_pesanan'
        ");

        echo "<script>
        alert('Bukti pembayaran berhasil dikirim');
        location='pesanan.php';
        </script>";
        exit;
    }
}


?>


<!DOCTYPE html>
<html>

<head>

<title>Pembayaran</title>

<link rel="stylesheet" href="checkout.css">

</head>


<body>


<div class="checkout-container">


<div class="card">


<h2>Pembayaran</h2>


<h3>
Metode : <?= $data['metode_pembayaran']; ?>
</h3>



<?php if($data['metode_pembayaran']=="Transfer Bank"){ ?>


<h3>Silakan Transfer ke:</h3>


<?php

if($data['bank']=="BCA"){

    echo "
    <h2>BCA</h2>
    <p>No Rekening : 1234567890</p>
    ";

}


elseif($data['bank']=="BRI"){

    echo "
    <h2>BRI</h2>
    <p>No Rekening : 9876543210</p>
    ";

}


elseif($data['bank']=="BNI"){

    echo "
    <h2>BNI</h2>
    <p>No Rekening : 1122334455</p>
    ";

}


elseif($data['bank']=="Mandiri"){

    echo "
    <h2>Mandiri</h2>
    <p>No Rekening : 5566778899</p>
    ";

}

?>


<?php } ?>



<?php if($data['metode_pembayaran']=="COD"){ ?>

<h3>
Pembayaran dilakukan saat barang diterima.
</h3>


<?php } ?>



<br>


<form method="POST" enctype="multipart/form-data">

<label>Upload Bukti Pembayaran</label>

<input
type="file"
name="bukti"
required>

<br><br>

<button
type="submit"
name="upload"
class="btn-order">

Kirim Bukti Pembayaran

</button>

</form>


</div>

</div>


</body>

</html>