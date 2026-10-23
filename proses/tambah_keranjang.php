<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) { header("Location: ../index.php"); exit; }
$menu_id = (int)($_POST['menu_id'] ?? 0);
$jumlah  = max(1, (int)($_POST['jumlah'] ?? 1));

$menu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $menu_id AND status = 'tersedia'"));
if (!$menu) {
    $_SESSION['pesan'] = "Menu tidak ditemukan.";
    header("Location: ../pelanggan/menu.php"); exit;
}

if ($jumlah > $menu['stok']) $jumlah = $menu['stok'];
if (!isset($_SESSION['keranjang'])) $_SESSION['keranjang'] = [];
$cur = $_SESSION['keranjang'][$menu_id] ?? 0;
$_SESSION['keranjang'][$menu_id] = min($cur + $jumlah, $menu['stok']);

$_SESSION['pesan'] = $menu['nama_menu'] . " ditambahkan ke keranjang.";
header("Location: ../pelanggan/menu.php");
exit;
?>