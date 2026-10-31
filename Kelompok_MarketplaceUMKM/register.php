<?php
$judul_halaman = 'Daftar';
require_once 'includes/fungsi.php';
require_once 'includes/koneksi.php';

if (sudah_login()) {
    arahkan('index.php');
}

$errors = [];
$nama = $email = $role = $nama_toko = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $konfirmasi = $_POST['konfirmasi'] ?? '';
    $role = $_POST['role'] ?? '';
    $nama_toko = trim($_POST['nama_toko'] ?? '');

    // Validasi sisi server
    if ($nama === '' || mb_strlen($nama) < 3) {
        $errors[] = 'Nama minimal 3 karakter.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }
    if ($password !== $konfirmasi) {
        $errors[] = 'Konfirmasi password tidak sama.';
    }
    if (!in_array($role, ['pembeli', 'penjual'], true)) {
        $errors[] = 'Pilih jenis akun.';
    }
    if ($role === 'penjual' && $nama_toko === '') {
        $errors[] = 'Nama toko wajib diisi untuk penjual.';
    }

    // Cek email sudah dipakai
    if (!$errors) {
        $cek = $koneksi->prepare('SELECT id FROM users WHERE email = ?');
        $cek->bind_param('s', $email);
        $cek->execute();
        if ($cek->get_result()->num_rows > 0) {
            $errors[] = 'Email sudah terdaftar.';
        }
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $toko = $role === 'penjual' ? $nama_toko : null;
        $ins = $koneksi->prepare('INSERT INTO users (nama, email, password, role, nama_toko) VALUES (?, ?, ?, ?, ?)');
        $ins->bind_param('sssss', $nama, $email, $hash, $role, $toko);
        if ($ins->execute()) {
            $_SESSION['flash'] = 'Pendaftaran berhasil. Silakan masuk.';
            arahkan('login.php');
        }
        $errors[] = 'Terjadi kesalahan, coba lagi.';
    }
}

include 'includes/header.php';
?>
<section class="form-card">
    <h1>Buat Akun</h1>

    <?php if ($errors): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" novalidate>
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="<?= e($nama) ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="konfirmasi">Konfirmasi Password</label>
        <input type="password" id="konfirmasi" name="konfirmasi" required>

        <label for="role">Daftar sebagai</label>
        <select id="role" name="role" required>
            <option value="">-- Pilih --</option>
            <option value="pembeli" <?= $role === 'pembeli' ? 'selected' : '' ?>>Pembeli</option>
            <option value="penjual" <?= $role === 'penjual' ? 'selected' : '' ?>>Penjual (pelaku UMKM)</option>
        </select>

        <label for="nama_toko">Nama Toko <small>(khusus penjual)</small></label>
        <input type="text" id="nama_toko" name="nama_toko" value="<?= e($nama_toko) ?>">

        <button type="submit" class="btn btn-penuh">Daftar</button>
    </form>
    <p class="tengah">Sudah punya akun? <a href="login.php">Masuk</a></p>
</section>
<?php include 'includes/footer.php'; ?>
