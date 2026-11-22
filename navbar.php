
<?php
$halaman = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'] ?? 'user';
$nama = $_SESSION['nama'] ?? 'Pengguna';
?>

<style>
    .sidebar {
        width: 250px;
        min-height: 100vh;
        flex-shrink: 0;
        background: #30251f;
        color: white;
        padding: 22px 16px;
        display: flex;
        flex-direction: column;
    }

    .sidebar-brand {
        padding: 10px 12px 20px;
        border-bottom: 1px solid rgba(255,255,255,.12);
        margin-bottom: 22px;
    }

    .sidebar-brand h4 {
        font-size: 19px;
        font-weight: 800;
        margin: 0;
    }

    .sidebar-brand small {
        color: #bca995;
        font-size: 11px;
    }

    .sidebar-label {
        color: #a99583;
        font-size: 10px;
        font-weight: bold;
        letter-spacing: 1.5px;
        padding: 0 12px;
        margin-bottom: 10px;
    }

    .sidebar .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 13px;
        margin-bottom: 6px;
        border-radius: 9px;
        color: #ded5ce;
        font-size: 14px;
        transition: all .25s ease;
    }

    .sidebar .nav-link i {
        font-size: 18px;
        width: 22px;
        text-align: center;
        color: #c49a72;
    }

    .sidebar .nav-link:hover {
        background: #514033;
        color: #fff;
        transform: translateX(5px);
    }

    .sidebar .nav-link:hover i {
        color: #ffc078;
    }

    .sidebar .nav-link.active {
        background: #815536;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,.15);
    }

    .sidebar .nav-link.active i {
        color: #ffd29e;
    }

    .sidebar-user {
        margin-top: auto;
        padding: 15px 10px 5px;
        border-top: 1px solid rgba(255,255,255,.12);
    }

    .sidebar-user .user-icon {
        width: 38px;
        height: 38px;
        background: #815536;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .sidebar-user .user-name {
        font-size: 13px;
        font-weight: bold;
    }

    .sidebar-user .user-role {
        font-size: 11px;
        color: #c49a72;
        text-transform: capitalize;
    }

    .sidebar .logout-link {
        color: #ffaaa0;
    }

    .sidebar .logout-link i {
        color: #ffaaa0;
    }

    .sidebar .logout-link:hover {
        background: #642f2b;
    }
</style>


<div class="sidebar">

    <!-- BRAND -->
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-buildings fs-3"
               style="color:#d6a16e;"></i>

            <div>
                <h4>Warehouse</h4>
                <small>Management System</small>
            </div>
        </div>
    </div>


    <!-- MENU -->
    <div class="sidebar-label">
        MAIN MENU
    </div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a href="dashboard.php"
               class="nav-link <?= $halaman == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="barang.php"
               class="nav-link <?= $halaman == 'barang.php' ? 'active' : ''; ?>">
                <i class="bi bi-box-seam"></i>
                Data Barang
            </a>
        </li>

        <li class="nav-item">
            <a href="barang_masuk.php"
               class="nav-link <?= $halaman == 'barang_masuk.php' ? 'active' : ''; ?>">
                <i class="bi bi-box-arrow-in-down"></i>
                Barang Masuk
            </a>
        </li>

        <li class="nav-item">
            <a href="barang_keluar.php"
               class="nav-link <?= $halaman == 'barang_keluar.php' ? 'active' : ''; ?>">
                <i class="bi bi-box-arrow-up"></i>
                Barang Keluar
            </a>
        </li>

        <li class="nav-item">
            <a href="riwayat.php"
               class="nav-link <?= $halaman == 'riwayat.php' ? 'active' : ''; ?>">
                <i class="bi bi-clock-history"></i>
                Riwayat Transaksi
            </a>
        </li>


<?php if ($role == 'admin') { ?>
    <li class="nav-item">
        <a href="users.php"
           class="nav-link <?= $halaman == 'users.php' || $halaman == 'tambah_user.php' || $halaman == 'edit_user.php' ? 'active' : ''; ?>">

            <i class="bi bi-people-fill"></i>
            Manajemen User

        </a>
    </li>
<?php } ?>


    </ul>


    <!-- USER AREA -->
    <div class="sidebar-user">

        <div class="d-flex align-items-center gap-2 mb-3">

            <div class="user-icon">
                <i class="bi bi-person-fill"></i>
            </div>

            <div>
                <div class="user-name">
                    <?= htmlspecialchars($nama); ?>
                </div>

                <div class="user-role">
                    <?= htmlspecialchars($role); ?>
                </div>
            </div>

        </div>

        <a href="logout.php" class="nav-link logout-link">
            <i class="bi bi-box-arrow-left"></i>
            Logout
        </a>

    </div>

</div>
