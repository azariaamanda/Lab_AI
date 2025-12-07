<?php
// navbar_edit.php - Form edit navbar
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';
$message_type = '';

// Ambil data navbar berdasarkan ID
$navbar = null;
if ($id > 0) {
    $query = "SELECT * FROM navbar WHERE id_navbar = $id";
    $result = pg_query($conn, $query);
    if ($result && pg_num_rows($result) > 0) {
        $navbar = pg_fetch_assoc($result);
    } else {
        $_SESSION['message'] = 'Menu navbar tidak ditemukan';
        $_SESSION['message_type'] = 'error';
        header('Location: navbar.php');
        exit;
    }
} else {
    $_SESSION['message'] = 'ID menu tidak valid';
    $_SESSION['message_type'] = 'error';
    header('Location: navbar.php');
    exit;
}

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_navbar = pg_escape_string($conn, $_POST['nama_navbar']);
    $url_nav = pg_escape_string($conn, $_POST['url_nav']);
    
    // Validasi
    if (empty($nama_navbar) || empty($url_nav)) {
        $message = 'Nama menu dan URL harus diisi';
        $message_type = 'error';
    } else {
        try {
            // Panggil stored procedure update
            $query = "CALL sp_update_navbar($id, '$nama_navbar', '$url_nav')";
            $result = pg_query($conn, $query);
            
            if ($result) {
                $_SESSION['message'] = 'Menu navbar berhasil diperbarui';
                $_SESSION['message_type'] = 'success';
                header('Location: navbar.php');
                exit;
            } else {
                $message = 'Gagal memperbarui menu: ' . pg_last_error($conn);
                $message_type = 'error';
            }
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Navbar - Dashboard Lab</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/form.css">
</head>
<body>
    <!-- Include Sidebar -->
    <?php include '../includes/sidebar.php'; ?>
    
    <main class="main-content">
        <!-- Include Header -->
        <?php include '../includes/header.php'; ?>
        
        <div class="dashboard-content">
            <!-- Header dengan judul -->
            <div class="page-header">
                <div class="header-left">
                    <h1 class="page-title">Edit Menu Navbar</h1>
                    <p class="page-subtitle">Edit menu: <?php echo htmlspecialchars($navbar['nama_navbar']); ?></p>
                </div>
                <div class="header-right">
                    <a href="navbar.php" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            
            <!-- Pesan error/success -->
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <i class="fas fa-<?php echo ($message_type == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo $message; ?>
            </div>
            <?php endif; ?>
            
            <!-- Info menu -->
            <div class="info-banner">
                <div class="info-content">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <h4>ID Menu: #<?php echo $navbar['id_navbar']; ?></h4>
                        <small>Edit menu navigasi website</small>
                    </div>
                </div>
            </div>
            
            <!-- Form edit navbar -->
            <div class="form-container">
                <form method="POST" id="navbarForm">
                    <div class="form-grid">
                        <!-- Kolom kiri -->
                        <div class="form-column">
                            <div class="form-group">
                                <label for="nama_navbar" class="form-label required">
                                    <i class="fas fa-header"></i> Nama Menu
                                </label>
                                <input type="text" 
                                       id="nama_navbar" 
                                       name="nama_navbar" 
                                       class="form-control" 
                                       value="<?php echo isset($_POST['nama_navbar']) ? htmlspecialchars($_POST['nama_navbar']) : htmlspecialchars($navbar['nama_navbar']); ?>"
                                       required>
                            </div>
                        </div>
                        
                        <!-- Kolom kanan -->
                        <div class="form-column">
                            <div class="form-group">
                                <label for="url_nav" class="form-label required">
                                    <i class="fas fa-link"></i> URL / Link
                                </label>
                                <input type="text" 
                                       id="url_nav" 
                                       name="url_nav" 
                                       class="form-control" 
                                       value="<?php echo isset($_POST['url_nav']) ? htmlspecialchars($_POST['url_nav']) : htmlspecialchars($navbar['url_nav']); ?>"
                                       required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview Card -->
                    <div class="preview-card">
                        <div class="preview-header">
                            <h4><i class="fas fa-eye"></i> Preview Menu</h4>
                        </div>
                        <div class="preview-body">
                            <div class="navbar-preview">
                                <div class="preview-menu-item">
                                    <i class="fas fa-link"></i>
                                    <span id="previewText" class="preview-text"><?php echo htmlspecialchars($navbar['nama_navbar']); ?></span>
                                </div>
                            </div>
                            <div class="preview-details">
                                <div class="preview-detail">
                                    <span class="detail-label">URL:</span>
                                    <span id="previewUrl" class="detail-value"><?php echo htmlspecialchars($navbar['url_nav']); ?></span>
                                </div>
                                <div class="preview-detail">
                                    <span class="detail-label">ID:</span>
                                    <span class="detail-value">#<?php echo $navbar['id_navbar']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form actions -->
                    <div class="form-actions">
                        <a href="navbar.php" class="btn btn-outline">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
    <!-- JavaScript
    <script src="../assets/js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview
            const namaNavbarInput = document.getElementById('nama_navbar');
            const urlNavInput = document.getElementById('url_nav');
            const previewText = document.getElementById('previewText');
            const previewUrl = document.getElementById('previewUrl');
            
            namaNavbarInput.addEventListener('input', function() {
                previewText.textContent = this.value;
            });
            
            urlNavInput.addEventListener('input', function() {
                previewUrl.textContent = this.value;
            });
        });
    </script> -->
</body>
</html>