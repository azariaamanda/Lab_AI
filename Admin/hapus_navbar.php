<?php
session_start();
require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $query = "DELETE FROM navbar WHERE id_navbar = $1";
    $result = pg_query_params($conn, $query, [$id]);

    if ($result) {
        $_SESSION['message'] = 'Menu navbar berhasil dihapus.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal menghapus menu: ' . pg_last_error($conn);
        $_SESSION['message_type'] = 'error';
    }
}

header('Location: kelola_navbar.php');
exit;