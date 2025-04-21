<?php 
session_start();  
require_once("../config.php");


if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");  
    exit();
}

$role = $_SESSION["role"];  // Mendapatkan role dari session
$nama = $_SESSION["nama"];  // Mendapatkan nama dari session
?>

<?php include(".layouts/header.php"); ?>
<!-- Dashboard -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h2>Hai, <?= htmlspecialchars($nama) ?>!</h2>

    <?php if ($role === "admin"): ?>
        <!-- Admin Dashboard -->
        <h4>Selamat datang di Dashboard Admin</h4>
        <p> menu dan pesanan pelanggan di sini!</p>

        <!-- Tabel Pesanan -->
        <div class="card">
            <div class="card-header">
                <h4>Daftar Pesanan</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Pemesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query untuk mengambil pesanan dari database
                        $query = "SELECT p.pesanan_id, u.nama AS pelanggan, m.nama AS menu, p.jumlah, p.status, p.tanggal_pemesanan 
                                  FROM pesanan p 
                                  JOIN users u ON p.user_id = u.user_id 
                                  JOIN menu m ON p.menu_id = m.menu_id";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>{$row['pelanggan']}</td>
                                <td>{$row['menu']}</td>
                                <td>{$row['jumlah']}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['tanggal_pemesanan']}</td>
                              </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php elseif ($role === "pelanggan"): ?>
        <!-- Pelanggan Dashboard -->
        <h4>Selamat datang di Dashboard Pelanggan</h4>
        <p>Pilih menu favorit kamu dan lakukan pemesanan!</p>

        <!-- Tabel Menu -->
        <div class="card">
            <div class="card-header">
                <h4>Menu Tersedia</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query untuk mengambil menu dari database
                        $query = "SELECT * FROM menu";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>{$row['nama']}</td>
                                <td>{$row['kategori']}</td>
                                <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                                <td>
                                    <form method='post' action='menu.php'>
                                        <input type='hidden' name='menu_id' value='{$row['menu_id']}'>
                                        <div class='form-group'>
                                            <label for='qty'>Jumlah</label>
                                            <input type='number' name='qty' class='form-control' min='1' value='1'>
                                        </div>
                                        <button type='submit' name='add_to_cart' class='btn btn-primary btn-sm'>Tambah ke Keranjang</button>
                                    </form>
                                </td>
                              </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Keranjang -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="cart-section">
                    <h4>Keranjang Belanja</h4>
                    <?php if (empty($_SESSION['cart'])): ?>
                        <p>Keranjang Anda kosong.</p>
                    <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($_SESSION['cart'] as $cart_item): ?>
                                <li class="list-group-item">
                                    <?php echo $cart_item['nama']; ?> x <?php echo $cart_item['qty']; ?> - Rp <?php echo number_format($cart_item['subtotal'], 0, ',', '.'); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p>Total: Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></p>
                        <form method="post" action="menu.php">
                            <button type="submit" name="clear_cart" class="btn btn-danger btn-block">Kosongkan Keranjang</button>
                            <a href="checkout.php" class="btn btn-success btn-block mt-2">Checkout</a>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>
<!-- /Dashboard -->
<?php include(".layouts/footer.php"); ?>