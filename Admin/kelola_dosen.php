<?php
require_once '../koneksi.php';

$query = "SELECT * FROM profil_dosen ORDER BY id_profil_dosen DESC";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Dosen - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/tabel.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="header-left">
                <h1><i class="fas fa-user-tie"></i> Data Dosen</h1>
                <p class="text-muted">Kelola data profil dosen laboratorium</p>
            </div>
            <div class="header-right">
                <a href="tambah_dosen.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Dosen
                </a>
            </div>
        </div>

        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php 
                if($_GET['success'] == 'tambah') echo 'Data dosen berhasil ditambahkan!';
                elseif($_GET['success'] == 'edit') echo 'Data dosen berhasil diupdate!';
                elseif($_GET['success'] == 'hapus') echo 'Data dosen berhasil dihapus!';
            ?>
        </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?= htmlspecialchars($_GET['error']); ?>
        </div>
        <?php endif; ?>

        <div class="table-container">
            <div class="table-header">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari nama dosen..." onkeyup="searchTable()">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" id="dosenTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>NIDN</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Jabatan</th>
                            <th>Email</th>
                            <th>Foto</th>
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
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nip']); ?></td>
                            <td><?= htmlspecialchars($row['nidn']); ?></td>
                            <td><strong><?= htmlspecialchars($row['nama_dosen']); ?></strong></td>
                            <td><?= htmlspecialchars($row['program_studi']); ?></td>
                            <td><?= htmlspecialchars($row['jabatan']); ?></td>
                            <td><?= htmlspecialchars($row['email_dosen']); ?></td>
                            <td>
                                <?php if(!empty($row['foto_profil'])): ?>
                                    <img src="uploads/dosen/<?= htmlspecialchars($row['foto_profil']); ?>" 
                                         style="width:50px;height:50px;border-radius:8px;object-fit:cover;">
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit_dosen.php?id=<?= $row['id_profil_dosen']; ?>" class="btn btn-sm btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button onclick="confirmDelete(<?= $row['id_profil_dosen']; ?>)" class="btn btn-sm btn-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="9" class="text-center">Belum ada data dosen</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div class="table-info">
                    Menampilkan <?= pg_num_rows($result); ?> data dosen
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchTable(){
            let input = document.getElementById("searchInput").value.toUpperCase();
            let rows = document.querySelectorAll("#dosenTable tbody tr");

            rows.forEach(r => {
                let found = [...r.children].some(td=>td.innerText.toUpperCase().includes(input));
                r.style.display = found ? "" : "none";
            });
        }

        function confirmDelete(id){
            if(confirm("Yakin ingin menghapus?")) window.location = "hapus_dosen.php?id=" + id;
        }
    </script>
</body>
</html>
