<?php
session_start();
require_once('config.php');
include('.includes/header.php');
include('.includes/toast_notification.php'); // Menampilkan notifikasi toast

// Pastikan ID user tersedia
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data pengguna
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Pastikan pengguna ditemukan
    if (!$user) {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => '⚠️ User ID tidak ditemukan!'];
        header("Location: users.php");
        exit();
    }

    // Proses update jika form dikirim
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nama = trim($_POST['nama']);
        $kontak = trim($_POST['kontak']);
        $username = trim($_POST['username']);
        $role = trim($_POST['role']);

        $update_query = "UPDATE users SET nama=?, kontak=?, username=?, role=? WHERE user_id=?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("ssssi", $nama, $kontak, $username, $role, $id);

        if ($stmt_update->execute()) {
            $_SESSION['notification'] = ['type' => 'success', 'message' => '✅ User berhasil diperbarui!'];
            header("Location: users.php");
            exit();
        } else {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => '⚠️ Gagal memperbarui user!'];
        }
    }
} else {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => '⚠️ User ID tidak ditemukan!'];
    header("Location: users.php");
    exit();
}
?>

<div class="container-xxl flex-grow-1 my-4">
    <h1 class="mb-4">Edit User</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="kontak" class="form-label">Kontak</label>
                    <input type="text" class="form-control" id="kontak" name="kontak" value="<?= htmlspecialchars($user['kontak']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="pelanggan" <?= ($user['role'] == 'pelanggan') ? 'selected' : ''; ?>>Customer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update User</button>
            </form>
        </div>
    </div>
</div>

<?php include('.includes/footer.php'); ?>