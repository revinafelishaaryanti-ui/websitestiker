```php
<?php
session_start();
include 'koneksi.php';

$error = '';

if(isset($_POST['register'])){

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // cek email sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($cek) > 0){

        $error = "Email sudah terdaftar!";

    }else{

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $insert = mysqli_query(
            $conn,
            "INSERT INTO users(nama,email,password)
            VALUES('$nama','$email','$passwordHash')"
        );

        if($insert){

            $_SESSION['id'] = mysqli_insert_id($conn);
            $_SESSION['nama'] = $nama;

            header("Location: dashboard.php");
            exit;
        }else{
            $error = "Gagal mendaftar!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register Stickerin</title>

<link rel="stylesheet" href="stayle.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="auth-body">

<div class="mobile">

    <div class="card auth-card">

        <div class="auth-top">

            <div class="auth-logo">
                <i class="fa-regular fa-comment"></i>
                <span>STICKERIN</span>
            </div>

            <h1>Buat Akun</h1>

            <p>Daftar untuk mulai menggunakan Stickerin</p>

        </div>

        <?php if($error != ''){ ?>
            <div class="auth-alert auth-alert-error">
                <?= $error ?>
            </div>
        <?php } ?>

        <form method="POST" class="auth-form">

            <div class="input-group">
                <i class="fa-solid fa-user input-icon"></i>
                <input
                    type="text"
                    name="nama"
                    placeholder="Masukkan Nama"
                    required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-envelope input-icon"></i>
                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan Email"
                    required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock input-icon"></i>
                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan Password"
                    required>
            </div>

            <button
                type="submit"
                name="register"
                class="auth-btn">
                Daftar
            </button>

        </form>

        <div class="auth-bottom">
            <p>
                Sudah punya akun?
                <a href="login.php">
                    Masuk
                </a>
            </p>
        </div>

    </div>

</div>

</body>
</html>
```
