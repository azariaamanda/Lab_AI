<?php
// Pastikan session dimulai untuk mengecek status login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user login (sesuaikan dengan variabel session di sistem login Anda)
// Contoh: $_SESSION['user_id'], $_SESSION['username'], dll.
$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['username']);

// Data dummy/default jika session belum ada
$avatar = $_SESSION['user_avatar'] ?? '';
$name = $_SESSION['nama_lengkap'] ?? $_SESSION['username'] ?? 'Pengunjung';
$role = $_SESSION['role'] ?? 'Guest';

// Jika avatar kosong, gunakan generator avatar dari UI Avatars
if (empty($avatar) || !file_exists($avatar)) {
    $avatar = "https://ui-avatars.com/api/?name=" . urlencode($name) . "&background=random&color=fff&size=128";
}
?>

<style>
    /* Container Widget */
    .profile-widget {
        position: relative;
        margin-left: 25px;
        display: flex;
        align-items: center;
        font-family: 'Montserrat', sans-serif;
        z-index: 1000;
    }

    /* Lingkaran Profil (Ring) */
    .profile-ring {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        padding: 2px; /* Ketebalan ring */
        background: linear-gradient(45deg, #FF8A00, #FFC107); /* Warna Ring Oranye */
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-ring:hover {
        transform: scale(1.05);
        box-shadow: 0 0 12px rgba(255, 138, 0, 0.6);
    }

    .profile-ring img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff; /* Pemisah putih antara ring dan foto */
        background-color: #fff;
    }

    /* Dropdown Menu */
    .profile-dropdown {
        position: absolute;
        top: 55px;
        right: 0;
        width: 220px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    /* Tampilkan dropdown saat hover */
    .profile-widget:hover .profile-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Header Dropdown */
    .dropdown-header {
        padding: 15px;
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    .dropdown-user-name {
        font-weight: 700;
        color: #0A2346;
        font-size: 14px;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dropdown-user-role {
        font-size: 11px;
        color: #FF8A00;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* List Menu */
    .dropdown-menu-list {
        list-style: none;
        padding: 5px 0;
        margin: 0;
    }

    .dropdown-menu-list li a {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        color: #333;
        text-decoration: none;
        font-size: 13px;
        transition: background 0.2s;
    }

    .dropdown-menu-list li a i {
        width: 20px;
        margin-right: 10px;
        color: #0A2346;
        text-align: center;
    }

    .dropdown-menu-list li a:hover {
        background-color: #f0f7ff;
        color: #FF8A00;
    }

    .dropdown-menu-list li a:hover i {
        color: #FF8A00;
    }

    /* Tombol Login (Jika belum login) */
    .btn-login-nav {
        background-color: #0A2346;
        color: #fff !important;
        padding: 8px 25px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        border: 2px solid #0A2346;
    }

    .btn-login-nav:hover {
        background-color: transparent;
        color: #0A2346 !important;
    }
</style>

<div class="profile-widget">
    <?php if ($isLoggedIn): ?>
        <!-- Tampilan SUDAH Login: Ring + Dropdown -->
        <div class="profile-ring">
            <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Profil">
        </div>
        
        <div class="profile-dropdown">
            <div class="dropdown-header">
                <div class="dropdown-user-name"><?php echo htmlspecialchars($name); ?></div>
                <div class="dropdown-user-role"><?php echo htmlspecialchars($role); ?></div>
            </div>
            <ul class="dropdown-menu-list">
                <!-- Menu untuk Admin -->
                <?php if(stripos($role, 'Admin') !== false): ?>
                    <li><a href="Admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <?php endif; ?>
                
                <!-- Menu Umum -->
                <li><a href="#"><i class="fas fa-user"></i> Profil Saya</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                
                <li style="border-top: 1px solid #eee;">
                    <a href="Admin/logout.php" style="color: #dc3545;">
                        <i class="fas fa-sign-out-alt" style="color: #dc3545;"></i> Keluar
                    </a>
                </li>
            </ul>
        </div>
    <?php else: ?>
        <!-- Tampilan BELUM Login: Tombol Login -->
        <a href="Admin/login.php" class="btn-login-nav">Login</a>
    <?php endif; ?>
</div>