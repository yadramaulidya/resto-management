<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $kontak = $_POST['kontak'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username sudah ada
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error_message'] = "Username sudah digunakan!";
        header("Location: register.php");
        exit();
    }

    // Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan data pengguna baru ke dalam tabel users
    $insert_query = "INSERT INTO users (kontak, nama, username, password, role) 
                     VALUES ('$kontak', '$nama', '$username', '$hashed_password', 'pelanggan')";
    
    if (mysqli_query($conn, $insert_query)) {
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