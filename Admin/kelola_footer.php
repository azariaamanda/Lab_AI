<?php
session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }

require_once '../koneksi.php';

// Inisialisasi variabel
$footer_data = [];
$message = '';
$message_type = '';

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_footer = 1; // Asumsi hanya ada 1 baris data footer
    $url_logo = $_POST['url_logo'] ?? '';
    $deskripsi = $_POST['deskripsi_footer'] ?? '';
    $jam_kerja = $_POST['jam_kerja'] ?? '';
    $email = $_POST['email'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $link_maps = $_POST['link_maps'] ?? '';

    $query_update = "UPDATE footer SET 
                        url_logo = $1, 
                        deskripsi_footer = $2, 
                        jam_kerja = $3, 
                        email = $4, 
                        alamat = $5, 
                        link_maps = $6
                    WHERE id_footer = $7";
    
    $params = [$url_logo, $deskripsi, $jam_kerja, $email, $alamat, $link_maps, $id_footer];
    $result_update = pg_query_params($conn, $query_update, $params);

    if ($result_update) {
        $_SESSION['message'] = 'Data footer berhasil diperbarui!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal memperbarui data footer: ' . pg_last_error($conn);
        $_SESSION['message_type'] = 'error';
    }

    // Redirect untuk mencegah resubmission form
    header('Location: kelola_footer.php');
    exit;
}

// Ambil data footer dari database
$query_select = "SELECT * FROM footer WHERE id_footer = 1 LIMIT 1";
$result_select = pg_query($conn, $query_select);
if ($result_select && pg_num_rows($result_select) > 0) {
    $footer_data = pg_fetch_assoc($result_select);
} else {
    // Data default jika tabel kosong
    $footer_data = [
        'url_logo' => 'img/logo/logo putih.png',
        'deskripsi_footer' => 'Deskripsi singkat laboratorium.',
        'jam_kerja' => "Senin – Jumat\n08.00 – 16.00 WIB",
        'email' => 'email@polinema.ac.id',
        'alamat' => "Alamat lengkap laboratorium.",
        'link_maps' => 'https://www.google.com/maps/embed?pb=...'
    ];
}

// Cek pesan dari session
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Footer - Dashboard Lab</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/styleDashboard.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <main class="main-content">
        <div class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Kelola Footer</h1>
                <p class="page-subtitle">Perbarui informasi yang ditampilkan di bagian footer website.</p>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <i class="fas fa-<?php echo ($message_type == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <div class="form-container">
                <form action="kelola_footer.php" method="POST" class="data-form" id="footerForm">
                    <div class="form-grid">
                        <!-- Kolom Kiri: Form Input -->
                        <div class="form-column">
                            <div class="form-card">
                                <div class="form-header">
                                    <h3><i class="fas fa-info-circle"></i> Informasi Umum</h3>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="url_logo" class="form-label required">URL Logo</label>
                                        <input type="text" id="url_logo" name="url_logo" class="form-control" value="<?php echo htmlspecialchars($footer_data['url_logo'] ?? ''); ?>" required>
                                        <div class="form-help">Contoh: ../img/logo/logo_putih.png</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_footer" class="form-label required">Deskripsi Footer</label>
                                        <textarea id="deskripsi_footer" name="deskripsi_footer" rows="3" class="form-control" required><?php echo htmlspecialchars($footer_data['deskripsi_footer'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-card">
                                <div class="form-header">
                                    <h3><i class="fas fa-address-book"></i> Informasi Kontak</h3>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="jam_kerja" class="form-label required">Jam Kerja</label>
                                        <textarea id="jam_kerja" name="jam_kerja" rows="2" class="form-control" required><?php echo htmlspecialchars($footer_data['jam_kerja'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label required">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($footer_data['email'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat" class="form-label required">Alamat</label>
                                        <textarea id="alamat" name="alamat" rows="3" class="form-control" required><?php echo htmlspecialchars($footer_data['alamat'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="link_maps" class="form-label required">Link Google Maps (Embed)</label>
                                        <textarea id="link_maps" name="link_maps" rows="4" class="form-control" required><?php echo htmlspecialchars($footer_data['link_maps'] ?? ''); ?></textarea>
                                        <div class="form-help">Salin kode dari Google Maps > Share > Embed a map.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Preview -->
                        <div class="form-column">
                            <div class="preview-card sticky-preview">
                                <div class="preview-header">
                                    <h4><i class="fas fa-eye"></i> Live Preview Footer</h4>
                                </div>
                                <div class="preview-body">
                                    <div class="footer-preview-container">
                                        <div class="preview-footer">
                                            <div class="preview-footer-top-border"></div>
                                            <div class="preview-footer-container">
                                                <div class="preview-footer-col preview-footer-logo">
                                                    <img src="<?php echo htmlspecialchars(str_replace('../', '', $footer_data['url_logo'] ?? '')); ?>" alt="Logo" id="previewLogo">
                                                    <p id="previewDeskripsi"><?php echo htmlspecialchars($footer_data['deskripsi_footer'] ?? ''); ?></p>
                                                </div>
                                                <div class="preview-footer-col">
                                                    <h4>MENU</h4>
                                                    <ul>
                                                        <li><a href="#">Beranda</a></li>
                                                        <li><a href="#">Produk</a></li>
                                                        <li><a href="#">Mitra</a></li>
                                                    </ul>
                                                </div>
                                                <div class="preview-footer-col">
                                                    <h4>LAYANAN</h4>
                                                    <ul>
                                                        <li><a href="#">Pendaftaran Asisten</a></li>
                                                        <li><a href="#">Peminjaman</a></li>
                                                    </ul>
                                                </div>
                                                <div class="preview-footer-col">
                                                    <h4>JAM KERJA</h4>
                                                    <ul id="previewJamKerja" style="white-space: pre-line;"><?php echo htmlspecialchars($footer_data['jam_kerja'] ?? ''); ?></ul>
                                                </div>
                                                <div class="preview-footer-right">
                                                    <div class="preview-footer-map" id="previewMapContainer">
                                                        <iframe src="<?php echo htmlspecialchars($footer_data['link_maps'] ?? ''); ?>" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    </div>
                                                    <p><img src="../img/footer/email.png"> <span id="previewEmail"><?php echo htmlspecialchars($footer_data['email'] ?? ''); ?></span></p>
                                                    <p><img src="../img/footer/maps.png"> <span id="previewAlamat"><?php echo nl2br(htmlspecialchars($footer_data['alamat'] ?? '')); ?></span></p>
                                                </div>
                                            </div>
                                            <div class="preview-footer-bottom-border"></div>
                                            <div class="preview-footer-bottom">
                                                Copyright © <?php echo date("Y"); ?> Lab Applied Informatics
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="js/dashboardJS.js"></script>
    <script src="js/form_footer.js"></script>
</body>
</html>