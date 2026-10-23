<?php
// admin/logout.php
session_start();
session_destroy();
header("Location: http://localhost/taking_order_dheaaaaaa/admin/login.php");
exit;
?>