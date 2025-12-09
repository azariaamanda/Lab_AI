<?php
require_once '../koneksi.php';

// Ambil daftar dosen
$query_dosen = "SELECT id_profil_dosen, nama_dosen FROM profil_dosen ORDER BY nama_dosen";
$dosen_list = pg_query($conn, $query_dosen);

// Proses submit form
if(isset($_POST['submit'])) {
    $id_dosen = pg_escape_string($conn, $_POST['id_profil_dosen']);
    $nama_sosmed = pg_escape_string($conn, $_POST['nama_sosmed_dsn']);
    $url = pg_escape_string($conn, $_POST['url_sosmed_dosen']);
    $icon = pg_escape_string($conn, $_POST['icon_sosmed']);

    $query = "INSERT INTO sosmed_dosen (id_profil_dosen, nama_sosmed_dsn, url_sosmed_dosen, icon_sosmed) 
              VALUES ('$id_dosen', '$nama_sosmed', '$url', '$icon')";

    if(pg_query($conn, $query)) {
        header("Location: kelola_sosmed_dosen.php?success=tambah");
        exit();
    } else {
        $error = "Gagal menambahkan data: " . pg_last_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sosial Media - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="main-content">

    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-share-alt"></i> Tambah Sosial Media</h1>
            <p class="text-muted">Tambahkan akun sosial media dosen</p>
        </div>
        <div class="header-right">
            <a href="kelola_sosmed_dosen.php" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <?php if(isset($error)): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i> <?= $error; ?>
    </div>
    <?php endif; ?>

    <div class="info-banner">
        <div class="info-content">
            <i class="fas fa-info-circle"></i>
            <div>
                <h4>Informasi</h4>
                <small>Lengkapi data sosial media dosen. Field bertanda (*) wajib diisi.</small>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form action="" method="POST">

            <div class="form-grid">

                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">Nama Dosen</label>
                        <select name="id_profil_dosen" class="form-control" required>
                            <option value="">Pilih Dosen</option>
                            <?php while($dosen = pg_fetch_assoc($dosen_list)): ?>
                                <option value="<?= $dosen['id_profil_dosen']; ?>">
                                    <?= htmlspecialchars($dosen['nama_dosen']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Nama Platform</label>
                        <select id="nama_sosmed_dsn" name="nama_sosmed_dsn" class="form-control" required onchange="updateIcon()">
                            <option value="">Pilih Platform</option>
                            <option value="LinkedIn" data-icon="fab fa-linkedin">LinkedIn</option>
                            <option value="Twitter" data-icon="fab fa-twitter">Twitter</option>
                            <option value="Facebook" data-icon="fab fa-facebook">Facebook</option>
                            <option value="Instagram" data-icon="fab fa-instagram">Instagram</option>
                            <option value="GitHub" data-icon="fab fa-github">GitHub</option>
                            <option value="Google Scholar" data-icon="fas fa-graduation-cap">Google Scholar</option>
                            <option value="ResearchGate" data-icon="fab fa-researchgate">ResearchGate</option>
                            <option value="YouTube" data-icon="fab fa-youtube">YouTube</option>
                        </select>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">URL Profil</label>
                        <input type="url" name="url_sosmed_dosen" class="form-control" 
                               placeholder="https://linkedin.com/in/username" required>
                        <small class="form-help">Link lengkap ke profil sosial media</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Icon Class</label>
                        <input type="text" id="icon_sosmed" name="icon_sosmed" class="form-control" 
                               placeholder="fab fa-linkedin" required readonly>
                        <small class="form-help">Otomatis terisi saat pilih platform</small>
                    </div>
                </div>
            </div>

            <!-- Preview Icon -->
            <div class="form-group">
                <label class="form-label">Preview Icon</label>
                <div style="padding:20px;background:#F7FAFC;border-radius:8px;text-align:center;">
                    <i id="iconPreview" class="" style="font-size:3rem;color:#3182CE;"></i>
                    <p id="iconText" class="text-muted" style="margin-top:10px;">Pilih platform untuk melihat icon</p>
                </div>
            </div>

            <div class="form-actions">
                <a href="kelola_sosmed_dosen.php" class="btn btn-outline"><i class="fas fa-times"></i> Batal</a>
                <button type="submit" name="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function updateIcon(){
    const option=document.querySelector("#nama_sosmed_dsn option:checked");
    document.getElementById("icon_sosmed").value = option.dataset.icon || "";
    document.getElementById("iconPreview").className = option.dataset.icon || "";
    document.getElementById("iconText").innerText = option.value || "Pilih platform untuk melihat icon";
}
</script>

</body>
</html>
