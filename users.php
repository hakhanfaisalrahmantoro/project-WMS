
<?php
include 'auth.php';
include 'koneksi.php';

adminOnly();

$query = mysqli_query($koneksi, "
    SELECT id_user, nama, username, role, status
    FROM users
    WHERE is_deleted = 0
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manajemen User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="d-flex">

    <?php include 'navbar.php'; ?>

    <main class="flex-grow-1 p-4" style="background:#f5f1eb; min-height:100vh;">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold">Manajemen User</h3>
                <p class="text-muted">Kelola akun pengguna warehouse.</p>
            </div>

            <a href="tambah_user.php" class="btn text-white"
               style="background:#75472b;">
                <i class="bi bi-person-plus"></i>
                Tambah User
            </a>

        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
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

                                <td>
                                    <?= htmlspecialchars($data['nama']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['username']); ?>
                                </td>

                                <td>
                                    <?php if ($data['role'] == 'admin') { ?>
                                        <span class="badge bg-dark">Admin</span>
                                    <?php } else { ?>
                                        <span class="badge bg-primary">User</span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php if ($data['status'] == 1) { ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php } else { ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <a href="edit_user.php?id=<?= $data['id_user']; ?>"
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <a href="hapus_user.php?id=<?= $data['id_user']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Nonaktifkan akun ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>

                            </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>
