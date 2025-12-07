<?php
// includes/header.php - Komponen header untuk dashboard
?>

<header class="top-header">
    <div class="header-left">
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Cari...">
        </div>
    </div>
    
    <div class="header-right">
        <button class="search-btn-mobile">
            <i class="fas fa-search"></i>
        </button>
        
        <button class="notification-btn" id="notificationBtn">
            <i class="fas fa-bell"></i>
        </button>
        
        <div class="user-profile" id="userProfile">
            <div class="user-info">
                <span class="user-name"><?php echo htmlspecialchars($user_name); ?></span>
                <span class="user-role"><?php echo htmlspecialchars($user_role); ?></span>
            </div>
            <img src="<?php echo htmlspecialchars($user_avatar); ?>" alt="Foto Profil" class="user-avatar">
        </div>
    </div>
    
    <!-- Dropdown Menu -->
    <div class="dropdown-menu" id="dropdownMenu">
        <a href="profil.php" class="dropdown-item">
            <i class="fas fa-user"></i>
            <span>Profil Saya</span>
        </a>
        <a href="pengaturan.php" class="dropdown-item">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </div>
    
    <!-- Notification Popup -->
    <div class="notification-popup" id="notificationPopup">
        <div class="notification-header">
            <span class="notification-title">Notifikasi</span>
            <button class="notification-clear">Tandai semua terbaca</button>
        </div>
        <div class="notification-list">
            <?php foreach ($notifications as $notif): ?>
            <div class="notification-item <?php echo $notif['sudah_dibaca'] ? '' : 'unread'; ?>">
                <div class="notification-icon <?php echo $notif['tipe']; ?>">
                    <i class="fas fa-<?php echo $notif['tipe']; ?>"></i>
                </div>
                <div class="notification-content">
                    <p class="notification-text"><?php echo htmlspecialchars($notif['pesan']); ?></p>
                    <span class="notification-time"><?php echo htmlspecialchars($notif['waktu']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</header>