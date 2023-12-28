<!-- Trang logout.php -->
<?php
session_start();

// Hủy bỏ tất cả các biến session
$_SESSION = array();

// Hủy bỏ session
session_destroy();

// Chuyển hướng về trang đăng nhập hoặc trang chính
header("location: index.php");
exit();
?>
