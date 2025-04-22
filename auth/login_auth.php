<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $kontak = $_POST["kontak"];
    $password = $_POST["password"];
    $user = null; 

    $sql = "SELECT pelanggan_id AS id, nama, password FROM pelanggan WHERE kontak='$kontak'";
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {

    $sql = "SELECT admin_id AS id, nama, password FROM admin WHERE kontak='$kontak'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}
        //verifikasi password
        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["kontak"] = $kontak;
            $_SESSION["nama"] = $user["nama"];
            $_SESSION["user_id"] = $user["id"];
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Hai! Senang bertemu kembali 🍖'
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


//Redirect kembali ke halaman login jika gagal
header('Location: login.php');
exit();

$conn->close();
?>
<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kontak = $_POST["kontak"];
    $password = $_POST["password"];
    $user = null; // Menyimpan data user

    // Cek di tabel pelanggan
    $sql = "SELECT pelanggan_id AS id, nama, password FROM pelanggan WHERE kontak='$kontak'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        // Jika tidak ditemukan di pelanggan, cek admin
        $sql = "SELECT admin_id AS id, nama, password FROM admin WHERE kontak='$kontak'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }
    }

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["kontak"] = $kontak;
        $_SESSION["nama"] = $user["nama"];
        $_SESSION["user_id"] = $user["id"];

        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Hai! Senang bertemu kembali 🍖'
        ];

        header('Location: ../dashboard.php');
        exit();
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Woops! Kontak atau password salah. Coba cek lagi yaa! 👩🏾'
        ];
    }
}

// Redirect kembali ke login jika gagal
header('Location: login.php');
exit();

$conn->close();