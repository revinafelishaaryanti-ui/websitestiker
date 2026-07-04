<div class="sidebar">

    <div class="logo">

        <h2>STICKERIN</h2>

    </div>

    <ul>

        <li class="active">
            <a href="dashboard.php">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="kategori.php">
                <i class="fa-solid fa-layer-group"></i>
                <span>Kategori</span>
            </a>
        </li>

        <li>
            <a href="produk.php">
                <i class="fa-solid fa-box"></i>
                <span>Produk</span>
            </a>
        </li>

        <li>
            <a href="custom.php">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span>Custom Sticker</span>
            </a>
        </li>

        <li>
            <a href="pesanan.php">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Pesanan</span>
            </a>
        </li>

        <li>
            <a href="pelanggan.php">
                <i class="fa-solid fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>

        <li>
            <a href="chat.php">
                <i class="fa-solid fa-comments"></i>
                <span>Chat Pelanggan</span>
            </a>
        </li>

        <li>
            <a href="laporan.php">
                <i class="fa-solid fa-chart-column"></i>
                <span>Laporan</span>
            </a>
        </li>

    </ul>

    <div class="admin-profile">

        <img src="../img/admin.png" alt="Admin">

        <h4><?= $_SESSION['admin_nama']; ?></h4>

        <p>Administrator</p>

        <a href="logout.php" class="logout-btn">

            <i class="fa-solid fa-right-from-bracket"></i>

            Logout

        </a>

    </div>

</div>