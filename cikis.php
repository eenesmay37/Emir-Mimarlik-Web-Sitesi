<?php
session_start();
session_destroy(); // Oturumu tamamen yok et (Ziyaretçi kartını yırt)
header("Location: login.php"); // Giriş sayfasına geri yolla
?>