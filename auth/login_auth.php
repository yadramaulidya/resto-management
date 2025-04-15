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

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["nama"] = $user["nama"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Hai! Senang bertemu kembali 🍖'
            ];

            header("Location: ../dashboard.php");
            exit();
        }
    }

    // klaug login gagal
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Username atau password salah. Coba dicek lagi ya!'
    ];
    header("Location: login.php");
    exit();
}

$conn->close();
?>