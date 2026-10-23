<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/login.php"); exit; }

$tgl_awal  = $_GET['tgl_awal']  ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');
$ta = mysqli_real_escape_string($koneksi, $tgl_awal);
$tk = mysqli_real_escape_string($koneksi, $tgl_akhir);

$q = mysqli_query($koneksi, "SELECT o.*, p.nama FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             WHERE DATE(o.waktu_order) BETWEEN '$ta' AND '$tk'
                             ORDER BY o.waktu_order ASC");
$total = 0; $data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
    if ($row['status'] === 'selesai') $total += $row['total_harga'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Order · Taking Order Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            @page { size: A4; margin: 15mm; }
            body { font-size: 11px; }
        }
        .num { font-variant-numeric: tabular-nums; }
    </style>
</head>
<body class="p-8 text-[#331A21] bg-white">
<div class="max-w-4xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between border-b-4 border-double border-[#8A2B43] pb-5 mb-6">
        <div class="flex items-center gap-4">
            <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="" style="height:56px;width:auto;">
            <div>
                <h1 class="text-xl font-bold text-[#8A2B43] tracking-wide">TAKING ORDER CAFE</h1>
                <p class="text-xs text-[#7A4B3A]">Jl. Contoh Alamat No. 123, Kota Anda</p>
                <p class="text-xs text-[#7A4B3A]">Telp: 021-1234567 · info@takingordercafe.com</p>
            </div>
        </div>
        <div class="text-right text-xs text-[#7A4B3A]">
            <p>Dicetak: <?= date('d/m/Y H:i'); ?></p>
        </div>
    </div>

    <h2 class="text-center text-lg font-bold mb-4 text-[#8A2B43]">LAPORAN ORDER</h2>
    <div class="text-xs mb-4 space-y-1">
        <p><strong>Periode:</strong> <?= date('d/m/Y', strtotime($tgl_awal)); ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)); ?></p>
    </div>

    <table class="w-full border-collapse text-xs">
        <thead>
            <tr class="bg-[#8A2B43] text-white">
                <th class="border border-[#8A2B43] px-2 py-1.5 text-center">No</th>
                <th class="border border-[#8A2B43] px-2 py-1.5 text-left">Kode Order</th>
                <th class="border border-[#8A2B43] px-2 py-1.5 text-left">Nama</th>
                <th class="border border-[#8A2B43] px-2 py-1.5 text-center">Meja</th>
                <th class="border border-[#8A2B43] px-2 py-1.5 text-right">Total</th>
                <th class="border border-[#8A2B43] px-2 py-1.5 text-center">Status</th>
                <th class="border border-[#8A2B43] px-2 py-1.5 text-center">Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr><td colspan="7" class="border border-[#7A4B3A] px-2 py-3 text-center">Tidak ada data.</td></tr>
            <?php else: $no=1; foreach ($data as $o): ?>
                <tr class="<?= $no % 2 === 0 ? 'bg-[#FFF5F7]' : 'bg-white'; ?>">
                    <td class="border border-[#7A4B3A] px-2 py-1.5 text-center num"><?= $no++; ?></td>
                    <td class="border border-[#7A4B3A] px-2 py-1.5"><?= htmlspecialchars($o['kode_order']); ?></td>
                    <td class="border border-[#7A4B3A] px-2 py-1.5"><?= htmlspecialchars($o['nama']); ?></td>
                    <td class="border border-[#7A4B3A] px-2 py-1.5 text-center"><?= htmlspecialchars($o['no_meja']); ?></td>
                    <td class="border border-[#7A4B3A] px-2 py-1.5 text-right num"><?= rupiah($o['total_harga']); ?></td>
                    <td class="border border-[#7A4B3A] px-2 py-1.5 text-center"><?= ucfirst($o['status']); ?></td>
                    <td class="border border-[#7A4B3A] px-2 py-1.5 text-center"><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <div class="mt-4 text-right font-bold text-[#8A2B43]">
        Total Pendapatan (Order Selesai): <?= rupiah($total); ?>
    </div>

    <div class="mt-12 text-right text-xs">
        <p>Kota Anda, <?= date('d/m/Y'); ?></p>
        <p class="mt-1">Administrator,</p>
        <p class="mt-16 inline-block border-t border-[#331A21] pt-1 px-8">
            <?= htmlspecialchars($_SESSION['admin_nama']); ?>
        </p>
    </div>
</div>

<script>
    window.onload = () => window.print();
    window.onafterprint = () => window.close();
</script>
</body>
</html>