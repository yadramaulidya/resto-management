<?php
session_start();
require_once('config.php');
include('.includes/header.php');
$title = "Manajemen Menu";

if (isset($_SESSION['notification'])) {
    echo '<div class="alert alert-' . $_SESSION['notification']['type'] . ' text-center">'
         . $_SESSION['notification']['message'] . '</div>';
    unset($_SESSION['notification']);
}

include('./.includes/toast_notification.php');

$filterCat = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$cat_query = "SELECT DISTINCT kategori FROM menu";
$cat_stmt = $conn->prepare($cat_query);
$cat_stmt->execute();
$cat_result = $cat_stmt->get_result();

if (!empty($filterCat)) {
    $query = "SELECT * FROM menu WHERE kategori = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $filterCat);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM menu";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<div class="container-fluid flex-grow-1 px-4 mt-3">
  <!-- Baris Filter Kategori di atas grid -->
  <div class="row mb-4">
    <div class="col">
      <div class="btn-group" role="group" aria-label="Filter berdasarkan kategori">
        <a href="menu.php" class="btn btn-outline-primary <?= empty($filterCat) ? 'active' : '' ?>">All</a>
        <?php while ($cat = $cat_result->fetch_assoc()): ?>
          <a href="menu.php?kategori=<?= urlencode($cat['kategori']) ?>" 
             class="btn btn-outline-primary <?= ($filterCat == $cat['kategori']) ? 'active' : '' ?>">
            <?= $cat['kategori'] ?>
          </a>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
  
  <!-- Grid Card Menu (termasuk tombol Tambah Menu sebagai grid item pertama) -->
  <div class="row g-4">
    <!-- Grid item untuk tombol Tambah Menu -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2">
      <a href="tambah_menu.php" style="text-decoration: none; color: inherit;">
        <div class="card shadow-sm h-100 d-flex justify-content-center align-items-center" style="border-radius: 15px; overflow: hidden;">
          <div class="d-flex flex-column align-items-center justify-content-center" style="height:200px;">
            <i class="bx bx-plus" style="font-size: 2rem;"></i>
            <h5 class="mt-2">Tambah Menu</h5>
          </div>
        </div>
      </a>
    </div>
    
    <!-- Loop untuk menampilkan setiap menu -->
    <?php while ($menu = $result->fetch_assoc()): ?>
      <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2">
        <div class="card shadow-sm h-100" style="border-radius: 15px; overflow: hidden; position: relative;">
          <img src="uploads/<?= $menu['gambar']; ?>" 
               class="card-img-top img-fluid" 
               alt="<?= $menu['nama']; ?>" 
               style="height: 200px; object-fit: cover;">
          <div class="card-body text-center d-flex flex-column align-items-center">
            <h5 class="card-title mb-2"><?= $menu['nama']; ?></h5>
            <!-- Tampilkan kategori di atas harga -->
            <p class="card-text text-muted small mb-1"><?= $menu['kategori']; ?></p>
            <p class="card-text text-muted small mb-0">Rp <?= number_format($menu['harga'], 0, ',', '.'); ?></p>
          </div>
          <!-- Dropdown Aksi CRUD -->
          <div class="position-absolute top-0 end-0 p-2">
            <button class="btn btn-sm btn-icon py-0" data-bs-toggle="dropdown">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="edit_menu.php?id=<?= $menu['menu_id']; ?>">
                  <i class="bx bx-edit-alt me-2"></i> Edit
                </a>
              </li>
              <li>
                <a class="dropdown-item text-danger" href="hapus_menu.php?id=<?= $menu['menu_id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus <?= $menu['nama']; ?>?')">
                  <i class="bx bx-trash me-2"></i> Hapus
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div><!-- End row -->
</div><!-- End container -->

<?php include('.includes/footer.php'); ?>