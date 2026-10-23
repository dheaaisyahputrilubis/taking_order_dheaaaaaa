<?php
require_once '../config/koneksi.php';
if (isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/dashboard.php"); exit; }
$judul = "Login Admin";
include '../includes/header.php';
?>
<div class="hero-surface min-h-screen flex items-center px-6">
    <div class="max-w-md w-full mx-auto bg-cream rounded-2xl p-8 md:p-10 shadow-2xl border border-soft-pink/40">
        <div class="text-center mb-8">
            <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="Taking Order Cafe" class="brand-logo-lg mx-auto mb-4">
            <h1 class="font-display text-2xl text-deep-berry">Login Admin</h1>
            <p class="text-sm text-wood-brown mt-1">Akses panel manajemen cafe</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-rose-pink/15 border border-rose-pink/40 text-deep-berry px-4 py-3 rounded-lg mb-4 text-sm" data-autohide>
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars(BASE_URL); ?>admin/proses_login.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Username</label>
                <input type="text" name="username" required class="input-base">
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Password</label>
                <input type="password" name="password" required class="input-base">
            </div>
            <button type="submit" class="btn btn-primary btn-block !py-3">
                <i class="bi bi-box-arrow-in-right"></i> Masuk
            </button>
        </form>

        <a href="<?= htmlspecialchars(BASE_URL); ?>index.php" class="btn btn-ghost btn-block mt-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Halaman Pelanggan
        </a>
    </div>
</div>
<?php include '../includes/footer.php'; ?>