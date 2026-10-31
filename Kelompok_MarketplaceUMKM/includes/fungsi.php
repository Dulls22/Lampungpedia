<?php
// Fungsi bantu yang dipakai di banyak halaman

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Escape output agar aman dari XSS
function e($teks)
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

// Format rupiah
function rupiah($angka)
{
    return 'Rp ' . number_format((int)$angka, 0, ',', '.');
}

function sudah_login()
{
    return isset($_SESSION['user_id']);
}

// Wajib login, jika belum diarahkan ke halaman login
function wajib_login($role = null)
{
    if (!sudah_login()) {
        header('Location: login.php');
        exit;
    }
    if ($role !== null && $_SESSION['role'] !== $role) {
        header('Location: index.php');
        exit;
    }
}

function arahkan($url)
{
    header('Location: ' . $url);
    exit;
}
