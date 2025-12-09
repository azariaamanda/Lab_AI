<?php
require_once '../koneksi.php';

if(!isset($_GET['id'])) {
    header("Location: kelola_publikasi.php?error=ID tidak ditemukan");
    exit();
}

$id = pg_escape_string($conn, $_GET['id']);

$query = "DELETE FROM publikasi_dosen WHERE id_publikasi = '$id'";

if(pg_query($conn, $query)) {
    header("Location: kelola_publikasi.php?success=hapus");
    exit();
} else {
    header("Location: kelola_publikasi.php?error=Gagal menghapus data");
    exit();
}
?>
