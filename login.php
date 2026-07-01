
<?php
session_start();
include 'koneksi.php';

$error = '';

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        if($password == $data['password'] || password_verify($password,$data['password'])){

            $_SESSION['id'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Stickerin</title>

    <link rel="stylesheet" href="stayle.css">
    <link rel="stylesheet" href="login.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="auth-body">

<div class="mobile auth-container">

    <div class="card auth-card">

        <div class="auth-top">

            <div class="auth-logo">
                <i class="fa-regular fa-comment"></i>
                <span>STICKERIN</span>
            </div>

            <h1>Welcome Back</h1>

            <p>
                Log In To Your Account
            </p>

        </div>

        <?php if($error != ''){ ?>
            <div class="auth-alert auth-alert-error">
                <?= $error; ?>
            </div>
        <?php } ?>

        <form action="" method="POST" class="auth-form">

            <div class="input-group">
                <i class="fa-solid fa-envelope input-icon"></i>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan Email"
                    required>
            </div>

            <div class="input-group password-group">

            <i class="fa-solid fa-lock input-icon"></i>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan Password"
                required>

            <i class="fa-regular fa-eye toggle-password" id="togglePassword"></i>

            </div>

            <div class="auth-row">
                <a href="#" class="auth-link">
                    Lupa Password?
                </a>
            </div>

            <button
                type="submit"
                name="login"
                class="auth-btn">
                Masuk
            </button>

        </form>

                    <div class="social-divider">
                <span>atau lanjutkan dengan</span>
            </div>

            <div class="social-buttons">

                <a href="#" class="social-btn social-google">
                    <i class="fab fa-google"></i>
                    <span>Google</span>
                </a>

                <a href="#" class="social-btn social-facebook">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                </a>

                <a href="#" class="social-btn social-instagram">
                    <i class="fab fa-instagram"></i>
                    <span>Instagram</span>
                </a>

                <a href="#" class="social-btn social-tiktok">
                    <i class="fab fa-tiktok"></i>
                    <span>TikTok</span>
                </a>

            </div>

        <div class="auth-bottom">
            <p>
                Belum punya akun?
                <a href="register.php">
                    Daftar Sekarang
                </a>
            </p>
        </div>

    </div>

</div>
<script>

const toggle = document.getElementById("togglePassword");
const password = document.getElementById("password");

toggle.addEventListener("click",function(){

    if(password.type==="password"){
        password.type="text";
        this.classList.remove("fa-eye");
        this.classList.add("fa-eye-slash");
    }else{
        password.type="password";
        this.classList.remove("fa-eye-slash");
        this.classList.add("fa-eye");
    }

});

</script>

</body>
</html>

