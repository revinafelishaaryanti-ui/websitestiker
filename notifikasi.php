<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("location:login.php");
    exit;
}

$id_user = $_SESSION['id'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi</title>

    <link rel="stylesheet" href="stayle.css">

</head>

<body>


<div class="layout">


    <!-- SIDEBAR USER -->
    <div class="sidebar">

        <div class="sidebar-card">

            <h3>
                Menu Saya
            </h3>

            <ul>

                <li>
                    <a href="dashboard.php">
                        Beranda
                    </a>
                </li>

                <li>
                    <a href="pesanan.php">
                        Pesanan
                    </a>
                </li>

                <li class="active">
                    <a href="notifikasi.php">
                        Notifikasi
                    </a>
                </li>

                <li>
                    <a href="akun.php">
                        Akun
                    </a>
                </li>

            </ul>

        </div>

    </div>




    <!-- CONTENT -->

    <div class="main-content">


        <div class="heading">

            <h1>
                Notifikasi
            </h1>

            <p>
                Informasi terbaru dari aktivitas akun kamu
            </p>

        </div>



        <div class="notif-container">


            <div class="notif-card">

                <div class="notif-icon">
                    <i class="fa-solid fa-bell"></i>
                </div>


                <div class="notif-text">

                    <h3>
                        Belum ada notifikasi
                    </h3>

                    <p>
                        Notifikasi pesanan dan informasi terbaru akan muncul di sini.
                    </p>

                </div>


            </div>


        </div>


    </div>


</div>


</body>
</html>