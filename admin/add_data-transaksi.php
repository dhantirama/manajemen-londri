<?php
include '../koneksi.php';
//aksi untuk tambah
if (isset($_POST['simpan'])) {
    $id_customer = $_POST['id_customer'];
    $kode_order = $_POST['kode_order'];
    $tanggal_order = $_POST['tanggal_order'];
    $status_order = $_POST['status_order'];

    $insert = mysqli_query($koneksi, "INSERT INTO  data_transaksi (id_customer, kode_order, tanggal_order, status_order) VALUES ('$data_transaksi', '$id_customer', '$kode_order', '$tanggal_order', '$status_order')");
    header("location:data-transaksi.php?tambah=berhasil");
}

//aksi untuk edit
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM data_transaksi WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
    $id_customer = $_POST['id_customer'];
    $kode_order = $_POST['kode_order'];
    $tanggal_order = $_POST['tanggal_order'];
    $status_order = $_POST['status_order'];

    $update = mysqli_query($koneksi, "UPDATE data_transaksi SET id_customer='$id_customer', kode_order='$kode_order', tanggal_order='$tanggal_order', '$status_order'  WHERE id='$id'");
    header("location:data-transaksi.php?edit=berhasil");
}

?>

<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/admin/assets//admin/assets//"
    data-template="vertical-menu-template-free">

<head>
    <?php include '../inc/head.php'; ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include '../inc/sidebar.php'; ?>
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
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                                    <div class="card-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3 row">
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Nama Customer</label>
                                                    <input type="text" class="form-control" id="" name="nama_customer" placeholder="Masukkan Nama Customer" required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_customer'] : '' ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Kode Transaksi</label>
                                                    <input type="kode_transaksi" class="form-control" id="" name="phone" placeholder="Masukkan Email Anda" required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['kode_transaksi'] : '' ?>">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">Address</label>
                                                    <textarea name="address" id="" class="form-control" cols="20" rows="5"><?php echo isset($_GET['edit']) ? $rowEdit['address'] : '' ?></textarea>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>" type="submit">Simpan</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->
        <?php include '../inc/js.php'; ?>
    </div>
</body>

</html>