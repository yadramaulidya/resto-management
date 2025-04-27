<?php
session_start();
require_once('config.php');

$title = "Ubah Status Pesanan";
$pesanan_id = $_GET['pesanan_id'];
$query = "SELECT pesanan.*, menu.nama AS menu_name, users.nama AS user_name
          FROM pesanan
          JOIN menu ON pesanan.menu_id = menu.menu_id
          JOIN users ON pesanan.user_id = users.user_id
          WHERE pesanan.pesanan_id = $pesanan_id";
$pesanan = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($pesanan);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    // Update status pesanan di database
    $query = "UPDATE pesanan SET status = '$status' WHERE pesanan_id = $pesanan_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'Status pesanan berhasil diubah!'];
        header('Location: pesanan.php');
        exit;
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal mengubah status pesanan!'];
    }
}

include('.includes/header.php');
include('.includes/toast_notification.php');
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <h1 class="my-4">Ubah Status Pesanan</h1>

  <?php if (isset($_SESSION['notification'])): ?>
    <div class="alert alert-<?php echo $_SESSION['notification']['type']; ?>" role="alert">
      <?php echo $_SESSION['notification']['message']; ?>
    </div>
    <?php unset($_SESSION['notification']); ?>
  <?php endif; ?>

  <div class="card">
    <div class="card-body">
      <form method="POST">
        <div class="mb-3">
          <label for="menu_name" class="form-label">Menu</label>
          <input type="text" class="form-control" id="menu_name" value="<?= htmlspecialchars($row['menu_name']); ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="user_name" class="form-label">Pelanggan</label>
          <input type="text" class="form-control" id="user_name" value="<?= htmlspecialchars($row['user_name']); ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Status Pesanan</label>
          <select class="form-select" id="status" name="status" required>
            <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="proses" <?= $row['status'] == 'proses' ? 'selected' : ''; ?>>Proses</option>
            <option value="selesai" <?= $row['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Ubah Status</button>
      </form>
    </div>
  </div>
</div>

<?php include('.includes/footer.php'); ?>