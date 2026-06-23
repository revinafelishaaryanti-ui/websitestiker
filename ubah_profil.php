
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stickerin</title>
<link rel="stylesheet" href="stayle.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="mobile">

    <!-- HEADER -->
    <div class="header">

        <h1>STICKERIN</h1>

        <div class="navbar">

        
        <a href="dashboard.php">Beranda</a>

        <a href="kategori.php">Kategori</a>

        <a href="pesanan.php">Pesanan</a>




    </div>

        <div class="icon-group">

            <i class="fa-regular fa-bell"></i>

            <i class="fa-solid fa-magnifying-glass"></i>

        <a href="akun.php">
            <i class="fa-solid fa-user"></i>
        </a>

            <a href="keranjang.php" class="cart">
    <i class="fa-solid fa-cart-shopping"></i>
    <span>3</span>
</a>

        </div>

    </div>

<div class="ubah_profile">

    <div class="sidebar-profile">
        <img id="fotoProfil" src="img/default.png" alt="Foto Profil">

        <input type="file" id="uploadFoto" hidden>

        <button class="btn-foto"
            onclick="document.getElementById('uploadFoto').click()">
            Ganti Foto Profil
        </button>
    </div>

    <div class="content-profile">

            <h1>ubah profil</h1>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" id="nama">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" id="email" readonly>
        </div>

        <div class="form-group">
            <label>No. HP</label>
            <input type="text" id="nohp">
        </div>

        <div class="password-section">
            <h2>Ubah Kata Sandi</h2>

            <div class="password-wrapper">

                <div class="password-form">

                    <div class="form-group">
                        <label>Kata Sandi Saat Ini</label>
                        <input type="password" id="oldPassword">
                    </div>

                    <div class="form-group">
                        <label>Kata Sandi Baru</label>
                        <input type="password" id="newPassword">
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="confirmPassword">
                    </div>

                </div>

                <div class="password-info">
                    <h3>Persyaratan Password</h3>

                    <ul>
                        <li>Minimal 8 karakter</li>
                        <li>Minimal 1 huruf besar</li>
                        <li>Minimal 1 angka</li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="action-buttons">
            <button class="btn-batal">Batal</button>
            <button class="btn-simpan">
            <?= $teks[$lang]['simpan']; ?>
            </button>
        </div>

    </div>

</div>

<script src="script.js"></script>

</div>
</body>
</html>

