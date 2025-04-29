<?php
require_once('config.php');
include('.includes/header.php');
$title = "Menu untuk Pelanggan";

// Query untuk mendapatkan semua menu
$query = "SELECT * FROM menu";
$menus = mysqli_query($conn, $query);
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <h1 class="my-4">Menu Kami</h1>

  <!-- menampilkan menu dalam bentuk cards -->
  <div class="row">
    <?php while ($row = mysqli_fetch_assoc($menus)): ?>
      <div class="col-md-4">
        <div class="card">
          <img src="uploads/<?php echo $row['gambar']; ?>" class="card-img-top" alt="Menu Image">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['nama']; ?></h5>
            <p class="card-text">Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
            <a href="pesan_menu.php?menu_id=<?php echo $row['menu_id']; ?>" class="btn btn-primary">Pesan</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php
include('.includes/footer.php');
