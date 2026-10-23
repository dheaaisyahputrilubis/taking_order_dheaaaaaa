<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id']) || !isset($_SESSION['last_order_id'])) {
    header("Location: " . BASE_URL . "index.php"); exit;
}
$oid = (int)$_SESSION['last_order_id'];
$order = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT o.*, p.nama, p.no_hp FROM orders o
    JOIN pelanggan p ON o.pelanggan_id = p.id WHERE o.id = $oid"));
if (!$order) { header("Location: " . BASE_URL . "index.php"); exit; }
$qd = mysqli_query($koneksi, "SELECT * FROM order_detail WHERE order_id = $oid");
$detail = [];
while ($d = mysqli_fetch_assoc($qd)) $detail[] = $d;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk <?= htmlspecialchars($order['kode_order']); ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 72mm; margin: 0 auto; padding: 4mm; color: #331A21; }
        .center { text-align: center; }
        .divider { border-top: 1px dashed #7A4B3A; margin: 4px 0; }
        .row { display: flex; justify-content: space-between; }
        h2 { font-size: 13px; letter-spacing: 2px; color: #8A2B43; }
        .footer { text-align: center; margin-top: 8px; font-size: 10px; color: #7A4B3A; }
        @media print { body { width: 72mm; } @page { size: 80mm auto; margin: 0; } }
    </style>
</head>
<body>
    <div class="center">
        <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="" style="height:36px;width:auto;margin:0 auto 4px;">
        <h2>TAKING ORDER CAFE</h2>
        <p>Jl. Contoh Alamat No. 123</p>
        <p>Telp: 021-1234567</p>
    </div>
    <div class="divider"></div>
    <div class="row"><span>Kode</span><span><?= htmlspecialchars($order['kode_order']); ?></span></div>
    <div class="row"><span>Tanggal</span><span><?= date('d/m/Y H:i', strtotime($order['waktu_order'])); ?></span></div>
    <div class="row"><span>Nama</span><span><?= htmlspecialchars($order['nama']); ?></span></div>
    <div class="row"><span>Meja</span><span><?= htmlspecialchars($order['no_meja']); ?></span></div>
    <div class="divider"></div>
    <?php foreach ($detail as $d): ?>
        <div><?= htmlspecialchars($d['nama_menu']); ?></div>
        <div class="row">
            <span><?= $d['jumlah']; ?> x <?= number_format($d['harga'],0,',','.'); ?></span>
            <span><?= number_format($d['subtotal'],0,',','.'); ?></span>
        </div>
    <?php endforeach; ?>
    <div class="divider"></div>
    <div class="row"><strong>TOTAL</strong><strong><?= number_format($order['total_harga'],0,',','.'); ?></strong></div>
    <div class="row"><span>Status</span><span><?= ucfirst($order['status']); ?></span></div>
    <?php if (!empty($order['catatan'])): ?>
        <div class="divider"></div>
        <div>Catatan: <?= nl2br(htmlspecialchars($order['catatan'])); ?></div>
    <?php endif; ?>
    <div class="divider"></div>
    <div class="footer">
        <p>Terima kasih atas kunjungan Anda</p>
        <p>Selamat menikmati</p>
    </div>
    <script>
        window.onload = () => window.print();
        window.onafterprint = () => window.close();
    </script>
</body>
</html>