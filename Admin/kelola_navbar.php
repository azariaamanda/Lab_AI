<?php
session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }

require_once '../koneksi.php';

// Ambil semua data navbar
$query = "SELECT * FROM navbar ORDER BY id_navbar ASC";
$result = pg_query($conn, $query);

$navbar_list = [];
if ($result && pg_num_rows($result) > 0) {
    $navbar_list = pg_fetch_all($result);
}

// Cek pesan dari operasi sebelumnya
$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Navbar - Dashboard Lab</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/styleDashboard.css">
    <link rel="stylesheet" href="css/tabel.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <main class="main-content">
        <div class="dashboard-content">
            <!-- Header -->
            <div class="page-header">
                <div class="header-left">
                    <h1 class="page-title">Kelola Navbar</h1>
                    <p class="page-subtitle">Manajemen menu navigasi utama website.</p>
                </div>
                <div class="header-right">
                    <a href="tambah_navbar.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Menu
                    </a>
                </div>
            </div>
            
            <!-- Pesan alert -->
            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <i class="fas fa-<?php echo ($message_type == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>
            
            <!-- Kontainer tabel -->
            <div class="table-container">
                <div class="table-header">
                    <div class="table-actions">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Cari menu...">
                        </div>
                    </div>
                </div>
                
                <!-- Tabel navbar -->
                <div class="table-responsive">
                    <table class="data-table" id="navbarTable">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Menu</th>
                                <th>URL</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($navbar_list)): ?>
                            <tr class="empty-state-row">
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-bars"></i>
                                    <p>Belum ada menu navbar</p>
                                    <a href="tambah_navbar.php" class="btn btn-primary btn-sm">Tambah Menu Pertama</a>
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php $no = 1; foreach ($navbar_list as $nav): ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($nav['nama_navbar'] ?? ''); ?></td>
                                <td><code><?php echo htmlspecialchars($nav['url_nav'] ?? ''); ?></code></td>
                                <td class="action-buttons">
                                    <a href="edit_navbar.php?id=<?php echo $nav['id_navbar']; ?>" class="btn btn-sm btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-delete" 
                                            data-id="<?php echo $nav['id_navbar']; ?>" 
                                            data-name="<?php echo htmlspecialchars($nav['nama_navbar'] ?? ''); ?>"
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
                
                <!-- Footer tabel -->
                <div class="table-footer">
                    <div class="table-info">
                        Total: <strong><?php echo count($navbar_list); ?></strong> menu
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-trash-alt"></i> Konfirmasi Hapus</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus menu <strong id="deleteItemName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline cancel-delete">Batal</button>
                <a href="#" class="btn btn-danger" id="confirmDelete">Ya, Hapus</a>
            </div>
        </div>
    </div>

    <script src="js/dashboardJS.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script untuk pencarian
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#navbarTable tbody tr');
                    rows.forEach(row => {
                        if (row.classList.contains('empty-state-row')) return;
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            }

            // Script untuk modal hapus
            const deleteModal = document.getElementById('deleteModal');
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    document.getElementById('deleteItemName').textContent = name;
                    document.getElementById('confirmDelete').href = `hapus_navbar.php?id=${id}`;
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