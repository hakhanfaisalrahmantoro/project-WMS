
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

// Fungsi khusus halaman Admin
function adminOnly() {
    if ($_SESSION['role'] !== 'admin') {
        header("Location: dashboard.php");
        exit;
    }
}
?>
