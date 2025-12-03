<!-- Sidebar Component -->
<div class="sidebar">
    <div class="sidebar-header">
        <h2>LAB APPLIED INFORMATICS</h2>
    </div>
    <ul class="sidebar-menu">
        <!-- Dashboard -->
        <li>
            <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>

        <!-- Konten & Informasi -->
        <li class="dropdown">
            <a class="dropdown-toggle">
                <span>
                    <i class="fas fa-newspaper"></i>
                    Konten & Informasi
                </span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="kelola_berita.php">Kelola Berita</a></li>
                <li><a href="kelola_kategori_berita.php">Kategori Berita</a></li>
                <li><a href="kelola_pengumuman.php">Kelola Pengumuman</a></li>
                <li><a href="kelola_agenda.php">Kelola Agenda</a></li>
                <li><a href="kelola_kategori_agenda.php">Kategori Agenda</a></li>
                <li><a href="kelola_galeri.php">Kelola Galeri</a></li>
                <li><a href="kelola_kategori_galeri.php">Kategori Galeri</a></li>
                <li><a href="kelola_jenis_galeri.php">Jenis Galeri</a></li>
            </ul>
        </li>

        <!-- Profil Laboratorium -->
        <li class="dropdown">
            <a class="dropdown-toggle">
                <span>
                    <i class="fas fa-flask"></i>
                    Profil Laboratorium
                </span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="kelola_profil_lab.php">Profil Lab</a></li>
                <li><a href="kelola_research_framework.php">Research Framework</a></li>
                <li><a href="kelola_fasilitas.php">Kelola Fasilitas</a></li>
            </ul>
        </li>

        <!-- Anggota -->
        <li class="dropdown">
            <a class="dropdown-toggle">
                <span>
                    <i class="fas fa-users"></i>
                    Anggota
                </span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="kelola_dosen.php">Profil Dosen</a></li>
                <li><a href="kelola_posisi_dosen.php">Posisi Dosen</a></li>
                <li><a href="kelola_mahasiswa.php">Profil Mahasiswa</a></li>
                <li><a href="kelola_kategori_mahasiswa.php">Kategori Mahasiswa</a></li>
            </ul>
        </li>

        <!-- Mitra & Produk -->
        <li class="dropdown">
            <a class="dropdown-toggle">
                <span>
                    <i class="fas fa-handshake"></i>
                    Mitra & Produk
                </span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="kelola_mitra.php">Kelola Mitra</a></li>
                <li><a href="kelola_kategori_mitra.php">Kategori Mitra</a></li>
                <li><a href="kelola_produk.php">Kelola Produk</a></li>
                <li><a href="kelola_video_produk.php">Video Produk</a></li>
            </ul>
        </li>

        <!-- Layanan & Pendaftaran -->
        <li class="dropdown">
            <a class="dropdown-toggle">
                <span>
                    <i class="fas fa-clipboard-list"></i>
                    Layanan & Pendaftaran
                </span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="kelola_layanan.php">Kelola Layanan</a></li>
                <li><a href="kelola_pendaftaran.php">Pendaftaran</a></li>
                <li><a href="kelola_peminjaman.php">Peminjaman Fasilitas</a></li>
            </ul>
        </li>

        <!-- Pengaturan Website -->
        <li class="dropdown">
            <a class="dropdown-toggle">
                <span>
                    <i class="fas fa-cog"></i>
                    Pengaturan Website
                </span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="kelola_navbar.php">Kelola Navbar</a></li>
                <li><a href="kelola_nav_banner.php">Nav Banner</a></li>
                <li><a href="kelola_footer.php">Kelola Footer</a></li>
            </ul>
        </li>

        <!-- Logout -->
        <li>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </li>
    </ul>
</div>

<script>
    // Dropdown toggle functionality - HANYA JALAN 1X
    (function() {
        // Cek apakah sudah di-initialize
        if (window.sidebarInitialized) return;
        window.sidebarInitialized = true;

        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const dropdown = this.parentElement;
                const isActive = dropdown.classList.contains('active');
                
                // Close all dropdowns
                document.querySelectorAll('.dropdown').forEach(d => {
                    d.classList.remove('active');
                });
                
                // Toggle current dropdown
                if (!isActive) {
                    dropdown.classList.add('active');
                }
            });
        });

        // Auto-expand dropdown and set active link based on current page
        const currentPath = window.location.pathname.split('/').pop();
        
        // Check submenu items
        document.querySelectorAll('.dropdown-menu a').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
                link.closest('.dropdown').classList.add('active');
            }
        });
        
        // Check main menu items
        document.querySelectorAll('.sidebar-menu > li > a:not(.dropdown-toggle)').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    })();
</script>