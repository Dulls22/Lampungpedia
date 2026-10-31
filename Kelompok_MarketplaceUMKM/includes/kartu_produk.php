<?php
// Komponen kartu produk. Variabel $p berisi satu baris produk.
?>
<article class="kartu">
    <div class="kartu-gambar"><?= e(mb_strtoupper(mb_substr($p['nama'], 0, 1))) ?></div>
    <div class="kartu-isi">
        <span class="label"><?= e($p['kategori']) ?></span>
        <h3><a href="detail_produk.php?id=<?= (int)$p['id'] ?>"><?= e($p['nama']) ?></a></h3>
        <p class="toko">oleh <?= e($p['nama_toko'] ?: $p['penjual']) ?></p>
        <p class="harga"><?= rupiah($p['harga']) ?></p>
    </div>
</article>
