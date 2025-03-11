<?php
session_start();
// Ambil data dari sesi
$userId = $_SESSION["pelanggan_id"];
$nama = $_SESSION["nama"];
$kontak = $_SESSION["kontak"];
// Ambil notifikasi jika ada, kemudian hapus dari sesi
$notification = $_SESSION["notification"] ?? null;
if ($notification) {
    unset($_SESSION['notification']);
}
/* Periksa apakah sesi username dan role sudah ada,
jika tidak arahkan ke halaman login */
if (empty($_SESSION["kontak"])) {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Silakan Login Terlebih Dahulu!'
    ];
    header('Location: ./auth/login.php');
    exit(); // Pastikan script berhenti setelah pengalihan
}