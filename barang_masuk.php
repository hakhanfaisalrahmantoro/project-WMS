
<?php
include 'auth.php';
include 'koneksi.php';

if (isset($_POST['simpan'])) {

    $id_barang = (int) $_POST['id_barang'];
    $jumlah = (int) $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

    if ($jumlah <= 0) {
        exit("Jumlah barang harus lebih dari 0.");
    }

    $query = mysqli_query($koneksi, "
        INSERT INTO barang_masuk
        (id_barang, jumlah, tanggal)
        VALUES
        ('$id_barang', '$jumlah', '$tanggal')
    ");

    if ($query) {

        $update = mysqli_query($koneksi, "
            UPDATE barang
            SET stok = stok + $jumlah
            WHERE id_barang = $id_barang
            AND status = 1
            AND is_deleted = 0
        ");

        if (!$update) {
            exit("Gagal memperbarui stok barang.");
        }

        header("Location: barang.php");
        exit;

    } else {
        echo "Gagal menyimpan transaksi: " . mysqli_error($koneksi);
    }
}

$query_barang = mysqli_query($koneksi, "
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
    <title>Barang Masuk - WMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="d-flex">

    <?php include 'navbar.php'; ?>

    <main class="flex-grow-1 p-4"  style="background:#f5f1eb; min-height:100vh;">

        <div class="container-fluid">

            <h1 class="mb-4">Input Barang Masuk</h1>

            <div class="card shadow">
                <div class="card-body">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>

                            <select name="id_barang" class="form-select" required>

                                <option value="">Pilih Barang</option>

                                <?php while ($barang = mysqli_fetch_assoc($query_barang)) { ?>

                                    <option value="<?= $barang['id_barang']; ?>">
                                        <?= htmlspecialchars($barang['nama_barang']); ?>
                                    </option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah"
                                   class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal"
                                   class="form-control"
                                   value="<?= date('Y-m-d'); ?>" required>
                        </div>

                        <button type="submit" name="simpan" class="btn btn-success">
                            Simpan Transaksi
                        </button>

                        <a href="barang.php" class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>

                </div>
            </div>

        </div>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
