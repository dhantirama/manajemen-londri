<?php
include '../koneksi.php';
//aksi untuk tambah
if (isset($_POST['simpan'])) {
    $nama_customer = $_POST['nama_customer'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $insert = mysqli_query($koneksi, "INSERT INTO  customer (nama_customer, phone, address) VALUES ('$nama_customer', '$phone', '$address')");
    header("location:customer.php?tambah=berhasil");
}

//aksi untuk edit
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM customer WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
    $nama_customer = $_POST['nama_customer'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update = mysqli_query($koneksi, "UPDATE customer SET address='$address', nama_customer='$nama_customer', phone='$phone'  WHERE id='$id'");
    header("location:customer.php?edit=berhasil");
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
                                    <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Customer</div>
                                    <div class="card-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3 row">
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="" name="nama_customer" placeholder="Masukkan Nama Customer" required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_customer'] : '' ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Telephone</label>
                                                    <input type="number" class="form-control" id="" name="phone" placeholder="Masukkan Email Anda" required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['phone'] : '' ?>">
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