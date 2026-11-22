
<?php
session_start();

include 'koneksi.php';

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/google.php';

// Validasi CSRF
$cookie_token = $_COOKIE['g_csrf_token'] ?? '';
$post_token = $_POST['g_csrf_token'] ?? '';

if (
    $cookie_token === '' ||
    $post_token === '' ||
    !hash_equals($cookie_token, $post_token)
) {
    exit("Permintaan login tidak valid.");
}

// Ambil token Google
$id_token = $_POST['credential'] ?? '';

if ($id_token === '') {
    exit("Token Google tidak ditemukan.");
}

// Verifikasi token Google
$client = new Google_Client([
    'client_id' => GOOGLE_CLIENT_ID
]);

try {
    $payload = $client->verifyIdToken($id_token);
} catch (Throwable $e) {
    $payload = false;
}

if (!$payload) {
    exit("Verifikasi akun Google gagal.");
}

// Ambil identitas Google
$google_sub = $payload['sub'] ?? '';
$email = strtolower($payload['email'] ?? '');
$email_verified = $payload['email_verified'] ?? false;

if (!$email_verified || $email === '' || $google_sub === '') {
    exit("Email Google belum terverifikasi.");
}

// Cari user di database
$query = mysqli_prepare($koneksi, "
    SELECT *
    FROM users
    WHERE email = ?
    AND status = 1
    AND is_deleted = 0
    LIMIT 1
");

mysqli_stmt_bind_param($query, "s", $email);
mysqli_stmt_execute($query);

$hasil = mysqli_stmt_get_result($query);
$user = mysqli_fetch_assoc($hasil);

if (!$user) {
    exit("Email belum terdaftar di WMS. Hubungi Admin.");
}

// Periksa hubungan Google ID
if (
    !empty($user['google_sub']) &&
    !hash_equals($user['google_sub'], $google_sub)
) {
    exit("Akun ini sudah terhubung ke Google lain.");
}

// Periksa apakah Google ID digunakan user lain
$cek = mysqli_prepare($koneksi, "
    SELECT id_user
    FROM users
    WHERE google_sub = ?
    AND id_user != ?
    LIMIT 1
");

mysqli_stmt_bind_param(
    $cek,
    "si",
    $google_sub,
    $user['id_user']
);

mysqli_stmt_execute($cek);

$hasil_cek = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($hasil_cek) > 0) {
    exit("Akun Google sudah terhubung ke user lain.");
}

// Simpan Google ID
$update = mysqli_prepare($koneksi, "
    UPDATE users
    SET google_sub = ?
    WHERE id_user = ?
");

mysqli_stmt_bind_param(
    $update,
    "si",
    $google_sub,
    $user['id_user']
);

if (!mysqli_stmt_execute($update)) {
    exit("Gagal menghubungkan akun Google.");
}

// Buat session
session_regenerate_id(true);

$_SESSION['id_user'] = $user['id_user'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['ROLE'];


header("Location: dashboard.php");
exit;
?>
