<?php
session_start();
require_once('config.php');
include('.includes/header.php');
$title = "Daftar Pesanan";

// Query untuk mengambil pesanan
$query = "SELECT pesanan.pesanan_id, pesanan.jumlah, pesanan.status, pesanan.tanggal_pemesanan, menu.nama as menu_name, users.nama as user_name
          FROM pesanan
          JOIN menu ON pesanan.menu_id = menu.menu_id
          JOIN users ON pesanan.user_id = users.user_id";
$pesanan = mysqli_query($conn, $query);
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <h1 class="my-4">Daftar Pesanan</h1>
  
  <div class="card">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Pelanggan</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Tanggal Pemesanan</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($pesanan)): ?>
            <tr>
              <td><?php echo $row['pesanan_id']; ?></td>
              <td><?php echo $row['user_name']; ?></td>
              <td><?php echo $row['menu_name']; ?></td>
              <td><?php echo $row['jumlah']; ?></td>
              <td><?php echo ucfirst($row['status']); ?></td>
              <td><?php echo $row['tanggal_pemesanan']; ?></td>
              <td>
                <a href="ubah_status.php?pesanan_id=<?php echo $row['pesanan_id']; ?>" class="btn btn-primary">Ubah Status</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
include('.includes/footer.php');
?>