<?php
// Pastikan file tidak diakses secara langsung
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__FILE__));
}

// Mulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Data statis untuk contoh riwayat pesanan
$orders = [
    ['pesanan_id' => 10025, 'pelanggan_id' => 5022, 'tanggal_pemesanan' => '2025-04-22', 'nama_pelanggan' => 'Budi Santoso', 'kontak' => '081234567890', 'total' => 85000, 'status' => 'Selesai', 'items' => [
        ['menu_id' => 1, 'nama' => 'Nasi Goreng Spesial', 'harga' => 35000, 'qty' => 2, 'subtotal' => 70000],
        ['menu_id' => 11, 'nama' => 'Es Teh Manis', 'harga' => 8000, 'qty' => 1, 'subtotal' => 8000],
        ['menu_id' => 13, 'nama' => 'Keripik Kentang', 'harga' => 10000, 'qty' => 0.7, 'subtotal' => 7000],
    ]],
    ['pesanan_id' => 10024, 'pelanggan_id' => 5021, 'tanggal_pemesanan' => '2025-04-22', 'nama_pelanggan' => 'Dewi Lestari', 'kontak' => '082345678901', 'total' => 120000, 'status' => 'Selesai', 'items' => [
        ['menu_id' => 2, 'nama' => 'Ayam Bakar Madu', 'harga' => 45000, 'qty' => 2, 'subtotal' => 90000],
        ['menu_id' => 9, 'nama' => 'Es Krim Vanilla', 'harga' => 15000, 'qty' => 2, 'subtotal' => 30000],
    ]],
    ['pesanan_id' => 10023, 'pelanggan_id' => 5020, 'tanggal_pemesanan' => '2025-04-21', 'nama_pelanggan' => 'Agus Priyanto', 'kontak' => '083456789012', 'total' => 75000, 'status' => 'Selesai', 'items' => [
        ['menu_id' => 5, 'nama' => 'Bakso Spesial', 'harga' => 30000, 'qty' => 2, 'subtotal' => 60000],
        ['menu_id' => 12, 'nama' => 'Jus Alpukat', 'harga' => 15000, 'qty' => 1, 'subtotal' => 15000],
    ]],
    ['pesanan_id' => 10022, 'pelanggan_id' => 5019, 'tanggal_pemesanan' => '2025-04-21', 'nama_pelanggan' => 'Siti Nurhaliza', 'kontak' => '084567890123', 'total' => 150000, 'status' => 'Selesai', 'items' => [
        ['menu_id' => 3, 'nama' => 'Sate Ayam', 'harga' => 30000, 'qty' => 3, 'subtotal' => 90000],
        ['menu_id' => 6, 'nama' => 'Lumpia Sayur', 'harga' => 18000, 'qty' => 2, 'subtotal' => 36000],
        ['menu_id' => 11, 'nama' => 'Es Teh Manis', 'harga' => 8000, 'qty' => 3, 'subtotal' => 24000],
    ]],
    ['pesanan_id' => 10021, 'pelanggan_id' => 5018, 'tanggal_pemesanan' => '2025-04-20', 'nama_pelanggan' => 'Joko Widodo', 'kontak' => '085678901234', 'total' => 95000, 'status' => 'Dibatalkan', 'items' => [
        ['menu_id' => 4, 'nama' => 'Soto Ayam', 'harga' => 25000, 'qty' => 2, 'subtotal' => 50000],
        ['menu_id' => 10, 'nama' => 'Pisang Goreng', 'harga' => 12000, 'qty' => 2, 'subtotal' => 24000],
        ['menu_id' => 12, 'nama' => 'Jus Alpukat', 'harga' => 15000, 'qty' => 1, 'subtotal' => 15000],
        ['menu_id' => 7, 'nama' => 'Tahu Crispy', 'harga' => 15000, 'qty' => 0.4, 'subtotal' => 6000],
    ]],
    ['pesanan_id' => 10020, 'pelanggan_id' => 5017, 'tanggal_pemesanan' => '2025-04-19', 'nama_pelanggan' => 'Rina Marlina', 'kontak' => '086789012345', 'total' => 68000, 'status' => 'Selesai', 'items' => [
        ['menu_id' => 1, 'nama' => 'Nasi Goreng Spesial', 'harga' => 35000, 'qty' => 1, 'subtotal' => 35000],
        ['menu_id' => 10, 'nama' => 'Pisang Goreng', 'harga' => 12000, 'qty' => 1, 'subtotal' => 12000],
        ['menu_id' => 11, 'nama' => 'Es Teh Manis', 'harga' => 8000, 'qty' => 1, 'subtotal' => 8000],
        ['menu_id' => 8, 'nama' => 'Tempe Mendoan', 'harga' => 12000, 'qty' => 1.1, 'subtotal' => 13000],
    ]],
    ['pesanan_id' => 10019, 'pelanggan_id' => 5016, 'tanggal_pemesanan' => '2025-04-18', 'nama_pelanggan' => 'Anton Wijaya', 'kontak' => '087890123456', 'total' => 105000, 'status' => 'Selesai', 'items' => [
        ['menu_id' => 2, 'nama' => 'Ayam Bakar Madu', 'harga' => 45000, 'qty' => 2, 'subtotal' => 90000],
        ['menu_id' => 12, 'nama' => 'Jus Alpukat', 'harga' => 15000, 'qty' => 1, 'subtotal' => 15000],
    ]],
];

