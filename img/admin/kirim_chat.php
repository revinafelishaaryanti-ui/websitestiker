<?php

session_start();
include '../koneksi.php';


if(!isset($_POST['id_order'])){
    die("ID pesanan tidak ditemukan");
}


$id_order = (int)$_POST['id_order'];
$tipe = $_POST['tipe'];

$pesan = mysqli_real_escape_string(
    $conn,
    $_POST['pesan']
);


// ID admin
$id_pengirim = 1;


$file = "";
$nama_file = "";


if(isset($_FILES['file']) && $_FILES['file']['tmp_name']!=""){

    $nama_file = time()."_".$_FILES['file']['name'];

    $file = base64_encode(
        file_get_contents($_FILES['file']['tmp_name'])
    );

}


// kalau custom
if($tipe=="custom"){


$sql = mysqli_query($conn,"
INSERT INTO chat
(
id_custom,
pengirim,
id_pengirim,
pesan,
file,
nama_file,
dibaca,
waktu
)
VALUES
(
'$id_order',
'admin',
'$id_pengirim',
'$pesan',
'$file',
'$nama_file',
'0',
NOW()
)
");


}else{


// kalau pesanan biasa

$sql = mysqli_query($conn,"
INSERT INTO chat
(
id_pesanan,
pengirim,
id_pengirim,
pesan,
file,
nama_file,
dibaca,
waktu
)
VALUES
(
'$id_order',
'admin',
'$id_pengirim',
'$pesan',
'$file',
'$nama_file',
'0',
NOW()
)
");


}



if($sql){

    header("Location:room.php?id_order=".$id_order."&tipe=".$tipe);
    exit;

}else{

    echo "Gagal mengirim pesan : ".mysqli_error($conn);

}


?>