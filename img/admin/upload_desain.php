<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])){
    header("Location:login.php");
    exit;
}

$id_custom = (int)$_POST['id_custom'];

if($_FILES['desain']['name']!=""){

    $nama = time()."_".$_FILES['desain']['name'];

    move_uploaded_file(
        $_FILES['desain']['tmp_name'],
        "../uploads/desain/".$nama
    );

    mysqli_query($conn,"
    UPDATE custom_sticker
    SET
    file_desain='$nama',
    status='Menunggu Persetujuan'
    WHERE id_custom='$id_custom'
    ");

}

header("Location:chat_admin.php?id_custom=".$id_custom);
exit;