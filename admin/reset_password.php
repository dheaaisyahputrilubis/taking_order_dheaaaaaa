<?php
require_once '../config/koneksi.php';
$hash = password_hash('admin123', PASSWORD_DEFAULT);
mysqli_query($koneksi, "UPDATE admin SET password='$hash' WHERE username='admin'");
echo "Password admin direset menjadi: <b>admin123</b><br>Hapus file ini setelah dijalankan.";
?>