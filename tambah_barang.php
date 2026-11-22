
<?php
include 'auth.php';
include 'koneksi.php';
adminOnly();

if (isset($_POST['simpan'])) {

    $nama_barang = $_POST['nama_barang'];
    $kategory = $_POST['kategory'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    $query = mysqli_query($koneksi, "
        INSERT INTO barang
        (nama_barang, kategory, stok, satuan)
        VALUES
        ('$nama_barang', '$kategory', '$stok', '$satuan')
    ");

    if ($query) {
        header("Location: barang.php");
        exit;
    } else {
        echo "Gagal menambahkan barang: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="gudang.png">
    <title>Tambah Barang - WMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="d-flex">

    <?php include 'navbar.php'; ?>

    <main class="flex-grow-1 p-4"  style="background:#f5f1eb; min-height:100vh;">

        <div class="container-fluid">

            <h1 class="mb-4">Tambah Barang</h1>

            <div class="card shadow">
                <div class="card-body">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategory</label>
                            <input type="text" name="kategory"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok"
                                   class="form-control" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="satuan"
                                   class="form-control" required>
                        </div>

                        <button type="submit" name="simpan" class="btn btn-success">
                            Simpan
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
