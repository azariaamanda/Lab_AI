<?php
session_start();
require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Ambil nama file gambar sebelum menghapus data dari DB
    $query_select = "SELECT gambar_fasilitas FROM fasilitas WHERE id_fasilitas = $1";
    $result_select = pg_query_params($conn, $query_select, [$id]);

    if ($result_select && pg_num_rows($result_select) > 0) {
        $fasilitas = pg_fetch_assoc($result_select);
        $gambar_file = $fasilitas['gambar_fasilitas'];

        // Hapus data dari database
        $query_delete = "DELETE FROM fasilitas WHERE id_fasilitas = $1";
        $result_delete = pg_query_params($conn, $query_delete, [$id]);

        if ($result_delete) {
            // Hapus file gambar dari server
            $file_path = '../img/fasilitas/' . $gambar_file;
            if (!empty($gambar_file) && file_exists($file_path)) {
                unlink($file_path);
            }
            $_SESSION['message'] = 'Fasilitas berhasil dihapus.';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Gagal menghapus fasilitas: ' . pg_last_error($conn);
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Fasilitas tidak ditemukan.';
        $_SESSION['message_type'] = 'error';
    }
}

header('Location: kelola_fasilitas.php');
exit;