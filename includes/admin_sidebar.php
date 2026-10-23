<?php
$current = basename($_SERVER['PHP_SELF']);
$menuItems = [
    'dashboard.php' => ['bi-grid-1x2-fill',        'Dashboard'],
    'menu.php'      => ['bi-cup-hot-fill',         'Kelola Menu'],
    'order.php'     => ['bi-receipt',              'Data Order'],
    'laporan.php'   => ['bi-file-earmark-text-fill','Laporan'],
    'profil.php'    => ['bi-person-fill',          'Profil Saya'],
];
?>
<header class="bg-deep-berry text-cream sticky top-0 z-40 border-b border-coffee/40">
    <div class="max-w-full mx-auto px-6 h-16 flex items-center justify-between">
        <a href="<?= htmlspecialchars(BASE_URL); ?>admin/dashboard.php" class="flex items-center gap-3">
            <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="Taking Order Cafe" class="brand-logo">
            <div class="leading-tight hidden sm:block">
                <span class="block font-display text-base">Admin Panel</span>
                <span class="block text-[10px] uppercase tracking-widest text-soft-pink/90">Taking Order Cafe</span>
            </div>
        </a>
        <div class="flex items-center gap-2">
            <span class="hidden md:inline-flex items-center gap-2 text-sm text-cream/85 pe-3 border-e border-cream/20">
                <i class="bi bi-person-circle text-soft-pink"></i>
                <?= htmlspecialchars($_SESSION['admin_nama']); ?>
            </span>
            <a href="<?= htmlspecialchars(BASE_URL); ?>admin/logout.php"
               class="btn btn-ghost btn-sm !text-cream !border-cream/40 hover:!bg-cream/10">
                <i class="bi bi-box-arrow-right"></i>
                <span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </div>
</header>

<div class="flex min-h-[calc(100vh-64px)]">
    <aside class="w-64 bg-white border-e border-soft-pink/40 hidden md:flex flex-col">
        <div class="p-5">
            <p class="text-[11px] uppercase tracking-widest text-wood-brown/80 mb-3">Navigasi</p>
            <ul class="space-y-1">
                <?php foreach ($menuItems as $file => [$icon, $label]):
                    $active = $current === $file;
                ?>
                <li>
                    <a href="<?= htmlspecialchars(BASE_URL); ?>admin/<?= $file; ?>"
                       class="side-item <?= $active ? 'is-active' : ''; ?>">
                        <i class="bi <?= $icon; ?>"></i>
                        <span><?= $label; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="mt-auto p-5 border-t border-soft-pink/40">
            <a href="<?= htmlspecialchars(BASE_URL); ?>index.php" target="_blank"
               class="btn btn-outline btn-block btn-sm">
                <i class="bi bi-box-arrow-up-right"></i> Lihat Situs
            </a>
        </div>
    </aside>
    <main class="flex-1 p-6 md:p-8 bg-cream">