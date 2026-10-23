<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/login.php"); exit; }
$judul = "Laporan Order";

$tgl_awal  = $_GET['tgl_awal']  ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');
$ta = mysqli_real_escape_string($koneksi, $tgl_awal);
$tk = mysqli_real_escape_string($koneksi, $tgl_akhir);

$q = mysqli_query($koneksi, "SELECT o.*, p.nama FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             WHERE DATE(o.waktu_order) BETWEEN '$ta' AND '$tk'
                             ORDER BY o.waktu_order DESC");
$total_pendapatan = 0;
$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
    if ($row['status'] === 'selesai') $total_pendapatan += $row['total_harga'];
}
include '../includes/header.php';
include '../includes/admin_sidebar.php';
?>

<div class="mb-6">
    <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Analitik</p>
    <h1 class="font-display text-3xl text-deep-berry">Laporan Order</h1>
    <p class="text-sm text-wood-brown mt-1">Filter periode dan cetak laporan.</p>
</div>

<div class="bg-white rounded-2xl border border-soft-pink/50 p-5 mb-5">
    <form method="GET" class="grid md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Tanggal Awal</label>
            <input type="date" name="tgl_awal" value="<?= htmlspecialchars($tgl_awal); ?>" class="input-base">
        </div>
        <div>
            <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Tanggal Akhir</label>
            <input type="date" name="tgl_akhir" value="<?= htmlspecialchars($tgl_akhir); ?>" class="input-base">
        </div>
        <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
        <a href="<?= htmlspecialchars(BASE_URL); ?>admin/cetak_laporan.php?tgl_awal=<?= $tgl_awal; ?>&tgl_akhir=<?= $tgl_akhir; ?>"
           target="_blank" class="btn btn-outline"><i class="bi bi-printer"></i> Cetak</a>
    </form>
</div>

<div class="bg-deep-berry text-cream rounded-2xl p-6 mb-5 border border-coffee/20">
    <p class="text-xs uppercase tracking-widest text-soft-pink mb-2">Total Pendapatan · Order Selesai</p>
    <p class="font-display text-3xl md:text-4xl font-bold"><?= rupiah($total_pendapatan); ?></p>
    <p class="text-sm text-cream/70 mt-2"><?= count($data); ?> transaksi dalam periode ini</p>
</div>

<div class="bg-white rounded-2xl border border-soft-pink/50 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full table-clean">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th class="!text-center">Meja</th>
                    <th class="!text-right">Total</th>
                    <th class="!text-center">Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($data as $o): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><code class="text-xs"><?= htmlspecialchars($o['kode_order']); ?></code></td>
                    <td><?= htmlspecialchars($o['nama']); ?></td>
                    <td class="text-center"><?= htmlspecialchars($o['no_meja']); ?></td>
                    <td class="text-right font-semibold"><?= rupiah($o['total_harga']); ?></td>
                    <td class="text-center"><?= ucfirst($o['status']); ?></td>
                    <td class="text-wood-brown"><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data)): ?>
                <tr><td colspan="7" class="!text-center !py-10 !text-wood-brown">Tidak ada data pada periode ini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</main>
</div>
<?php include '../includes/footer.php'; ?>