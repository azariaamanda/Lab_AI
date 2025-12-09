<?php
require_once '../koneksi.php';

// Ambil data pendidikan dosen dengan join ke tabel profil_dosen
$query = "SELECT pd.*, d.nama_dosen 
          FROM pendidikan_dosen pd
          LEFT JOIN profil_dosen d ON pd.id_profil_dosen = d.id_profil_dosen
          ORDER BY pd.id_pendidikan DESC";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pendidikan Dosen - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/tabel.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="header-left">
                <h1><i class="fas fa-graduation-cap"></i> Pendidikan Dosen</h1>
                <p class="text-muted">Kelola riwayat pendidikan dosen</p>
            </div>
            <div class="header-right">
                <a href="tambah_pendidikan_dosen.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pendidikan
                </a>
            </div>
        </div>

        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php 
                if($_GET['success'] == 'tambah') echo 'Data pendidikan berhasil ditambahkan!';
                elseif($_GET['success'] == 'edit') echo 'Data pendidikan berhasil diupdate!';
                elseif($_GET['success'] == 'hapus') echo 'Data pendidikan berhasil dihapus!';
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
                <table class="data-table" id="pendidikanTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dosen</th>
                            <th>Jenjang</th>
                            <th>Program Studi</th>
                            <th>Universitas</th>
                            <th>Tahun Mulai</th>
                            <th>Tahun Selesai</th>
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
                            <td><span class="badge"><?= htmlspecialchars($row['jenjang']); ?></span></td>
                            <td><?= htmlspecialchars($row['program_studi']); ?></td>
                            <td><?= htmlspecialchars($row['universitas']); ?></td>
                            <td><?= htmlspecialchars($row['tahun_mulai']); ?></td>
                            <td><?= htmlspecialchars($row['tahun_selesai']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit_pendidikan_dosen.php?id=<?= $row['id_pendidikan']; ?>" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="confirmDelete(<?= $row['id_pendidikan']; ?>)" class="btn btn-sm btn-delete">
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
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-graduation-cap"></i>
                                    <p>Belum ada data pendidikan</p>
                                    <a href="tambah_pendidikan_dosen.php" class="btn btn-sm btn-primary">
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
                    Menampilkan <?= pg_num_rows($result); ?> data pendidikan
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
                <p>Apakah Anda yakin ingin menghapus data pendidikan ini?</p>
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
            const table = document.getElementById("pendidikanTable");
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
            document.getElementById('deleteLink').href = 'hapus_pendidikan_dosen.php?id=' + id;
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
            background: rgba(49, 130, 206, 0.1);
            color: #3182CE;
        }
    </style>
</body>
</html>
