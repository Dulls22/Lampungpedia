<?php
$judul_halaman = 'Dashboard Penjual';
require_once 'includes/fungsi.php';
require_once 'includes/koneksi.php';
wajib_login('penjual');

$penjual_id = (int)$_SESSION['user_id'];
$errors = [];
$sukses = '';
$f = ['nama' => '', 'kategori_id' => '', 'harga' => '', 'stok' => '', 'deskripsi' => ''];

// Hapus produk milik sendiri (via $_GET)
if (isset($_GET['hapus'])) {
    $hid = (int)$_GET['hapus'];
    $del = $koneksi->prepare('DELETE FROM produk WHERE id = ? AND penjual_id = ?');
    $del->bind_param('ii', $hid, $penjual_id);
    $del->execute();
    $_SESSION['flash'] = 'Produk dihapus.';
    arahkan('dashboard.php');
}

// Tambah produk (via $_POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $f['nama'] = trim($_POST['nama'] ?? '');
    $f['kategori_id'] = (int)($_POST['kategori_id'] ?? 0);
    $f['harga'] = trim($_POST['harga'] ?? '');
    $f['stok'] = trim($_POST['stok'] ?? '');
    $f['deskripsi'] = trim($_POST['deskripsi'] ?? '');

    if (mb_strlen($f['nama']) < 3) {
        $errors[] = 'Nama produk minimal 3 karakter.';
    }
    if ($f['kategori_id'] < 1) {
        $errors[] = 'Pilih kategori.';
    }
    if (!ctype_digit($f['harga']) || (int)$f['harga'] <= 0) {
        $errors[] = 'Harga harus berupa angka lebih dari 0.';
    }
    if (!ctype_digit($f['stok'])) {
        $errors[] = 'Stok harus berupa angka (0 atau lebih).';
    }
    if ($f['deskripsi'] === '') {
        $errors[] = 'Deskripsi wajib diisi.';
    }

    if (!$errors) {
        $harga = (int)$f['harga'];
        $stok = (int)$f['stok'];
        $ins = $koneksi->prepare('INSERT INTO produk (penjual_id, kategori_id, nama, deskripsi, harga, stok) VALUES (?, ?, ?, ?, ?, ?)');
        $ins->bind_param('iissii', $penjual_id, $f['kategori_id'], $f['nama'], $f['deskripsi'], $harga, $stok);
        $ins->execute();
        $_SESSION['flash'] = 'Produk berhasil ditambahkan.';
        arahkan('dashboard.php');
    }
}

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

$kategori_list = $koneksi->query('SELECT * FROM kategori ORDER BY nama');
$produk = $koneksi->prepare(
    'SELECT p.*, k.nama AS kategori FROM produk p JOIN kategori k ON k.id = p.kategori_id
     WHERE p.penjual_id = ? ORDER BY p.id DESC'
);
$produk->bind_param('i', $penjual_id);
$produk->execute();
$daftar = $produk->get_result();

include 'includes/header.php';
?>
<h1>Dashboard Penjual</h1>
<p>Halo, <strong><?= e($_SESSION['nama']) ?></strong>. Kelola produk toko Anda di sini.</p>

<?php if ($flash): ?><div class="alert alert-ok"><?= e($flash) ?></div><?php endif; ?>

<div class="dua-kolom">
    <section class="form-card">
        <h2>Tambah Produk</h2>
        <?php if ($errors): ?>
            <div class="alert alert-error">
                <ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>
        <form method="post" novalidate>
            <label for="nama">Nama Produk</label>
            <input type="text" id="nama" name="nama" value="<?= e($f['nama']) ?>" required>

            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id" required>
                <option value="">-- Pilih --</option>
                <?php while ($k = $kategori_list->fetch_assoc()): ?>
                    <option value="<?= (int)$k['id'] ?>" <?= (int)$f['kategori_id'] === (int)$k['id'] ? 'selected' : '' ?>><?= e($k['nama']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="harga">Harga (Rp)</label>
            <input type="text" id="harga" name="harga" value="<?= e($f['harga']) ?>" inputmode="numeric" required>

            <label for="stok">Stok</label>
            <input type="text" id="stok" name="stok" value="<?= e($f['stok']) ?>" inputmode="numeric" required>

            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" required><?= e($f['deskripsi']) ?></textarea>

            <button type="submit" class="btn btn-penuh">Simpan Produk</button>
        </form>
    </section>

    <section>
        <h2>Produk Saya</h2>
        <div class="tabel-wrap">
            <table>
                <thead>
                    <tr><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php if ($daftar->num_rows > 0): ?>
                    <?php while ($r = $daftar->fetch_assoc()): ?>
                        <tr>
                            <td><?= e($r['nama']) ?></td>
                            <td><?= e($r['kategori']) ?></td>
                            <td><?= rupiah($r['harga']) ?></td>
                            <td><?= (int)$r['stok'] ?></td>
                            <td><a class="link-hapus" href="dashboard.php?hapus=<?= (int)$r['id'] ?>">Hapus</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">Belum ada produk.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php include 'includes/footer.php'; ?>
