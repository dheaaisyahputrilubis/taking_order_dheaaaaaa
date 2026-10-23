<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) { header("Location: " . BASE_URL . "index.php"); exit; }
$keranjang = $_SESSION['keranjang'] ?? [];
if (empty($keranjang)) { header("Location: " . BASE_URL . "pelanggan/keranjang.php"); exit; }

$total = 0;
foreach ($keranjang as $mid => $jml) {
    $m = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT harga FROM menu WHERE id = $mid"));
    if ($m) $total += $m['harga'] * $jml;
}
$judul = "Checkout — Taking Order Cafe";
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Langkah Akhir</p>
        <h1 class="font-display text-4xl text-deep-berry">Konfirmasi Pesanan</h1>
    </div>

    <div class="grid md:grid-cols-5 gap-5">
        <div class="md:col-span-3 space-y-5">
            <div class="card-base p-6">
                <h3 class="font-display text-lg text-deep-berry mb-3">Data Pelanggan</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-wood-brown">Nama</dt><dd class="font-semibold"><?= htmlspecialchars($_SESSION['pelanggan_nama']); ?></dd></div>
                    <div class="flex justify-between"><dt class="text-wood-brown">No. Meja</dt><dd class="font-semibold"><?= htmlspecialchars($_SESSION['pelanggan_meja']); ?></dd></div>
                </dl>
            </div>

            <form action="<?= htmlspecialchars(BASE_URL); ?>proses/simpan_order.php" method="POST">
                <div class="card-base p-6">
                    <h3 class="font-display text-lg text-deep-berry mb-3">Catatan Tambahan</h3>
                    <textarea name="catatan" rows="3" placeholder="Contoh: tanpa gula, extra shot, dll (opsional)" class="input-base"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block !py-3 mt-5">
                    <i class="bi bi-send-check"></i> Kirim Pesanan
                </button>
            </form>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl border border-soft-pink/50 overflow-hidden">
                <div class="px-5 py-4 border-b border-soft-pink/50">
                    <h3 class="font-display text-lg text-deep-berry">Rincian Pesanan</h3>
                </div>
                <div class="p-5">
                    <?php foreach ($keranjang as $mid => $jml):
                        $m = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $mid"));
                        if (!$m) continue;
                    ?>
                    <div class="flex justify-between text-sm mb-2">
                        <span><?= htmlspecialchars($m['nama_menu']); ?> <span class="text-wood-brown/70">&times; <?= $jml; ?></span></span>
                        <span class="font-semibold"><?= rupiah($m['harga'] * $jml); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="border-t border-soft-pink/50 mt-3 pt-3 flex justify-between items-center">
                        <span class="font-bold">Total</span>
                        <span class="font-display text-2xl font-bold text-deep-berry"><?= rupiah($total); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>