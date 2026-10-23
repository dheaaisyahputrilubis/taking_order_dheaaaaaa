<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/login.php"); exit; }
$id = (int)($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st = mysqli_real_escape_string($koneksi, $_POST['status']);
    mysqli_query($koneksi, "UPDATE orders SET status='$st' WHERE id=$id");
    $_SESSION['pesan'] = "Status order berhasil diperbarui.";
    header("Location: " . BASE_URL . "admin/order_detail.php?id=$id"); exit;
}

$judul = "Detail Order";
$o = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT o.*, p.nama, p.no_hp FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id WHERE o.id = $id"));
if (!$o) { header("Location: " . BASE_URL . "admin/order.php"); exit; }
$qd = mysqli_query($koneksi, "SELECT * FROM order_detail WHERE order_id = $id");
include '../includes/header.php';
include '../includes/admin_sidebar.php';
?>

<a href="<?= htmlspecialchars(BASE_URL); ?>admin/order.php" class="inline-flex items-center gap-1 text-wood-brown hover:text-rose-pink text-sm mb-4">
    <i class="bi bi-arrow-left"></i> Kembali
</a>

<div class="mb-6">
    <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Transaksi</p>
    <h1 class="font-display text-3xl text-deep-berry">Detail Order</h1>
    <p class="text-sm text-wood-brown mt-1"><code><?= htmlspecialchars($o['kode_order']); ?></code></p>
</div>

<?php if (isset($_SESSION['pesan'])): ?>
    <div class="chip chip--ok !block !w-auto !rounded-lg !px-4 !py-3 mb-4" data-autohide>
        <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
    </div>
<?php endif; ?>

<div class="grid md:grid-cols-5 gap-5">
    <div class="md:col-span-2 space-y-5">
        <div class="card-base p-5">
            <h3 class="font-display text-lg text-deep-berry mb-3">Informasi Pelanggan</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-wood-brown">Nama</dt><dd class="font-semibold"><?= htmlspecialchars($o['nama']); ?></dd></div>
                <div class="flex justify-between"><dt class="text-wood-brown">No. HP</dt><dd><?= htmlspecialchars($o['no_hp'] ?: '-'); ?></dd></div>
                <div class="flex justify-between"><dt class="text-wood-brown">Meja</dt><dd><?= htmlspecialchars($o['no_meja']); ?></dd></div>
                <div class="flex justify-between"><dt class="text-wood-brown">Waktu</dt><dd><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></dd></div>
                <div class="flex justify-between gap-3"><dt class="text-wood-brown shrink-0">Catatan</dt><dd class="text-right"><?= htmlspecialchars($o['catatan'] ?: '-'); ?></dd></div>
            </dl>
        </div>
        <div class="card-base p-5">
            <h3 class="font-display text-lg text-deep-berry mb-3">Update Status</h3>
            <form method="POST" class="space-y-3">
                <select name="status" class="input-base">
                    <?php foreach (['pending','diproses','selesai','dibatalkan'] as $s): ?>
                        <option value="<?= $s; ?>" <?= $o['status']===$s?'selected':''; ?>><?= ucfirst($s); ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-primary btn-block"><i class="bi bi-save"></i> Simpan</button>
            </form>
        </div>
    </div>

    <div class="md:col-span-3">
        <div class="bg-white rounded-2xl border border-soft-pink/50 overflow-hidden">
            <div class="px-5 py-4 border-b border-soft-pink/50">
                <h3 class="font-display text-lg text-deep-berry">Rincian Item</h3>
            </div>
            <table class="w-full table-clean">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th class="!text-right">Harga</th>
                        <th class="!text-center">Qty</th>
                        <th class="!text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($d = mysqli_fetch_assoc($qd)): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['nama_menu']); ?></td>
                        <td class="text-right"><?= rupiah($d['harga']); ?></td>
                        <td class="text-center"><?= $d['jumlah']; ?></td>
                        <td class="text-right font-semibold"><?= rupiah($d['subtotal']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="!text-right">Total</td>
                        <td class="!text-right text-deep-berry"><?= rupiah($o['total_harga']); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

</main>
</div>
<?php include '../includes/footer.php'; ?>