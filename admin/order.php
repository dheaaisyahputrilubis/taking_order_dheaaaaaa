<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/login.php"); exit; }
$judul = "Data Order";

$filter = $_GET['status'] ?? '';
$where = "";
if ($filter !== '') {
    $f = mysqli_real_escape_string($koneksi, $filter);
    $where = "WHERE o.status = '$f'";
}
$q = mysqli_query($koneksi, "SELECT o.*, p.nama FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             $where ORDER BY o.waktu_order DESC");
include '../includes/header.php';
include '../includes/admin_sidebar.php';

$statuses = ['' => 'Semua', 'pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
?>

<div class="mb-6">
    <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Transaksi</p>
    <h1 class="font-display text-3xl text-deep-berry">Data Order</h1>
    <p class="text-sm text-wood-brown mt-1">Daftar semua pesanan masuk.</p>
</div>

<div class="flex flex-wrap gap-2 mb-5">
    <?php foreach ($statuses as $s => $label):
        $active = $filter === $s;
        $href = BASE_URL . 'admin/order.php' . ($s ? '?status=' . urlencode($s) : '');
    ?>
    <a href="<?= htmlspecialchars($href); ?>"
       class="btn btn-sm <?= $active ? 'btn-dark' : 'btn-ghost'; ?>">
        <?= $label; ?>
    </a>
    <?php endforeach; ?>
</div>

<div class="bg-white rounded-2xl border border-soft-pink/50 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full table-clean">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th class="!text-center">Meja</th>
                    <th class="!text-right">Total</th>
                    <th class="!text-center">Status</th>
                    <th>Waktu</th>
                    <th class="!text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($o = mysqli_fetch_assoc($q)):
                    $badge = [
                        'pending'    => '<span class="chip chip--warn">Pending</span>',
                        'diproses'   => '<span class="chip chip--info">Diproses</span>',
                        'selesai'    => '<span class="chip chip--ok">Selesai</span>',
                        'dibatalkan' => '<span class="chip chip--bad">Dibatalkan</span>',
                    ][$o['status']] ?? '<span class="chip chip--brown">' . ucfirst($o['status']) . '</span>';
                ?>
                <tr>
                    <td><code class="text-xs bg-soft-pink/30 px-2 py-1 rounded"><?= htmlspecialchars($o['kode_order']); ?></code></td>
                    <td><?= htmlspecialchars($o['nama']); ?></td>
                    <td class="text-center"><?= htmlspecialchars($o['no_meja']); ?></td>
                    <td class="text-right font-semibold text-deep-berry"><?= rupiah($o['total_harga']); ?></td>
                    <td class="text-center"><?= $badge; ?></td>
                    <td class="text-wood-brown"><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></td>
                    <td class="text-center">
                        <a href="<?= htmlspecialchars(BASE_URL); ?>admin/order_detail.php?id=<?= $o['id']; ?>"
                           class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-soft-pink/40 text-deep-berry hover:bg-deep-berry hover:text-cream transition">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if (mysqli_num_rows($q) === 0): ?>
                <tr><td colspan="7" class="!text-center !py-10 !text-wood-brown">Tidak ada data order.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</main>
</div>
<?php include '../includes/footer.php'; ?>