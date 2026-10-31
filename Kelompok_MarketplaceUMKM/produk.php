<?php
$judul_halaman = 'Produk';
include 'includes/header.php';

// Ambil filter dari URL ($_GET)
$q = trim($_GET['q'] ?? '');
$kat = (int)($_GET['kategori'] ?? 0);

$kategori_list = $koneksi->query("SELECT * FROM kategori ORDER BY nama");

$sql = "SELECT p.*, k.nama AS kategori, u.nama AS penjual, u.nama_toko
        FROM produk p
        JOIN kategori k ON k.id = p.kategori_id
        JOIN users u ON u.id = p.penjual_id
        WHERE (p.nama LIKE ? OR p.deskripsi LIKE ?)";
$cari = '%' . $q . '%';
if ($kat > 0) {
    $sql .= " AND p.kategori_id = ?";
}
$sql .= " ORDER BY p.created_at DESC, p.id DESC";

$stmt = $koneksi->prepare($sql);
if ($kat > 0) {
    $stmt->bind_param('ssi', $cari, $cari, $kat);
} else {
    $stmt->bind_param('ss', $cari, $cari);
}
$stmt->execute();
$hasil = $stmt->get_result();
?>
<h1>Daftar Produk</h1>

<form method="get" class="filter">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari produk..." aria-label="Cari produk">
    <select name="kategori" aria-label="Kategori">
        <option value="0">Semua Kategori</option>
        <?php while ($k = $kategori_list->fetch_assoc()): ?>
            <option value="<?= (int)$k['id'] ?>" <?= $kat === (int)$k['id'] ? 'selected' : '' ?>><?= e($k['nama']) ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit" class="btn">Terapkan</button>
</form>

<div class="grid-produk">
    <?php if ($hasil->num_rows > 0): ?>
        <?php while ($p = $hasil->fetch_assoc()): ?>
            <?php include 'includes/kartu_produk.php'; ?>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Produk tidak ditemukan.</p>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
