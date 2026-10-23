<?php
/**
 * Konfigurasi global: base URL & helper logo.
 * Dipakai oleh header/footer/navbar agar path aset konsisten.
 */
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/taking_order_dheaaaaaa/');
}

/**
 * Cari file logo brand di folder /assets/ dengan ekstensi yang didukung.
 * Return path lengkap (dengan BASE_URL). Fallback ke ikon SVG inline bila tidak ditemukan.
 */
function logoSrc(): string {
    static $cache = null;
    if ($cache !== null) return $cache;

    $exts = ['png', 'jpg', 'jpeg', 'svg', 'webp'];
    foreach ($exts as $ext) {
        $rel  = 'assets/logo_brand.' . $ext;
        $abs  = __DIR__ . '/../' . $rel;
        if (file_exists($abs)) {
            return $cache = BASE_URL . $rel;
        }
    }
    // Fallback: SVG inline bertema Deep Berry
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64">'
         . '<circle cx="32" cy="32" r="30" fill="#8A2B43"/>'
         . '<path d="M20 26h20v12a6 6 0 0 1-6 6h-8a6 6 0 0 1-6-6z" fill="#F7B5CA"/>'
         . '<path d="M40 30h3a3 3 0 1 1 0 6h-3" stroke="#F7B5CA" stroke-width="2" fill="none"/>'
         . '</svg>';
    return $cache = 'data:image/svg+xml;base64,' . base64_encode($svg);
}

/**
 * Helper URL aset supaya konsisten.
 */
function asset(string $path): string {
    return BASE_URL . ltrim($path, '/');
}
?>