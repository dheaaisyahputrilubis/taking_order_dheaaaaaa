<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/login.php"); exit; }
$judul = "Edit Menu";
$id = (int)($_GET['id'] ?? 0);
$m  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $id"));
if (!$m) { header("Location: " . BASE_URL . "admin/menu.php"); exit; }

$uploadDir = __DIR__ . '/../assets/uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $kat    = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga  = (float)$_POST['harga'];
    $desc   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $stok   = (int)$_POST['stok'];
    $status = $_POST['status'];
    $gambar = $m['gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp']) && $_FILES['gambar']['size'] <= 2*1024*1024) {
            $newName = 'menu_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $newName)) {
                if ($gambar && file_exists($uploadDir . $gambar)) unlink($uploadDir . $gambar);
                $gambar = $newName;
            }
        }
    }
    $gambarSql = $gambar ? "'$gambar'" : "NULL";
    $sql = "UPDATE menu SET nama_menu='$nama',kategori='$kat',harga=$harga,deskripsi='$desc',
            stok=$stok,status='$status',gambar=$gambarSql WHERE id=$id";
    if (mysqli_query($koneksi, $sql)) {
        $_SESSION['pesan'] = "Menu berhasil diperbarui.";
        header("Location: " . BASE_URL . "admin/menu.php"); exit;
    }
}
include '../includes/header.php';
include '../includes/admin_sidebar.php';
?>

<div class="max-w-3xl">
    <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Katalog</p>
    <h1 class="font-display text-3xl text-deep-berry mb-1">Edit Menu</h1>
    <p class="text-sm text-wood-brown mb-6">Perbarui detail produk.</p>

    <div class="bg-white rounded-2xl border border-soft-pink/50 p-6 md:p-8">
        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Nama Menu</label>
                    <input type="text" name="nama_menu" required value="<?= htmlspecialchars($m['nama_menu']); ?>" class="input-base">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Kategori</label>
                    <input type="text" name="kategori" required value="<?= htmlspecialchars($m['kategori']); ?>" class="input-base">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Harga (Rp)</label>
                    <input type="number" name="harga" required value="<?= $m['harga']; ?>" class="input-base">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Stok</label>
                    <input type="number" name="stok" required value="<?= $m['stok']; ?>" class="input-base">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Status</label>
                    <select name="status" class="input-base">
                        <option value="tersedia" <?= $m['status']==='tersedia'?'selected':''; ?>>Tersedia</option>
                        <option value="habis"    <?= $m['status']==='habis'?'selected':''; ?>>Habis</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Gambar Produk</label>
                    <input type="file" name="gambar" accept="image/*"
                        class="w-full text-sm border border-soft-pink/60 rounded-lg p-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-rose-pink file:text-cream file:font-semibold hover:file:bg-deep-berry">
                </div>
            </div>

            <div>
                <p class="text-[11px] uppercase tracking-widest text-wood-brown/80 mb-2">Gambar saat ini</p>
                <img id="previewGambar" src="<?= gambarMenu($m['gambar']); ?>" alt=""
                     class="w-40 h-40 object-cover rounded-xl border border-soft-pink/50">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="input-base"><?= htmlspecialchars($m['deskripsi']); ?></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                <a href="<?= htmlspecialchars(BASE_URL); ?>admin/menu.php" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>

</main>
</div>
<?php include '../includes/footer.php'; ?>