<?php
function nav_link($file, $label, $aktif)
{
    $kelas = ($file === $aktif) ? ' class="aktif"' : '';
    echo '<li><a href="' . $file . '"' . $kelas . '>' . $label . '</a></li>';
}
?>
<input type="checkbox" id="menu-toggle" class="menu-toggle">
<label for="menu-toggle" class="menu-icon" aria-label="Buka menu">&#9776;</label>
<nav class="navbar">
    <ul>
        <?php
        nav_link('index.php', 'Beranda', $halaman_aktif);
        nav_link('produk.php', 'Produk', $halaman_aktif);
        nav_link('kontak.php', 'Kontak', $halaman_aktif);
        if (sudah_login()) {
            if ($_SESSION['role'] === 'penjual') {
                nav_link('dashboard.php', 'Dashboard', $halaman_aktif);
            }
            echo '<li><a href="logout.php" class="btn btn-kecil">Keluar (' . e($_SESSION['nama']) . ')</a></li>';
        } else {
            nav_link('login.php', 'Masuk', $halaman_aktif);
            echo '<li><a href="register.php" class="btn btn-kecil">Daftar</a></li>';
        }
        ?>
    </ul>
</nav>
