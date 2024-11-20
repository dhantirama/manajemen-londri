<?php
include '../koneksi.php';
$dataCustomer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id DESC");
$id = isset($_GET['detail']) ? $_GET['detail'] : "";
$queryTransDetail = $queryTransDetail = mysqli_query($koneksi, "SELECT 
customer.nama_customer, 
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

// Handle form submissions, mengambil  nilai input dgn attribute name="" di form
if (isset($_POST['simpan'])) {
    $id_customer = $_POST['id_customer'];
    $kode_order = $_POST['kode_order'];
    $tanggal_order = $_POST['tanggal_order'];

    $id_paket = $_POST['id_paket'];
    // print_r($_POST);
    // die; debugging untuk melihat apakah nilai keluar
    $qty = $_POST['qty'];

    // Insert into table data_transaksi
    $insertTransOrder = mysqli_query($koneksi, "INSERT INTO data_transaksi (id_customer, kode_order, tanggal_order) VALUES ('$id_customer', '$kode_order', '$tanggal_order')");

    $last_id = mysqli_insert_id($koneksi);

    //insert ke detail_transaksi
    //mengambil nilai lebih dari satu, looping dengan foreach
    foreach ($id_paket as $key => $value) {
        // Check if the service ID and quantity are valid
        if (!empty($value) && !empty($qty[$key]) && (int)$qty[$key] > 0) {
            $id_paket = $value; // Current service ID
            $quantity = (int)$qty[$key]; // Current quantity

            //query untuk mengambil harga dari tabel paket
            $queryPaket = mysqli_query($koneksi, "SELECT harga FROM paket WHERE id='$id_paket'");
            if ($rowPaketTransc = mysqli_fetch_assoc($queryPaket)) {
                $harga = $rowPaketTransc['harga'];
                // print_r($rowPaket);
                // die; //debugging
                //subTotal
                $subTotal = $quantity * $harga;

                // Insert into trans_order_detail
                $insertDetailTransaksi = mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_order, id_paket, qty, subTotal) VALUES ('$last_id', '$id_paket', '$quantity', '$subTotal')");
            }
        }
    }

    header("location:data-transaksi.php?tambah=berhasil");
}


$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryDataTransaksi = mysqli_query($koneksi, "SELECT * FROM data_transaksi WHERE id ='$id'");
$rowDataTransaksi = mysqli_fetch_assoc($queryDataTransaksi);

//jika button edit di klik
// if (isset($_POST['edit'])) {
//     $id_customer = $_POST['id_customer'];
//     $kode_order = $_POST['kode_order'];
//     $tanggal_order = $_POST['tanggal_order'];
//     $status_order = $_POST['status_order'];

//     $update = mysqli_query($koneksi, "UPDATE data_transaksi SET id_customer='$id_customer',kode_order='$kode_order',tanggal_order='$tanggal_order',status_order='$status_order' WHERE id='$id'");
//     header("location:data-transaksi.php?ubah=berhasil");
// }


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
                    <?php if (isset($_GET['detail'])) : ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3"></div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Transaksi</h5>
                                        </div>
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
                                                    <td><?php echo $row[0]['status_order'] ?></td>
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
                                                    <td><?php echo $row[0]['telepon'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?php echo $row[0]['alamat'] ?></td>
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
                                                    <?php $no = 1;
                                                    foreach ($row as $key => $value) : ?>
                                                        <tr>
                                                            <td><?php echo $no++ ?></td>
                                                            <td><?php echo $value['nama_paket'] ?></td>
                                                            <td><?php echo $value['qty'] ?></td>
                                                            <td><?php echo $value['harga'] ?></td>
                                                            <td><?php echo $value['subtotal'] ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
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