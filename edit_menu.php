<?php
require_once('config.php'); 


$id = $_GET['id'];
$r  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu WHERE menu_id = '$id'"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama     = trim($_POST['nama']);
  $harga    = trim($_POST['harga']);
  $kategori = trim($_POST['kategori']);

  // up pict
  if (!empty($_FILES['gambar']['name'])) {
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = "uploads/" . basename($gambar);
    move_uploaded_file($gambar_tmp, $gambar_path);
    $query = "UPDATE menu SET nama='$nama', harga='$harga', kategori='$kategori', gambar='$gambar' WHERE menu_id='$id'";
  } else {
    $query = "UPDATE menu SET nama='$nama', harga='$harga', kategori='$kategori' WHERE menu_id='$id'";
  }

  if (mysqli_query($conn, $query)) {
    $_SESSION['notification'] = ['type' => 'success', 'message' => 'Menu berhasil diperbarui!'];
    header('Location: menu.php');
    exit(); 
  } else {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal memperbarui menu!'];
  }
}

include('.includes/header.php');
$title = "Edit Menu";
include('.includes/toast_notification.php');
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <h1 class="my-4">Edit Menu</h1>

  <div class="card">
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nama" class="form-label">Nama Menu</label>
          <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($r['nama']); ?>" required>
        </div>
        <div class="mb-3">
          <label for="harga" class="form-label">Harga</label>
          <input type="number" class="form-control" id="harga" name="harga" value="<?= htmlspecialchars($r['harga']); ?>" required>
        </div>
        <div class="mb-3">
          <label for="kategori" class="form-label">Kategori</label>
          <input type="text" class="form-control" id="kategori" name="kategori" value="<?= htmlspecialchars($r['kategori']); ?>" required>
        </div>
        <div class="mb-3">
          <label for="gambar" class="form-label">Gambar Menu</label>
          <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
          <img src="uploads/<?= htmlspecialchars($r['gambar']); ?>" width="100" alt="gambar menu">
        </div>
        <button type="submit" class="btn btn-primary">Perbarui Menu</button>
      </form>
    </div>
  </div>
</div>

<?php include('.includes/footer.php'); ?>