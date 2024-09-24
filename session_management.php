<?php
// Cek apakah session belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$timeout_duration = 1800; // 30 menit = 1800 detik

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Cek waktu terakhir aktivitas
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();     // Hapus data session
    session_destroy();   // Hancurkan session
    header('Location: login.php?timeout=true'); // Redirect ke halaman login dengan pesan timeout
    exit;
}

// Perbarui waktu aktivitas terakhir
$_SESSION['last_activity'] = time();
?>
