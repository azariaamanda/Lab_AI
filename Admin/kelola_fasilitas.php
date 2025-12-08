<?php
session_start();
require_once '../koneksi.php';

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);

// Ambil data fasilitas
$query = "SELECT * FROM fasilitas ORDER BY id_fasilitas ASC";
$result = pg_query($conn, $query);
$fasilitas_list = pg_fetch_all($result) ?: [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Fasilitas - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styleDashboard.css">
    <link rel="stylesheet" href="css/tabel.css">
    <style>
        .fasilitas-img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="dashboard-content">
            <?php include 'header.php'; ?>
            <div class="page-header">
                <div class="header-left">
                    <h1 class="page-title">Kelola Fasilitas</h1>
                    <p class="page-subtitle">Manajemen daftar fasilitas laboratorium.</p>
                </div>
                <div class="header-right">
                    <a href="tambah_fasilitas.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Fasilitas
                    </a>
                </div>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <i class="fas fa-<?php echo ($message_type == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Gambar</th>
                                <th>Nama Fasilitas</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($fasilitas_list)): ?>
                                <tr class="empty-state-row">
                                    <td colspan="4" class="empty-state">
                                        <i class="fas fa-couch"></i>
                                        <p>Belum ada data fasilitas.</p>
                                        <a href="tambah_fasilitas.php" class="btn btn-primary btn-sm">Tambah Fasilitas Pertama</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($fasilitas_list as $fasilitas): ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td>
                                        <img src="../img/fasilitas/<?php echo htmlspecialchars($fasilitas['gambar_fasilitas']); ?>" alt="<?php echo htmlspecialchars($fasilitas['nama_fasilitas']); ?>" class="fasilitas-img" onerror="this.src='../img/default-placeholder.png'">
                                    </td>
                                    <td><?php echo htmlspecialchars($fasilitas['nama_fasilitas']); ?></td>
                                    <td class="action-buttons">
                                        <a href="edit_fasilitas.php?id=<?php echo $fasilitas['id_fasilitas']; ?>" class="btn btn-sm btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button class="btn btn-sm btn-delete" 
                                                data-id="<?php echo $fasilitas['id_fasilitas']; ?>" 
                                                data-name="<?php echo htmlspecialchars($fasilitas['nama_fasilitas']); ?>"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-trash-alt"></i> Konfirmasi Hapus Fasilitas</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus fasilitas <strong id="deleteItemName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline cancel-delete">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Ya, Hapus</a>
            </div>
        </div>
    </div>

    <script src="js/dashboardJS.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            if (!deleteModal) return;

            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    document.getElementById('deleteItemName').textContent = name;
                    document.getElementById('confirmDelete').href = `hapus_fasilitas.php?id=${id}`;
                    deleteModal.style.display = 'flex';
                });
            });

            const closeModal = () => deleteModal.style.display = 'none';
            deleteModal.querySelector('.modal-close').addEventListener('click', closeModal);
            deleteModal.querySelector('.cancel-delete').addEventListener('click', closeModal);
            deleteModal.addEventListener('click', (e) => {
                if (e.target === deleteModal) closeModal();
            });
        });
    </script>
</body>
</html>