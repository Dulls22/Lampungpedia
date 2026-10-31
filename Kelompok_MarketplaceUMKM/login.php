<?php
$judul_halaman = 'Masuk';
require_once 'includes/fungsi.php';
require_once 'includes/koneksi.php';

if (sudah_login()) {
    arahkan('index.php');
}

$errors = [];
$email = '';
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Email dan password wajib diisi.';
    } else {
        $stmt = $koneksi->prepare('SELECT id, nama, password, role FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];
            arahkan($user['role'] === 'penjual' ? 'dashboard.php' : 'index.php');
        }
        $errors[] = 'Email atau password salah.';
    }
}

include 'includes/header.php';
?>
<section class="form-card">
    <h1>Masuk</h1>

    <?php if ($flash): ?><div class="alert alert-ok"><?= e($flash) ?></div><?php endif; ?>
    <?php if ($errors): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" novalidate>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn btn-penuh">Masuk</button>
    </form>
    <p class="tengah">Belum punya akun? <a href="register.php">Daftar</a></p>
    <p class="catatan">Akun contoh penjual: penjual@contoh.com / password123</p>
</section>
<?php include 'includes/footer.php'; ?>
