<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/login.php"); exit; }
$judul = "Profil Admin";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];
    $admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE id = {$_SESSION['admin_id']}"));

    if (!password_verify($old, $admin['password'])) {
        $_SESSION['pesan_err'] = "Password lama salah.";
    } elseif (strlen($new) < 6) {
        $_SESSION['pesan_err'] = "Password baru minimal 6 karakter.";
    } elseif ($new !== $confirm) {
        $_SESSION['pesan_err'] = "Konfirmasi password tidak cocok.";
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE admin SET password='$hash' WHERE id={$_SESSION['admin_id']}");
        $_SESSION['pesan'] = "Password berhasil diubah.";
    }
    header("Location: " . BASE_URL . "admin/profil.php"); exit;
}
include '../includes/header.php';
include '../includes/admin_sidebar.php';
?>

<div class="max-w-2xl">
    <p class="text-xs uppercase tracking-widest text-wood-brown/80 mb-1">Akun</p>
    <h1 class="font-display text-3xl text-deep-berry mb-1">Profil Admin</h1>
    <p class="text-sm text-wood-brown mb-6">Kelola akun administrator Anda.</p>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="chip chip--ok !block !w-auto !rounded-lg !px-4 !py-3 mb-4" data-autohide>
            <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['pesan_err'])): ?>
        <div class="chip chip--bad !block !w-auto !rounded-lg !px-4 !py-3 mb-4" data-autohide>
            <?= $_SESSION['pesan_err']; unset($_SESSION['pesan_err']); ?>
        </div>
    <?php endif; ?>

    <div class="card-base p-6 mb-5">
        <div class="flex items-center gap-4">
            <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="" class="brand-logo">
            <div>
                <p class="text-xs uppercase tracking-widest text-wood-brown/80">Administrator</p>
                <p class="font-display text-lg text-deep-berry"><?= htmlspecialchars($_SESSION['admin_nama']); ?></p>
            </div>
        </div>
    </div>

    <div class="card-base p-6">
        <h3 class="font-display text-lg text-deep-berry mb-4">Ubah Password</h3>
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Password Lama</label>
                <input type="password" name="old_password" required class="input-base">
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Password Baru</label>
                <input type="password" name="new_password" required minlength="6" class="input-base">
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-wood-brown mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" required minlength="6" class="input-base">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

</main>
</div>
<?php include '../includes/footer.php'; ?>