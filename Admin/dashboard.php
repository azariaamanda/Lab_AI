<?php
// ============ SESSION & CONNECTION ============
// session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }
require_once '../koneksi.php';

// ============ STATISTIK DASHBOARD ============
$query_stats = "SELECT * FROM get_dashboard_statistics()";
$result_stats = pg_query($conn, $query_stats);
if (!$result_stats) {
    die("Query statistik gagal: " . pg_last_error($conn));
}
$stats = pg_fetch_assoc($result_stats);

// Jika tidak ada data, set default
if (!$stats) {
    $stats = array(
        'jumlah_dosen' => 0,
        'jumlah_asisten_lab' => 0,
        'jumlah_magang' => 0,
        'jumlah_admin' => 0,
        'jumlah_fasilitas' => 0,
        'jumlah_produk' => 0,
        'jumlah_mitra' => 0,
        'jumlah_galeri' => 0
    );
}

// ============ AGENDA TERBARU ============
$query_agenda = "
    SELECT id_agenda, tanggal_agenda, judul_agenda, jam_mulai, jam_selesai 
    FROM agenda 
    WHERE tanggal_agenda >= CURRENT_DATE 
    ORDER BY tanggal_agenda, jam_mulai 
    LIMIT 4
";
$result_agenda = pg_query($conn, $query_agenda);
$agenda_items = array();
if ($result_agenda) {
    while ($row = pg_fetch_assoc($result_agenda)) {
        $agenda_items[] = $row;
    }
}

$formatted_agenda = array();
foreach ($agenda_items as $agenda) {
    $date = strtotime($agenda['tanggal_agenda']);
    $formatted_agenda[] = array(
        'id' => $agenda['id_agenda'],
        'day' => date('d', $date),
        'month' => date('M', $date),
        'title' => $agenda['judul_agenda'],
        'time' => substr($agenda['jam_mulai'], 0, 5) . ' - ' . substr($agenda['jam_selesai'], 0, 5),
        'full_date' => $agenda['tanggal_agenda'],
        'start_time' => $agenda['jam_mulai'],
        'end_time' => $agenda['jam_selesai']
    );
}

// ============ NOTIFIKASI ============
// $query_notif = "
//     SELECT id, tipe, pesan, waktu, sudah_dibaca 
//     FROM notifikasi 
//     WHERE user_id = $user_id OR user_id IS NULL 
//     ORDER BY waktu DESC 
//     LIMIT 5
// ";
// $result_notif = pg_query($conn, $query_notif);
// $notifications = array();
// if ($result_notif) {
//     while ($row = pg_fetch_assoc($result_notif)) {
//         $notifications[] = $row;
//     }
// }

// ============ DATA UNTUK PIE CHART ============
$query_pie = "
    SELECT kategori, COUNT(*) as jumlah 
    FROM (
        SELECT 'Dosen' as kategori FROM profil_dosen
        UNION ALL
        SELECT 'Asisten Lab' FROM profil_mahasiswa pm 
        JOIN kategori_mahasiswa km ON pm.id_kategori_mhs = km.id_kategori_mhs 
        WHERE km.nama_kategori_mhs = 'Asisten Laboratorium'
        UNION ALL
        SELECT 'Mahasiswa Magang' FROM profil_mahasiswa pm 
        JOIN kategori_mahasiswa km ON pm.id_kategori_mhs = km.id_kategori_mhs 
        WHERE km.nama_kategori_mhs = 'Magang'
        UNION ALL
        SELECT 'Admin' FROM admin_user
    ) as anggota 
    GROUP BY kategori
";
$result_pie = pg_query($conn, $query_pie);
$pie_chart_data = array();
if ($result_pie) {
    while ($row = pg_fetch_assoc($result_pie)) {
        $pie_chart_data[] = $row;
    }
}

