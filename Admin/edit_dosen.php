<?php
require_once '../koneksi.php';

// Get ID from URL
if(!isset($_GET['id'])) {
    header("Location: kelola_dosen.php?error=ID tidak ditemukan");
    exit();
}

$id = pg_escape_string($conn, $_GET['id']);

// Get existing data
$query = "SELECT * FROM profil_dosen WHERE id_profil_dosen = '$id'";
$result = pg_query($conn, $query);

if(pg_num_rows($result) == 0) {
    header("Location: kelola_dosen.php?error=Data tidak ditemukan");
    exit();
}

$data = pg_fetch_assoc($result);

// Handle form submission
if(isset($_POST['submit'])) {
    $nip     = pg_escape_string($conn, $_POST['nip']);
    $nidn    = pg_escape_string($conn, $_POST['nidn']);
    $nama    = pg_escape_string($conn, $_POST['nama_dosen']);
    $prodi   = pg_escape_string($conn, $_POST['program_studi']);
    $jabatan = pg_escape_string($conn, $_POST['jabatan']);
    $email   = pg_escape_string($conn, $_POST['email_dosen']);
    $website = pg_escape_string($conn, $_POST['website_dosen']);
    $bidang  = pg_escape_string($conn, $_POST['bidang_keahlian']);

    $foto = $data['foto_profil']; // default tetap foto lama

    // Upload file baru jika ada
    if(isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $allowed = ['jpg','jpeg','png','gif'];
        $filename = $_FILES['foto_profil']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if(in_array($ext,$allowed)) {
            $newname = time().'_'.$filename;
            $upload_dir = 'uploads/dosen/';

            if(!is_dir($upload_dir)) mkdir($upload_dir,0777,true);

            if(move_uploaded_file($_FILES['foto_profil']['tmp_name'],$upload_dir.$newname)) {

                // Hapus foto lama
                if(!empty($data['foto_profil']) && file_exists($upload_dir.$data['foto_profil'])) {
                    unlink($upload_dir.$data['foto_profil']);
                }
                $foto = $newname;
            }
        }
    }

    $query = "UPDATE profil_dosen SET 
              nip = '$nip',
              nidn = '$nidn',
              nama_dosen = '$nama',
              program_studi = '$prodi',
              jabatan = '$jabatan',
              email_dosen = '$email',
              website_dosen = '$website',
              bidang_keahlian = '$bidang',
              foto_profil = '$foto'
              WHERE id_profil_dosen = '$id'";

    if(pg_query($conn,$query)) {
        header("Location: kelola_dosen.php?success=edit");
        exit();
    } else {
        $error = "Gagal mengupdate data: " . pg_last_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Dosen - Dashboard Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-user-edit"></i> Edit Data Dosen</h1>
            <p class="text-muted">Update profil dosen</p>
        </div>
        <div class="header-right">
            <a href="kelola_dosen.php" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <?php if(isset($error)): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?= $error ?>
    </div>
    <?php endif; ?>

    <div class="info-banner">
        <div class="info-content">
            <i class="fas fa-info-circle"></i>
            <div>
                <h4>Informasi</h4>
                <small>Update data dosen dengan benar. Field bertanda (*) wajib diisi.</small>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form action="" method="POST" enctype="multipart/form-data">

            <div class="form-grid">
                <!-- Left -->
                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">NIP</label>
                        <input type="text" name="nip" class="form-control" value="<?= $data['nip'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">NIDN</label>
                        <input type="text" name="nidn" class="form-control" value="<?= $data['nidn'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Nama Lengkap</label>
                        <input type="text" name="nama_dosen" class="form-control" value="<?= $data['nama_dosen'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Program Studi</label>
                        <select name="program_studi" class="form-control" required>
                            <option value="">Pilih Program Studi</option>
                            <option value="Teknik Informatika" <?= $data['program_studi']=='Teknik Informatika'?'selected':'' ?>>Teknik Informatika</option>
                            <option value="Sistem Informasi Bisnis" <?= $data['program_studi']=='Sistem Informasi Bisnis'?'selected':'' ?>>Sistem Informasi Bisnis</option>
                            <option value="Pengembangan Piranti Lunak Situs" <?= $data['program_studi']=='Pengembangan Piranti Lunak Situs'?'selected':'' ?>>Pengembangan Piranti Lunak Situs</option>
                        </select>
                    </div>
                </div>

                <!-- Right -->
                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="<?= $data['jabatan'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email_dosen" class="form-control" value="<?= $data['email_dosen'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" name="website_dosen" class="form-control" value="<?= $data['website_dosen'] ?>">
                    </div>

                    <div class="form-group">
                        <label>Bidang Keahlian</label>
                        <input type="text" name="bidang_keahlian" class="form-control" value="<?= $data['bidang_keahlian'] ?>">
                    </div>
                </div>
            </div>

            <!-- FOTO -->
            <div class="form-group">
                <label>Foto Profil Saat Ini</label>
                <?php if(!empty($data['foto_profil'])): ?>
                    <div style="margin:10px 0;">
                        <img src="uploads/dosen/<?= $data['foto_profil'] ?>" style="max-width:200px;border-radius:8px;border:2px solid #E2E8F0;">
                    </div>
                <?php else: ?>
                    <p class="text-muted">Belum ada foto</p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Upload Foto Baru (Opsional)</label>
                <input type="file" name="foto_profil" class="form-control" accept="image/*">
            </div>

            <div class="form-actions">
                <a href="kelola_dosen.php" class="btn btn-outline"><i class="fas fa-times"></i> Batal</a>
                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Data</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
