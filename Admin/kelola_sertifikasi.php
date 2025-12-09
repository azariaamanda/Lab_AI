<?php
require_once '../koneksi.php';

$query = "SELECT s.*, d.nama_dosen 
          FROM sertifikasi_dosen s
          LEFT JOIN profil_dosen d ON s.id_profil_dosen = d.id_profil_dosen
          ORDER BY s.id_sertifikasi DESC";

$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Sertifikasi Dosen - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/tabel.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="header-left">
                <h1><i class="fas fa-certificate"></i> Sertifikasi Dosen</h1>
                <p class="text-muted">Kelola sertifikasi dan penghargaan dosen</p>
            </div>
            <div class="header-right">
                <a href="tambah_sertifikasi.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Sertifikasi
                </a>
            </div>
        </div>

        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php 
                if($_GET['success'] == 'tambah') echo 'Data sertifikasi berhasil ditambahkan!';
                elseif($_GET['success'] == 'edit') echo 'Data sertifikasi berhasil diupdate!';
                elseif($_GET['success'] == 'hapus') echo 'Data sertifikasi berhasil dihapus!';
            ?>
        </div>
        <?php endif; ?>

        <div class="table-container">
            <div class="table-header">
                <div class="table-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari sertifikasi..." onkeyup="searchTable()">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" id="sertifikasiTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dosen</th>
                            <th>Nama Sertifikasi</th>
                            <th>Institusi Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Tahun Kadaluarsa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if(pg_num_rows($result) > 0):
                            while($row = pg_fetch_assoc($result)): 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= htmlspecialchars($row['nama_dosen']); ?></strong></td>
                            <td><?= htmlspecialchars($row['nama_sertifikasi']); ?></td>
                            <td><?= htmlspecialchars($row['institusi_penerbit']); ?></td>
                            <td><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                            <td>
                                <?php if($row['tahun_kadaluarsa']): ?>
                                    <?= htmlspecialchars($row['tahun_kadaluarsa']); ?>
                                <?php else: ?>
                                    <span class="text-muted">Seumur Hidup</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit_sertifikasi.php?id=<?= $row['id_sertifikasi']; ?>" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="confirmDelete(<?= $row['id_sertifikasi']; ?>)" class="btn btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        else: 
                        ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-certificate"></i>
                                    <p>Belum ada data sertifikasi</p>
                                    <a href="tambah_sertifikasi.php" class="btn btn-sm btn-primary">
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
                    Menampilkan <?= pg_num_rows($result); ?> data sertifikasi
                </div>
            </div>
        </div>
    </div>

<script>
function searchTable() {
    const input = document.getElementById("searchInput").value.toUpperCase();
    const tr = document.querySelectorAll("#sertifikasiTable tbody tr");
    
    tr.forEach(row => {
        const match = [...row.getElementsByTagName("td")].some(td => td.textContent.toUpperCase().includes(input));
        row.style.display = match ? "" : "none";
    });
}

function confirmDelete(id) {
    document.getElementById('deleteModal').style.display = 'flex';
    document.getElementById('deleteLink').href = 'hapus_sertifikasi.php?id=' + id;
}

function closeModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

window.onclick = e => { if(e.target.id === 'deleteModal') closeModal(); };
</script>

</body>
</html>
