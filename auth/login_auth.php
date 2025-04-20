<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kontak = $_POST["kontak"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM pelanggan WHERE kontak='$kontak'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        //verifikasi password
        if (password_verify($password, $row["password"])) {
            $_SESSION["kontak"] = $kontak;
            $_SESSION["nama"] = $row["nama"]; 
            $_SESSION["user_id"] = $row["id_pelanggan"];
            //Set notifikasi selamat datang
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'hai! senang bertemu kembali 🍖'
            ];
            //Redirect ke dashboard
            header('Location: ../dashboard.php');
            exit();
        } else {
            //password salah
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'woops! passwordnya salah. coba di cek lagi yaa! 👩🏾'
            ];
    }
} else {
    // Username tidak ditemukan
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'woops! kontaknya nggak ketemu. coba di cek lagi yaa! 👩🏾'
    ];
}
}

//Redirect kembali ke halaman login jika gagal
header('Location: login.php');
exit();

$conn->close();
?>