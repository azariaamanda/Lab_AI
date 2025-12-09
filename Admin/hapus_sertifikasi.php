<?php
require_once '../koneksi.php';

// ================= CEK ID =================
if(!isset($_GET['id'])) {
    header("Location: kelola_sertifikasi.php?error=ID tidak ditemukan");
    exit();
}

// Escape input dari MySQL → PostgreSQL
$id = pg_escape_string($conn, $_GET['id']);

// ================= QUERY DELETE =================
$query = "DELETE FROM sertifikasi_dosen WHERE id_sertifikasi = '$id'";

if(pg_query($conn, $query)) {
    header("Location: kelola_sertifikasi.php?success=hapus");
    exit();
} else {
    header("Location: kelola_sertifikasi.php?error=Gagal menghapus data");
    exit();
}
?>