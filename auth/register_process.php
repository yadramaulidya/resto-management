<?php 
require_once("../config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kontak = $_POST["kontak"];
    $nama = $_POST["nama"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
 fitur-register
    $role = "pelanggan";


$sql = "INSERT INTO pelanggan (kontak, nama, password)
VALUES ('$kontak', '$nama', '$hashedPassword')";
if ($conn->query($sql) === TRUE) {
 main

    // pakai prepared steatment agar aman masukin data ke db
    $stmt = $conn->prepare("INSERT INTO users (kontak, nama, username, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $kontak, $nama, $username, $hashedPassword, $role);

fitur-register
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

    $stmt->close();
    $conn->close();
    header('Location: login.php');
    exit();
}

}
$conn->close();
 main
?>