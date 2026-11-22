<?php
$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "warehouse"
);

if (!$koneksi) {
    die("koneksi gagal : ".
    mysqli_connect_error());
}

?>