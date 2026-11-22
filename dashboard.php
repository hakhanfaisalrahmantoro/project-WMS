
<?php
include 'auth.php';
include 'koneksi.php';

// Menghitung jumlah jenis barang
$query_barang = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total
    FROM barang
");

$data_barang = mysqli_fetch_assoc($query_barang);
$total_barang = $data_barang['total'];


// Menghitung total stok
$query_stok = mysqli_query($koneksi, "
    SELECT SUM(stok) AS total
    FROM barang
");

$data_stok = mysqli_fetch_assoc($query_stok);
$total_stok = $data_stok['total'] ?? 0;


// Menghitung jumlah kategori
$query_kategory = mysqli_query($koneksi, "
    SELECT COUNT(DISTINCT kategory) AS total
    FROM barang
");

$data_kategory = mysqli_fetch_assoc($query_kategory);
$total_kategory = $data_kategory['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="gudang.png">

    <title>Dashboard WMS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <?php include 'navbar.php'; ?>


    <!-- KONTEN DASHBOARD -->
    <main class="flex-grow-1 p-4">

        <div class="container-fluid">

            <h1 class="mb-4">Dashboard Warehouse</h1>

            <div class="row g-4">

                <!-- JENIS BARANG -->
                <div class="col-md-4">

                    <div class="card shadow">

                        <div class="card-body">

                            <h5 class="card-title">
                                <i class="bi bi-box-seam text-warning fs-1"></i>
                                Jenis Barang
                            </h5>

                            <h2>
                                <?= $total_barang; ?>
                            </h2>

                            <p class="text-muted">
                                Jenis barang terdaftar
                            </p>

                        </div>

                    </div>

                </div>


                <!-- TOTAL STOK -->
                <div class="col-md-4">

                    <div class="card shadow">

                        <div class="card-body">

                            <h5 class="card-title">
                                <i class="bi bi-bar-chart text-primary fs-1"></i>
                                Total Stok
                            </h5>

                            <h2>
                                <?= $total_stok; ?>
                            </h2>

                            <p class="text-muted">
                                Total seluruh stok
                            </p>

                        </div>

                    </div>

                </div>


                <!-- KATEGORI -->
                <div class="col-md-4">

                    <div class="card shadow">

                        <div class="card-body">

                            <h5 class="card-title">
                                <i class="bi bi-grid text-success fs-1"></i>
                                Kategori
                            </h5>

                            <h2>
                                <?= $total_kategory; ?>
                            </h2>

                            <p class="text-muted">
                                Kategori barang
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <!-- TOMBOL AKSI -->
            <div class="mt-4">

                <a href="barang.php" class="btn btn-primary">
                    <i class="bi bi-eye"></i>
                    Lihat Data Barang
                </a>

                <a href="tambah_barang.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Barang
                </a>

            </div>

        </div>

    </main>

</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
