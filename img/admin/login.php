<?php
session_start();
include '../koneksi.php';

$error = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'"; 

    $query = mysqli_query($conn, $sql);

    if(!$query){
        die("Query Error: " . mysqli_error($conn));
    }

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        $_SESSION['admin_id'] = $data['id_admin'];
        $_SESSION['admin_nama'] = $data['nama_admin'];

        header("Location: dashboard.php");
        exit;

    }else{

        $error = "Email atau Password Salah!";

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Login Admin Stickerin</title>

<link rel="stylesheet" href="../stayle.css">

</head>

<body class="auth-body">

<div class="mobile">

<div class="card auth-card">

<h2>Admin Stickerin</h2>

<?php
if($error!=""){
?>

<div class="auth-alert auth-alert-error">

<?= $error ?>

</div>

<?php
}
?>

<form method="POST">

<div class="input-group">

<input
    type="email"
    name="email"
    placeholder="Email Admin"
    required>

</div>

<div class="input-group">

<input
type="password"
name="password"
placeholder="Password"
required>

</div>

<button
class="auth-btn"
name="login">

Masuk

</button>

</form>

</div>

</div>

</body>

</html>