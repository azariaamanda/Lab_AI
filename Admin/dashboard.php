<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="StyleSidebar.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
        }

        .page-header {
            background: linear-gradient(135deg, #3AA9AF 0%, #1A476E 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(58, 169, 175, 0.3);
        }

        .page-header h2 {
            margin: 0;
            font-weight: 600;
        }

        .page-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 25px;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        .stats-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .stats-card.blue .icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stats-card.green .icon {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .stats-card.orange .icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .stats-card.teal .icon {
            background: linear-gradient(135deg, #3AA9AF 0%, #1A476E 100%);
            color: white;
        }

        .stats-card h3 {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
            color: #2c3e50;
        }

        .stats-card p {
            color: #6c757d;
            margin: 0;
            font-size: 14px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #3AA9AF 0%, #1A476E 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(58, 169, 175, 0.3);
        }

        .welcome-card h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .welcome-card p {
            opacity: 0.9;
            margin: 0;
        }

        .quick-actions {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .quick-actions h4 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 600;
        }

        .action-btn {
            display: block;
            padding: 15px 20px;
            background: #f8f9fa;
            border: none;
            border-radius: 10px;
            color: #2c3e50;
            text-decoration: none;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            text-align: left;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, #3AA9AF 0%, #1A476E 100%);
            color: white;
            transform: translateX(5px);
        }

        .action-btn i {
            margin-right: 10px;
            width: 20px;
        }
    </style>
</head>
<body>

    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <h1><i class="fas fa-hand-wave me-2"></i>Selamat Datang, Admin!</h1>
            <p>Kelola semua konten dan data laboratorium Anda dari sini</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card blue">
                    <div class="icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3>24</h3>
                    <p>Total Berita</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card green">
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>48</h3>
                    <p>Total Anggota</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card orange">
                    <div class="icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>15</h3>
                    <p>Total Mitra</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card teal">
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <h3>8</h3>
                    <p>Agenda Bulan Ini</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="quick-actions">
                    <h4><i class="fas fa-bolt me-2"></i>Aksi Cepat</h4>
                    <a href="kelola_berita.php" class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Berita Baru
                    </a>
                    <a href="kelola_pengumuman.php" class="action-btn">
                        <i class="fas fa-bullhorn"></i>
                        Buat Pengumuman
                    </a>
                    <a href="kelola_agenda.php" class="action-btn">
                        <i class="fas fa-calendar-plus"></i>
                        Tambah Agenda
                    </a>
                    <a href="kelola_galeri.php" class="action-btn">
                        <i class="fas fa-image"></i>
                        Upload Galeri
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="quick-actions">
                    <h4><i class="fas fa-chart-line me-2"></i>Aktivitas Terbaru</h4>
                    <div class="text-muted">
                        <p><i class="fas fa-circle" style="font-size: 8px; color: #3AA9AF;"></i> Berita baru ditambahkan - 2 jam lalu</p>
                        <p><i class="fas fa-circle" style="font-size: 8px; color: #3AA9AF;"></i> Mahasiswa baru terdaftar - 5 jam lalu</p>
                        <p><i class="fas fa-circle" style="font-size: 8px; color: #3AA9AF;"></i> Galeri diperbarui - 1 hari lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>