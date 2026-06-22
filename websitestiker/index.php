<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Stickerin</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="card">

    <div class="logo">
        <div class="logo-icon">S</div>
        <h2>STICKERIN</h2>
    </div>

    <div class="title">
        <h1>Welcome Back</h1>
        <p>Log In To Your Account</p>
    </div>

    <form>
        <div class="input-box">
            <i class="fa-solid fa-user left"></i>
            <input type="text" placeholder="Username / Email">
        </div>

        <div class="input-box">
            <i class="fa-solid fa-lock left"></i>
            <input type="password" id="password" placeholder="Password">
            <i class="fa-solid fa-eye-slash toggle" id="togglePass"></i>
        </div>

        <div class="forgot">
            <a href="#">Lupa Password?</a>
        </div>

        <button type="submit" class="btn-login">
            Masuk
        </button>
    </form>

    <div class="signup">
        Belum punya akun?
        <a href="#">Daftar</a>
    </div>

    <div class="divider">
        Or continue with
    </div>

    <div class="social">
        <a href="#" class="google">
            <i class="fab fa-google"></i>
        </a>

        <a href="#" class="tiktok">
            <i class="fab fa-tiktok"></i>
        </a>

        <a href="#" class="facebook">
            <i class="fab fa-facebook-f"></i>
        </a>

        <a href="#" class="apple">
            <i class="fab fa-apple"></i>
        </a>
    </div>

</div>

<script src="script.js"></script>

</body>
</html>