<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];

$id_order = (int)$_POST['id_order'];
$tipe = $_POST['tipe'];

$pesan = mysqli_real_escape_string($conn,$_POST['pesan']);

$file = "";

if(isset($_FILES['file']) && $_FILES['file']['name']!=""){

    $file = time()."_".$_FILES['file']['name'];

    move_uploaded_file(
        $_FILES['file']['tmp_name'],
        "uploads/chat/".$file
    );

}

if($tipe=="custom"){
    $result = mysqli_query($conn,"
    INSERT INTO chat
    (
        id_custom,
        pengirim,
        id_pengirim,
        pesan,
        file
    )
    VALUES
    (
        '$id_order',
        'user',
        '$id_user',
        '$pesan',
        '$file'
    )
    ");
    
    if(!$result){
        die("Error Custom: ".mysqli_error($conn));
    }

    $result = mysqli_query($conn,"
INSERT INTO chat
(
    id_pesanan,
    pengirim,
    id_pengirim,
    pesan,
    file
)
VALUES
(
    '$id_order',
    'user',
    '$id_user',
    '$pesan',
    '$file'
)
");

if(!$result){
    die("Error Produk: ".mysqli_error($conn));

}

header("Location:chat.php?id_order=".$id_order."&tipe=".$tipe);
exit;