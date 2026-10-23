<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/login.php"); exit; }
$judul = "Kelola Menu";
$q = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY kategori, nama_menu");
include '../includes/header.php';
include '../includes/admin_sidebar.php';
?>

<div class="flex items-end justify-between mb-6">
    <div>
        <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Katalog</p>
        <h1 class="font-display text-3xl text-deep-berry">Kelola Menu</h1>
        <p class="text-sm text-wood-brown mt-1">Perbarui daftar produk cafe Anda.</p>
    </div>
    <a href="<?= htmlspecialchars(BASE_URL); ?>admin/menu_tambah.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Menu
    </a>
</div>

<?php if (isset($_SESSION['pesan'])): ?>
    <div class="chip chip--ok !block !w-auto !rounded-lg !px-4 !py-3 mb-5" data-autohide>
        <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-soft-pink/50 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full table-clean">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th class="!text-right">Harga</th>
                    <th class="!text-center">Stok</th>
                    <th class="!text-center">Status</th>
                    <th class="!text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($m = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td>
                        <img src="<?= gambarMenu($m['gambar']); ?>" alt=""
                             class="w-14 h-14 object-cover rounded-lg border border-soft-pink/60">
                    </td>
                    <td class="font-semibold"><?= htmlspecialchars($m['nama_menu']); ?></td>
                    <td><span class="chip chip--pink"><?= htmlspecialchars($m['kategori']); ?></span></td>
                    <td class="text-right font-semibold text-deep-berry"><?= rupiah($m['harga']); ?></td>
                    <td class="text-center"><?= $m['stok']; ?></td>
                    <td class="text-center">
                        <?php if ($m['status'] === 'tersedia'): ?>
                            <span class="chip chip--ok">Tersedia</span>
                        <?php else: ?>
                            <span class="chip chip--bad">Habis</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="<?= htmlspecialchars(BASE_URL); ?>admin/menu_edit.php?id=<?= $m['id']; ?>"
                               class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-soft-pink/40 text-deep-berry hover:bg-deep-berry hover:text-cream transition">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= htmlspecialchars(BASE_URL); ?>admin/menu_hapus.php?id=<?= $m['id']; ?>"
                               data-confirm="Hapus menu ini? Tindakan tidak bisa dibatalkan."
                               class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-rose-pink/20 text-deep-berry hover:bg-deep-berry hover:text-cream transition">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</main>
</div>
<?php include '../includes/footer.php'; ?>