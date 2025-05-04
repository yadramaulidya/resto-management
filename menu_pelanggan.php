<?php
require_once('config.php');
include('./.includes/header.php');
$title = "Menu untuk Pelanggan";

$query = "SELECT * FROM menu";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <h1 class="my-4">Menu Kami</h1>
  <div class="row">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-md-3 col-sm-6 mb-2">
        <div class="card shadow-sm">
          <img src="uploads/<?= $row['gambar']; ?>" class="card-img-top img-fluid" alt="Menu Image" style="height: 120px; object-fit: cover;">
          <div class="card-body text-center d-flex flex-column align-items-center">
            <h6 class="card-title mb-2"><?= $row['nama']; ?></h6>
            <p class="card-text text-muted small">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
            <a href="pesan_menu.php?menu_id=<?= $row['menu_id'] ?>" class="btn btn-sm btn-primary">Pesan</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include('./.includes/footer.php'); ?>