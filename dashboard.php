<?php
session_start();
require_once('config.php');
include('.includes/header.php');

if (!isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

$title = "Dashboard";

// klau admin
if ($_SESSION['role'] === 'admin') {

    // ringkasan pesanan pending
    $query_pesanan = "SELECT COUNT(*) AS total_pesanan FROM pesanan WHERE status = 'pending'";
    $pesanan_result = mysqli_query($conn, $query_pesanan);
    $pesanan_data = mysqli_fetch_assoc($pesanan_result);

    // menu terlaku
    $query_menu_terlaris = "SELECT menu.nama, SUM(pesanan.jumlah) AS total_terjual
                            FROM pesanan
                            JOIN menu ON pesanan.menu_id = menu.menu_id
                            GROUP BY menu.menu_id
                            ORDER BY total_terjual DESC LIMIT 1";
    $menu_terlaris_result = mysqli_query($conn, $query_menu_terlaris);
    $menu_terlaris = mysqli_fetch_assoc($menu_terlaris_result);

    ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="my-4">Dashboard Admin</h1>

        <div class="row">
            <!-- Ringkasan Pesanan -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pesanan Pending</h5>
                        <p class="card-text"><?php echo $pesanan_data['total_pesanan']; ?> pesanan pending</p>
                        <a href="pesanan.php" class="btn btn-primary">Lihat Pesanan</a>
                    </div>
                </div>
            </div>

            <!-- Menu Terlaris -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Menu Terlaris</h5>
                        <p class="card-text"><?php echo $menu_terlaris['nama']; ?> - Terjual <?php echo $menu_terlaris['total_terjual']; ?> kali</p>
                    </div>
                </div>
            </div>

            <!-- Status Pesanan -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pesanan yang Sedang Diproses</h5>
                        <p class="card-text">Status pesanan akan ditampilkan di sini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else if ($_SESSION['role'] === 'pelanggan') {
    // kalau pelanggan

    $user_id = $_SESSION['user_id'];
    // ambil pesNAN dr pelanghgan
    $query_pesanan = "SELECT COUNT(*) AS total_pesanan_pending FROM pesanan WHERE user_id = '$user_id' AND status = 'pending'";
    $pesanan_result = mysqli_query($conn, $query_pesanan);
    $pesanan_data = mysqli_fetch_assoc($pesanan_result);

    //ambil riwayat pesanan pelanggan
    $query_riwayat = "SELECT pesanan.pesanan_id, pesanan.jumlah, pesanan.status, pesanan.tanggal_pemesanan, menu.nama as menu_name
                      FROM pesanan
                      JOIN menu ON pesanan.menu_id = menu.menu_id
                      WHERE pesanan.user_id = '$user_id'";
    $riwayat_pesanan = mysqli_query($conn, $query_riwayat);
    ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1 class="my-4">Dashboard Pelanggan</h1>

        <div class="row">
            <!-- Ringkasan Pesanan Pending -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pesanan Pending</h5>
                        <p class="card-text"><?php echo $pesanan_data['total_pesanan_pending']; ?> pesanan pending</p>
                        <a href="pesan_menu.php" class="btn btn-primary">Pesan Sekarang</a>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pesanan -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Riwayat Pesanan</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Menu</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($riwayat_pesanan)): ?>
                                    <tr>
                                        <td><?php echo $row['pesanan_id']; ?></td>
                                        <td><?php echo $row['menu_name']; ?></td>
                                        <td><?php echo $row['jumlah']; ?></td>
                                        <td><?php echo ucfirst($row['status']); ?></td>
                                        <td><?php echo $row['tanggal_pemesanan']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include('.includes/footer.php');
?>