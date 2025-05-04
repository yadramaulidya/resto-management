dashboard-admin
<?php 
session_start();
require_once("config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["role"];
$nama = $_SESSION["nama"];

// Query untuk total pendapatan, transaksi, dan jumlah pelanggan untuk admin
if ($role === 'admin') {
    $query_transaksi = "
        SELECT COUNT(p.pesanan_id) AS total_orders, SUM(m.harga * p.jumlah) AS total_revenue
        FROM pesanan p
        JOIN menu m ON p.menu_id = m.menu_id
    ";
    $result_transaksi = mysqli_query($conn, $query_transaksi);
    $data_transaksi = mysqli_fetch_assoc($result_transaksi);

    $total_revenue = $data_transaksi['total_revenue'];
    $total_orders = $data_transaksi['total_orders'];

    // Query untuk jumlah pelanggan
    $query_pelanggan = "SELECT COUNT(user_id) AS total_customers FROM users";
    $result_pelanggan = mysqli_query($conn, $query_pelanggan);
    $data_pelanggan = mysqli_fetch_assoc($result_pelanggan);
    $total_customers = $data_pelanggan['total_customers'];

    // Query untuk pesanan terbaru
    $query_pesanan_terbaru = "SELECT * FROM pesanan ORDER BY tanggal_pemesanan DESC LIMIT 5";
    $result_pesanan_terbaru = mysqli_query($conn, $query_pesanan_terbaru);
    $pesanan_terbaru = [];
    while ($row = mysqli_fetch_assoc($result_pesanan_terbaru)) {
        $pesanan_terbaru[] = $row;
    }

    // Query untuk status pesanan
    $query_status_pesanan = "
        SELECT status, COUNT(pesanan_id) AS total 
        FROM pesanan
        GROUP BY status
    ";
    $result_status_pesanan = mysqli_query($conn, $query_status_pesanan);
    $status_pesanan = [];
    while ($row = mysqli_fetch_assoc($result_status_pesanan)) {
        $status_pesanan[$row['status']] = $row['total'];
    }
}

?>

<?php include("./.includes/header.php"); ?>

<!-- Dashboard -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h2>Hai, <?= htmlspecialchars($nama) ?>!</h2>
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
 main

    // ringkasan pesanan pending
    $query_pesanan = "SELECT COUNT(*) AS total_pesanan FROM pesanan WHERE status = 'pending'";
    $pesanan_result = mysqli_query($conn, $query_pesanan);
    $pesanan_data = mysqli_fetch_assoc($pesanan_result);

dashboard-admin
        <!-- Kartu Statistik -->
        <div class="row mb-4">
            <div class="col-md-3 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1">Transaksi</span>
                        <h3 class="card-title mb-2">Rp14.857.000</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28,14%</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1">Pendapatan</span>
                        <h3 class="card-title mb-2">Rp8.350.000</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +18,2%</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1">Pelanggan</span>
                        <h3 class="card-title mb-2">245</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +12,5%</small>

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
main
                    </div>
                </div>
            </div>

 dashboard-admin
            <div class="col-md-3 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1">Pesanan</span>
                        <h3 class="card-title mb-2">178</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +32,7%</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pesanan Terbaru -->
        <div class="card">
            <div class="card-header">
                <h4>Daftar Pesanan Terbaru</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="pesananTable">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Aksi</th>
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
                            // Menentukan warna status berdasarkan status pesanan
                            $statusClass = "";
                            $statusText = "";
                            switch ($row['status']) {
                                case 'pending':
                                    $statusClass = 'badge bg-warning text-dark'; // Pending
                                    $statusText = 'Pending';
                                    break;
                                case 'proses':
                                    $statusClass = 'badge bg-info text-white'; // Proses
                                    $statusText = 'Proses';
                                    break;
                                case 'selesai':
                                    $statusClass = 'badge bg-success text-white'; // Selesai
                                    $statusText = 'Selesai';
                                    break;
                                default:
                                    $statusClass = 'badge bg-secondary text-white'; // Default
                                    $statusText = 'Unknown';
                                    break;
                            }
                            echo "<tr>
                                    <td>{$row['pelanggan']}</td>
                                    <td>{$row['menu']}</td>
                                    <td>{$row['jumlah']}</td>
                                    <td><span class='$statusClass'>{$statusText}</span></td>
                                    <td>{$row['tanggal_pemesanan']}</td>
                                    <td><button class='btn btn-sm btn-primary'>Detail</button></td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Inisialisasi DataTable
    $(document).ready(function() {
        $('#pesananTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "pageLength": 10
        });
    });
</script>

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
 main
