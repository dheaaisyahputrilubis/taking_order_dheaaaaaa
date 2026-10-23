<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/login.php"); exit; }
$judul = "Dashboard Admin";

$total_menu   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) j FROM menu"))['j'];
$total_order  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) j FROM orders"))['j'];
$total_pending= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) j FROM orders WHERE status='pending'"))['j'];
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(total_harga),0) j FROM orders WHERE status='selesai'"))['j'];

include '../includes/header.php';
include '../includes/admin_sidebar.php';

$cards = [
    ['Total Menu',     $total_menu,               'bi-cup-hot-fill',  'bg-deep-berry'],
    ['Total Order',    $total_order,              'bi-receipt',       'bg-wood-brown'],
    ['Order Pending',  $total_pending,            'bi-clock-fill',    'bg-rose-pink'],
    ['Pendapatan',     rupiah($total_pendapatan), 'bi-cash-stack',    'bg-coffee'],
];
?>

<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 mb-8">
    <div>
        <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Ringkasan</p>
        <h1 class="font-display text-3xl text-deep-berry">Dashboard</h1>
        <p class="text-sm text-wood-brown mt-1">Selamat datang kembali, <?= htmlspecialchars($_SESSION['admin_nama']); ?>.</p>
    </div>
    <a href="<?= htmlspecialchars(BASE_URL); ?>admin/menu_tambah.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Menu
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <?php foreach ($cards as [$label, $value, $icon, $bg]): ?>
        <div class="<?= $bg; ?> text-cream rounded-2xl p-5 border border-coffee/20">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs uppercase tracking-widest text-cream/75"><?= $label; ?></span>
                <i class="bi <?= $icon; ?> text-xl text-soft-pink"></i>
            </div>
            <div class="font-display text-2xl md:text-3xl font-bold"><?= $value; ?></div>
        </div>
    <?php endforeach; ?>
</div>

<div class="mt-8 grid lg:grid-cols-3 gap-4">
    <a href="<?= htmlspecialchars(BASE_URL); ?>admin/order.php" class="card-base p-5 block">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-widest text-wood-brown/80">Order</p>
                <p class="font-display text-lg text-deep-berry mt-1">Kelola pesanan</p>
            </div>
            <i class="bi bi-receipt text-2xl text-rose-pink"></i>
        </div>
    </a>
    <a href="<?= htmlspecialchars(BASE_URL); ?>admin/menu.php" class="card-base p-5 block">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-widest text-wood-brown/80">Menu</p>
                <p class="font-display text-lg text-deep-berry mt-1">Daftar produk</p>
            </div>
            <i class="bi bi-cup-hot-fill text-2xl text-rose-pink"></i>
        </div>
    </a>
    <a href="<?= htmlspecialchars(BASE_URL); ?>admin/laporan.php" class="card-base p-5 block">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-widest text-wood-brown/80">Laporan</p>
                <p class="font-display text-lg text-deep-berry mt-1">Statistik pendapatan</p>
            </div>
            <i class="bi bi-file-earmark-text-fill text-2xl text-rose-pink"></i>
        </div>
    </a>
</div>

</main>
</div>
<?php include '../includes/footer.php'; ?>