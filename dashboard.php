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
    // Query untuk total transaksi dan pendapatan
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

    <?php if ($role === "admin"): ?>
        <!-- Admin Dashboard -->
        <h4>Selamat datang di Dashboard Admin</h4>
        <p>Kelola menu dan pesanan pelanggan di sini!</p>

        <!-- Kartu Statistik -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1">Transaksi</span>
                        <h3 class="card-title mb-2">Rp<?= number_format($total_revenue, 0, ',', '.') ?></h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28,14%</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1">Pendapatan</span>
                        <h3 class="card-title mb-2">Rp<?= number_format($total_revenue, 0, ',', '.') ?></h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +18,2%</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1">Pelanggan</span>
                        <h3 class="card-title mb-2"><?= $total_customers ?></h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +12,5%</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1">Pesanan</span>
                        <h3 class="card-title mb-2"><?= $total_orders ?></h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +32,7%</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Status Pesanan dan Pendapatan -->
        <div class="row mb-4">
            <!-- Grafik Status Pesanan -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Distribusi Status Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Pendapatan dan Transaksi -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Pendapatan dan Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pesanan Terbaru -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h4>Daftar Pesanan Terbaru</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped" id="pesananTable">
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
                                    <td><a href='ubah_status.php?pesanan_id={$row['pesanan_id']}' class='btn btn-sm btn-primary'>Detail</a></td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Grafik Status Pesanan
var ctx1 = document.getElementById('statusChart').getContext('2d');
var statusChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Pending', 'Proses', 'Selesai'],
        datasets: [{
            label: 'Status Pesanan',
            data: [
                <?php echo isset($status_pesanan['pending']) ? $status_pesanan['pending'] : 0; ?>,
                <?php echo isset($status_pesanan['proses']) ? $status_pesanan['proses'] : 0; ?>,
                <?php echo isset($status_pesanan['selesai']) ? $status_pesanan['selesai'] : 0; ?>
            ],
            backgroundColor: ['#FF7F50', '#3B5998', '#4CAF50'],
            borderColor: ['#FF7F50', '#3B5998', '#4CAF50'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Grafik Pendapatan dan Transaksi
var ctx2 = document.getElementById('revenueChart').getContext('2d');
var revenueChart = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei'],
        datasets: [{
            label: 'Pendapatan',
            data: [5000000, 6000000, 7000000, 8000000, 9000000], // Contoh data
            fill: false,
            borderColor: '#4CAF50',
            tension: 0.1
        }, {
            label: 'Transaksi',
            data: [100, 120, 150, 170, 200], // Contoh data transaksi
            fill: false,
            borderColor: '#FF7F50',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>