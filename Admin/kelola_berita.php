<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita - Admin Panel</title>
    

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

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #3AA9AF 0%, #1A476E 100%);
            color: white;
            padding: 20px 25px;
            border: none;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .btn-add {
            background: linear-gradient(135deg, #3AA9AF 0%, #1A476E 100%);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(58, 169, 175, 0.4);
            color: white;
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #495057;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            margin: 0 2px;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(245, 87, 108, 0.4);
            color: white;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
        }

        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-box input {
            border-radius: 10px;
            padding: 12px 45px 12px 20px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: #3AA9AF;
            box-shadow: 0 0 0 0.2rem rgba(58, 169, 175, 0.15);
        }

        .search-box i {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            max-width: 300px;
        }
    </style>
</head>
<body>

    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="fas fa-newspaper me-2"></i>Kelola Berita</h2>
            <p>Manajemen data berita dan pengumuman</p>
        </div>

        <!-- Card Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list me-2"></i>Daftar Berita</span>
                <button class="btn btn-add" onclick="tambahBerita()">
                    <i class="fas fa-plus me-2"></i>Tambah Berita
                </button>
            </div>
            <div class="card-body p-0">
                <!-- Search Box -->
                <div class="p-3">
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Cari berita...">
                        <i class="fas fa-search"></i>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 10%;">ID</th>
                                <th style="width: 12%;">Kategori</th>
                                <th style="width: 25%;">Judul</th>
                                <th style="width: 12%;">Tanggal</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 13%;" class="text-center">Gambar</th>
                                <th style="width: 13%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="badge bg-secondary">1</span></td>
                                <td><span class="badge bg-info">3</span></td>
                                <td>
                                    <div class="text-truncate-2">
                                        Tim Polinesika Integrasikan Smart Farming untuk Optimalisasi Project-Based Learning di SMK Negeri 13 Malang
                                    </div>
                                </td>
                                <td>2024-12-06</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted">[null]</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-action btn-edit" onclick="editBerita(1)">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <button class="btn btn-action btn-delete" onclick="hapusBerita(1)">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan 1 dari 1 data
                    </div>
                    <nav>
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script>
        function tambahBerita() {
            alert('Halaman tambah berita akan dibuat');
            // window.location.href = 'tambah_berita.php';
        }

        function editBerita(id) {
            alert('Edit berita ID: ' + id);
            // window.location.href = 'edit_berita.php?id=' + id;
        }

        function hapusBerita(id) {
            if(confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
                alert('Hapus berita ID: ' + id);
                // window.location.href = 'hapus_berita.php?id=' + id;
            }
        }
    </script>
</body>
</html>