<?php
require_once('.includes/init_session.php');

include('.includes/header.php');
$title = "Manajemen Menu";

include '.includes/toast_notification.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="my-4">Manajemen Menu</h1>

    <a href="tambah_menu.php" class="btn btn-primary mb-4">
        <i class="bx bx-plus me-1"></i> Tambah Menu
    </a>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php
            $query = "SELECT * FROM menu";
            $result = mysqli_query($conn, $query);
            while ($menu = mysqli_fetch_assoc($result)):
        ?>
            <div class="col">
                <div class="card h-100">
                    <img src="uploads/<?= $menu['gambar']; ?>" class="card-img-top" alt="<?= htmlspecialchars($menu['nama']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($menu['nama']) ?></h5>
                        <p class="card-text">Harga: Rp <?= number_format($menu['harga'],0,',','.') ?></p>
                        <p class="card-text">Kategori: <?= htmlspecialchars($menu['kategori']) ?></p>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-icon py-0" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="edit_menu.php?id=<?= $menu['menu_id'] ?>">
                                    <i class="bx bx-edit-alt me-2"></i> Edit
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="hapus_menu.php?id=<?= $menu['menu_id'] ?>"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus <?= htmlspecialchars($menu['nama']) ?>?')">
                                    <i class="bx bx-trash me-2"></i> Hapus
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
include('.includes/footer.php');
?>