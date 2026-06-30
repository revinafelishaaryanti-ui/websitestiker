<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location:login.php");
    exit;
}

$id_user = $_SESSION['id'];

$id_custom = $_POST['id_custom'];
$pesan = mysqli_real_escape_string($conn,$_POST['pesan']);

$file = "";

if($_FILES['file']['name']!=""){

    $file = time()."_".$_FILES['file']['name'];

    move_uploaded_file(
        $_FILES['file']['tmp_name'],
        "uploads/chat/".$file
    );

}

mysqli_query($conn,"
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
'$id_custom',
'user',
'$id_user',
'$pesan',
'$file'
)
");

header("Location:chat_user.php?id_custom=".$id_custom);
exit;