<?php

session_start();

include '../koneksi.php';


// cek id custom
if(!isset($_POST['id_custom'])){
    header("Location:chat.php");
    exit;
}


$id_custom = (int)$_POST['id_custom'];

$pesan = mysqli_real_escape_string(
    $conn,
    $_POST['pesan']
);


// ID admin
// sesuaikan jika ID admin kamu berbeda
$id_pengirim = 1;


$file = "";


if(isset($_FILES['file']) && $_FILES['file']['name']!=""){

    $file = time()."_".$_FILES['file']['name'];

    // folder penyimpanan gambar
    $folder = "../img/";

    // buat folder jika belum ada
    if(!is_dir($folder)){
        mkdir($folder,0777,true);
    }


    move_uploaded_file(
        $_FILES['file']['tmp_name'],
        $folder.$file
    );
}



$query = mysqli_query($conn,"
INSERT INTO chat
(
id_custom,
pengirim,
id_pengirim,
pesan,
file,
dibaca,
waktu
)
VALUES
(
'$id_custom',
'admin',
'$id_pengirim',
'$pesan',
'$file',
'0',
NOW()
)
");



if($query){

    header("Location:room.php?id_custom=".$id_custom);
    exit;

}else{

    echo "Gagal mengirim pesan : ".mysqli_error($conn);

}


?>