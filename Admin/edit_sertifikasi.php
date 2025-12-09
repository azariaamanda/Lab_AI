<?php
require_once '../koneksi.php';

// ================= CEK PARAMETER ID =================
if(!isset($_GET['id'])) {
    header("Location: kelola_sertifikasi.php?error=ID tidak ditemukan");
    exit();
}

// Escape dari MySQL → PostgreSQL
$id = pg_escape_string($conn, $_GET['id']);

$query = "SELECT * FROM sertifikasi_dosen WHERE id_sertifikasi = '$id'";
$result = pg_query($conn, $query);

if(pg_num_rows($result) == 0) {
    header("Location: kelola_sertifikasi.php?error=Data tidak ditemukan");
    exit();
}

$data = pg_fetch_assoc($result);

// ================= AMBIL LIST DOSEN =================
$query_dosen = "SELECT id_profil_dosen, nama_dosen FROM profil_dosen ORDER BY nama_dosen";
$dosen_list = pg_query($conn, $query_dosen);

// ================= UPDATE DATA =================
if(isset($_POST['submit'])) {

    $id_dosen = pg_escape_string($conn, $_POST['id_profil_dosen']);
    $nama_sertifikasi = pg_escape_string($conn, $_POST['nama_sertifikasi']);
    $institusi = pg_escape_string($conn, $_POST['institusi_penerbit']);
    $tahun_terbit = pg_escape_string($conn, $_POST['tahun_terbit']);
    $tahun_kadaluarsa = pg_escape_string($conn, $_POST['tahun_kadaluarsa']);

    $query = "UPDATE sertifikasi_dosen SET 
                id_profil_dosen = '$id_dosen',
                nama_sertifikasi = '$nama_sertifikasi',
                institusi_penerbit = '$institusi',
                tahun_terbit = '$tahun_terbit',
                tahun_kadaluarsa = ".($tahun_kadaluarsa != '' ? "'$tahun_kadaluarsa'" : "NULL")."
              WHERE id_sertifikasi = '$id'";

    if(pg_query($conn, $query)) {
        header("Location: kelola_sertifikasi.php?success=edit");
        exit();
    } else {
        $error = "Gagal update: " . pg_last_error($conn);
    }
}
?>
