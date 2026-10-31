<?php
require_once __DIR__ . '/fungsi.php';
require_once __DIR__ . '/koneksi.php';
$judul_halaman = $judul_halaman ?? 'Beranda';
$halaman_aktif = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($judul_halaman) ?> | Pasar UMKM</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="logo">Pasar<span>UMKM</span></a>
        <?php include __DIR__ . '/navbar.php'; ?>
    </div>
</header>
<main class="container">
