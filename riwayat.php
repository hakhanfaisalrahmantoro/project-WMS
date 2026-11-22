
<?php
include 'auth.php';
include 'koneksi.php';

$query = mysqli_query($koneksi, "

    SELECT
        bm.id_masuk AS id_transaksi,
        bm.tanggal AS tanggal,
        b.nama_barang,
        'Barang Masuk' AS jenis,
        bm.jumlah AS jumlah
    FROM barang_masuk bm
    JOIN barang b ON bm.id_barang = b.id_barang

    UNION ALL

    SELECT
        bk.id_keluar AS id_transaksi,
        bk.tanggal AS tanggal,
        b.nama_barang,
        'Barang Keluar' AS jenis,
        bk.jumlah AS jumlah
    FROM barang_keluar bk
    JOIN barang b ON bk.id_barang = b.id_barang

    UNION ALL

    SELECT
        b.id_barang AS id_transaksi,
        DATE(b.created_date) AS tanggal,
        b.nama_barang,
        'Barang Baru' AS jenis,
        b.stok AS jumlah
    FROM barang b

    ORDER BY tanggal DESC

");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="gudang.png">
    <title>Riwayat Transaksi - WMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="d-flex">

    <?php include 'navbar.php'; ?>

    <main class="flex-grow-1 p-4"  style="background:#f5f1eb; min-height:100vh;">

        <div class="container-fluid">

            <h1 class="mb-4">Riwayat Transaksi</h1>

            <div class="card shadow">
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $no = 1;

                                while ($data = mysqli_fetch_assoc($query)) {
                                ?>

                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($data['tanggal']); ?></td>
                                    <td><?= htmlspecialchars($data['nama_barang']); ?></td>
                                    
<td>
    <?php if ($data['jenis'] == 'Barang Masuk') { ?>

        <span class="badge bg-success">
            Barang Masuk
        </span>

    <?php } elseif ($data['jenis'] == 'Barang Keluar') { ?>

        <span class="badge bg-danger">
            Barang Keluar
        </span>

    <?php } else { ?>

        <span class="badge bg-primary">
            Barang Baru
        </span>

    <?php } ?>
</td>

                                    <td><?= $data['jumlah']; ?></td>
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
