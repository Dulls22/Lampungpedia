<?php
$judul_halaman = 'Detail Produk';
include 'includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $koneksi->prepare(
    "SELECT p.*, k.nama AS kategori, u.nama AS penjual, u.nama_toko
     FROM produk p
     JOIN kategori k ON k.id = p.kategori_id
     JOIN users u ON u.id = p.penjual_id
     WHERE p.id = ?"
);
$stmt->bind_param('i', $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
?>
<?php if (!$p): ?>
    <div class="alert alert-error">Produk tidak ditemukan.</div>
    <a href="produk.php" class="btn btn-garis">Kembali ke Produk</a>
<?php else: ?>
    <a href="produk.php" class="kembali">&larr; Kembali</a>
    <section class="detail">
        <div class="detail-gambar"><?= e(mb_strtoupper(mb_substr($p['nama'], 0, 1))) ?></div>
        <div class="detail-info">
            <span class="label"><?= e($p['kategori']) ?></span>
            <h1><?= e($p['nama']) ?></h1>
            <p class="harga besar"><?= rupiah($p['harga']) ?></p>
            <p>Stok: <strong><?= (int)$p['stok'] ?></strong></p>
            <p>Dijual oleh <strong><?= e($p['nama_toko'] ?: $p['penjual']) ?></strong></p>
            <h3>Deskripsi</h3>
            <p><?= nl2br(e($p['deskripsi'])) ?></p>
            <a href="kontak.php" class="btn">Hubungi Penjual</a>
        </div>
    </section>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
