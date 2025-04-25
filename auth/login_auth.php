<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT user_id, nama, username, password, role FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
           
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama'] = $user['nama'];

            //
            header("Location: ../dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Password salah!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Username tidak ditemukan!";
        header("Location: login.php");
        exit();
    }
}
?>