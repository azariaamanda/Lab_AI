<?php
require_once '../koneksi.php';

if(!isset($_GET['id'])) {
    header("Location: kelola_sosmed_dosen.php?error=ID tidak ditemukan");
    exit();
}

$id = pg_escape_string($conn, $_GET['id']);

$query = "DELETE FROM sosmed_dosen WHERE id_sosmed_dosen = '$id'";

if(pg_query($conn, $query)) {
    header("Location: kelola_sosmed_dosen.php?success=hapus");
    exit();
} else {
    header("Location: kelola_sosmed_dosen.php?error=Gagal menghapus data");
    exit();
}
?>
