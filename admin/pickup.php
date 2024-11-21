<?php
include '../koneksi.php';
$dataCustomer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id DESC");
$id = isset($_GET['ambil']) ? $_GET['ambil'] : "";
$queryTransDetail = mysqli_query($koneksi, "SELECT 
customer.nama_customer, 
customer.phone, 
customer.address, 
data_transaksi.id_customer,
data_transaksi.kode_order, 
data_transaksi.tanggal_order, 
data_transaksi.status_order, 
paket.nama_paket, 
paket.harga, 
detail_transaksi.* 
FROM detail_transaksi 
LEFT JOIN data_transaksi ON data_transaksi.id = detail_transaksi.id_order
LEFT JOIN customer ON customer.id = data_transaksi.id_customer
LEFT JOIN paket ON paket.id = detail_transaksi.id_paket 
WHERE detail_transaksi.id_order = '$id'");

$row = [];
while ($dataTrans = mysqli_fetch_assoc($queryTransDetail)) {
    $row[] = $dataTrans;
}
$queryPaket = mysqli_query($koneksi, "SELECT * FROM paket ORDER BY id DESC");
$rowPaket = [];
while ($data = mysqli_fetch_assoc($queryPaket)) {
    $rowPaket[] = $data;
}

$queryTransPickup = mysqli_query($koneksi, "SELECT * FROM pickup WHERE id_order = '$id'"); //id diambil dari line 4

// Handle form submissions, mengambil  nilai input dgn attribute name="" di form
if (isset($_POST['simpan_transaksi'])) {
    $id_customer = $_POST['id_customer'];
    $id_order = $_POST['id_order'];
    $pickup_pay = $_POST['pickup_pay'];
    $pickup_change = $_POST['pickup_change'];
    $pickup_date = date("Y-m-d");

    // Insert into table pickup
    $insert = mysqli_query($koneksi, "INSERT INTO pickup (id_customer, id_order, pickup_pay, pickup_change, pickup_date) VALUES ('$id_customer', '$id_order', '$pickup_pay', '$pickup_change', '$pickup_date')");

    //ubah status order jadi 1 = sudah diambil
    $updateTransOrder = mysqli_query($koneksi, "UPDATE data_transaksi SET status_order = 1 WHERE id = '$id_order'");



    header("location:data-transaksi.php?pickup=berhasil");
}


function generateTransactionCode()
{
    $kode = date('ymdHis');

    return $kode;
}

//no invoice kode
//001, jika ada auto increment id +1 = 002, selain itu 001
// select max adalah mencari data yg terbesar, min terkecil
$queryInvoice = mysqli_query($koneksi, "SELECT MAX(id) AS no_invoice FROM detail_transaksi");
//membuat string unik
$str_unique  = "INV";
$date_now   = date("dmY");
//jika di dalam tabel trans_order ada datanya 
if (mysqli_num_rows($queryInvoice) > 0) {
    $rowInvoice = mysqli_fetch_assoc($queryInvoice);
    $incrementPlus = $rowInvoice['no_invoice'] + 1; //no_invoice adalah alias yg sudah dibuat untuk id
    $code = $str_unique . "" . $date_now . "" . "000" . $incrementPlus;
} else {
    $code = $str_unique . "" . $date_now . "" . "0001";
}

?>
<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <?php include '../inc/head.php' ?>
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

                <?php include '../inc/nav.php' ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?php if (isset($_GET['ambil'])) : ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>Pengambilan Laundry <?php echo $row[0]['nama_customer'] ?></h5>
                                                </div>
                                                <div class="col-sm-6" align="right">
                                                    <a href="data-transaksi.php" class="btn btn-secondary">Kembali</a>
                                                    <a href="print.php?id=<?php echo $id ?>" class="btn btn-success">Print</a>
                                                    <a href="" class="btn btn-warning">Ambil Cucian</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Transaksi</h5>
                                        </div>
                                        <?php include 'helper.php' ?>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr> <!-- mengapa tidak memakai foreach karena invoice satu untuk banyak transaksi, semantara foreach digunakan untuk memanggil seluruh data dri satu invoice -->
                                                    <th>No Invoice</th>
                                                    <td><?php echo $row[0]['kode_order'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Laundry</th>
                                                    <td><?php echo $row[0]['tanggal_order'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><?php echo changeStatus($row[0]['status_order']) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Customer</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?php echo $row[0]['nama_customer'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Telepon</th>
                                                    <td><?php echo $row[0]['phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?php echo $row[0]['address'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Transaksi Detail</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Qty</th>
                                                            <th>Nama Paket</th>
                                                            <th>Harga</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $total = 0; // $total dimasukkan keatas foreach agar kembali k nol
                                                        foreach ($row as $key => $value) : ?>
                                                            <tr>
                                                                <td><?php echo $no++ ?></td>
                                                                <td><?php echo $value['nama_paket'] ?></td>
                                                                <td><?php echo $value['qty'] ?></td>
                                                                <td><?php echo $value['harga'] ?></td>
                                                                <td><?php echo $value['subtotal'] ?></td>
                                                            </tr>
                                                            <?php
                                                            $total += $value['subtotal'];
                                                            ?>
                                                            <!-- koding dibuat di dalam foreach agar setiap jumlah yg ditambahkan akan terotomatis terhitung -->
                                                        <?php endforeach ?>
                                                        <tr>
                                                            <td colspan="4" align="right">
                                                                <strong>Total Keseluruhan</strong>
                                                            </td>
                                                            <td><strong><?php echo "Rp" . number_format($total) ?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align="right">
                                                                <strong>Dibayar</strong>
                                                            </td>
                                                            <td>
                                                                <strong>
                                                                    <?php if (mysqli_num_rows($queryTransPickup)): ?>
                                                                        <?php $rowTransPickup = mysqli_fetch_assoc($queryTransPickup) ?>
                                                                        <input type="text" name="pickup_pay" placeholder="Dibayar" class="form-control" value="<?php echo "Rp" . "" . number_format($rowTransPickup['pickup_pay'])  ?>" readonly>
                                                                    <?php else : ?>
                                                                        <input type="number" name="pickup_pay" placeholder="Dibayar" class="form-control" value="<?php echo isset($_POST['pickup_pay']) ? $_POST['pickup_pay'] : '' ?>">
                                                                    <?php endif ?>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align="right">
                                                                <strong>Kembalian</strong>
                                                            </td>
                                                            <?php if (isset($_POST['proses_kembalian'])) {
                                                                $total = $_POST['total'];
                                                                $dibayar = $_POST['pickup_pay'];

                                                                $kembalian = 0;
                                                                $kembalian = $dibayar - $total;
                                                            } ?>
                                                            <td>
                                                                <input type="hidden" name="total" value="<?php echo $total ?>">
                                                                <input type="hidden" name="id_customer" value="<?php echo $row[0]['id_customer'] ?>">
                                                                <input type="hidden" name="id_order" value="<?php echo $row[0]['id_order'] ?>">
                                                                <strong>
                                                                    <?php if (mysqli_num_rows($queryTransPickup) > 0): ?> <!-- mysqli_num_row digunakan untuk mengecek apakah data ada didatabase -->
                                                                        <input type="text" name="pickup_change" placeholder="Kembalian" class="form-control" value="<?php echo "Rp" . "" . number_format($rowTransPickup['pickup_change']) ?>" readonly>
                                                                    <?php else : ?>
                                                                        <input type="text" name="pickup_change" placeholder="Kembalian" class="form-control" value="<?php echo isset($kembalian) ? number_format($kembalian) : 0 ?>" readonly>
                                                                    <?php endif ?>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <?php if ($row[0]['status_order'] == 0): ?>
                                                            <tr>
                                                                <td colspan="5" align="right">
                                                                    <strong>
                                                                        <button class="btn btn-primary" name="proses_kembalian">Prosess Kembalian</button>
                                                                        <button class="btn btn-success" name="simpan_transaksi">Simpan Transaksi</button>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                        <?php endif ?>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>

                        <div class="container-xxl flex-grow-1 container-p-y">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">Data berhasil dihapus</div>
                                                <?php endif ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Nama Customer</label>
                                                        <select name="id_customer" id="" class="form-control">
                                                            <option value="">pilih customer</option>
                                                            <?php while ($resultCustomer = mysqli_fetch_assoc($dataCustomer)) : ?>
                                                                <option value="<?= $resultCustomer['id'] ?>">
                                                                    <?= $resultCustomer['nama_customer'] ?>
                                                                </option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Kode Order</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="kode_order"
                                                            value="#<?php echo $code ?>"
                                                            readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Tanggal Order</label>
                                                        <input type="date"
                                                            class="form-control"
                                                            name="tanggal_order"
                                                            placeholder=""
                                                            value="<?php echo isset($_GET['edit']) ? $rowDataTransaksi['tanggal_order'] : '' ?>"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">Detail Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">Data berhasil dihapus</div>
                                                <?php endif ?>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-3">
                                                        <label for="" class="form-label">Paket</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <select class="form-control" name="id_paket[]" id="">
                                                            <option value="">--pilih paket--</option>
                                                            <?php foreach ($rowPaket as $key => $value) { ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nama_paket'] ?></option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-3">
                                                        <label for="" class="form-label">Qty</label>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <input type="number" name="qty[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-3">
                                                        <label for="" class="form-label">Paket</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <select class="form-control" name="id_paket[]" id="">
                                                            <option value="">--pilih paket--</option>
                                                            <?php foreach ($rowPaket as $key => $value) { ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nama_paket'] ?></option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-3">
                                                        <label for="" class="form-label">Qty</label>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <input type="number" name="qty[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>" type="submit">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endif ?>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include '../inc/footer.php'; ?>
</body>

</html>