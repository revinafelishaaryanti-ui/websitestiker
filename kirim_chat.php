<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];

$id_order = isset($_POST['id_order']) ? (int)$_POST['id_order'] : 0;
$tipe = isset($_POST['tipe']) ? $_POST['tipe'] : '';

$pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

$file = "";
$nama_file = "";

if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=""){

    $nama_file = time() . "_" . $_FILES['file']['name'];

    $file = base64_encode(
        file_get_contents($_FILES['file']['tmp_name'])
    );
}

if($tipe == "custom"){

    $sql = "
    INSERT INTO chat
    (
        id_custom,
        pengirim,
        id_pengirim,
        pesan,
        file,
        nama_file
    )
    VALUES
(
    '$id_order',
    'user',
    '$id_user',
    '$pesan',
    '$file',
    '$nama_file'
)";

}else{

    $sql = "
    INSERT INTO chat
(
    id_pesanan,
    pengirim,
    id_pengirim,
    pesan,
    file,
    nama_file
)
    VALUES
    (
        '$id_order',
        'user',
        '$id_user',
        '$pesan',
        '$file',
        '$nama_file'
    )";

}

if(mysqli_query($conn, $sql)){

    header("Location:chat.php?id_order=".$id_order."&tipe=".$tipe);
    exit;

}else{

    die("Gagal menyimpan chat : ".mysqli_error($conn));

}