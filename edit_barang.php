
<?php
include 'auth.php';
include 'koneksi.php';
adminOnly();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query_barang = mysqli_query($koneksi, "
    SELECT *
    FROM barang
    WHERE id_barang = $id
    AND status = 1
    AND is_deleted = 0
");

$data = mysqli_fetch_assoc($query_barang);

if (!$data) {
    exit("Data barang tidak ditemukan.");
}

if (isset($_POST['simpan'])) {

    $nama_barang = $_POST['nama_barang'];
    $kategory = $_POST['kategory'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    $query = mysqli_query($koneksi, "
        UPDATE barang
        SET
            nama_barang = '$nama_barang',
            kategory = '$kategory',
            stok = '$stok',
            satuan = '$satuan'
        WHERE id_barang = $id
        AND status = 1
        AND is_deleted = 0
    ");

    if ($query) {
        header("Location: barang.php");
        exit;
    } else {
        echo "Gagal mengubah data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="gudang.png">
    <title>Edit Barang - WMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="d-flex">

    <?php include 'navbar.php'; ?>

    <main class="flex-grow-1 p-4" style="background:#f5f1eb; min-height:100vh;">

        <div class="container-fluid">

            <h1 class="mb-4">Edit Barang</h1>

            <div class="card shadow">
                <div class="card-body">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang"
                                   class="form-control"
                                   value="<?= htmlspecialchars($data['nama_barang']); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategory</label>
                            <input type="text" name="kategory"
                                   class="form-control"
                                   value="<?= htmlspecialchars($data['kategory']); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok"
                                   class="form-control" min="0"
                                   value="<?= $data['stok']; ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="satuan"
                                   class="form-control"
                                   value="<?= htmlspecialchars($data['satuan']); ?>"
                                   required>
                        </div>

                        <button type="submit" name="simpan" class="btn btn-primary">
                            Simpan Perubahan
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
