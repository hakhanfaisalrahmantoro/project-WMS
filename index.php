
<?php
session_start();
require_once 'config/google.php';
include 'koneksi.php';


// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_prepare($koneksi, "
        SELECT id_user, nama, username, password, role
        FROM users
        WHERE username = ?
        AND status = 1
        AND is_deleted = 0
        LIMIT 1
    ");

    mysqli_stmt_bind_param($query, "s", $username);
    mysqli_stmt_execute($query);

    $hasil = mysqli_stmt_get_result($query);
    $user = mysqli_fetch_assoc($hasil);

    if ($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Username atau password tidak sesuai!";
    }

    mysqli_stmt_close($query);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="gudang.png" type="image/x-icon">

    <title>Login | Warehouse Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eee7dc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
        }

        .login-container {
            width: 100%;
            max-width: 1050px;
            min-height: 600px;
            background: white;
            border-radius: 22px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            box-shadow: 0 20px 60px rgba(50, 30, 15, 0.18);
        }

        .brand-panel {
            position: relative;
            overflow: hidden;
            padding: 55px;
            color: white;
            background:
                radial-gradient(circle at 85% 15%, rgba(255,255,255,.13), transparent 30%),
                linear-gradient(145deg, #59351f, #2b1b13);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-panel::before,
        .brand-panel::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 50%;
            width: 350px;
            height: 350px;
            right: -130px;
            bottom: -100px;
            animation: float 8s ease-in-out infinite;
        }

        .brand-panel::after {
            width: 240px;
            height: 240px;
            right: -70px;
            bottom: -45px;
            animation-delay: 1s;
        }

        .brand-content,
        .brand-footer {
            position: relative;
            z-index: 1;
        }

        .brand-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            font-size: 30px;
            margin-bottom: 35px;
        }

        .brand-panel h1 {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .brand-panel p {
            color: #e4d5c5;
            line-height: 1.8;
            max-width: 400px;
        }

        .wood-details {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 35px;
        }

        .wood-tag {
            padding: 9px 14px;
            border-radius: 30px;
            border: 1px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.08);
            font-size: 13px;
        }

        .brand-footer {
            color: #cbb9a8;
            font-size: 12px;
        }

        .login-panel {
            padding: 65px 55px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-panel h2 {
            color: #35251b;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .login-subtitle {
            color: #888;
            margin-bottom: 35px;
        }

        .form-label {
            color: #49382b;
            font-weight: 600;
            font-size: 14px;
        }

        .input-group {
            border: 1px solid #e4ddd5;
            border-radius: 10px;
            overflow: hidden;
            background: #faf9f7;
        }

        .input-group-text {
            border: none;
            background: transparent;
            color: #8b6345;
            padding-left: 15px;
        }

        .form-control {
            border: none;
            background: transparent;
            padding: 13px 12px;
            box-shadow: none !important;
        }

        .input-group:focus-within {
            border-color: #a66b3f;
            box-shadow: 0 0 0 3px rgba(166,107,63,.12);
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: #75472b;
            color: white;
            font-weight: 700;
            margin-top: 12px;
            transition: .3s;
        }

        .btn-login:hover {
            background: #4d2e1c;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(75,45,28,.2);
        }

        .login-note {
            color: #999;
            font-size: 12px;
            text-align: center;
            margin-top: 30px;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-18px);
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .login-container {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                padding: 35px;
                min-height: 330px;
            }

            .brand-panel h1 {
                font-size: 32px;
            }

            .login-panel {
                padding: 40px 30px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <!-- PANEL IDENTITAS -->
    <div class="brand-panel">

        <div class="brand-content">

            <div class="brand-icon">
                <i class="bi bi-buildings"></i>
            </div>

            <h1>Warehouse<br>Management System.</h1>

            <p>
                Sistem manajemen persediaan untuk mendukung
                pengelolaan bahan kayu, material, dan komponen
                produksi gitar secara terstruktur.
            </p>

            <div class="wood-details">
                <span class="wood-tag">
                    <i class="bi bi-tree"></i> Wood Material
                </span>

                <span class="wood-tag">
                    <i class="bi bi-music-note"></i> Guitar Parts
                </span>

                <span class="wood-tag">
                    <i class="bi bi-box-seam"></i> Inventory
                </span>
            </div>

        </div>

        <div class="brand-footer">
            © 2026  Warehouse Management System
        </div>

    </div>


    <!-- PANEL LOGIN -->
    <div class="login-panel">

        <div class="mb-4">
            <span class="text-uppercase small fw-bold"
                  style="color:#a66b3f; letter-spacing:2px;">
                Welcome Back
            </span>

            <h2 class="mt-2">Sign In</h2>

            <p class="login-subtitle">
                Silakan masuk untuk mengakses sistem gudang.
            </p>
        </div>

        <?php if ($error != "") { ?>
            <div class="alert alert-danger py-2">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= htmlspecialchars($error); ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Username</label>

                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        placeholder="Masukkan username"
                        autocomplete="username"
                        required>
                </div>
            </div>


            <div class="mb-4">
                <label class="form-label">Password</label>

                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required>
                </div>
            </div>


            <button type="submit" name="login" class="btn-login">
                Sign In
                <i class="bi bi-arrow-right ms-2"></i>
            </button>

        <div class="text-center my-3">
            <span class="text-muted small">ATAU</span>
        </div>

        <div id="g_id_onload"
            data-client_id="<?= htmlspecialchars(GOOGLE_CLIENT_ID) ?>"
            data-login_uri="http://localhost/warehouse/google_login.php"
            data-ux_mode="redirect">
        </div>

        <div class="g_id_signin"
            data-type="standard"
            data-size="large"
            data-theme="outline"
            data-text="signin_with"
            data-shape="rectangular"
            data-logo_alignment="left"
            data-width="350">
        </div>

</div>
<script src="https://accounts.google.com/gsi/client" async defer></script>
</body>
</html>
