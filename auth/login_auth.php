<?php
session_start();
require_once("../config.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    
    $stmt = $conn->prepare("SELECT user_id, nama, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);  
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password menggunakan password_verify
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama'] = $user['nama'];

            // Redirect ke dashboard
            header("Location: ../dashboard.php");
            exit();
        } else {
            // Jika password salah, set pesan error di session
            $_SESSION['error_message'] = "Password salah!";
            header("Location: login.php");  // Kembali ke halaman login
            exit();
        }
    } else {
        // Jika username tidak ditemukan, set pesan error di session
        $_SESSION['error_message'] = "Username tidak ditemukan!";
        header("Location: login.php");  // Kembali ke halaman login
        exit();
    }
}
?>