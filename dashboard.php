<?php 
session_start();  // Mulai session untuk mengakses session variables
require_once("../config.php");

// Cek apakah user sudah login
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
        <p>Kelola menu dan pesanan pelanggan di sini!</p>

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
                                <td><a href='order.php?menu_id={$row['menu_id']}' class='btn btn-primary btn-sm'>Pesan</a></td>
                              </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>
<!-- /Dashboard -->
<?php include(".layouts/footer.php"); ?>