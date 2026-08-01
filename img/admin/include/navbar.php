<div class="navbar-admin">

    <div class="nav-left">

        <h2>Dashboard</h2>

        <p>
            Selamat datang kembali,
            <b><?= $_SESSION['admin_nama']; ?></b>
        </p>

    </div>

    <div class="nav-right">

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                placeholder="Cari sesuatu...">

        </div>

        <div class="notif">

            <i class="fa-regular fa-bell"></i>

            <span>3</span>

        </div>

        <div class="admin-info">

            <img src="../img/admin.png" alt="Admin">

            <div>

                <h4><?= $_SESSION['admin_nama']; ?></h4>

                <span>Administrator</span>

            </div>

        </div>

    </div>

</div>