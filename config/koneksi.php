<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config.php';

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_cafe";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
mysqli_set_charset($koneksi, "utf8mb4");
date_default_timezone_set('Asia/Jakarta');

function rupiah($angka) {
    return "Rp " . number_format((float)$angka, 0, ',', '.');
}

function generateKodeOrder() {
    return "ORD-" . date("YmdHis") . "-" . rand(100, 999);
}

/**
 * URL gambar menu; fallback ke SVG placeholder bertema palet.
 */
function gambarMenu($filename) {
    if ($filename && file_exists(__DIR__ . '/../assets/uploads/' . $filename)) {
        return BASE_URL . 'assets/uploads/' . $filename;
    }
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300">'
         . '<rect width="400" height="300" fill="#FFF5F7"/>'
         . '<circle cx="200" cy="130" r="50" fill="#F7B5CA"/>'
         . '<text x="200" y="230" text-anchor="middle" font-family="sans-serif" font-size="16" fill="#8A2B43">No Image</text>'
         . '</svg>';
    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}
?>