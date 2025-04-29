<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // bil data dari form
    $kontak = $_POST['kontak'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username sudah ada
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error_message'] = "Username sudah digunakan!";
        header("Location: register.php");
        exit();
    }

    // enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_query = "INSERT INTO users (kontak, nama, username, password, role) 
                     VALUES (?, ?, ?, ?, 'pelanggan')";
    $stmt_insert = $conn->prepare($insert_query);
    $stmt_insert->bind_param("ssss", $kontak, $nama, $username, $hashed_password);

    if ($stmt_insert->execute()) {
        $_SESSION['success_message'] = "Pendaftaran berhasil! Silakan login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Terjadi kesalahan saat mendaftar!";
        header("Location: register.php");
        exit();
    }
}
?>