<?php 
session_start();  // Mulai session untuk mengakses session variables
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $username = $_POST["username"];
    $password = $_POST["password"];

    
    $stmt = $conn->prepare("SELECT user_id, nama, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);  // 's' berarti string
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika username ditemukan
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user["password"])) {
            // Menyimpan session data jika login berhasil
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["nama"] = $user["nama"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            // Set notifikasi selamat datang
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Hai! Senang bertemu kembali 🍖'
            ];

            // Arahkan ke dashboard berdasarkan role
            header('Location: ../dashboard.php');
            exit();
        } else {
            // Jika password salah
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Password salah!'
            ];
            header('Location: login.php');
            exit();
        }
    } else {
        
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Username tidak ditemukan!'
        ];
        header('Location: login.php');
        exit();
    }
}


$conn->close();
?>