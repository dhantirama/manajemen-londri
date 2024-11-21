<?php

include '../koneksi.php';
$tanggal_dari = isset($_GET['tanggal_dari']) ? $_GET['tanggal_dari'] : '';
$tanggal_sampai = isset($_GET['tanggal_sampai']) ? $_GET['tanggal_sampai'] : '';
$status = isset($_GET['status_order']) ? $_GET['status_order'] : '';
$query = "SELECT customer.nama_customer, data_transaksi.* FROM data_transaksi LEFT JOIN customer ON customer.id = data_transaksi.id_customer WHERE 1";

//jika status tidak kosong

if ($tanggal_dari != "") {
    $query .= " AND tanggal_order >= '$tanggal_dari'";
}
if ($tanggal_sampai != "") {
    $query .= " AND tanggal_order <= '$tanggal_sampai'";
}
if ($status != "") {
    $query .= " AND status_order = '$status'";
}
$query .= " ORDER BY data_transaksi.id DESC";
$queryTransaksi = mysqli_query($koneksi, $query);

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
                                <h5 class="card-header">Transaksi Laundry</h5>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <form action="" method="get">
                                            <div class="mb-3 row">
                                                <div class="col-sm-3">
                                                    <label for="">Dari Tanggal</label>
                                                    <input type="date" name="tanggal_dari" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="">Sampai Tanggal</label>
                                                    <input type="date" name="tanggal_dari" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="">Status</label>
                                                    <select name="status_order" id="" class="form-control">
                                                        <option value="">--Pilih Status--</option>
                                                        <option value="0">Baru</option>
                                                        <option value="1">Sudah Kembali</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mt-4">
                                                    <button name="filter" class="btn btn-primary">Tampilkan Laporan</button>
                                                </div>
                                            </div>
                                        </form>
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
                                                while ($rowTransaksi = mysqli_fetch_assoc($queryTransaksi)) : ?>
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
                                                            | <a target="_blank" href="print.php?id=<?php echo $rowTransaksi['id'] ?>"><i class='bx bx-printer'></i></a> | </td>
                                                        </td>
                                                    </tr>
                                                <?php endwhile ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include '../inc/footer.php' ?>

</body>

</html>