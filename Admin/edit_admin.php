<?php
session_start();
require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data admin yang akan diedit
$query_select = "SELECT * FROM admin WHERE id_admin = $1";
$result_select = pg_query_params($conn, $query_select, [$id]);
$admin = pg_fetch_assoc($result_select);

if (!$admin) {
    $_SESSION['message'] = 'Admin tidak ditemukan.';
    $_SESSION['message_type'] = 'error';
    header('Location: kelola_admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($nama_lengkap) || empty($username) || empty($email) || empty($role)) {
        $_SESSION['message'] = 'Semua field kecuali password wajib diisi!';
        $_SESSION['message_type'] = 'error';
    } else {
        $params = [$nama_lengkap, $username, $email, $role];
        // Cek apakah password diisi
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query_update = "UPDATE admin SET nama_lengkap = $1, username = $2, email = $3, role = $4, password = $5 WHERE id_admin = $6";
            array_push($params, $hashed_password, $id);
        } else {
            $query_update = "UPDATE admin SET nama_lengkap = $1, username = $2, email = $3, role = $4 WHERE id_admin = $5";
            array_push($params, $id);
        }

        $result_update = pg_query_params($conn, $query_update, $params);

        if ($result_update) {
            $_SESSION['message'] = 'Data admin berhasil diperbarui!';
            $_SESSION['message_type'] = 'success';
            header('Location: kelola_admin.php');
            exit;
        } else {
            $_SESSION['message'] = 'Gagal memperbarui data: ' . pg_last_error($conn);
            $_SESSION['message_type'] = 'error';
        }
    }
    header("Location: edit_admin.php?id=$id");
    exit;
}

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styleDashboard.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="dashboard-content">
            <?php include 'header.php'; ?>
            <div class="page-header">
                <h1 class="page-title">Edit Admin</h1>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <div class="form-container" style="max-width: 800px; margin: auto;">
                <form action="edit_admin.php?id=<?php echo $id; ?>" method="POST" class="data-form">
                    <div class="form-card">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="nama_lengkap" class="form-label required">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="<?php echo htmlspecialchars($admin['nama_lengkap']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="username" class="form-label required">Username</label>
                                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label required">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password Baru (Opsional)</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <div class="form-help">Kosongkan jika tidak ingin mengubah password.</div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="form-label required">Peran</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="Administrator" <?php echo ($admin['role'] == 'Administrator') ? 'selected' : ''; ?>>Administrator</option>
                                    <option value="Editor" <?php echo ($admin['role'] == 'Editor') ? 'selected' : ''; ?>>Editor</option>
                                    <option value="Viewer" <?php echo ($admin['role'] == 'Viewer') ? 'selected' : ''; ?>>Viewer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="kelola_admin.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/dashboardJS.js"></script>
</body>
</html>