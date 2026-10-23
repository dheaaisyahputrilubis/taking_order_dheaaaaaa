<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) { header("Location: " . BASE_URL . "index.php"); exit; }
$judul = "Keranjang — Taking Order Cafe";
include '../includes/header.php';
include '../includes/navbar.php';

$keranjang = $_SESSION['keranjang'] ?? [];
$total = 0;
?>

<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="mb-6">
        <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Pesanan</p>
        <h1 class="font-display text-4xl text-deep-berry">Keranjang Pesanan</h1>
    </div>

    <?php if (empty($keranjang)): ?>
        <div class="bg-white border border-soft-pink/60 rounded-2xl p-12 text-center">
            <i class="bi bi-cart-x text-5xl text-rose-pink/70 mb-3"></i>
            <p class="text-wood-brown mb-4">Keranjang masih kosong.</p>
            <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/menu.php" class="btn btn-primary">
                <i class="bi bi-cup-hot"></i> Lihat Menu
            </a>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-2xl border border-soft-pink/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-clean">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th class="!text-right">Harga</th>
                            <th class="!text-center">Jumlah</th>
                            <th class="!text-right">Subtotal</th>
                            <th class="!text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($keranjang as $mid => $jml):
                            $m = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $mid"));
                            if (!$m) continue;
                            $sub = $m['harga'] * $jml;
                            $total += $sub;
                        ?>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="<?= gambarMenu($m['gambar']); ?>" class="w-12 h-12 object-cover rounded-lg border border-soft-pink/50" alt="">
                                    <span class="font-semibold"><?= htmlspecialchars($m['nama_menu']); ?></span>
                                </div>
                            </td>
                            <td class="text-right"><?= rupiah($m['harga']); ?></td>
                            <td>
                                <form action="<?= htmlspecialchars(BASE_URL); ?>proses/update_keranjang.php" method="POST" class="flex items-center justify-center gap-1">
                                    <input type="hidden" name="menu_id" value="<?= $mid; ?>">
                                    <input type="number" name="jumlah" value="<?= $jml; ?>" min="1" max="<?= $m['stok']; ?>"
                                           class="input-base !w-16 !px-2 !py-1 text-sm text-center">
                                    <button class="w-7 h-7 inline-flex items-center justify-center bg-soft-pink/40 text-deep-berry rounded-md hover:bg-rose-pink hover:text-cream transition" title="Update">
                                        <i class="bi bi-arrow-repeat text-xs"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-right font-bold text-deep-berry"><?= rupiah($sub); ?></td>
                            <td class="text-center">
                                <a href="<?= htmlspecialchars(BASE_URL); ?>proses/hapus_keranjang.php?id=<?= $mid; ?>"
                                   class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-rose-pink/20 text-deep-berry hover:bg-deep-berry hover:text-cream transition">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="!text-right">Total</td>
                            <td colspan="2" class="!text-right font-display !text-xl !text-deep-berry"><?= rupiah($total); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between gap-3 mt-6">
            <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/menu.php" class="btn btn-outline">
                <i class="bi bi-arrow-left"></i> Lanjut Pesan
            </a>
            <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/checkout.php" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Checkout
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>