<?php
require_once '../koneksi.php';

if(!isset($_GET['id'])) {
    header("Location: kelola_pendidikan_dosen.php?error=ID tidak ditemukan");
    exit();
}

// Sanitasi input (hindari SQL Injection)
$id = pg_escape_string($conn, $_GET['id']);

// Query hapus data
$query = "DELETE FROM pendidikan_dosen WHERE id_pendidikan = '$id'";

$result = pg_query($conn, $query);

if($result) {
    header("Location: kelola_pendidikan_dosen.php?success=hapus");
    exit();
} else {
    $error = pg_last_error($conn);
    header("Location: kelola_pendidikan_dosen.php?error=Gagal menghapus data: $error");
    exit();
}
?>
