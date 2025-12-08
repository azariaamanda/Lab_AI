<?php
session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }

require_once '../koneksi.php';

// Ambil semua data nav banner
$query = "SELECT id_navbanner, nama, url_navbanner, icon_navbanner FROM vw_nav_banner ORDER BY id_navbanner ASC";
$result = pg_query($conn, $query);

$banner_list = [];
if ($result && pg_num_rows($result) > 0) {
    $banner_list = pg_fetch_all($result);
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
    <title>Kelola Nav Banner - Dashboard Lab</title>
    
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
                    <h1 class="page-title">Kelola Nav Banner</h1>
                    <p class="page-subtitle">Manajemen ikon navigasi di bawah banner utama.</p>
                </div>
                <div class="header-right">
                    <a href="tambah_nav_banner.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Item
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
                            <input type="text" id="searchInput" placeholder="Cari item...">
                        </div>
                    </div>
                </div>
                
                <!-- Tabel nav banner -->
                <div class="table-responsive">
                    <table class="data-table" id="bannerTable">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Ikon & Nama</th>
                                <th>URL Tujuan</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($banner_list)): ?>
                            <tr class="empty-state-row">
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-stream"></i>
                                    <p>Belum ada data nav banner</p>
                                    <a href="tambah_nav_banner.php" class="btn btn-primary btn-sm">Tambah Item Pertama</a>
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php $no = 1; foreach ($banner_list as $banner): ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td>
                                    <div class="user-profile-cell">
                                        <img src="../<?php echo htmlspecialchars($banner['icon_navbanner']); ?>" alt="Ikon" class="avatar-square">
                                        <span class="user-name-cell"><?php echo htmlspecialchars($banner['nama']); ?></span>
                                    </div>
                                </td>
                                <td><code><?php echo htmlspecialchars($banner['url_navbanner']); ?></code></td>
                                <td class="action-buttons">
                                    <a href="edit_nav_banner.php?id=<?php echo $banner['id_navbanner']; ?>" class="btn btn-sm btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-delete" 
                                            data-id="<?php echo $banner['id_navbanner']; ?>" 
                                            data-name="<?php echo htmlspecialchars($banner['nama']); ?>"
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
                        Total: <strong><?php echo count($banner_list); ?></strong> item
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Modal Konfirmasi Hapus (dapat ditambahkan di sini) -->
    <!-- ... -->

    <script src="js/dashboardJS.js"></script>
    <script>
        // Script pencarian dan modal bisa ditambahkan di sini, mirip dengan kelola_admin.php
    </script>
    <style>
        .avatar-square {
            width: 40px;
            height: 40px;
            object-fit: contain;
            border-radius: 4px;
            background-color: #f0f4f8;
            padding: 4px;
        }
    </style>
</body>
</html>