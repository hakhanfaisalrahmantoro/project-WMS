<?php
include 'koneksi.php';

echo "PHP jalan<br>";

$result = mysqli_query($koneksi, "SELECT * FROM barang");

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

echo "Database dan tabel barang berhasil diakses!<br><br>";

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['nama_barang'] . " - " . $row['stok'] . " " . $row['satuan'] . "<br>";
}
?>