<?php
require_once('.includes/init_session.php');
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $kontak = $_POST["kontak"];
    $nama = $_POST["nama"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Hash password untuk keamanan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = "pelanggan";  // Set role menjadi pelanggan

    // Pastikan form tidak kosong (validasi)
    if (empty($kontak) || empty($nama) || empty($username) || empty($password)) {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Semua kolom harus diisi!'
        ];
        header('Location: register.php');
        exit();
    }

    // Gunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("INSERT INTO users (kontak, nama, username, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $kontak, $nama, $username, $hashedPassword, $role);

    // Eksekusi query dan periksa hasilnya
    if ($stmt->execute()) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Registrasi Berhasil!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal Registrasi: ' . $stmt->error
        ];
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();

    // Redirect ke login setelah selesai
    header('Location: login.php');
    exit();
}

// Tutup koneksi jika tidak ada form yang dikirim
$conn->close();
?>