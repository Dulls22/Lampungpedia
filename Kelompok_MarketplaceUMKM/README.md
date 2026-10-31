# Pasar UMKM - Marketplace UMKM

Tugas Akhir Pemrograman Web (progress). Dibuat dengan HTML, CSS, dan PHP native + MySQL (tanpa JavaScript dan framework).

## Cara menjalankan (XAMPP / Laragon)
1. Salin folder ini ke `htdocs` (XAMPP) atau `www` (Laragon).
2. Nyalakan Apache dan MySQL.
3. Buka phpMyAdmin, lalu import `database/marketplace_umkm.sql` (database `marketplace_umkm` dibuat otomatis).
4. Cek `includes/koneksi.php` bila user/password MySQL berbeda dari default (`root`, kosong).
5. Buka `http://localhost/Kelompok_MarketplaceUMKM/`.

## Akun contoh (password: `password123`)
- Penjual: penjual@contoh.com
- Pembeli: pembeli@contoh.com

## Struktur folder
```
Kelompok_MarketplaceUMKM/
├── index.php            Beranda (produk terbaru, pencarian)
├── produk.php           Daftar produk + filter kategori/pencarian ($_GET)
├── detail_produk.php    Detail satu produk
├── register.php         Pendaftaran (validasi server, password_hash)
├── login.php            Masuk (session)
├── logout.php           Keluar
├── dashboard.php        Dashboard penjual: tambah dan hapus produk
├── kontak.php           Form kontak (disimpan ke database)
├── css/style.css        Seluruh gaya (Flexbox, Grid, media query)
├── img/                 Aset gambar
├── includes/            header, navbar, footer, kartu_produk, koneksi, fungsi
└── database/marketplace_umkm.sql
```

## Fitur yang sudah berfungsi
- Beranda, daftar produk dengan pencarian dan filter, detail produk
- Register, login, logout (session, password terenkripsi)
- Dashboard penjual: tambah dan hapus produk milik sendiri
- Form kontak tersimpan ke database
- Tampilan responsif (desktop dan mobile)

## Rencana pengembangan
- Upload gambar produk, edit produk, keranjang dan pesanan, ulasan, dashboard admin
