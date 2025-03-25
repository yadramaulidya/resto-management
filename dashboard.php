<?php
include (".includes/header.php");
$title = "Dashboard";
include '.includes/toast_notification.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- tabel pesanan -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Daftar Pesanan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="datatable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">#</th>
                            <th>Pelanggan</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th width="150px">Pilihan</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        $index = 1;
                        $query = "SELECT pesanan.pesanan_id, pelanggan.nama AS pelanggan, menu.nama AS menu,pesanan.tanggal_pemesanan,pesanan.status 
                                  FROM pesanan
                                  INNER JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.pelanggan_id
                                  INNER JOIN menu ON pesanan.menu_id = menu.menu_id";
                        $exec = mysqli_query($conn, $query);

                        while ($pesanan = mysqli_fetch_assoc($exec)) :  
                        ?>
                        <tr>
                            <td><?= $index++; ?></td>
                            <td><?= $pesanan['pelanggan']; ?></td>
                            <td><?= $pesanan['menu']; ?></td>
                            <td><?= $pesanan['jumlah']; ?></td>
                            <td><?= $pesanan['status']; ?></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="edit_pesanan.php?id=<?= $pesanan['id']; ?>" class="dropdown-item">
                                            <i class="bx bx-edit-alt me-2"></i> Edit
                                        </a>                       
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                           data-bs-target="#deletePesanan_<?= $pesanan['id']; ?>">
                                            <i class="bx bx-trash me-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal Hapus Pesanan -->
                        <div class="modal fade" id="deletePesanan_<?= $pesanan['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Pesanan?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="proses_pesanan.php" method="POST">
                                            <p>Tindakan ini tidak bisa dibatalkan.</p>
                                            <input type="hidden" name="pesananID" value="<?= $pesanan['id']; ?>">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" name="delete" class="btn btn-primary">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- daftar menu -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Daftar Menu</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="datatable2" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">#</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        $index = 1;
                        $query = "SELECT menu_id, nama, harga FROM menu";
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
    </div>

    <!-- daftar pelanggan -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Daftar Pelanggan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="datatable3" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        $index = 1;
                        $query = "SELECT pelanggan_id, nama, kontak FROM pelanggan";
                        $exec = mysqli_query($conn, $query);

                        while ($pelanggan = mysqli_fetch_assoc($exec)) :  
                        ?>
                        <tr>
                            <td><?= $index++; ?></td>
                            <td><?= $pelanggan['nama']; ?></td>
                            <td><?= $pelanggan['kontak']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include (".includes/footer.php"); ?>