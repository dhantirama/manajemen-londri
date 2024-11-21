<?php

include '../koneksi.php';
$transaksi = mysqli_query($koneksi, "SELECT customer.nama_customer, data_transaksi.* FROM data_transaksi LEFT JOIN customer ON customer.id = data_transaksi.id_customer ORDER BY id DESC");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM customer WHERE id='$id'");
    header("location: data-transaksi.php?hapus=berhasil");
}

// 

?>
<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../page/backend/assets/"
    data-template="vertical-menu-template-free">

<head>
    <?php include '../inc/head.php'; ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include '../inc/sidebar.php' ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include '../inc/nav.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="card">
                                <h5 class="card-header">Customer</h5>
                                <div align="right">
                                    <a href="add_data-transaksi.php" class="btn btn-success"><i class="fa-solid fa-square-plus"></i>Tambah</a>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Customer</th>
                                                <th>Kode Order</th>
                                                <th>Tanggal Order</th>
                                                <th>Status Order</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <?php $no = 1;
                                            while ($rowTransaksi = mysqli_fetch_assoc($transaksi)) : ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $rowTransaksi['nama_customer'] ?></td>
                                                    <td><?php echo $rowTransaksi['kode_order'] ?></td>
                                                    <td><?php echo $rowTransaksi['tanggal_order'] ?></td>
                                                    <td>
                                                        <?php
                                                        switch ($rowTransaksi['status_order']) {
                                                            case '1':
                                                                $badge = "<span class='badge bg-success'>Sudah dikembalikan</span>";
                                                                break;

                                                            default:
                                                                $badge = "<span class='badge bg-warning'>Baru</span>";
                                                                break;
                                                        }
                                                        echo $badge;
                                                        ?></td>
                                                    <td>| <a target="_blank" href="add_data-transaksi.php?detail=<?php echo $rowTransaksi['id'] ?>"><i class='bx bx-show'></i></a>
                                                        | <a target="_blank" href="print.php?id=<?php echo $rowTransaksi['id'] ?>"><i class='bx bx-printer'></i></a> | | <a href="transaksi.php?delete=<?php echo $rowTransaksi['id'] ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini??')"><i class='bx bx-trash'></i> |</a></td>
                                                    </td>
                                                </tr>
                                            <?php endwhile ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include '../inc/footer.php' ?>

</body>

</html>