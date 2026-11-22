<?php
include 'auth.php';
include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM barang
                                 where status = 1
                                 and is_deleted = 0");

if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}

include 'koneksi.php';

$query = mysqli_query($koneksi, "
    SELECT *
    FROM barang
    WHERE status = 1
    AND is_deleted = 0
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="gudang.png">
    <title>Data Barang - WMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="d-flex">

    <?php include 'navbar.php'; ?>

    <main class="flex-grow-1 p-4" style="background:#f5f1eb; min-height:100vh;">

        <div class="container-fluid">

            <h1 class="mb-4">Data Barang</h1>

            <a href="order.html" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i>
                Tambah Barang
            </a>

            <div class="card shadow">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategory</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;

                                while ($data = mysqli_fetch_assoc($query)) {
                                ?>

                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($data['nama_barang']); ?></td>
                                    <td><?= htmlspecialchars($data['kategory']); ?></td>
                                    <td><?= $data['stok']; ?></td>
                                    <td><?= htmlspecialchars($data['satuan']); ?></td>

                                    <td>
                                        <a href="edit_barang.php?id=<?= $data['id_barang']; ?>"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="hapus_barang.php?id=<?= $data['id_barang']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>

                                <?php } ?>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="gudang.png">
    <title>Data Barang - WMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <h2>Data Barang</h2>

        <a href="order.html" class="btn btn-primary">
            + Tambah Barang
        </a>

        
    </div>

    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Kategory</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php while ($row = mysqli_fetch_assoc($query)) { ?>

                        <tr>

                            <td><?= $row['id_barang']; ?></td>

                            <td><?= $row['nama_barang']; ?></td>

                            <td><?= $row['kategory']; ?></td>

                            <td><?= $row['stok']; ?></td>

                            <td><?= $row['satuan']; ?></td>

                            <td>

                                <a href="edit_barang.php?id=<?= $row['id_barang']; ?>"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a href="hapus_barang.php?id=<?= $row['id_barang']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                    Hapus
                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>