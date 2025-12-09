<?php
require_once '../koneksi.php';

if(!isset($_GET['id'])) {
    header("Location: kelola_sosmed_dosen.php?error=ID tidak ditemukan");
    exit();
}

$id = pg_escape_string($conn, $_GET['id']);

// Ambil data sosmed berdasarkan ID
$query = "SELECT * FROM sosmed_dosen WHERE id_sosmed_dosen = '$id'";
$result = pg_query($conn, $query);

if(pg_num_rows($result) == 0) {
    header("Location: kelola_sosmed_dosen.php?error=Data tidak ditemukan");
    exit();
}

$data = pg_fetch_assoc($result);

// Ambil daftar dosen
$query_dosen = "SELECT id_profil_dosen, nama_dosen FROM profil_dosen ORDER BY nama_dosen";
$dosen_list = pg_query($conn, $query_dosen);

if(isset($_POST['submit'])) {
    $id_dosen = pg_escape_string($conn, $_POST['id_profil_dosen']);
    $nama_sosmed = pg_escape_string($conn, $_POST['nama_sosmed_dsn']);
    $url = pg_escape_string($conn, $_POST['url_sosmed_dosen']);
    $icon = pg_escape_string($conn, $_POST['icon_sosmed']);

    $update = "UPDATE sosmed_dosen SET 
               id_profil_dosen = '$id_dosen',
               nama_sosmed_dsn = '$nama_sosmed',
               url_sosmed_dosen = '$url',
               icon_sosmed = '$icon'
               WHERE id_sosmed_dosen = '$id'";

    if(pg_query($conn, $update)) {
        header("Location: kelola_sosmed_dosen.php?success=edit");
        exit();
    } else {
        $error = "Gagal mengupdate data: " . pg_last_error($conn);
    }
}
?>