// ============ DATA UNTUK BAR CHART ============
// $query_bar = "
//     SELECT 
//         TO_CHAR(tanggal_publikasi, 'Mon') as bulan,
//         COUNT(CASE WHEN tipe = 'berita' THEN 1 END) as berita,
//         COUNT(CASE WHEN tipe = 'agenda' THEN 1 END) as agenda,
//         COUNT(CASE WHEN tipe = 'pengumuman' THEN 1 END) as pengumuman,
//         COUNT(CASE WHEN tipe = 'galeri' THEN 1 END) as galeri
//     FROM publikasi
//     WHERE tanggal_publikasi >= DATE_TRUNC('month', CURRENT_DATE - INTERVAL '5 months')
//     GROUP BY TO_CHAR(tanggal_publikasi, 'Mon'), DATE_TRUNC('month', tanggal_publikasi)
//     ORDER BY MIN(tanggal_publikasi)
//     LIMIT 6
// ";
// $result_bar = pg_query($conn, $query_bar);
// $bar_chart_data = array();
// if ($result_bar) {
//     while ($row = pg_fetch_assoc($result_bar)) {
//         $bar_chart_data[] = $row;
//     }
// } else {
//     // Data dummy jika query gagal
//     $bar_chart_data = array(
//         array('bulan' => 'Jan', 'berita' => 5, 'agenda' => 3, 'pengumuman' => 2, 'galeri' => 4),
//         array('bulan' => 'Feb', 'berita' => 7, 'agenda' => 4, 'pengumuman' => 3, 'galeri' => 6),
//         array('bulan' => 'Mar', 'berita' => 6, 'agenda' => 5, 'pengumuman' => 4, 'galeri' => 5),
//         array('bulan' => 'Apr', 'berita' => 8, 'agenda' => 6, 'pengumuman' => 5, 'galeri' => 7),
//         array('bulan' => 'Mei', 'berita' => 9, 'agenda' => 7, 'pengumuman' => 6, 'galeri' => 8)
//     );
// }

// ============ QUICK ACTIONS ============
$quick_actions = array(
    array(
        'icon' => 'fas fa-user-plus',
        'title' => 'Tambah Dosen Baru',
        'description' => 'Tambahkan data dosen baru ke sistem',
        'link' => 'dosen/tambah.php',
        'color' => '#3182CE'
    ),
    array(
        'icon' => 'fas fa-calendar-plus',
        'title' => 'Buat Agenda Baru',
        'description' => 'Jadwalkan kegiatan atau meeting',
        'link' => 'agenda/tambah.php',
        'color' => '#38A169'
    ),
    array(
        'icon' => 'fas fa-newspaper',
        'title' => 'Posting Berita',
        'description' => 'Publikasikan berita terbaru',
        'link' => 'berita/tambah.php',
        'color' => '#D69E2E'
    ),
    array(
        'icon' => 'fas fa-microscope',
        'title' => 'Tambah Fasilitas',
        'description' => 'Tambahkan data alat lab baru',
        'link' => 'fasilitas/tambah.php',
        'color' => '#805AD5'
    ),
    array(
        'icon' => 'fas fa-image',
        'title' => 'Upload ke Galeri',
        'description' => 'Tambahkan foto ke galeri',
        'link' => 'galeri/tambah.php',
        'color' => '#DD6B20'
    )
);

// ============ AKTIVITAS TERBARU (LOG) ============
// $query_log = "
//     SELECT 
//         l.id_log,
//         l.waktu,
//         l.deskripsi as aktivitas,
//         COALESCE(a.username, 'System') as user,
//         l.status,
//         l.modul
//     FROM log_aktivitas l
//     LEFT JOIN admin_user a ON l.user_id = a.id_user
//     ORDER BY l.waktu DESC 
//     LIMIT 8
// ";
// $result_log = pg_query($conn, $query_log);
// $activities = array();
// if ($result_log) {
//     while ($row = pg_fetch_assoc($result_log)) {
//         $row['waktu_formatted'] = date('H:i', strtotime($row['waktu']));
//         $activities[] = $row;
//     }
// }

