<?php
require_once 'config/koneksi.php';
$judul = "Selamat Datang — Taking Order Cafe";
include 'includes/header.php';
?>
<div class="hero-surface min-h-[calc(100vh-4rem)]">
    <div class="max-w-7xl mx-auto px-6 py-16 md:py-24 relative">
        <div class="grid md:grid-cols-2 gap-12 items-center">

            <!-- Kiri -->
            <div class="text-cream">
                <div class="flex items-center gap-3 mb-8">
                    <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="Taking Order Cafe" class="brand-logo-lg">
                </div>
                <p class="text-soft-pink uppercase tracking-[0.3em] text-xs mb-4">Coffee · Kitchen · Since 2020</p>
                <h1 class="font-display text-4xl md:text-6xl leading-[1.08] mb-6">
                    Nikmati kopi<br>
                    <span class="text-soft-pink italic">terbaik</span><br>
                    di kota Anda.
                </h1>
                <p class="text-cream/80 text-base md:text-lg max-w-md mb-8 leading-relaxed">
                    Pesan langsung dari meja Anda. Cepat, mudah, dan tanpa antre.
                </p>
                <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-cream/90">
                    <span class="inline-flex items-center gap-2"><i class="bi bi-check-circle-fill text-soft-pink"></i> Tanpa antre</span>
                    <span class="inline-flex items-center gap-2"><i class="bi bi-check-circle-fill text-soft-pink"></i> Bahan segar</span>
                    <span class="inline-flex items-center gap-2"><i class="bi bi-check-circle-fill text-soft-pink"></i> Pelayanan cepat</span>
                </div>
            </div>

            <!-- Kanan: form -->
            <div class="bg-cream rounded-2xl p-8 md:p-10 shadow-2xl border border-soft-pink/40">
                <div class="mb-6">
                    <span class="chip chip--pink mb-3"><i class="bi bi-stars"></i> Selamat datang</span>
                    <h2 class="font-display text-2xl md:text-3xl text-deep-berry">Mulai pesanan Anda</h2>
                    <p class="text-sm text-wood-brown mt-2">Isi data diri terlebih dahulu untuk membuka menu.</p>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-rose-pink/15 border border-rose-pink/40 text-deep-berry px-4 py-3 rounded-lg mb-4 text-sm flex items-start gap-2" data-autohide>
                        <i class="bi bi-exclamation-circle-fill mt-0.5"></i>
                        <span><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?= htmlspecialchars(BASE_URL); ?>proses/simpan_pelanggan.php" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <i class="bi bi-person absolute left-3 top-1/2 -translate-y-1/2 text-wood-brown/70"></i>
                            <input type="text" name="nama" required placeholder="Masukkan nama Anda" class="input-base input-icon">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Nomor Meja</label>
                        <div class="relative">
                            <i class="bi bi-grid-3x3-gap absolute left-3 top-1/2 -translate-y-1/2 text-wood-brown/70"></i>
                            <input type="text" name="no_meja" required placeholder="Contoh: A01" class="input-base input-icon">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">No. HP <span class="normal-case text-wood-brown/60">(opsional)</span></label>
                        <div class="relative">
                            <i class="bi bi-telephone absolute left-3 top-1/2 -translate-y-1/2 text-wood-brown/70"></i>
                            <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" class="input-base input-icon">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block !py-3">
                        <i class="bi bi-arrow-right-circle"></i> Mulai Pesan
                    </button>
                </form>

                <div class="divider-orn my-6">atau</div>

                <a href="<?= htmlspecialchars(BASE_URL); ?>admin/login.php"
                   class="btn btn-ghost btn-block">
                    <i class="bi bi-shield-lock"></i> Masuk sebagai Admin
                </a>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>