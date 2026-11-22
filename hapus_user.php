
<?php
include 'auth.php';
include 'koneksi.php';

adminOnly();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    exit("ID pengguna tidak valid.");
}

if ($id == (int) $_SESSION['id_user']) {
    exit("Kamu tidak dapat menghapus akun sendiri.");
}

$id_admin = (string) $_SESSION['id_user'];

$query = mysqli_prepare($koneksi, "
    UPDATE users
    SET is_deleted = 1,
        last_updated_by = ?
    WHERE id_user = ?
    AND is_deleted = 0
");

mysqli_stmt_bind_param($query, "si", $id_admin, $id);

if (mysqli_stmt_execute($query)) {
    header("Location: users.php");
    exit;
} else {
    echo "Gagal menonaktifkan akun: " . mysqli_error($koneksi);
}

mysqli_stmt_close($query);
?>
