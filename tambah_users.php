<?php
ob_start();
session_start();
include('config.php');
include('.includes/header.php');

// Pastikan tidak ada output sebelum header()
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = "INSERT INTO users (nama, kontak, username, password, role) 
              VALUES ('$nama', '$kontak', '$username', '$password', '$role')";

    if (mysqli_query($conn, $query)) {
        header("Location: users.php"); // Redirect setelah sukses
        exit; // **Perbaikan**: Menghentikan eksekusi agar tidak ada output tambahan
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<div class="container-xxl flex-grow-1 my-4">
    <h1>Add New User</h1>
    <form method="POST" action="tambah_users.php">
        <div class="mb-3">
            <label for="nama" class="form-label">Name</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <div class="mb-3">
            <label for="kontak" class="form-label">Contact</label>
            <input type="text" class="form-control" id="kontak" name="kontak" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="pelanggan">Customer</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>

<?php include('.includes/footer.php'); ?>