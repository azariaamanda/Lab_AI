// dashboardJS.js - Combined Sidebar & Dashboard UI Interactions

document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard UI JS loaded');

    // ============ SIDEBAR TOGGLE ============
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    
    // Desktop sidebar toggle (collapse/expand)
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }
    
    // Mobile menu toggle
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('show');
        });
    }
    
    // ============ SUBMENU TOGGLE ============
    const hasSubmenuItems = document.querySelectorAll('.has-submenu > .nav-link');
    
    hasSubmenuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Jangan buka submenu jika sidebar dalam mode collapsed
            if (sidebar.classList.contains('collapsed')) {
                return;
            }
            
            const parent = this.parentElement;
            const submenu = this.nextElementSibling;
            
            // Toggle submenu
            if (submenu && submenu.classList.contains('submenu')) {
                const isCurrentlyOpen = parent.classList.contains('open');
                
                // Tutup SEMUA submenu (baik level utama maupun nested)
                const allSubmenuParents = document.querySelectorAll('.has-submenu');
                allSubmenuParents.forEach(menuItem => {
                    menuItem.classList.remove('open');
                    const menuSubmenu = menuItem.querySelector('.submenu');
                    if (menuSubmenu) {
                        menuSubmenu.classList.remove('show');
                    }
                });
                
                // Jika menu tidak sedang terbuka, buka menu yang diklik
                if (!isCurrentlyOpen) {
                    parent.classList.add('open');
                    submenu.classList.add('show');
                }
            }
        });
    });
    
    // ============ NESTED SUBMENU TOGGLE ============
    const allSubmenuLinks = document.querySelectorAll('.submenu .has-submenu > .nav-link');
    
    allSubmenuLinks.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (sidebar.classList.contains('collapsed')) {
                return;
            }
            
            const parent = this.parentElement;
            const submenu = this.nextElementSibling;
            
            if (submenu && submenu.classList.contains('submenu')) {
                const isCurrentlyOpen = parent.classList.contains('open');
                
                // Tutup semua nested submenu di parent yang sama
                const parentSubmenu = parent.closest('.submenu');
                if (parentSubmenu) {
                    const nestedItems = parentSubmenu.querySelectorAll('.has-submenu');
                    nestedItems.forEach(nestedItem => {
                        nestedItem.classList.remove('open');
                        const nestedSubmenu = nestedItem.querySelector('.submenu');
                        if (nestedSubmenu) {
                            nestedSubmenu.classList.remove('show');
                        }
                    });
                }
                
                // Buka yang diklik jika sebelumnya tertutup
                if (!isCurrentlyOpen) {
                    parent.classList.add('open');
                    submenu.classList.add('show');
                }
            }
        });
    });
    
    // ============ USER PROFILE DROPDOWN ============
    const userProfile = document.getElementById('userProfile');
    const dropdownMenu = document.getElementById('dropdownMenu');
    
    if (userProfile && dropdownMenu) {
        userProfile.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
            
            // Tutup notifikasi jika terbuka
            const notificationPopup = document.getElementById('notificationPopup');
            if (notificationPopup) {
                notificationPopup.classList.remove('show');
            }
        });
        
        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            if (!userProfile.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    }
    
    // ============ NOTIFICATION POPUP ============
    // const notificationBtn = document.getElementById('notificationBtn');
    // const notificationPopup = document.getElementById('notificationPopup');
    
    // if (notificationBtn && notificationPopup) {
    //     notificationBtn.addEventListener('click', function(e) {
    //         e.stopPropagation();
    //         notificationPopup.classList.toggle('show');
    //         
    //         // Tutup dropdown profil jika terbuka
    //         if (dropdownMenu) {
    //             dropdownMenu.classList.remove('show');
    //         }
    //     });
    //     
    //     // Tutup notifikasi saat klik di luar
    //     document.addEventListener('click', function(e) {
    //         if (!notificationBtn.contains(e.target) && !notificationPopup.contains(e.target)) {
    //             notificationPopup.classList.remove('show');
    //         }
    //     });
    // }
    
    // ============ CLOSE MOBILE SIDEBAR WHEN CLICKING OUTSIDE ============
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (sidebar && !sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
    
    // ============ CLOSE MOBILE SIDEBAR WHEN CLICKING A LINK ============
    const allNavLinks = document.querySelectorAll('.nav-link:not(.has-submenu > .nav-link)');
    allNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('show');
            }
        });
    });
    
    // ============ ACTIVE MENU HIGHLIGHT ============
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Hanya untuk link yang bukan parent submenu
            if (!this.parentElement.classList.contains('has-submenu')) {
                // Hapus active dari semua link
                navLinks.forEach(l => l.classList.remove('active'));
                // Tambahkan active ke link yang diklik
                this.classList.add('active');
            }
        });
    });
    
    // ============ SEARCH FUNCTIONALITY ============
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const searchValue = this.value.trim();
                if (searchValue) {
                    console.log(`Mencari: ${searchValue}`);
                    showToast(`Mencari: "${searchValue}"`, 'info');
                    this.value = '';
                    
                    // Tambahkan logika pencarian di sini
                    // window.location.href = `search.php?q=${encodeURIComponent(searchValue)}`;
                }
            }
        });
    }
    
    // ============ MOBILE SEARCH BUTTON ============
    const searchBtnMobile = document.querySelector('.search-btn-mobile');
    if (searchBtnMobile) {
        searchBtnMobile.addEventListener('click', function() {
            if (window.innerWidth <= 576) {
                const searchTerm = prompt('Masukkan kata kunci pencarian:');
                if (searchTerm) {
                    showToast(`Mencari: "${searchTerm}"`, 'info');
                    console.log('Searching for:', searchTerm);
                }
            }
        });
    }
    
    // ============ SMOOTH SCROLL FOR ANCHOR LINKS ============
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // ============ PREVENT SECTION HEADER CLICKS ============
    const sectionHeaders = document.querySelectorAll('.section-header');
    sectionHeaders.forEach(header => {
        header.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });
    
    // ============ QUICK ACTIONS INTERACTION ============
    const quickActionCards = document.querySelectorAll('.quick-action-card');
    quickActionCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            const title = this.querySelector('.quick-action-title').textContent;
            showToast(`Membuka: ${title}`, 'info');
            
            // Simulasi delay sebelum redirect
            setTimeout(() => {
                // Di production, uncomment ini:
                // window.location.href = this.getAttribute('href');
                console.log('Redirect to:', this.getAttribute('href'));
            }, 300);
        });
    });
    
    // ============ STATS CARDS INTERACTION ============
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('click', function() {
            const label = this.querySelector('.stat-label').textContent;
            const value = this.querySelector('.stat-value').textContent;
            
            let redirectUrl = '';
            let actionText = '';
            
            switch(label.toLowerCase()) {
                case 'dosen':
                    redirectUrl = 'dosen.php';
                    actionText = 'Lihat Daftar Dosen';
                    break;
                case 'asisten lab':
                    redirectUrl = 'asisten.php';
                    actionText = 'Kelola Asisten Lab';
                    break;
                case 'magang':
                    redirectUrl = 'magang.php';
                    actionText = 'Kelola Mahasiswa Magang';
                    break;
                case 'admin':
                    redirectUrl = 'admin.php';
                    actionText = 'Kelola Admin';
                    break;
                case 'fasilitas':
                    redirectUrl = 'fasilitas.php';
                    actionText = 'Lihat Fasilitas Lab';
                    break;
                case 'produk':
                    redirectUrl = 'produk.php';
                    actionText = 'Kelola Produk';
                    break;
                case 'mitra':
                    redirectUrl = 'mitra.php';
                    actionText = 'Lihat Mitra';
                    break;
                case 'galeri':
                    redirectUrl = 'galeri.php';
                    actionText = 'Buka Galeri';
                    break;
            }
            
            showToast(`${actionText}: ${value} data tersedia`, 'info');
            
            // Optional: Redirect setelah klik
            // setTimeout(() => {
            //     window.location.href = redirectUrl;
            // }, 1000);
        });
    });
    
    // ============ TOAST NOTIFICATION SYSTEM ============
    function showToast(message, type = 'success') {
        // Remove existing toast
        const existingToast = document.querySelector('.custom-toast');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Create new toast
        const toast = document.createElement('div');
        toast.className = `custom-toast toast-${type}`;
        
        const icon = type === 'success' ? 'fa-check-circle' : 
                    type === 'info' ? 'fa-info-circle' : 
                    'fa-exclamation-triangle';
        
        toast.innerHTML = `
            <i class="fas ${icon}"></i>
            <span>${message}</span>
            <button class="toast-close">&times;</button>
        `;
        
        // Add styles
        Object.assign(toast.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            background: '#FFFFFF',
            color: '#1A202C',
            padding: '15px 20px',
            borderRadius: '12px',
            boxShadow: '0 10px 30px rgba(0,0,0,0.15)',
            display: 'flex',
            alignItems: 'center',
            gap: '12px',
            zIndex: '9999',
            borderLeft: `4px solid ${type === 'success' ? '#38A169' : type === 'info' ? '#3182CE' : '#F56565'}`,
            animation: 'slideIn 0.3s ease-out',
            maxWidth: '350px',
            border: '1px solid #E2E8F0'
        });
        
        // Add keyframes if not exists
        if (!document.querySelector('#toast-keyframes')) {
            const style = document.createElement('style');
            style.id = 'toast-keyframes';
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
                .toast-close {
                    background: none;
                    border: none;
                    font-size: 20px;
                    color: #718096;
                    cursor: pointer;
                    padding: 0;
                    margin-left: auto;
                    transition: color 0.2s;
                }
                .toast-close:hover {
                    color: #2D3748;
                }
            `;
            document.head.appendChild(style);
        }
        
        // Add to body
        document.body.appendChild(toast);
        
        // Close button
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', function() {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        });
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    }
    
    // ============ WINDOW RESIZE HANDLER ============
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Reset sidebar pada desktop
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
            }
            
            // Reset collapsed state jika perlu
            if (window.innerWidth <= 768 && sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
            }
        }, 250);
    });
    
    // ============ INITIAL WELCOME TOAST ============
    setTimeout(() => {
        showToast('Selamat datang di Dashboard Laboratorium!', 'success');
    }, 1000);
    
    console.log('Sidebar & Dashboard JavaScript initialized successfully!');
});