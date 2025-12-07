<?php
// session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }

require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Ambil data untuk pesan konfirmasi
    $query_select = "SELECT nama_navbar FROM navbar WHERE id_navbar = $id";
    $result_select = pg_query($conn, $query_select);
    
    if ($result_select && pg_num_rows($result_select) > 0) {
        $navbar = pg_fetch_assoc($result_select);
        $nama_navbar = $navbar['nama_navbar'];
        
        // Hapus data menggunakan stored procedure
        try {
            $query_delete = "CALL sp_delete_navbar($id)";
            $result_delete = pg_query($conn, $query_delete);
            
            if ($result_delete) {
                $_SESSION['message'] = "Menu '$nama_navbar' berhasil dihapus";
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Gagal menghapus menu: ' . pg_last_error($conn);
                $_SESSION['message_type'] = 'error';
            }
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Menu navbar tidak ditemukan';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'ID menu tidak valid';
    $_SESSION['message_type'] = 'error';
}

// Redirect kembali ke halaman navbar
header('Location:kelola_navbar.php');
exit;
?>