<?php
require 'koneksi.php';
include 'Navbar.php';

// Query data dengan parameter yang aman
$q_kepala   = pg_query_params($conn, "SELECT * FROM profil_dosen WHERE LOWER(jabatan) LIKE LOWER($1) ORDER BY nama_dosen", array('%kepala%'));
$q_peneliti = pg_query_params($conn, "SELECT * FROM profil_dosen WHERE LOWER(jabatan) LIKE LOWER($1) ORDER BY nama_dosen", array('%tenaga%'));
$q_aslab    = pg_query($conn, "SELECT * FROM profil_mahasiswa WHERE id_kategori_mhs = 2 ORDER BY nama_lengkap");
$q_magang   = pg_query($conn, "SELECT * FROM profil_mahasiswa WHERE id_kategori_mhs = 1 ORDER BY nama_lengkap");

// Fungsi helper untuk menampilkan foto
function displayPhoto($photo, $default = 'img/avatar-default.png', $alt = 'Foto Profil') {
    if (!empty($photo) && file_exists($photo)) {
        return $photo;
    }
    return $default;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anggota Laboratorium - Politeknik Negeri Malang</title>
    <meta name="description" content="Halaman profil anggota laboratorium Politeknik Negeri Malang">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/StyleAnggota.css">
    <link rel="stylesheet" href="css/StyleBeranda.css">
    <link rel="stylesheet" href="css/StyleNavbar.css">
    <link rel="stylesheet" href="css/StyleFooter.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="img/logo/favicon.ico">
</head>
<body>

<!-- Hero Section -->
<div class="hero">
    <img src="img/logo/gedung-sipil.jpg" alt="Gedung Sipil Politeknik Negeri Malang" loading="lazy">
    <h1>ANGGOTA LABORATORIUM</h1>
</div>

<!-- Main Content -->
<main class="container">
    
    <!-- ===================== KEPALA LAB ===================== -->
    <section class="member-section">
        <h2>KEPALA LABORATORIUM</h2>
        <div class="research-grid" style="justify-content: center;">
            <?php if (pg_num_rows($q_kepala) > 0): ?>
                <?php while($d = pg_fetch_assoc($q_kepala)): ?>
                    <div class="research-card">
                        <div class="card-avatar">
                            <div class="card-avatar-circle">
                                <img src="<?= htmlspecialchars(displayPhoto($d['foto_profil'], 'img/avatar-default.png', $d['nama_dosen'])) ?>" 
                                     alt="Foto <?= htmlspecialchars($d['nama_dosen']) ?>"
                                     loading="lazy"
                                     onerror="this.src='img/avatar-default.png'">
                            </div>
                        </div>
                        <div class="card-label">Kepala Lab</div>
                        <div class="card-content">
                            <h4><?= htmlspecialchars($d['nama_dosen']) ?></h4>
                            <p><?= !empty($d['bidang_keahlian']) ? htmlspecialchars($d['bidang_keahlian']) : 'Bidang keahlian tidak tersedia' ?></p>
                            <a href="pages/profil-peneliti.php?id=<?= urlencode($d['id_profil_dosen']) ?>" 
                               aria-label="Lihat profil lengkap <?= htmlspecialchars($d['nama_dosen']) ?>">
                                <button class="card-button">Profil Lengkap</button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>Data kepala laboratorium sedang tidak tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ===================== PENELITI ===================== -->
    <section class="member-section">
        <h2>PENELITI</h2>
        <div class="research-grid">
            <?php if (pg_num_rows($q_peneliti) > 0): ?>
                <?php while($p = pg_fetch_assoc($q_peneliti)): ?>
                    <div class="research-card">
                        <div class="card-avatar">
                            <div class="card-avatar-circle">
                                <img src="<?= htmlspecialchars(displayPhoto($p['foto_profil'], 'img/avatar-default.png', $p['nama_dosen'])) ?>" 
                                     alt="Foto <?= htmlspecialchars($p['nama_dosen']) ?>"
                                     loading="lazy"
                                     onerror="this.src='img/avatar-default.png'">
                            </div>
                        </div>
                        <div class="card-label">Peneliti</div>
                        <div class="card-content">
                            <h4><?= htmlspecialchars($p['nama_dosen']) ?></h4>
                            <p><?= !empty($p['bidang_keahlian']) ? htmlspecialchars($p['bidang_keahlian']) : 'Bidang keahlian tidak tersedia' ?></p>
                            <a href="pages/profil-peneliti.php?id=<?= urlencode($p['id_profil_dosen']) ?>"
                               aria-label="Lihat profil lengkap <?= htmlspecialchars($p['nama_dosen']) ?>">
                                <button class="card-button">Profil Lengkap</button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>Data peneliti sedang tidak tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ===================== ASISTEN LAB ===================== -->
    <section class="member-section">
        <h2>ASISTEN LABORATORIUM</h2>
        <div class="research-grid">
            <?php if (pg_num_rows($q_aslab) > 0): ?>
                <?php while($a = pg_fetch_assoc($q_aslab)): ?>
                    <div class="research-card">
                        <div class="card-avatar">
                            <div class="card-avatar-circle">
                                <img src="<?= htmlspecialchars(displayPhoto($a['foto_3x4'], 'img/avatar-default.png', $a['nama_lengkap'])) ?>" 
                                     alt="Foto <?= htmlspecialchars($a['nama_lengkap']) ?>"
                                     loading="lazy"
                                     onerror="this.src='img/avatar-default.png'">
                            </div>
                        </div>
                        <div class="card-label">Asisten Lab</div>
                        <div class="card-content">
                            <h4><?= htmlspecialchars($a['nama_lengkap']) ?></h4>
                            <p><?= htmlspecialchars($a['program_studi']) ?> - Semester <?= htmlspecialchars($a['semester']) ?></p>
                            <a href="pages/profil.php?id=<?= urlencode($a['id_profil_mhs']) ?>"
                               aria-label="Lihat profil lengkap <?= htmlspecialchars($a['nama_lengkap']) ?>">
                                <button class="card-button">Profil Lengkap</button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>Data asisten laboratorium sedang tidak tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ===================== MAGANG ===================== -->
    <section class="member-section">
        <h2>MAHASISWA MAGANG</h2>
        <div class="research-grid">
            <?php if (pg_num_rows($q_magang) > 0): ?>
                <?php while($m = pg_fetch_assoc($q_magang)): ?>
                    <div class="research-card">
                        <div class="card-avatar">
                            <div class="card-avatar-circle">
                                <img src="<?= htmlspecialchars(displayPhoto($m['foto_3x4'], 'img/avatar-default.png', $m['nama_lengkap'])) ?>" 
                                     alt="Foto <?= htmlspecialchars($m['nama_lengkap']) ?>"
                                     loading="lazy"
                                     onerror="this.src='img/avatar-default.png'">
                            </div>
                        </div>
                        <div class="card-label">Mahasiswa Magang</div>
                        <div class="card-content">
                            <h4><?= htmlspecialchars($m['nama_lengkap']) ?></h4>
                            <p><?= htmlspecialchars($m['program_studi']) ?> - Semester <?= htmlspecialchars($m['semester']) ?></p>
                            <a href="pages/profil-magang.php?id=<?= urlencode($m['id_profil_mhs']) ?>"
                               aria-label="Lihat profil lengkap <?= htmlspecialchars($m['nama_lengkap']) ?>">
                                <button class="card-button">Profil Lengkap</button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>Data mahasiswa magang sedang tidak tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php 
// Tutup koneksi
pg_close($conn);
include 'footer.php'; 
?>

<!-- Optional: JavaScript untuk interaksi -->
<script>
// Fungsi untuk menangani error gambar
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'img/avatar-default.png';
        });
    });
    
    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>
</body>
</html>