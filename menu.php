<?php
session_start();
require_once('config.php');
include('.includes/header.php');
$title = "Manajemen Menu";


if (isset($_SESSION['notification'])) {
    echo '<div class="alert alert-' . $_SESSION['notification']['type'] . ' text-center">' . $_SESSION['notification']['message'] . '</div>';
    unset($_SESSION['notification']);
}

include('./.includes/toast_notification.php'); 

$query = "SELECT * FROM menu";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="my-4 text-center">Manajemen Menu</h1>

    <a href="tambah_menu.php" class="btn btn-primary mb-4">
        <i class="bx bx-plus me-1"></i> Tambah Menu
    </a>

    <div class="row row-cols-2 row-cols-md-4 g-2"> 
    <?php while ($menu = $result->fetch_assoc()): ?>
        <div class="col">
            <div class="card h-100 text-center p-1"> 
                <img src="uploads/<?= $menu['gambar']; ?>" class="img-fluid rounded" alt="<?= $menu['nama'] ?>" style="height: 120px; object-fit: cover;"> 
                <h6 class="mt-2"><?= $menu['nama'] ?></h6>
                <p class="text-muted small">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></p>
                <div class="position-absolute top-0 end-0 p-1"> 
                    <button class="btn btn-sm btn-icon py-0" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="edit_menu.php?id=<?= $menu['menu_id'] ?>">
                            <i class="bx bx-edit-alt me-2"></i> Edit
                        </a></li>
                        <li><a class="dropdown-item text-danger" href="hapus_menu.php?id=<?= $menu['menu_id'] ?>"
                               onclick="return confirm('Apakah Anda yakin ingin menghapus <?= $menu['nama'] ?>?')">
                            <i class="bx bx-trash me-2"></i> Hapus
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php include('.includes/footer.php'); ?>