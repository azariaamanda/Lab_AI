<?php
require_once '../koneksi. php';

$id = $_GET['id'] ?? '';

if (!$id) {
    header('Location: kelola_layanan.php');
    exit;
}

try {
    $query = "CALL sp_delete_layanan(:id)";
    $stmt = $koneksi->prepare($query);
    $stmt->execute([':id' => $id]);
    
    header('Location: kelola_layanan.php? success=Data berhasil dihapus');
    exit;
} catch (PDOException $e) {
    header('Location: kelola_layanan.php?error=' . urlencode($e->getMessage()));
    exit;
}
?>