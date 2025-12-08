// dashboardJS.js - Combined Sidebar & Dashboard UI Interactions

document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard UI JS loaded');

    // ============ SIDEBAR TOGGLE ============
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mainContent = document.querySelector('.main-content');
    
    // Fungsi untuk toggle sidebar dan simpan state
    const handleSidebarToggle = () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        
        const icon = toggleBtn.querySelector('i');
        const isCollapsed = sidebar.classList.contains('collapsed');
        
        // Simpan state ke localStorage
        localStorage.setItem('sidebarState', isCollapsed ? 'collapsed' : 'expanded');
        
        // Ubah ikon
        icon.className = isCollapsed ? 'fas fa-chevron-right' : 'fas fa-chevron-left';
    };

    // Cek dan terapkan state dari localStorage saat halaman dimuat
    if (localStorage.getItem('sidebarState') === 'collapsed') {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
        if (toggleBtn) {
            toggleBtn.querySelector('i').className = 'fas fa-chevron-right';
        }
    }

    // Event listener untuk tombol toggle
    if (toggleBtn) toggleBtn.addEventListener('click', handleSidebarToggle);
    
    // Mobile menu toggle
    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        sidebar.classList.toggle('show');
    });
    
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
            const isCurrentlyOpen = parent.classList.contains('open');


            // Buka atau tutup submenu yang diklik
            parent.classList.toggle('open', !isCurrentlyOpen);
            submenu.classList.toggle('show', !isCurrentlyOpen);

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
                
                // Buka atau tutup submenu yang diklik
                parent.classList.toggle('open', !isCurrentlyOpen);
                submenu.classList.toggle('show', !isCurrentlyOpen);
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
    const setActiveMenu = () => {
        const currentUrl = window.location.href.split('?')[0].split('#')[0];
        const allNavLinks = document.querySelectorAll('.sidebar .nav-link');

        allNavLinks.forEach(link => {
            link.classList.remove('active');
        });

        for (const link of allNavLinks) {
             const linkUrl = link.href.split('?')[0].split('#')[0];
             if (linkUrl === currentUrl) {
                link.classList.add('active');

                // Buka parent submenu dari link yang aktif
                let parent = link.closest('.has-submenu');
                while (parent) {
                    parent.classList.add('open');
                    const submenu = parent.querySelector('.submenu');
                    if (submenu) submenu.classList.add('show');
                    // Naik ke parent berikutnya jika ada nested submenu
                    parent = parent.parentElement.closest('.has-submenu');
                }
                break; // Hentikan loop setelah link aktif ditemukan
            }
        }
    };
    
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
    
    // Panggil fungsi untuk menandai menu aktif saat halaman dimuat
    setActiveMenu();

    console.log('Sidebar & Dashboard JavaScript initialized successfully!');
});
