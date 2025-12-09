<?php
require_once '../koneksi.php';

$query = "SELECT s.*, d.nama_dosen 
          FROM sosmed_dosen s
          LEFT JOIN profil_dosen d ON s.id_profil_dosen = d.id_profil_dosen
          ORDER BY s.id_sosmed_dosen DESC";

$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Sosial Media Dosen - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/tabel.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-share-alt"></i> Sosial Media Dosen</h1>
            <p class="text-muted">Kelola akun sosial media dosen</p>
        </div>
        <div class="header-right">
            <a href="tambah_sosmed_dosen.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Sosial Media
            </a>
        </div>
    </div>

    <?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php 
            if($_GET['success'] == 'tambah') echo 'Data sosial media berhasil ditambahkan!';
            elseif($_GET['success'] == 'edit') echo 'Data sosial media berhasil diupdate!';
            elseif($_GET['success'] == 'hapus') echo 'Data sosial media berhasil dihapus!';
        ?>
    </div>
    <?php endif; ?>

    <div class="table-container">
        <div class="table-header">
            <div class="table-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari data..." onkeyup="searchTable()">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table" id="sosmedTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dosen</th>
                        <th>Platform</th>
                        <th>URL</th>
                        <th>Icon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                $no=1;
                if(pg_num_rows($result) > 0):
                    while($row = pg_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= htmlspecialchars($row['nama_dosen']); ?></strong></td>
                            <td><?= htmlspecialchars($row['nama_sosmed_dsn']); ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($row['url_sosmed_dosen']); ?>" target="_blank" class="btn-link">
                                    <i class="fas fa-external-link-alt"></i> Lihat Profil
                                </a>
                            </td>
                            <td>
                                <?php if(!empty($row['icon_sosmed'])): ?>
                                    <i class="<?= htmlspecialchars($row['icon_sosmed']); ?>" style="font-size: 1.3rem; color:#3182CE;"></i>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit_sosmed_dosen.php?id=<?= $row['id_sosmed_dosen']; ?>" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="confirmDelete(<?= $row['id_sosmed_dosen']; ?>)" class="btn btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                <?php endwhile; else: ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-share-alt"></i>
                                    <p>Belum ada data sosial media</p>
                                    <a href="tambah_sosmed_dosen.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Data Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="table-info">
                Menampilkan <?= pg_num_rows($result); ?> data sosial media
            </div>
        </div>
    </div>
</div>


<!-- Modal Hapus -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>

        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus data sosial media ini?</p>
        </div>

        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal()">Batal</button>
            <a href="#" id="deleteLink" class="btn btn-danger">
                <i class="fas fa-trash"></i> Hapus
            </a>
        </div>
    </div>
</div>

<script>
function searchTable() {
    const input=document.getElementById("searchInput").value.toUpperCase();
    const tr=document.querySelectorAll("#sosmedTable tbody tr");
    tr.forEach(row=>{
        row.style.display=[...row.children].some(td=>td.innerText.toUpperCase().includes(input))?"":"none";
    });
}
function confirmDelete(id){
    document.getElementById('deleteModal').style.display='flex';
    document.getElementById('deleteLink').href='hapus_sosmed_dosen.php?id='+id;
}
function closeModal(){
    document.getElementById('deleteModal').style.display='none';
}
</script>

<style>
.btn-link{color:#3182CE;text-decoration:none;font-size:0.9rem;}
.btn-link:hover{text-decoration:underline;}
</style>
</body>
</html>
