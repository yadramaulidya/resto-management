<?php
require_once('../.includes/init_session.php');
require_once('../config.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT user_id, nama, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];  
            $_SESSION['username'] = $user['username']; 
            $_SESSION['nama'] = $user['nama']; 
            $_SESSION['role'] = $user['role']; 
  
            header('Location: ../dashboard.php');
            exit();
        } else {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Username atau password salah!'];
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Username tidak ditemukan!'];
        header('Location: login.php');
        exit();
    }
}
?>