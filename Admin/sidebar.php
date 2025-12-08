<?php
// Ambil data user dari session
$user_name = $_SESSION['user_name'] ?? 'Admin Lab';
$user_role = $_SESSION['user_role'] ?? 'Administrator';
$user_avatar = $_SESSION['user_avatar'] ?? 'https://ui-avatars.com/api/?name=Admin+Lab&background=3182CE&color=fff&size=100';
$user_id = $_SESSION['user_id'] ?? 1;

require_once '../koneksi.php';
?>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="logo">
                <img src="../img/logo/logo putih.png" alt="Lab Dashboard Logo" class="logo-img">
            </a>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        
        <ul class="nav-menu">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-home nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            <!-- KONTEN WEBSITE SECTION -->
            <li class="section-header">
                <i class="fas fa-globe section-icon"></i>
                <span class="section-text">Konten Website</span>
            </li>
            
            <!-- Beranda -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-home nav-icon"></i>
                    <span class="nav-text">Beranda</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="kelola_navbar.php" class="nav-link"><span class="nav-text">Navbar</span></a></li>
                    <li class="nav-item"><a href="kelola_nav_banner.php" class="nav-link"><span class="nav-text">Nav Banner</span></a></li>
                    <li class="nav-item"><a href="kelola_footer.php" class="nav-link"><span class="nav-text">Footer</span></a></li>
                    <li class="nav-item"><a href="kelola_admin.php" class="nav-link"><span class="nav-text">Admin</span></a></li>
                </ul>
            </li>
            
            <!-- Profil Lab -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-building nav-icon"></i>
                    <span class="nav-text">Profil Lab</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="kelola_visi.php" class="nav-link"><span class="nav-text">Visi</span></a></li>
                    <li class="nav-item"><a href="kelola_misi.php" class="nav-link"><span class="nav-text">Misi</span></a></li>
                    <li class="nav-item"><a href="kelola_deskripsi.php" class="nav-link"><span class="nav-text">Deskripsi</span></a></li>
                    <li class="nav-item"><a href="kelola_fasilitas.php" class="nav-link"><span class="nav-text">Fasilitas</span></a></li>
                </ul>
            </li>
            
            <!-- Research Framework -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-flask nav-icon"></i>
                    <span class="nav-text">Research Framework</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Scope</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Research Topic</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Blueprint</span></a></li>
                </ul>
            </li>
            
            <!-- MANAJEMEN ANGGOTA SECTION -->
            <li class="section-header">
                <i class="fas fa-users section-icon"></i>
                <span class="section-text">Manajemen Anggota</span>
            </li>
            
            <!-- Dosen -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-chalkboard-teacher nav-icon"></i>
                    <span class="nav-text">Dosen</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Data Dosen</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Pendidikan</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Sertifikasi</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Publikasi</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Sosial Media</span></a></li>
                </ul>
            </li>
            
            <!-- Mahasiswa -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-graduate nav-icon"></i>
                    <span class="nav-text">Mahasiswa</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Profil Mahasiswa</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kategori Mahasiswa</span></a></li>
                </ul>
            </li>
            
            <!-- MITRA & PRODUK SECTION -->
            <li class="section-header">
                <i class="fas fa-microscope section-icon"></i>
                <span class="section-text">Mitra & Produk</span>
            </li>
            
            <!-- Mitra -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-handshake nav-icon"></i>
                    <span class="nav-text">Mitra</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kategori Mitra</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kelola Mitra</span></a></li>
                </ul>
            </li>
            
            <!-- Produk -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-box nav-icon"></i>
                    <span class="nav-text">Produk</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kelola Produk</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Video Produk</span></a></li>
                </ul>
            </li>
            
            <!-- PUBLIKASI SECTION -->
            <li class="section-header">
                <i class="fas fa-bullhorn section-icon"></i>
                <span class="section-text">Publikasi</span>
            </li>
            
            <!-- Berita -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-newspaper nav-icon"></i>
                    <span class="nav-text">Berita</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kategori Berita</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kelola Berita</span></a></li>
                </ul>
            </li>
            
            <!-- Agenda -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar nav-icon"></i>
                    <span class="nav-text">Agenda</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kategori Agenda</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kelola Agenda</span></a></li>
                </ul>
            </li>
            
            <!-- Pengumuman -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-bullhorn nav-icon"></i>
                    <span class="nav-text">Pengumuman</span>
                </a>
            </li>
            
            <!-- Galeri -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-images nav-icon"></i>
                    <span class="nav-text">Galeri</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Jenis Galeri</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kategori Galeri</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kelola Galeri</span></a></li>
                </ul>
            </li>
            
            <!-- LAYANAN SECTION -->
            <li class="section-header">
                <i class="fas fa-tools section-icon"></i>
                <span class="section-text">Layanan</span>
            </li>
            
            <!-- Layanan -->
            <li class="nav-item has-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-cogs nav-icon"></i>
                    <span class="nav-text">Layanan</span>
                </a>
                <ul class="submenu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Kelola Layanan</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Pendaftaran Asisten Lab</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Pendaftaran Magang</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">Peminjaman Fasilitas</span></a></li>
                </ul>
            </li>
        </ul>
    </aside>