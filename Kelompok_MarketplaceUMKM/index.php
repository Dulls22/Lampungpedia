<?php
$judul_halaman = 'Beranda';
include 'includes/header.php';

$sql = "SELECT p.*, k.nama AS kategori, u.nama AS penjual, u.nama_toko
        FROM produk p
        JOIN kategori k ON k.id = p.kategori_id
        JOIN users u ON u.id = p.penjual_id
        ORDER BY p.created_at DESC, p.id DESC LIMIT 8";
$hasil = $koneksi->query($sql);
?>
<section class="hero">
    <h1>Belanja Produk Asli UMKM Lokal</h1>
    <p>Temukan makanan, fashion, kerajinan, dan banyak lagi langsung dari pelaku usaha di sekitar Anda.</p>
    <form action="produk.php" method="get" class="form-cari">
        <input type="text" name="q" placeholder="Cari produk, misalnya kopi atau tapis" aria-label="Cari produk">
        <button type="submit" class="btn">Cari</button>
    </form>
</section>

<section>
    <h2>Produk Terbaru</h2>
    <div class="grid-produk">
        <?php if ($hasil && $hasil->num_rows > 0): ?>
            <?php while ($p = $hasil->fetch_assoc()): ?>
                <?php include 'includes/kartu_produk.php'; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada produk.</p>
        <?php endif; ?>
    </div>
    <p class="tengah"><a href="produk.php" class="btn btn-garis">Lihat Semua Produk</a></p>
</section>

<section class="fitur">
    <div><h3>Dukung UMKM</h3><p>Setiap pembelian membantu usaha lokal tumbuh.</p></div>
    <div><h3>Mudah Berjualan</h3><p>Penjual dapat menambah produk lewat dashboard.</p></div>
    <div><h3>Aman dan Sederhana</h3><p>Akun terlindungi dengan password terenkripsi.</p></div>
</section>
<?php include 'includes/footer.php'; ?>
