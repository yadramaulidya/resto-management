<?php
// Pastikan sesi hanya dimulai jika belum aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION["user_id"] ?? null;  
$nama = $_SESSION["nama"] ?? null; 

$notification = $_SESSION["notification"] ?? null;
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