<?php
require_once('config.php');
include('./.includes/header.php');
$title = "Menu untuk Pelanggan";

// Ambil menu dari database
$query = "SELECT * FROM menu";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-fluid flex-grow-1 px-4 mt-3">
  <div class="row g-4">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card shadow-md h-100 border" 
             style="border-radius: 15px; overflow: hidden; padding: 15px; text-align: center;">
          <img src="uploads/<?= $row['gambar']; ?>" class="card-img-top img-fluid" 
               alt="<?= $row['nama']; ?>" style="height: 200px; object-fit: cover; border-radius: 10px;">
          <div class="card-body">
            <h5 class="card-title"><?= $row['nama']; ?></h5>
            <p class="card-text text-muted small">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
            <p class="card-text <?= ($row['stok'] > 0) ? 'text-warning' : 'text-danger'; ?>">
                <?= ($row['stok'] > 0) ? '⭐ Stok: ' . $row['stok'] . ' tersedia' : '❌ Stok: Habis'; ?>
            </p>
            <a href="pesan_menu.php?menu_id=<?= $row['menu_id']; ?>" 
               class="btn btn-primary btn-sm <?= ($row['stok'] > 0) ? '' : 'disabled'; ?>">
                Pesan Sekarang
            </a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include('./.includes/footer.php'); ?>