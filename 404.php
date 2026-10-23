<?php
http_response_code(404);
require_once 'config/koneksi.php';
$judul = "Halaman Tidak Ditemukan";
include 'includes/header.php';
?>
<div class="min-h-screen flex items-center justify-center px-6">
    <div class="text-center max-w-md">
        <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="" class="brand-logo-lg mx-auto mb-6 opacity-90">
        <p class="chip chip--pink mb-4">404</p>
        <h1 class="font-display text-5xl text-deep-berry mb-3">Halaman hilang.</h1>
        <p class="text-wood-brown mb-8">Sepertinya halaman yang Anda cari tidak tersedia.</p>
        <a href="<?= htmlspecialchars(BASE_URL); ?>index.php" class="btn btn-primary">
            <i class="bi bi-house-door"></i> Kembali ke Beranda
        </a>
    </div>
</div>
<?php include 'includes/footer.php'; ?>