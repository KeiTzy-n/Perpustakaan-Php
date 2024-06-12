<?php
// Mulai sesi
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Hapus cookie remember_me jika ada
if (isset($_COOKIE['remember_me'])) {
    // Hapus cookie
    setcookie('remember_me', '', time() - 3600, '/');
}

// Redirect ke halaman login
header("Location: ../login2.php");
exit;
?>