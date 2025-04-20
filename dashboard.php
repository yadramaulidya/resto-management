<?php
include(".includes/header.php");
$title = "Dashboard";
include '.includes/toast_notification.php';

// Cek role user
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
?>

<div class="container-xxl flex-grow-1 container-p-y">

<?php if ($role === 'admin') : ?>
    <!-- DAFTAR PESANAN -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Daftar Pesanan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="datatable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 1;
                        $query = "SELECT pesanan.*, users.nama AS pelanggan, menu.nama AS menu
                                  FROM pesanan
                                  INNER JOIN users ON pesanan.user_id = users.user_id
                                  INNER JOIN menu ON pesanan.menu_id = menu.menu_id";
                        $exec = mysqli_query($conn, $query);

                        while ($pesanan = mysqli_fetch_assoc($exec)) : ?>
                        <tr>
                            <td><?= $index++; ?></td>
                            <td><?= $pesanan['pelanggan']; ?></td>
                            <td><?= $pesanan['menu']; ?></td>
                            <td><?= $pesanan['jumlah']; ?></td>
                            <td><?= $pesanan['status']; ?></td>
                            <td>
                                <!-- Aksi Dropdown -->
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="edit_pesanan.php?id=<?= $pesanan['pesanan_id']; ?>" class="dropdown-item">
                                            <i class="bx bx-edit-alt me-2"></i> Edit
                                        </a>
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deletePesanan_<?= $pesanan['pesanan_id']; ?>">
                                            <i class="bx bx-trash me-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="deletePesanan_<?= $pesanan['pesanan_id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="proses_pesanan.php" method="POST" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Pesanan?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Tindakan ini tidak bisa dibatalkan.</p>
                                        <input type="hidden" name="pesananID" value="<?= $pesanan['pesanan_id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="delete" class="btn btn-primary">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DAFTAR MENU -->
    <div class="card mt-4">
        <div class="card-header"><h4>Daftar Menu</h4></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    $query = "SELECT * FROM menu";
                    $exec = mysqli_query($conn, $query);
                    while ($menu = mysqli_fetch_assoc($exec)) :
                    ?>
                    <tr>
                        <td><?= $index++; ?></td>
                        <td><?= $menu['nama']; ?></td>
                        <td><?= $menu['harga']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- DAFTAR PELANGGAN -->
    <div class="card mt-4">
        <div class="card-header"><h4>Daftar Pelanggan</h4></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    $query = "SELECT * FROM users WHERE role = 'pelanggan'";
                    $exec = mysqli_query($conn, $query);
                    while ($user = mysqli_fetch_assoc($exec)) :
                    ?>
                    <tr>
                        <td><?= $index++; ?></td>
                        <td><?= $user['nama']; ?></td>
                        <td><?= $user['kontak']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php else : ?>
    <!-- DASHBOARD PELANGGAN -->
    <div class="card">
        <div class="card-header"><h4>Pesanan Kamu</h4></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    $query = "SELECT pesanan.*, menu.nama AS menu
                              FROM pesanan
                              INNER JOIN menu ON pesanan.menu_id = menu.menu_id
                              WHERE pesanan.user_id = $user_id";
                    $exec = mysqli_query($conn, $query);
                    while ($pesanan = mysqli_fetch_assoc($exec)) :
                    ?>
                    <tr>
                        <td><?= $index++; ?></td>
                        <td><?= $pesanan['menu']; ?></td>
                        <td><?= $pesanan['jumlah']; ?></td>
                        <td><?= $pesanan['status']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

</div>

<?php include(".includes/footer.php"); ?>