<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) { header("Location: " . BASE_URL . "index.php"); exit; }
$judul = "Menu — Taking Order Cafe";

$kf = $_GET['kategori'] ?? '';
$where = "WHERE status = 'tersedia'";
if ($kf !== '') {
    $kfe = mysqli_real_escape_string($koneksi, $kf);
    $where .= " AND kategori = '$kfe'";
}
$query = mysqli_query($koneksi, "SELECT * FROM menu $where ORDER BY kategori, nama_menu");
$kategori_list = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM menu ORDER BY kategori");
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Katalog Menu</p>
            <h1 class="font-display text-4xl text-deep-berry">Menu Cafe</h1>
            <p class="text-sm text-wood-brown mt-1">Pilih menu favorit Anda.</p>
        </div>
        <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/keranjang.php" class="btn btn-primary">
            <i class="bi bi-cart-fill"></i> Lihat Keranjang
        </a>
    </div>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="chip chip--ok !block !w-auto !rounded-lg !px-4 !py-3 mb-5" data-autohide>
            <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
        </div>
    <?php endif; ?>

    <div class="flex flex-wrap gap-2 mb-8">
        <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/menu.php"
           class="btn btn-sm <?= $kf==='' ? 'btn-dark' : 'btn-ghost'; ?>">Semua</a>
        <?php while ($k = mysqli_fetch_assoc($kategori_list)): ?>
            <a href="<?= htmlspecialchars(BASE_URL); ?>pelanggan/menu.php?kategori=<?= urlencode($k['kategori']); ?>"
               class="btn btn-sm <?= $kf===$k['kategori'] ? 'btn-dark' : 'btn-ghost'; ?>">
                <?= htmlspecialchars($k['kategori']); ?>
            </a>
        <?php endwhile; ?>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <?php if (mysqli_num_rows($query) === 0): ?>
            <div class="col-span-full bg-white border border-soft-pink/60 rounded-xl p-10 text-center text-wood-brown">
                <i class="bi bi-inbox text-4xl mb-2 text-rose-pink"></i>
                <p>Belum ada menu tersedia.</p>
            </div>
        <?php endif; ?>
        <?php while ($m = mysqli_fetch_assoc($query)): ?>
            <article class="menu-card">
                <div class="menu-card__img">
                    <img src="<?= gambarMenu($m['gambar']); ?>" alt="<?= htmlspecialchars($m['nama_menu']); ?>">
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <span class="chip chip--pink self-start mb-2"><?= htmlspecialchars($m['kategori']); ?></span>
                    <h3 class="font-display text-lg text-deep-berry leading-tight"><?= htmlspecialchars($m['nama_menu']); ?></h3>
                    <p class="text-sm text-wood-brown/80 mt-1 mb-3 line-clamp-2"><?= htmlspecialchars($m['deskripsi']); ?></p>
                    <div class="mt-auto">
                        <p class="font-bold text-rose-pink text-lg mb-1"><?= rupiah($m['harga']); ?></p>
                        <p class="text-xs text-wood-brown/70 mb-3">Stok: <?= $m['stok']; ?></p>
                        <form action="<?= htmlspecialchars(BASE_URL); ?>proses/tambah_keranjang.php" method="POST" class="flex gap-2">
                            <input type="hidden" name="menu_id" value="<?= $m['id']; ?>">
                            <input type="number" name="jumlah" value="1" min="1" max="<?= $m['stok']; ?>" class="input-base !w-16 !px-2 !py-1.5 text-sm text-center">
                            <button type="submit" class="btn btn-primary btn-sm flex-1 !py-1.5">
                                <i class="bi bi-plus-circle"></i> Tambah
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>