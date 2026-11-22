
<?php
include 'auth.php';
include 'koneksi.php';
adminOnly();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query = mysqli_query($koneksi, "
    UPDATE barang
    SET is_deleted = 1
    WHERE id_barang = $id
");

if ($query) {
    header("Location: barang.php");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
}

?>
