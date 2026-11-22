
<?php
include 'auth.php';
include 'koneksi.php';

adminOnly();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$cek = mysqli_prepare($koneksi, "
    SELECT * FROM users
    WHERE id_user = ? AND is_deleted = 0
");

mysqli_stmt_bind_param($cek, "i", $id);
mysqli_stmt_execute($cek);

$hasil = mysqli_stmt_get_result($cek);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    exit("Pengguna tidak ditemukan.");
}

$error = "";


if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'];
    $status = (int) $_POST['status'];

    // VALIDASI DATA
    if ($nama == "" || $username == "" || $email == "") {
        $error = "Nama, username, dan email wajib diisi!";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";

    } elseif (!in_array($role, ['admin', 'user'], true) ||
              !in_array($status, [0, 1], true)) {
        $error = "Data role atau status tidak valid!";

    } elseif ($password != "" && strlen($password) < 8) {
        $error = "Password minimal 8 karakter!";

    } elseif ($id == (int) $_SESSION['id_user'] &&
              ($role != 'admin' || $status != 1)) {
        $error = "Kamu tidak boleh menonaktifkan atau mengubah role akun sendiri!";

    } else {

        // CEK USERNAME
        $cek_username = mysqli_prepare($koneksi, "
            SELECT id_user FROM users
            WHERE username = ? AND id_user != ?
        ");

        mysqli_stmt_bind_param($cek_username, "si", $username, $id);
        mysqli_stmt_execute($cek_username);

        $hasil_username = mysqli_stmt_get_result($cek_username);

        // CEK EMAIL
        $cek_email = mysqli_prepare($koneksi, "
            SELECT id_user FROM users
            WHERE email = ? AND id_user != ?
        ");

        mysqli_stmt_bind_param($cek_email, "si", $email, $id);
        mysqli_stmt_execute($cek_email);

        $hasil_email = mysqli_stmt_get_result($cek_email);

        if (mysqli_num_rows($hasil_username) > 0) {
            $error = "Username sudah digunakan!";

        } elseif (mysqli_num_rows($hasil_email) > 0) {
            $error = "Email sudah digunakan!";

        } else {

            $id_admin = (string) $_SESSION['id_user'];

            // UPDATE JIKA PASSWORD DIUBAH
            if ($password != "") {

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $query = mysqli_prepare($koneksi, "
                    UPDATE users
                    SET nama = ?,
                        username = ?,
                        email = ?,
                        password = ?,
                        role = ?,
                        status = ?,
                        last_updated_by = ?
                    WHERE id_user = ?
                ");

                mysqli_stmt_bind_param(
                    $query,
                    "sssssisi",
                    $nama,
                    $username,
                    $email,
                    $hash,
                    $role,
                    $status,
                    $id_admin,
                    $id
                );

            } else {

                // UPDATE TANPA MENGUBAH PASSWORD
                $query = mysqli_prepare($koneksi, "
                    UPDATE users
                    SET nama = ?,
                        username = ?,
                        email = ?,
                        role = ?,
                        status = ?,
                        last_updated_by = ?
                    WHERE id_user = ?
                ");

                mysqli_stmt_bind_param(
                    $query,
                    "ssssisi",
                    $nama,
                    $username,
                    $email,
                    $role,
                    $status,
                    $id_admin,
                    $id
                );
            }

            // JALANKAN UPDATE
            if (mysqli_stmt_execute($query)) {
                header("Location: users.php");
                exit;
            } else {
                $error = "Gagal memperbarui data pengguna!";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="d-flex">

    <?php include 'navbar.php'; ?>

    <main class="flex-grow-1 p-4" style="background:#f5f1eb; min-height:100vh;">

        <h3 class="fw-bold mb-4">Edit Pengguna</h3>

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
                               value="<?= htmlspecialchars($_POST['nama'] ?? $data['nama']); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control"
                               value="<?= htmlspecialchars($_POST['username'] ?? $data['username']); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Google</label>
                        <input type="email"
                            name="email"
                            class="form-control"
                            value="<?= htmlspecialchars($_POST['email'] ?? $data['email'] ?? '') ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control"
                               minlength="8">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti password.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin"
                                <?= ($data['role'] ?? '') == 'admin' ? 'selected' : ''; ?>>
                                Admin
                            </option>

                            <option value="user"
                                <?= ($data['role'] ?? '') == 'user' ? 'selected' : ''; ?>>
                                User
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="1"
                                <?= ($data['status'] ?? '') == 1 ? 'selected' : ''; ?>>
                                Aktif
                            </option>

                            <option value="0"
                                <?= ($data['status'] ?? '') == 0 ? 'selected' : ''; ?>>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    <button type="submit" name="simpan"
                            class="btn text-white"
                            style="background:#75472b;">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
                    </button>

                    <a href="users.php" class="btn btn-secondary">Kembali</a>

                </form>

            </div>
        </div>

    </main>

</div>

</body>
</html>