// ============ DATA UNTUK JAVASCRIPT (JSON) ============
// Set default untuk bar chart jika tidak ada
$bar_chart_data = array(
    array('bulan' => 'Jan', 'berita' => 0, 'agenda' => 0, 'pengumuman' => 0, 'galeri' => 0)
);

$chart_data_json = json_encode(array(
    'pie' => $pie_chart_data,
    'bar' => $bar_chart_data,
    'stats' => $stats,
    'agenda' => $agenda_items
));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Laboratorium</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/styleDashboard.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.min.js"></script>
</head>
<body>

    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang, <?php echo htmlspecialchars($user_name); ?>. Berikut ringkasan aktivitas terbaru.</p>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value"><?php echo $stats['jumlah_dosen'] ?? 0; ?></div>
                        <div class="stat-label">Dosen</div>
                    </div>
                    <div class="stat-icon dosen">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value"><?php echo $stats['jumlah_asisten_lab'] ?? 0; ?></div>
                        <div class="stat-label">Asisten Lab</div>
                    </div>
                    <div class="stat-icon asisten">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value"><?php echo $stats['jumlah_magang'] ?? 0; ?></div>
                        <div class="stat-label">Magang</div>
                    </div>
                    <div class="stat-icon magang">
                        <i class="fas fa-briefcase"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value"><?php echo $stats['jumlah_admin'] ?? 0; ?></div>
                        <div class="stat-label">Admin</div>
                    </div>
                    <div class="stat-icon admin">
                        <i class="fas fa-user-cog"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value"><?php echo $stats['jumlah_fasilitas'] ?? 0; ?></div>
                        <div class="stat-label">Fasilitas</div>
                    </div>
                    <div class="stat-icon fasilitas">
                        <i class="fas fa-microscope"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value"><?php echo $stats['jumlah_produk'] ?? 0; ?></div>
                        <div class="stat-label">Produk</div>
                    </div>
                    <div class="stat-icon produk">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value"><?php echo $stats['jumlah_mitra'] ?? 0; ?></div>
                        <div class="stat-label">Mitra</div>
                    </div>
                    <div class="stat-icon mitra">
                        <i class="fas fa-handshake"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value"><?php echo $stats['jumlah_galeri'] ?? 0; ?></div>
                        <div class="stat-label">Galeri</div>
                    </div>
                    <div class="stat-icon galeri">
                        <i class="fas fa-images"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions-section">
            <div class="quick-actions-header">
                <h3 class="section-title">Quick Actions</h3>
                <small>Klik untuk aksi cepat</small>
            </div>
            <div class="quick-actions-grid">
                <?php foreach ($quick_actions as $action): ?>
                <a href="<?php echo htmlspecialchars($action['link']); ?>" class="quick-action-card">
                    <div class="quick-action-icon" style="background-color: <?php echo $action['color']; ?>">
                        <i class="<?php echo $action['icon']; ?>"></i>
                    </div>
                    <div class="quick-action-title"><?php echo htmlspecialchars($action['title']); ?></div>
                    <div class="quick-action-description"><?php echo htmlspecialchars($action['description']); ?></div>
                    <span class="quick-action-link">Akses sekarang →</span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="charts-row">
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Komposisi Anggota</h3>
                    <select class="chart-filter" id="pieChartFilter">
                        <option value="all">Semua</option>
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>
                <div class="chart-wrapper">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Aktivitas Publikasi</h3>
                    <select class="chart-filter" id="barChartFilter">
                        <option value="month">Bulan Ini</option>
                        <option value="year">Tahun Ini</option>
                        <option value="all">Semua</option>
                    </select>
                </div>
                <div class="chart-wrapper">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Calendar & Agenda Row -->
        <div class="calendar-agenda-row">
            <!-- Kalender di Kiri -->
            <div class="calendar-container">
                <div class="calendar-header">
                    <h3 class="section-title">Kalender</h3>
                    <div class="calendar-actions">
                        <button id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                        <button id="nextMonth"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <div id="calendar"></div>
            </div>
            
            <!-- Agenda Terbaru di Kanan -->
            <div class="agenda-container">
                <div class="agenda-header">
                    <h3 class="section-title">Agenda Terbaru</h3>
                    <a href="agenda.php" class="view-all">Lihat Semua</a>
                </div>
                <div class="agenda-list">
                    <?php if (empty($formatted_agenda)): ?>
                    <div class="agenda-item empty-agenda">
                        <div class="agenda-content">
                            <div class="agenda-title">
                                <i class="fas fa-calendar-times"></i> Tidak ada agenda mendatang
                            </div>
                            <div class="agenda-description">
                                <small>Tambahkan agenda baru untuk mengisi kalender</small>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <?php foreach ($formatted_agenda as $agenda): ?>
                    <div class="agenda-item" data-id="<?php echo $agenda['id']; ?>" 
                         data-date="<?php echo $agenda['full_date']; ?>"
                         data-start="<?php echo $agenda['start_time']; ?>"
                         data-end="<?php echo $agenda['end_time']; ?>">
                        <div class="agenda-date">
                            <span class="agenda-day"><?php echo $agenda['day']; ?></span>
                            <span class="agenda-month"><?php echo $agenda['month']; ?></span>
                        </div>
                        <div class="agenda-content">
                            <div class="agenda-title"><?php echo htmlspecialchars($agenda['title']); ?></div>
                            <div class="agenda-time">
                                <i class="far fa-clock"></i>
                                <?php echo $agenda['time']; ?>
                            </div>
                            <div class="agenda-actions">
                                <button class="btn-edit-agenda" title="Edit Agenda">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-delete-agenda" title="Hapus Agenda">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="agenda-footer">
                    <a href="agenda/tambah.php" class="btn-add-agenda">
                        <i class="fas fa-plus"></i> Tambah Agenda Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script scr="js/sidebar.js"></script>

    <!-- JavaScript -->
    <script>
        // Data dari PHP ke JavaScript
        const dashboardData = <?php echo $chart_data_json; ?>;
        
        // Data untuk charts
        const pieChartData = {
            labels: <?php echo json_encode(array_column($pie_chart_data, 'kategori')); ?>,
            values: <?php echo json_encode(array_column($pie_chart_data, 'jumlah')); ?>
        };
        
        const barChartData = {
            months: <?php echo json_encode(array_column($bar_chart_data, 'bulan')); ?>,
            berita: <?php echo json_encode(array_column($bar_chart_data, 'berita')); ?>,
            agenda: <?php echo json_encode(array_column($bar_chart_data, 'agenda')); ?>,
            pengumuman: <?php echo json_encode(array_column($bar_chart_data, 'pengumuman')); ?>,
            galeri: <?php echo json_encode(array_column($bar_chart_data, 'galeri')); ?>
        };
        
        // Data untuk calendar
        const calendarEvents = [
            <?php foreach ($agenda_items as $agenda): ?>
            {
                id: '<?php echo $agenda['id_agenda']; ?>',
                title: '<?php echo addslashes($agenda['judul_agenda']); ?>',
                start: '<?php echo $agenda['tanggal_agenda']; ?>T<?php echo $agenda['waktu_mulai']; ?>',
                end: '<?php echo $agenda['tanggal_agenda']; ?>T<?php echo $agenda['waktu_selesai']; ?>',
                color: '#3182CE',
                allDay: false
            },
            <?php endforeach; ?>
        ];
    </script>
    
    <!-- JS Files -->
    <script scr="js/sidebar.js"></script>
    <script src="js/dashboardCharts.js"></script>
    <script src="js/dashboardJS.js"></script>
    <script src="js/dashboardCalendar.js"></script>
</body>
</html>