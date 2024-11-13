<?php

include 'koneksi.php';
//munculkan satu atau semua kolom dari tabel user
$queryUser = mysqli_query($koneksi, "SELECT * FROM user");
//mysqli_fetch_assoc = untuk menjadikan hasil query menjadi sebuah data (object, atau array)

//jika parameternya ada ?delete=nilai param
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; //mengambil nilai parameter

    //query perintah hapus
    $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$id'");
    header("location:user.php?hapus=berhasil");
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
    data-assets-path="../assets/admin/assets//admin/assets//"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />
    <?php include 'inc/head.php'; ?>

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include 'inc/sidebar.php'; ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include 'inc/nav.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <!--/ Total Revenue -->
                            <div class="col-12 col-md-8 col-lg-12 order-3 order-md-2">
                                <div class="row">
                                    <div class="col-sm-12 card">
                                        <div class="card-header">Data User</div>
                                        <div class="table-responsive text-nowrap">
                                            <?php if (isset($_GET['hapus'])):  ?>
                                                <div class="alert alert-primary" role="alert">Data Berhasil Dihapus</div>
                                            <?php endif ?>
                                            <div align="right" class="mb-3 just"><a href="tambah_user.php" class="btn btn-primary btn-sm"><span class="tf-icon bx bx-pencil bx-18px"></span> Tambah </a></div>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Level</th>
                                                        <th>Nama</th>
                                                        <th>Email</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    <?php $no = 1;
                                                    while ($row = mysqli_fetch_assoc($queryUser)) { ?>
                                                        <tr>
                                                            <td><?php echo $no++ ?></td>
                                                            <td><?php echo $row['nama_level'] ?></td>
                                                            <td><?php echo $row['nama'] ?></td>
                                                            <td><?php echo $row['email'] ?></td>
                                                            <td><a href="tambah_user.php?edit=<?php echo $row['id'] ?>" class="btn btn-primary btn-sm"><span class="tf-icon bx bx-pencil bx-18px"></span></a> <a onclick="return confirm('Apakah anda yakin akan menghapus data ini??')" href="user.php?delete=<?php echo $row['id'] ?>" class="btn btn-secondary btn-sm"><span class="tf-icon bx bx-trash bx-18px"></span></a></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                </div>
                            </div>
                            <div class="row">

                            </div>
                        </div>
                        <!-- / Content -->

                        <!-- Footer -->
                        <?php include 'inc/footer.php'; ?>
                        <!-- / Footer -->

                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->


        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <?php include 'inc/js.php'; ?>
</body>

</html>