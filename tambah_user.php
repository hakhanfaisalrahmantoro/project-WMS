

<?php
include 'auth.php';
include 'koneksi.php';

adminOnly();

$error = "";

if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'];
    $role = $_POST['role'];

    // VALIDASI DATA
    if ($nama == "" || $username == "" || $email == "" || $password == "") {
        $error = "Semua kolom wajib diisi!";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";

    } elseif (!in_array($role, ['admin', 'user'], true)) {
        $error = "Role tidak valid!";

    } elseif (strlen($password) < 8) {
        $error = "Password minimal 8 karakter!";

    } else {

        // CEK USERNAME
        $cek = mysqli_prepare($koneksi, "
            SELECT id_user FROM users
            WHERE username = ?
        ");

        mysqli_stmt_bind_param($cek, "s", $username);
        mysqli_stmt_execute($cek);

        $hasil = mysqli_stmt_get_result($cek);

        // CEK EMAIL
        $cek_email = mysqli_prepare($koneksi, "
            SELECT id_user FROM users
            WHERE email = ?
        ");

        mysqli_stmt_bind_param($cek_email, "s", $email);
        mysqli_stmt_execute($cek_email);

        $hasil_email = mysqli_stmt_get_result($cek_email);

        if (mysqli_num_rows($hasil) > 0) {
            $error = "Username sudah digunakan!";

        } elseif (mysqli_num_rows($hasil_email) > 0) {
            $error = "Email sudah digunakan!";

        } else {

            // HASH PASSWORD
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // ID ADMIN YANG MEMBUAT USER
            $id_admin = (string) $_SESSION['id_user'];

            // INSERT USER
            $query = mysqli_prepare($koneksi, "
                INSERT INTO users
                (nama, username, email, password, role,
                 created_by, last_updated_by)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            mysqli_stmt_bind_param(
                $query,
                "sssssss",
                $nama,
                $username,
                $email,
                $hash,
                $role,
                $id_admin,
                $id_admin
            );

            if (mysqli_stmt_execute($query)) {
                header("Location: users.php");
                exit;
            } else {
                $error = "Gagal menambahkan pengguna.";
            }

            mysqli_stmt_close($query);
        }

        mysqli_stmt_close($cek);
        mysqli_stmt_close($cek_email);
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tambah User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="d-flex">

    <?php include 'navbar.php'; ?>

    <main class="flex-grow-1 p-4" style="background:#f5f1eb; min-height:100vh;">

        <h3 class="fw-bold mb-4">Tambah Pengguna</h3>

        <div class="card border-0 shadow-sm rounded-4" style="max-width:650px;">
            <div class="card-body p-4">

                <?php if ($error != "") { ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error); ?>
                    </div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control"
                               value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control"
                               value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>"
                               required>
                    </div>

                     <div class="mb-3">
                         <label class="form-label">Email Google</label>
                        <input type="email"
                                name="email"
                                class="form-control"
                                placeholder="nama@gmail.com"
                                required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               minlength="8" required>
                        <small class="text-muted">Minimal 8 karakter.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Role Pengguna</label>
                        <select name="role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <button type="submit" name="simpan"
                            class="btn text-white"
                            style="background:#75472b;">
                        <i class="bi bi-save me-1"></i>
                        Simpan Pengguna
                    </button>

                    <a href="users.php" class="btn btn-secondary">
                        Kembali
                    </a>

                </form>

            </div>
        </div>

    </main>

</div>

</body>
</html>
