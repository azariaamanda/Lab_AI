<?php
session_start();
require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $query = "DELETE FROM admin WHERE id_admin = $1";
    $result = pg_query_params($conn, $query, [$id]);

    if ($result) {
        $_SESSION['message'] = 'Admin berhasil dihapus.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal menghapus admin: ' . pg_last_error($conn);
        $_SESSION['message_type'] = 'error';
    }
}
header('Location: kelola_admin.php');
exit;
?>