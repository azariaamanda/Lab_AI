<?php
session_start();
require_once '../koneksi.php';

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);

// Ambil data Visi
$query_visi = "SELECT * FROM profil_lab WHERE tipe_konten = 'Visi' LIMIT 1";
$result_visi = pg_query($conn, $query_visi);
$visi = pg_fetch_assoc($result_visi);

// Ambil data Misi
$query_misi = "SELECT * FROM profil_lab WHERE tipe_konten = 'Misi' ORDER BY id_profil ASC";
$result_misi = pg_query($conn, $query_misi);
$misi_list = pg_fetch_all($result_misi) ?: [];

// Ambil data Deskripsi
$query_deskripsi = "SELECT * FROM profil_lab WHERE tipe_konten = 'Deskripsi' LIMIT 1";
$result_deskripsi = pg_query($conn, $query_deskripsi);
$deskripsi = pg_fetch_assoc($result_deskripsi);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Profil Lab - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styleDashboard.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/tabel.css">
    <style>
        .form-section {
            margin-bottom: 40px;
        }
        .misi-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: #F7FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .misi-content {
            flex-grow: 1;
        }
        .misi-content strong {
            display: block;
            color: var(--text-dark);
        }
        .misi-content p {
            margin: 5px 0 0;
            color: var(--text-light);
            font-size: 0.9rem;
        }
        .misi-actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="main-content">
        <div class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Kelola Profil Laboratorium</h1>
                <p class="page-subtitle">Atur konten Visi, Misi, dan Deskripsi laboratorium.</p>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <i class="fas fa-<?php echo ($message_type == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <!-- VISI -->
            <div class="form-section">
                <div class="form-container">
                    <form action="proses_profil_lab.php" method="POST" class="data-form">
                        <input type="hidden" name="action" value="update_visi">
                        <input type="hidden" name="id_profil" value="<?php echo $visi['id_profil'] ?? ''; ?>">
                        <div class="form-card">
                            <div class="form-header">
                                <h3><i class="fas fa-eye"></i> Visi Laboratorium</h3>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="judul_visi" class="form-label">Judul Visi</label>
                                    <input type="text" id="judul_visi" name="judul" class="form-control" value="<?php echo htmlspecialchars($visi['judul'] ?? 'VISI LABORATORIUM'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="isi_visi" class="form-label required">Isi Visi</label>
                                    <textarea id="isi_visi" name="isi" rows="4" class="form-control" required><?php echo htmlspecialchars($visi['isi'] ?? ''); ?></textarea>
                                </div>
                                <div class="form-actions" style="border-top: none; padding-top: 15px;">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Visi</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MISI -->
            <div class="form-section">
                <div class="table-container">
                    <div class="page-header" style="border-bottom: none; margin-bottom: 15px; padding-bottom: 0;">
                        <div class="header-left">
                            <h3 style="margin:0;"><i class="fas fa-bullseye"></i> Misi Laboratorium</h3>
                        </div>
                        <div class="header-right">
                            <a href="tambah_misi.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Misi
                            </a>
                        </div>
                    </div>
                    <div class="misi-list">
                        <?php if (empty($misi_list)): ?>
                            <div class="empty-state" style="padding: 20px;">
                                <i class="fas fa-bullseye"></i>
                                <p>Belum ada data misi.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($misi_list as $misi): ?>
                            <div class="misi-item">
                                <div class="misi-content">
                                    <strong><?php echo htmlspecialchars($misi['judul']); ?></strong>
                                    <p><?php echo htmlspecialchars($misi['isi']); ?></p>
                                </div>
                                <div class="misi-actions">
                                    <a href="edit_misi.php?id=<?php echo $misi['id_profil']; ?>" class="btn btn-sm btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-delete" 
                                            data-id="<?php echo $misi['id_profil']; ?>" 
                                            data-name="<?php echo htmlspecialchars($misi['judul']); ?>"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div class="form-section">
                <div class="form-container">
                    <form action="proses_profil_lab.php" method="POST" class="data-form">
                        <input type="hidden" name="action" value="update_deskripsi">
                        <input type="hidden" name="id_profil" value="<?php echo $deskripsi['id_profil'] ?? ''; ?>">
                        <div class="form-card">
                            <div class="form-header">
                                <h3><i class="fas fa-align-left"></i> Deskripsi Laboratorium</h3>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="isi_deskripsi" class="form-label required">Isi Deskripsi</label>
                                    <textarea id="isi_deskripsi" name="isi" rows="6" class="form-control" required><?php echo htmlspecialchars($deskripsi['isi'] ?? ''); ?></textarea>
                                    <div class="form-help">Deskripsi ini akan muncul di halaman Beranda.</div>
                                </div>
                                <div class="form-actions" style="border-top: none; padding-top: 15px;">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Deskripsi</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-trash-alt"></i> Konfirmasi Hapus Misi</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus misi <strong id="deleteItemName"></strong>?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline cancel-delete">Batal</button>
                <form action="proses_profil_lab.php" method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="delete_misi">
                    <input type="hidden" name="id_profil" id="deleteItemId">
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
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
                    document.getElementById('deleteItemId').value = id;
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