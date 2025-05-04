<?php
// Pastikan sesi hanya dimulai jika belum aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// cek jika user_id ada di sesi, jika tidak arahkan ke login
$userId = $_SESSION["user_id"] ?? null;  
$nama = $_SESSION["nama"] ?? null; 

// Mengambil dan menyimpan notifikasi jika ada
$notification = $_SESSION["notification"] ?? null;

// Periksa jika sesi user_id kosong, arahkan ke halaman login
if (empty($userId)) {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Silakan Login Terlebih Dahulu!'
    ];
    header('Location: ./auth/login.php');
    exit();
}

if ($notification) {
    unset($_SESSION['notification']);
}
?>