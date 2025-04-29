<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $harga = trim($_POST['harga']);
    $kategori = trim($_POST['kategori']);

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_path = "uploads/" . basename($gambar);

        // Simpan gambar ke folder uploads
        if (move_uploaded_file($gambar_tmp, $gambar_path)) {
            $query = "INSERT INTO menu (nama, harga, kategori, gambar) VALUES ('$nama', '$harga', '$kategori', '$gambar')";
            if (mysqli_query($conn, $query)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Menu berhasil ditambahkan!'];
                header('Location: menu.php');
                exit; 
            } else {
                $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menambahkan menu!'];
            }
        } else {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal meng-upload gambar!'];
        }
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gambar menu tidak valid!'];
    }
}

include('.includes/header.php');
$title = "Tambah Menu";
?>

<!-- Form Tambah Menu -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="my-4">Tambah Menu</h1>

    <!-- Menampilkan Notifikasi jika ada pesan -->
    <?php if (isset($_SESSION['notification'])): ?>
        <div class="alert alert-<?php echo $_SESSION['notification']['type']; ?>" role="alert">
            <?php echo $_SESSION['notification']['message']; ?>
        </div>
        <?php unset($_SESSION['notification']); ?>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama menu" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga menu" required>
                </div>
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <!-- Dropdown untuk kategori -->
                    <select class="form-control" id="kategori" name="kategori" required>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Snack">Snack</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Menu</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Menu</button>
            </form>
        </div>
    </div>
</div>

<?php
include('.includes/footer.php');
?>