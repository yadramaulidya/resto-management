<?php
// Mulai session dan pastikan file database telah dimasukkan
session_start();
require_once("../config.php");

// Ambil kategori dari URL jika ada
$selected_category = isset($_GET['kategori']) ? $_GET['kategori'] : 'all';
$filtered_menu = [];

// Ambil data kategori dari database
$query = "SELECT * FROM menu";
$result = mysqli_query($conn, $query);

// Filter menu berdasarkan kategori jika ada
if ($selected_category != 'all') {
    $query = "SELECT * FROM menu WHERE kategori = '$selected_category'";
    $result = mysqli_query($conn, $query);
} else {
    $query = "SELECT * FROM menu";
    $result = mysqli_query($conn, $query);
}

// Handle jika ada item yang ditambahkan ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tambah item ke keranjang
    if (isset($_POST['add_to_cart'])) {
        $menu_id = $_POST['menu_id'];
        $qty = $_POST['qty'];

        // Cari menu dengan ID tersebut
        $menu_query = "SELECT * FROM menu WHERE menu_id = $menu_id";
        $menu_result = mysqli_query($conn, $menu_query);
        $item = mysqli_fetch_assoc($menu_result);

        // Jika item sudah ada di keranjang, tambah qty
        $found = false;
        foreach ($_SESSION['cart'] as $key => $cart_item) {
            if ($cart_item['menu_id'] == $menu_id) {
                $_SESSION['cart'][$key]['qty'] += $qty;
                $found = true;
                break;
            }
        }

        // Jika item belum ada di keranjang, tambahkan baru
        if (!$found) {
            $cart_item = [
                'menu_id' => $item['menu_id'],
                'nama' => $item['nama'],
                'harga' => $item['harga'],
                'qty' => $qty,
                'subtotal' => $item['harga'] * $qty
            ];
            $_SESSION['cart'][] = $cart_item;
        }

        // Redirect untuk mencegah form resubmission
        header('Location: menu.php');
        exit;
    }

    // Kosongkan keranjang
    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = [];
        header('Location: menu.php');
        exit;
    }
}

// Hitung total belanja
$total_belanja = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_belanja += $item['harga'] * $item['qty'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Sistem Manajemen Restoran BITENEST</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            <li class="nav-item active">
                <a class="nav-link" href="menu.php">Menu</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> <?php echo $_SESSION['nama']; ?>
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

<div class="container mt-5">
    <h2>Menu - Pilih Menu Anda</h2>

    <div class="mb-3">
        <a href="menu.php?kategori=all" class="btn btn-primary">Semua Menu</a>
        <?php 
        // Menampilkan kategori menu
        $categories = ['Main Course', 'Appetizers', 'Desserts', 'Beverages', 'Snacks'];
        foreach ($categories as $category) {
            echo "<a href='menu.php?kategori=" . urlencode($category) . "' class='btn btn-outline-primary'>" . $category . "</a>";
        }
        ?>
    </div>

    <div class="row">
        <?php while ($item = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img class="card-img-top" src="images/<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $item['nama']; ?></h5>
                        <p class="card-text"><?php echo $item['deskripsi']; ?></p>
                        <p class="menu-price">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                        <form method="post" action="menu.php">
                            <input type="hidden" name="menu_id" value="<?php echo $item['menu_id']; ?>">
                            <div class="form-group">
                                <label for="qty">Jumlah</label>
                                <input type="number" name="qty" class="form-control" min="1" value="1">
                            </div>
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

</body>
</html>