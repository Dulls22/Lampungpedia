<?php
// Koneksi database (sesuaikan dengan XAMPP/Laragon Anda)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_LampungPedia';

mysqli_report(MYSQLI_REPORT_OFF);
$koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($koneksi->connect_error) {
    die('Koneksi database gagal. Pastikan MySQL aktif dan file database/marketplace_umkm.sql sudah diimport.');
}
$koneksi->set_charset('utf8mb4');
