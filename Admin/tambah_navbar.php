<?php
// session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }

require_once '../koneksi.php';

$message = '';
$message_type = '';

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
            // Panggil stored procedure
            $query = "CALL sp_insert_navbar('$nama_navbar', '$url_nav')";
            $result = pg_query($conn, $query);
            
            if ($result) {
                $_SESSION['message'] = 'Menu navbar berhasil ditambahkan';
                $_SESSION['message_type'] = 'success';
                header('Location: kelola_navbar.php');
                exit;
            } else {
                $message = 'Gagal menambahkan menu: ' . pg_last_error($conn);
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
    <title>Tambah Menu Navbar - Dashboard Lab</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <!-- <link rel="stylesheet" href="../assets/css/styles.css"> -->
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/styleDashboard.css">
</head>
<body>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>
    
    <main class="main-content">
        
        <div class="dashboard-content">
            <!-- Header dengan judul -->
            <div class="page-header">
                <div class="header-left">
                    <h1 class="page-title">Tambah Menu Navbar</h1>
                    <p class="page-subtitle">Tambahkan menu baru ke navigasi website</p>
                </div>
                <div class="header-right">
                    <a href="kelola_navbar.php" class="btn btn-outline">
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
            
            <!-- Form tambah navbar -->
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
                                       placeholder="Contoh: Beranda, Profil, Kontak"
                                       value="<?php echo isset($_POST['nama_navbar']) ? htmlspecialchars($_POST['nama_navbar']) : ''; ?>"
                                       required>
                                <div class="form-help">Nama yang akan ditampilkan di navbar</div>
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
                                       placeholder="Contoh: index.php, profil.php, atau http://..."
                                       value="<?php echo isset($_POST['url_nav']) ? htmlspecialchars($_POST['url_nav']) : ''; ?>"
                                       required>
                                <div class="form-help">
                                    URL relatif (contoh: index.php) atau absolut (contoh: https://example.com)
                                </div>
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
                                    <span id="previewText" class="preview-text">Beranda</span>
                                </div>
                            </div>
                            <div class="preview-details">
                                <div class="preview-detail">
                                    <span class="detail-label">URL:</span>
                                    <span id="previewUrl" class="detail-value">index.php</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form actions -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" id="resetBtn">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Menu
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Contoh URL -->
            <div class="card examples-card">
                <div class="card-header">
                    <h3><i class="fas fa-lightbulb"></i> Contoh URL</h3>
                </div>
                <div class="card-body">
                    <div class="icon-examples">
                        <div class="icon-example">
                            <i class="fas fa-home"></i>
                            <div>
                                <strong>Beranda</strong>
                                <div class="url-example">index.php</div>
                            </div>
                        </div>
                        <div class="icon-example">
                            <i class="fas fa-info-circle"></i>
                            <div>
                                <strong>Tentang Kami</strong>
                                <div class="url-example">about.php</div>
                            </div>
                        </div>
                        <div class="icon-example">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Kontak</strong>
                                <div class="url-example">contact.php</div>
                            </div>
                        </div>
                        <div class="icon-example">
                            <i class="fas fa-external-link-alt"></i>
                            <div>
                                <strong>Link Eksternal</strong>
                                <div class="url-example">https://example.com</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/dashboardJS.js"></script>
    <!-- JavaScript -->
    <!-- <script src="../assets/js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview
            const namaNavbarInput = document.getElementById('nama_navbar');
            const urlNavInput = document.getElementById('url_nav');
            const previewText = document.getElementById('previewText');
            const previewUrl = document.getElementById('previewUrl');
            
            namaNavbarInput.addEventListener('input', function() {
                previewText.textContent = this.value || 'Beranda';
            });
            
            urlNavInput.addEventListener('input', function() {
                previewUrl.textContent = this.value || 'index.php';
            });
            
            // Reset form
            const resetBtn = document.getElementById('resetBtn');
            const navbarForm = document.getElementById('navbarForm');
            
            resetBtn.addEventListener('click', function() {
                if (confirm('Reset semua input? Data yang sudah diisi akan hilang.')) {
                    navbarForm.reset();
                    previewText.textContent = 'Beranda';
                    previewUrl.textContent = 'index.php';
                }
            });
            
            // Form validation
            navbarForm.addEventListener('submit', function(e) {
                const namaNavbar = namaNavbarInput.value.trim();
                const urlNav = urlNavInput.value.trim();
                
                if (!namaNavbar) {
                    e.preventDefault();
                    alert('Nama menu harus diisi');
                    namaNavbarInput.focus();
                    return false;
                }
                
                if (!urlNav) {
                    e.preventDefault();
                    alert('URL harus diisi');
                    urlNavInput.focus();
                    return false;
                }
                
                return true;
            });
        });
    </script> -->
    
    <style>
        .url-example {
            font-size: 0.85rem;
            color: #718096;
            margin-top: 2px;
            font-family: monospace;
        }
        
        .icon-example {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: #F7FAFC;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            transition: all 0.3s;
        }
        
        .icon-example:hover {
            background-color: #E2E8F0;
            transform: translateY(-2px);
        }
        
        .icon-example i {
            font-size: 1.5rem;
            color: #3182CE;
            width: 30px;
            text-align: center;
        }
        
        .icon-example strong {
            display: block;
            margin-bottom: 5px;
            color: #2D3748;
        }
    </style>
</body>
</html>