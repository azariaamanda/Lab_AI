<?php
session_start();
require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $query_delete = "DELETE FROM profil_lab WHERE id_profil = $1 AND tipe_konten = 'Misi'";
    $result_delete = pg_query_params($conn, $query_delete, [$id]);

    if ($result_delete) {
        $_SESSION['message'] = 'Poin Misi berhasil dihapus.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal menghapus Misi: ' . pg_last_error($conn);
        $_SESSION['message_type'] = 'error';
    }
}

header('Location: kelola_misi.php');
exit;