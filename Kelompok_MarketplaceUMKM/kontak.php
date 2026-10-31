<?php
$judul_halaman = 'Kontak';
require_once 'includes/fungsi.php';
require_once 'includes/koneksi.php';

$errors = [];
$sukses = false;
$nama = $email = $pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    if ($nama === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }
    if (mb_strlen($pesan) < 10) {
        $errors[] = 'Pesan minimal 10 karakter.';
    }

    if (!$errors) {
        $ins = $koneksi->prepare('INSERT INTO pesan_kontak (nama, email, pesan) VALUES (?, ?, ?)');
        $ins->bind_param('sss', $nama, $email, $pesan);
        $ins->execute();
        $sukses = true;
        $nama = $email = $pesan = '';
    }
}

include 'includes/header.php';
?>
<section class="form-card">
    <h1>Hubungi Kami</h1>
    <p>Punya pertanyaan atau ingin bergabung sebagai penjual? Kirim pesan di bawah ini.</p>

    <?php if ($sukses): ?><div class="alert alert-ok">Pesan berhasil dikirim. Terima kasih!</div><?php endif; ?>
    <?php if ($errors): ?>
        <div class="alert alert-error">
            <ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post" novalidate>
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?= e($nama) ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" required>

        <label for="pesan">Pesan</label>
        <textarea id="pesan" name="pesan" rows="5" required><?= e($pesan) ?></textarea>

        <button type="submit" class="btn btn-penuh">Kirim Pesan</button>
    </form>
</section>
<?php include 'includes/footer.php'; ?>
