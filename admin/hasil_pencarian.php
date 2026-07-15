<?php

session_start();

if(!isset($_SESSION['admin_id'])){

    header("Location: login.php");
    exit;

}

include '../koneksi.php';


$keyword = $_GET['keyword'];


echo "Kamu mencari : ".$keyword;


?>