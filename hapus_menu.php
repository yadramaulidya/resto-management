<?php
require_once('config.php');

// Memeriksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];

    // Query untuk menghapus menu berdasarkan ID
    $query = "DELETE FROM menu WHERE menu_id = '$id_menu'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'Menu berhasil dihapus!'];
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menghapus menu! Query error: ' . mysqli_error($conn)];
    }
} else {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'ID menu tidak ditemukan!'];
}

header('Location: menu.php');
exit;
?>