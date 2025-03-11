<?php 
require_once("../config.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kontak = $_POST["kontak"];
    $nama = $_POST["nama"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
}
$sql = "INSERT INTO pelanggan (kontak, nama, password)
VALUES ('$kontak', '$nama', '$hashedPassword')";
if ($conn->query($sql) === TRUE) {

    $_SESSION['notification'] = [
        'type' => 'primary',
        'message' => 'Registrasi Berhasil!'
    ];
} else {
    $_SESSION['notification'] = [
         'type' => 'danger',
        'message' => 'gagal Registrasi: ' . mysqli_error($conn)
    ];
}
header('Location: login.php');
exit();


$conn->close();
?>