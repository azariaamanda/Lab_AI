<?php
session_start();
require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Hapus data dari database
    $query_delete = "DELETE FROM nav_banner WHERE id_navbanner = $1";
    $result_delete = pg_query_params($conn, $query_delete, [$id]);

    if ($result_delete) {
        $_SESSION['message'] = 'Nav Banner berhasil dihapus.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal menghapus Nav Banner: ' . pg_last_error($conn);
        $_SESSION['message_type'] = 'error';
    }
}

header('Location: kelola_nav_banner.php');
exit;