<nav class="bg-deep-berry text-cream sticky top-0 z-40 border-b border-coffee/40">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="<?= htmlspecialchars(BASE_URL); ?>index.php" class="flex items-center gap-3">
            <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="Taking Order Cafe" class="brand-logo">
            <div class="leading-tight hidden sm:block">
                <span class="block font-display text-base">Taking Order Cafe</span>
                <span class="block text-[10px] uppercase tracking-widest text-soft-pink/90">Coffee · Kitchen</span>
            </div>
        </a>

        <div class="flex items-center gap-2">
            <?php if (isset($_SESSION['pelanggan_id'])): ?>
                <span class="hidden md:inline-flex items-center gap-2 text-sm text-cream/85 pe-3 border-e border-cream/20">
                    <i class="bi bi-person-circle text-soft-pink"></i>
                    <?= htmlspecialchars($_SESSION['pelanggan_nama']); ?>
                    <span class="text-cream/40">·</span>
                    <i class="bi bi-grid-3x3-gap"></i>
                    Meja <?= htmlspecialchars($_SESSION['pelanggan_meja']); ?>
                </span>
                <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/keranjang.php"
                   class="btn btn-primary btn-sm">
                    <i class="bi bi-cart-fill"></i>
                    Keranjang
                    <span class="bg-cream text-deep-berry rounded-full px-2 py-0.5 text-[11px] font-bold">
                        <?= isset($_SESSION['keranjang']) ? array_sum($_SESSION['keranjang']) : 0; ?>
                    </span>
                </a>
                <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/logout_pelanggan.php"
                   class="btn btn-ghost btn-sm !text-cream !border-cream/40 hover:!bg-cream/10">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="hidden sm:inline">Selesai</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>