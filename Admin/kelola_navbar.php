<?php
// session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }

require_once '../koneksi.php';

// Ambil data navbar
$query = "SELECT * FROM navbar ORDER BY id_navbar ASC";
$result = pg_query($conn, $query);

$navbar_items = array();
if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $navbar_items[] = $row;
    }
}

// Cek apakah ada pesan dari operasi sebelumnya
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : '';
unset($_SESSION['message']);
unset($_SESSION['message_type']);
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
    <!-- <link rel="stylesheet" href="../assets/css/styles.css"> -->
    <link rel="stylesheet" href="css/tabel.css">
    <link rel="stylesheet" href="css/styleDashboard.css">
</head>
<body>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>
    
    <main class="main-content">
        
        <div class="dashboard-content">
            <!-- Header dengan judul dan tombol tambah -->
            <div class="page-header">
                <div class="header-left">
                    <h1 class="page-title">Kelola Navbar</h1>
                    <p class="page-subtitle">Kelola menu navigasi website laboratorium</p>
                </div>
                <div class="header-right">
                    <a href="tambah_navbar.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Menu
                    </a>
                </div>
            </div>
            
            <!-- Pesan alert -->
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <i class="fas fa-<?php echo ($message_type == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo $message; ?>
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
                            <?php if (empty($navbar_items)): ?>
                            <tr class="empty-state-row">
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-bars"></i>
                                    <p>Belum ada menu navbar</p>
                                    <a href="tambah_navbar.php" class="btn btn-primary btn-sm">Tambah Menu Pertama</a>
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($navbar_items as $item): ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td>
                                    <div class="menu-info">
                                        <i class="fas fa-link menu-icon"></i>
                                        <span><?php echo htmlspecialchars($item['nama_navbar']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <code><?php echo htmlspecialchars($item['url_nav']); ?></code>
                                </td>
                                <td class="action-buttons">
                                    <a href="edit_navbar.php?id=<?php echo $item['id_navbar']; ?>" class="btn btn-sm btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-delete" 
                                            data-id="<?php echo $item['id_navbar']; ?>" 
                                            data-name="<?php echo htmlspecialchars($item['nama_navbar']); ?>"
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
                        Total: <strong><?php echo count($navbar_items); ?></strong> menu
                    </div>
                </div>
            </div>
            
            <!-- Info tambahan -->
            <div class="card info-card">
                <div class="card-header">
                    <h3><i class="fas fa-info-circle"></i> Panduan Navbar</h3>
                </div>
                <div class="card-body">
                    <ul class="guide-list">
                        <li><strong>Nama Menu</strong> akan ditampilkan di navbar website</li>
                        <li><strong>URL</strong> adalah alaman yang akan dituju ketika menu diklik</li>
                        <li>URL bisa relatif (contoh: index.php) atau absolut (contoh: https://example.com)</li>
                        <li>Menu akan ditampilkan sesuai urutan ID secara ascending</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-trash"></i> Konfirmasi Hapus</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus menu <strong id="deleteItemName"></strong>?</p>
                <p class="text-muted">Menu yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline cancel-delete">Batal</button>
                <a href="hapus_navbar.php" class="btn btn-danger" id="confirmDelete">Ya, Hapus</a>
            </div>
        </div>
    </div>
    <script src="js/dashboardJS.js"></script>
    
    <!-- JavaScript
    <script src="../assets/js/script.js"></script>
    <script>
        // Script khusus untuk halaman navbar
        document.addEventListener('DOMContentLoaded', function() {
            // Pencarian
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#navbarTable tbody tr:not(.empty-state-row)');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    
                    // Update count
                    updateTableCount();
                });
            }
            
            // Update table count
            function updateTableCount() {
                const visibleRows = document.querySelectorAll('#navbarTable tbody tr:not(.empty-state-row)[style!="display: none;"]');
                const count = visibleRows.length;
                const tableInfo = document.querySelector('.table-info');
                if (tableInfo) {
                    tableInfo.innerHTML = `Total: <strong>${count}</strong> menu`;
                }
            }
            
            // Delete modal
            const deleteModal = document.getElementById('deleteModal');
            const deleteButtons = document.querySelectorAll('.btn-delete');
            const deleteItemName = document.getElementById('deleteItemName');
            const confirmDelete = document.getElementById('confirmDelete');
            const cancelDelete = document.querySelector('.cancel-delete');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    
                    deleteItemName.textContent = name;
                    confirmDelete.href = `navbar_hapus.php?id=${id}`;
                    deleteModal.style.display = 'flex';
                });
            });
            
            // Close modal
            const modalClose = deleteModal.querySelector('.modal-close');
            modalClose.addEventListener('click', function() {
                deleteModal.style.display = 'none';
            });
            
            cancelDelete.addEventListener('click', function() {
                deleteModal.style.display = 'none';
            });
            
            // Close modal when clicking outside
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    deleteModal.style.display = 'none';
                }
            });
        });
    </script> -->
</body>
</html>