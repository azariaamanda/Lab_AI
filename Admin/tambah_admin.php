<?php
session_start();
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validasi dasar
    if (empty($nama_lengkap) || empty($username) || empty($email) || empty($password) || empty($role)) {
        $_SESSION['message'] = 'Semua field wajib diisi!';
        $_SESSION['message_type'] = 'error';
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Generate avatar URL
        $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($nama_lengkap) . '&background=random&color=fff&size=100';

        $query = "INSERT INTO admin (nama_lengkap, username, email, password, role, avatar) VALUES ($1, $2, $3, $4, $5, $6)";
        $params = [$nama_lengkap, $username, $email, $hashed_password, $role, $avatar];
        
        $result = pg_query_params($conn, $query, $params);

        if ($result) {
            $_SESSION['message'] = 'Admin baru berhasil ditambahkan!';
            $_SESSION['message_type'] = 'success';
            header('Location: kelola_admin.php');
            exit;
        } else {
            $_SESSION['message'] = 'Gagal menambahkan admin: ' . pg_last_error($conn);
            $_SESSION['message_type'] = 'error';
        }
    }
    // Redirect kembali ke form jika ada error
    header('Location: tambah_admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styleDashboard.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="main-content">
        <div class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Tambah Admin Baru</h1>
                <p class="page-subtitle">Isi formulir di bawah untuk menambahkan pengguna admin baru.</p>
            </div>

            <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            </div>
            <?php endif; ?>

            <div class="form-container" style="max-width: 800px; margin: auto;">
                <form action="tambah_admin.php" method="POST" class="data-form">
                    <div class="form-card">
                        <div class="form-header">
                            <h3><i class="fas fa-user-shield"></i> Informasi Akun</h3>
                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <label for="nama_lengkap" class="form-label required">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="username" class="form-label required">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label required">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label required">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="role" class="form-label required">Peran (Role)</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="" disabled selected>Pilih Peran</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Editor">Editor</option>
                                    <option value="Viewer">Viewer</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="kelola_admin.php" class="btn btn-outline">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Tambah Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="js/dashboardJS.js"></script>
</body>
</html>