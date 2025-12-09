<?php
require_once '../koneksi.php'; 

// Check if ID is provided
if(!isset($_GET['id'])) {
    header("Location: kelola_dosen.php?error=ID tidak ditemukan");
    exit();
}

$id = pg_escape_string($conn, $_GET['id']);

// Get photo filename before deleting
$query = "SELECT foto_profil FROM profil_dosen WHERE id_profil_dosen = '$id'";
$result = pg_query($conn, $query);

if(pg_num_rows($result) == 0) {
    header("Location: kelola_dosen.php?error=Data tidak ditemukan");
    exit();
}

$data = pg_fetch_assoc($result);

// Delete the record
$query = "DELETE FROM profil_dosen WHERE id_profil_dosen = '$id'";
$delete = pg_query($conn, $query);

if($delete) {
    // Delete photo file if exists
    if(!empty($data['foto_profil'])) {
        $photo_path = 'uploads/dosen/' . $data['foto_profil'];
        if(file_exists($photo_path)) {
            unlink($photo_path);
        }
    }

    header("Location: kelola_dosen.php?success=hapus");
    exit();
} else {
    header("Location: kelola_dosen.php?error=Gagal menghapus data");
    exit();
}
?>