// Filter pesanan berdasarkan status atau tanggal jika ada request
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';
$filtered_orders = $orders;

// Filter berdasarkan status
if ($status_filter && $status_filter != 'all') {
    $temp_orders = [];
    foreach ($filtered_orders as $order) {
        if ($order['status'] == $status_filter) {
            $temp_orders[] = $order;
        }
    }
    $filtered_orders = $temp_orders;
}

// Filter berdasarkan tanggal
if ($date_filter) {
    $temp_orders = [];
    foreach ($filtered_orders as $order) {
        if ($order['tanggal_pemesanan'] == $date_filter) {
            $temp_orders[] = $order;
        }
    }
    $filtered_orders = $temp_orders;
}

// Hitung total pendapatan dari pesanan yang selesai
$total_pendapatan = 0;
$total_pesanan_selesai = 0;
foreach ($orders as $order) {
    if ($order['status'] == 'Selesai') {
        $total_pendapatan += $order['total'];
        $total_pesanan_selesai++;
    }
}

// Hitung jumlah pesanan per status
$count_by_status = [
    'all' => count($orders),
    'Selesai' => 0,
    'Dibatalkan' => 0
];

foreach ($orders as $order) {
    if (isset($count_by_status[$order['status']])) {
        $count_by_status[$order['status']]++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Sistem Manajemen Restoran BITENEST</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    
    <style>
        body {
            background: linear-gradient(to right, #D2B48C, #FFF5E1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-content {
            padding: 20px;
        }
        .page-title {
            font-size: 1.5rem;
            margin-bottom: 0;
        }
        .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border: none;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #A67B5B;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            padding: 15px 20px;
            color: white;
        }
        .card-title {
            margin-bottom: 0;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #A67B5B;
            border-color: #A67B5B;
        }
        .btn-primary:hover {
            background-color: #8B6B4F;
            border-color: #8B6B4F;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(166, 123, 91, 0.1);
        }
        .order-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .order-link {
            color: #A67B5B;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        .order-link:hover {
            color: #8B6B4F;
            text-decoration: underline;
        }
        .status-filter .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .status-filter .badge {
            margin-left: 5px;
        }
        .stats-card {
            border-left: 4px solid;
            border-radius: 4px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 20px;
            background-color: white;
        }
        .stats-card.income {
            border-left-color: #28a745;
        }
        .stats-card.orders {
            border-left-color: #17a2b8;
        }
        .stats-icon {
            font-size: 2rem;
            opacity: 0.7;
        }
        .stats-number {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .date-range-filter {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .date-range-filter label {
            margin-right: 10px;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">BITENEST</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kategori.php">Kategori</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="menu.php">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pesanan.php">Pesanan</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="riwayat_pesanan.php">Riwayat Pesanan <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> Admin
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile.php">Profil</a>
                    <a class="dropdown-item" href="settings.php">Pengaturan</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="main-content">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="page-title">Riwayat Pesanan</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Riwayat Pesanan</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <!-- Statistik Riwayat Pesanan -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="stats-card income">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Pendapatan</h6>
                            <div class="stats-number">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></div>
                        </div>
                        <div class="stats-icon text-success">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stats-card orders">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Pesanan Selesai</h6>
                            <div class="stats-number"><?php echo $total_pesanan_selesai; ?> Pesanan</div>
                        </div>
                        <div class="stats-icon text-info">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filter Riwayat Pesanan -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Filter Riwayat Pesanan:</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="status-filter">
                                    <a href="riwayat_pesanan.php" class="btn <?php echo ($status_filter == '' || $status_filter == 'all') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                        Semua <span class="badge badge-light"><?php echo $count_by_status['all']; ?></span>
                                    </a>
                                    <a href="riwayat_pesanan.php?status=Selesai<?php echo $date_filter ? '&date='.$date_filter : ''; ?>" class="btn <?php echo ($status_filter == 'Selesai') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                        Selesai <span class="badge badge-light"><?php echo $count_by_status['Selesai']; ?></span>
                                    </a>
                                    <a href="riwayat_pesanan.php?status=Dibatalkan<?php echo $date_filter ? '&date='.$date_filter : ''; ?>" class="btn <?php echo ($status_filter == 'Dibatalkan') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                        Dibatalkan <span class="badge badge-light"><?php echo $count_by_status['Dibatalkan']; ?></span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form method="get" action="riwayat_pesanan.php">
                                    <?php if ($status_filter): ?>
                                    <input type="hidden" name="status" value="<?php echo $status_filter; ?>">
                                    <?php endif; ?>
                                    <div class="date-range-filter">
                                        <label for="date">Filter Tanggal:</label>
                                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $date_filter; ?>">
                                        <button type="submit" class="btn btn-primary ml-2">Filter</button>
                                        <?php if ($date_filter): ?>
                                        <a href="riwayat_pesanan.php<?php echo $status_filter ? '?status='.$status_filter : ''; ?>" class="btn btn-secondary ml-2">Reset</a>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Daftar Riwayat Pesanan -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Daftar Riwayat Pesanan</h5>
                        <button class="btn btn-sm btn-light" onclick="window.print()">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="riwayatPesananTable">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Pelanggan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($filtered_orders)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada pesanan yang ditemukan</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php foreach ($filtered_orders as $order): 
                                        $status_class = $order['status'] == 'Selesai' ? 'badge-success' : 'badge-danger';
                                    ?>
                                    <tr>
                                        <td>#<?php echo $order['pesanan_id']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($order['tanggal_pemesanan'])); ?></td>
                                        <td><?php echo htmlspecialchars($order['nama_pelanggan']); ?></td>
                                        <td>Rp <?php echo number_format($order['total'], 0, ',', '.'); ?></td>
                                        <td><span class="badge <?php echo $status_class; ?>"><?php echo $order['status']; ?></span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailPesananModal" data-pesanan-id="<?php echo $order['pesanan_id']; ?>">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pesanan -->
<div class="modal fade" id="detailPesananModal" tabindex="-1" role="dialog" aria-labelledby="detailPesananModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPesananModalLabel">Detail Riwayat Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailPesananContent">
                <!-- Content will be loaded dynamically using JavaScript -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Dependensi JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    $('#riwayatPesananTable').DataTable({
        "order": [[0, "desc"]], // Urutkan berdasarkan ID Pesanan terbaru
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
    
    $('#detailPesananModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var pesananId = button.data('pesanan-id');
    var modal = $(this);
    
    // Reset konten modal dan tampilkan loading
    modal.find('#detailPesananContent').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
    
    // Simulasi delay untuk pemrosesan data (di produksi nyata, gunakan AJAX)
    setTimeout(function() {
        var detailContent = '';
        var orderFound = false;
        
        <?php foreach ($orders as $order): ?>
        if (<?php echo $order['pesanan_id']; ?> == pesananId) {
            orderFound = true;
            detailContent = '<div class="row">' +
                '<div class="col-md-6">' +
                    '<h6 class="font-weight-bold">Informasi Pesanan</h6>' +
                    '<table class="table table-sm table-borderless">' +
                        '<tr>' +
                            '<td width="40%">Nomor Pesanan:</td>' +
                            '<td width="60%"><strong>#<?php echo $order['pesanan_id']; ?></strong></td>' +
                        '</tr>' +
                        '<tr>' +
                            '<td>Tanggal:</td>' +
                            '<td><?php echo date('d/m/Y', strtotime($order['tanggal_pemesanan'])); ?></td>' +
                        '</tr>' +
                        '<tr>' +
                            '<td>Status:</td>' +
                            '<td><span class="badge <?php echo $order['status'] == 'Selesai' ? 'badge-success' : 'badge-danger'; ?>"><?php echo $order['status']; ?></span></td>' +
                        '</tr>' +
                    '</table>' +
                '</div>' +
                '<div class="col-md-6">' +
                    '<h6 class="font-weight-bold">Informasi Pelanggan</h6>' +
                    '<table class="table table-sm table-borderless">' +
                        '<tr>' +
                            '<td width="40%">Nama:</td>' +
                            '<td width="60%"><?php echo htmlspecialchars($order['nama_pelanggan']); ?></td>' +
                        '</tr>' +
                        '<tr>' +
                            '<td>Kontak:</td>' +
                            '<td><?php echo htmlspecialchars($order['kontak']); ?></td>' +
                        '</tr>' +
                        '<tr>' +
                            '<td>ID Pelanggan:</td>' +
                            '<td><?php echo $order['pelanggan_id']; ?></td>' +
                        '</tr>' +
                    '</table>' +
                '</div>' +
            '</div>' +
            '<div class="row mt-4">' +
                '<div class="col-12">' +
                    '<h6 class="font-weight-bold">Detail Item Pesanan</h6>' +
                    '<div class="table-responsive">' +
                        '<table class="table table-bordered">' +
                            '<thead class="thead-light">' +
                                '<tr>' +
                                    '<th>Menu</th>' +
                                    '<th class="text-center">Harga</th>' +
                                    '<th class="text-center">Qty</th>' +
                                    '<th class="text-right">Subtotal</th>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody>';
                            
                            <?php foreach ($order['items'] as $item): ?>
                            detailContent += '<tr>' +
                                '<td><?php echo htmlspecialchars($item['nama']); ?></td>' +
                                '<td class="text-center">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>' +
                                '<td class="text-center"><?php echo $item['qty']; ?></td>' +
                                '<td class="text-right">Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>' +
                            '</tr>';
                            <?php endforeach; ?>
                            
                            detailContent += '</tbody>' +
                            '<tfoot>' +
                                '<tr class="bg-light">' +
                                    '<th colspan="3" class="text-right">Total:</th>' +
                                    '<th class="text-right">Rp <?php echo number_format($order['total'], 0, ',', '.'); ?></th>' +
                                '</tr>' +
                            '</tfoot>' +
                        '</table>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '<div class="row mt-3">' +
                '<div class="col-12">' +
                    '<h6 class="font-weight-bold">Catatan Riwayat</h6>' +
                    '<p class="text-muted">Pesanan ini telah <?php echo strtolower($order['status']); ?> pada <?php echo date('d/m/Y H:i', strtotime($order['tanggal_pemesanan'] . ' +2 hours')); ?>.</p>' +
                '</div>' +
            '</div>';
        }
        <?php endforeach; ?>
        
        if (!orderFound) {
            detailContent = '<div class="alert alert-warning">' +
                '<i class="fas fa-exclamation-triangle"></i> Data pesanan dengan ID ' + pesananId + ' tidak ditemukan.' +
            '</div>';
        }
        
        modal.find('#detailPesananContent').html(detailContent);
    }, 500); // 500ms delay untuk simulasi loading
});
    
    // Fungsi cetak detail pesanan
    function printDetailPesanan() {
        var printContents = document.getElementById('detailPesananContent').innerHTML;
        var originalContents = document.body.innerHTML;
        
        document.body.innerHTML = `
            <div class="container mt-4">
                <h4 class="text-center mb-4">Detail Riwayat Pesanan - BITENEST</h4>
                ${printContents}
            </div>
        `;
        
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
});
</script>

<!-- Tambahan script untuk laporan dan ekspor data -->
<script>
$(document).ready(function() {
    // Fungsi untuk ekspor data ke Excel (contoh implementasi sederhana)
    function exportToExcel() {
        // Di implementasi nyata, ini akan menggunakan AJAX atau form submission
        // ke endpoint server yang menghasilkan file Excel
        alert('Fitur ekspor ke Excel akan diimplementasikan di server.');
    }
    
    // Fungsi untuk membuat laporan pendapatan
    function generateIncomeReport() {
        // Implementasi sederhana, pada sistem nyata akan memanggil endpoint laporan
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        
        if (!startDate || !endDate) {
            alert('Silakan pilih rentang tanggal terlebih dahulu.');
            return;
        }
        
        // Redirect ke halaman laporan dengan parameter tanggal
        window.location.href = 'laporan_pendapatan.php?start=' + startDate + '&end=' + endDate;
    }
    
    // Tambahkan event handler jika diperlukan
    $('#btnExportExcel').on('click', exportToExcel);
    $('#btnGenerateReport').on('click', generateIncomeReport);
});
</script>

</body>
</html>