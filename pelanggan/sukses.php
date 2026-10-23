<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id']) || !isset($_SESSION['last_order_id'])) {
    header("Location: " . BASE_URL . "index.php"); exit;
}
$oid = (int)$_SESSION['last_order_id'];
$order = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT o.*, p.nama, p.no_hp FROM orders o
                                                    JOIN pelanggan p ON o.pelanggan_id = p.id
                                                    WHERE o.id = $oid"));
if (!$order) { header("Location: " . BASE_URL . "index.php"); exit; }
$qdetail = mysqli_query($koneksi, "SELECT * FROM order_detail WHERE order_id = $oid");
$detail = [];
while ($d = mysqli_fetch_assoc($qdetail)) $detail[] = $d;

$judul = "Struk Pesanan — Taking Order Cafe";
include '../includes/header.php';
?>

<div class="max-w-md mx-auto px-6 py-10">
    <div class="text-center mb-6 no-print">
        <div class="w-16 h-16 bg-soft-pink/40 text-deep-berry rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="bi bi-check-circle-fill text-3xl"></i>
        </div>
        <h1 class="font-display text-2xl text-deep-berry">Pesanan Berhasil</h1>
        <p class="text-wood-brown text-sm">Tunjukkan struk ini ke kasir atau pelayan.</p>
    </div>

    <div class="struk-wrapper">
        <div class="text-center mb-2">
            <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="" style="height:36px;width:auto;margin:0 auto 6px;">
            <h2 class="font-bold tracking-widest text-deep-berry text-sm">TAKING ORDER CAFE</h2>
            <p class="text-[11px] text-wood-brown">Jl. Contoh Alamat No. 123, Kota Anda</p>
            <p class="text-[11px] text-wood-brown">Telp: 021-1234567</p>
        </div>

        <div class="struk-divider mt-2">================================</div>
        <div class="space-y-0.5">
            <div class="row-line"><span>Kode Order</span><span><?= htmlspecialchars($order['kode_order']); ?></span></div>
            <div class="row-line"><span>Tanggal</span><span><?= date('d/m/Y H:i', strtotime($order['waktu_order'])); ?></span></div>
            <div class="row-line"><span>Nama</span><span><?= htmlspecialchars($order['nama']); ?></span></div>
            <div class="row-line"><span>No. Meja</span><span><?= htmlspecialchars($order['no_meja']); ?></span></div>
            <?php if ($order['no_hp']): ?>
                <div class="row-line"><span>No. HP</span><span><?= htmlspecialchars($order['no_hp']); ?></span></div>
            <?php endif; ?>
        </div>

        <div class="struk-divider mt-2">================================</div>
        <div class="space-y-1">
            <?php foreach ($detail as $d): ?>
                <div class="text-sm font-semibold mt-1"><?= htmlspecialchars($d['nama_menu']); ?></div>
                <div class="row-line">
                    <span><?= $d['jumlah']; ?> &times; <?= number_format($d['harga'], 0, ',', '.'); ?></span>
                    <span><?= number_format($d['subtotal'], 0, ',', '.'); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="struk-divider mt-2">================================</div>
        <div class="row-line total-line"><span>TOTAL</span><span><?= rupiah($order['total_harga']); ?></span></div>
        <div class="row-line"><span>Status</span><span><?= ucfirst($order['status']); ?></span></div>

        <?php if (!empty($order['catatan'])): ?>
            <div class="struk-divider mt-1">--------------------------------</div>
            <div class="text-sm">
                <div class="font-semibold">Catatan:</div>
                <div><?= nl2br(htmlspecialchars($order['catatan'])); ?></div>
            </div>
        <?php endif; ?>

        <div class="struk-divider mt-2">================================</div>
        <div class="text-center text-[11px] mt-2 text-wood-brown">
            <p>Terima kasih atas kunjungan Anda</p>
            <p>Selamat menikmati</p>
        </div>
    </div>

    <div class="text-center mt-6 no-print flex flex-col sm:flex-row gap-2 justify-center">
        <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/struk_cetak.php" target="_blank" class="btn btn-outline">
            <i class="bi bi-printer"></i> Cetak Struk
        </a>
        <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/menu.php" class="btn btn-outline">
            <i class="bi bi-plus-circle"></i> Order Lagi
        </a>
        <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/logout_pelanggan.php" class="btn btn-dark">
            <i class="bi bi-box-arrow-right"></i> Selesai
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>