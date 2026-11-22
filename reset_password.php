
<?php
include 'koneksi.php';

$username = "admin";
$password = "admin123";

$hash = password_hash($password, PASSWORD_DEFAULT);

$query = mysqli_prepare($koneksi, "
    UPDATE users
    SET password = ?
    WHERE username = ?
");

mysqli_stmt_bind_param($query, "ss", $hash, $username);

if (mysqli_stmt_execute($query)) {

    if (mysqli_stmt_affected_rows($query) >= 0) {
        echo "Password berhasil diperbarui!";
    }

} else {
    echo "Gagal: " . mysqli_error($koneksi);
}

mysqli_stmt_close($query);
?>
