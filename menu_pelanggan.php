<?php
require_once('config.php');
include('./.includes/header.php');
$title = "Menu untuk Pelanggan";

// Prepared statement untuk mengambil semua menu
$query = "SELECT * FROM menu";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container-fluid flex-grow-1 px-4 mt-3">
  <div class="row g-4">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2">
        <div class="card shadow-sm h-100" style="border-radius: 15px; overflow: hidden;">
          <img src="uploads/<?= $row['gambar']; ?>" class="card-img-top img-fluid" alt="<?= $row['nama']; ?>" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center d-flex flex-column align-items-center">
            <h5 class="card-title mb-2"><?= $row['nama']; ?></h5>
            <p class="card-text text-muted small">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
            <a href="pesan_menu.php?menu_id=<?= $row['menu_id']; ?>" class="btn btn-primary btn-sm mt-auto">Pesan Sekarang</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include('./.includes/footer.php'); ?>