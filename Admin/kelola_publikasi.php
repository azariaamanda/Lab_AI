<?php
require_once '../koneksi.php';

$query = "SELECT p.*, d.nama_dosen 
          FROM publikasi_dosen p
          LEFT JOIN profil_dosen d ON p.id_profil_dosen = d.id_profil_dosen
          ORDER BY p.id_publikasi DESC";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Publikasi Dosen - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/tabel.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="header-left">
                <h1><i class="fas fa-book"></i> Publikasi Dosen</h1>
                <p class="text-muted">Kelola jurnal dan publikasi ilmiah dosen</p>
            </div>
            <div class="header-right">
                <a href="tambah_publikasi.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Publikasi
                </a>
            </div>
        </div>

        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php 
                if($_GET['success'] == 'tambah') echo 'Data publikasi berhasil ditambahkan!';
                elseif($_GET['success'] == 'edit') echo 'Data publikasi berhasil diupdate!';
                elseif($_GET['success'] == 'hapus') echo 'Data publikasi berhasil dihapus!';
            ?>
        </div>
        <?php endif; ?>

        <div class="table-container">
            <div class="table-header">
                <div class="table-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari publikasi..." onkeyup="searchTable()">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" id="publikasiTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dosen</th>
                            <th>Jenis Publikasi</th>
                            <th>Judul</th>
                            <th>Tahun</th>
                            <th>Link</th>
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
                            <td>
                                <span class="badge badge-<?= strtolower($row['id_jenis_publikasi']); ?>">
                                    <?= htmlspecialchars($row['id_jenis_publikasi']); ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['judul_publikasi']); ?></td>
                            <td><?= htmlspecialchars($row['tahun']); ?></td>
                            <td>
                                <?php if(!empty($row['url_publikasi'])): ?>
                                    <a href="<?= htmlspecialchars($row['url_publikasi']); ?>" target="_blank" class="btn-link">
                                        <i class="fas fa-external-link-alt"></i> Lihat
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit_publikasi.php?id=<?= $row['id_publikasi']; ?>" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="confirmDelete(<?= $row['id_publikasi']; ?>)" class="btn btn-sm btn-delete">
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
                                    <i class="fas fa-book"></i>
                                    <p>Belum ada data publikasi</p>
                                    <a href="tambah_publikasi.php" class="btn btn-sm btn-primary">
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
                    Menampilkan <?= pg_num_rows($result); ?> data publikasi
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data publikasi ini?</p>
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
            const input = document.getElementById("searchInput");
            const filter = input.value.toUpperCase();
            const table = document.getElementById("publikasiTable");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td");
                let found = false;
                
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        const txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }

        function confirmDelete(id) {
            document.getElementById('deleteModal').style.display = 'flex';
            document.getElementById('deleteLink').href = 'hapus_publikasi.php?id=' + id;
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) closeModal();
        }
    </script>

    <style>
        .badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .badge-jurnal {
            background: rgba(49, 130, 206, 0.1);
            color: #3182CE;
        }
        .badge-konferensi {
            background: rgba(56, 161, 105, 0.1);
            color: #38A169;
        }
        .badge-buku {
            background: rgba(214, 158, 46, 0.1);
            color: #D69E2E;
        }
        .btn-link {
            color: #3182CE;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .btn-link:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>
