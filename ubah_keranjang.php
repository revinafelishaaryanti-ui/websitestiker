<?php

session_start();

include 'koneksi.php';


if(!isset($_SESSION['id'])){

    header("Location: login.php");
    exit;

}


$id_user = $_SESSION['id'];

$id = $_GET['id'];

$aksi = $_GET['aksi'];



// tambah jumlah

if($aksi == "tambah"){


    mysqli_query($conn,"
    UPDATE keranjang SET jumlah = jumlah + 1
    WHERE id='$id'
    AND id_user='$id_user'
    ");


}


// kurangi jumlah

else if($aksi == "kurang"){


    mysqli_query($conn,"
    UPDATE keranjang SET jumlah = jumlah - 1
    WHERE id='$id'
    AND id_user='$id_user'
    ");



    // hapus jika jumlah 0

    mysqli_query($conn,"
    DELETE FROM keranjang
    WHERE id='$id'
    AND jumlah <= 0
    ");


}



header("Location: keranjang.php");

exit;

?>