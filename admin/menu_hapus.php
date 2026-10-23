<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . BASE_URL . "admin/login.php"); exit; }

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: " . BASE_URL . "admin/menu.php"); exit; }

$cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) j FROM order_detail WHERE menu_id = $id"))['j'];
if ($cek > 0) {
    mysqli_query($koneksi, "UPDATE menu SET status='habis' WHERE id=$id");
    $_SESSION['pesan'] = "Menu tidak bisa dihapus karena sudah pernah dipesan. Status diubah menjadi 'habis'.";
    header("Location: " . BASE_URL . "admin/menu.php"); exit;
}

$m = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT gambar FROM menu WHERE id = $id"));
if ($m && $m['gambar']) {
    $file = __DIR__ . '/../assets/uploads/' . $m['gambar'];
    if (file_exists($file)) unlink($file);
}
mysqli_query($koneksi, "DELETE FROM menu WHERE id = $id");
$_SESSION['pesan'] = "Menu berhasil dihapus.";
header("Location: " . BASE_URL . "admin/menu.php");
?>