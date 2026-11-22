
<?php
include 'koneksi.php';

$nama = "Administrator";
$username = "admin";
$PASSWORD = "admin123";

$hash = password_hash($PASSWORD, PASSWORD_DEFAULT);

$query = mysqli_prepare($koneksi, "
    INSERT INTO users (nama, username, PASSWORD, role)
    VALUES (?, ?, ?, 'admin')
");

mysqli_stmt_bind_param(
    $query,
    "sss",
    $nama,
    $username,
    $hash
);

if (mysqli_stmt_execute($query)) {
    echo "Akun Admin berhasil dibuat!";
} else {
    echo "Gagal membuat akun: " . mysqli_error($koneksi);
}

mysqli_stmt_close($query);
?>
