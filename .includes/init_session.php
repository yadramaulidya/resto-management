<?php
session_start();

$userId = $_SESSION["user_id"];  
$nama = $_SESSION["nama"];

$notification = $_SESSION["notification"] ?? null;
if ($notification) {
    unset($_SESSION['notification']);
}

if (empty($_SESSION["user_id"])) {  
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Silakan Login Terlebih Dahulu!'
    ];
    header('Location: ./auth/login.php');  
    exit(); 
} //
?>