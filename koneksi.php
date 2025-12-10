<?php
    $host = 'localhost';
    $port = '5432';
    $dbname = 'LAB AI';
    $user = 'postgres';
    $pass = 'gampangbanget';

    $conn = pg_connect("host=$host port=$port dbname='$dbname' user=$user password=$pass");
    if(!$conn){
        die("Koneksi gagal.");
    }
?>