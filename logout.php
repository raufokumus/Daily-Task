<?php
session_start();

// Oturumu sonlandır
session_destroy();

// Index sayfasına yönlendir
header("Location: index.php");
exit();
?>
