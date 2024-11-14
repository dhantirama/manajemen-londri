<?php

include '../koneksi.php';
$siswa = mysqli_query($koneksi, "SELECT jurusan.jurusan, gelombang.gelombang, peserta_pelatihan.* FROM peserta_pelatihan LEFT JOIN gelombang ON gelombang.id = peserta_pelatihan.id_gelombang LEFT JOIN jurusan ON jurusan.id = peserta_pelatihan.id_jurusan WHERE peserta_pelatihan.status = 1 ORDER BY id DESC ");

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = mysqli_query($koneksi, "UPDATE peserta_pelatihan SET status = 2 WHERE id ='$id'");
    header("location: wawancara.php");
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
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../page/backend/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../page/backend/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../page/backend/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../page/backend/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../page/backend/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../page/backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../page/backend/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../page/backend/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../page/backend/assets/js/config.js"></script>
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
                <?php include '../inc/header.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="card">
                                <h5 class="card-header">Data Pendaftar</h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Lengkap</th>
                                                <th>Gelombang</th>
                                                <th>Kejuruan</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <?php $no = 1;
                                            while ($rowSiswa = mysqli_fetch_assoc($siswa)) : ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $rowSiswa['nama_lengkap'] ?></td>
                                                    <td><?php echo $rowSiswa['gelombang'] ?></td>
                                                    <td><span class="badge bg-label-primary me-1"><?php echo $rowSiswa['jurusan'] ?></td></span>
                                                    <td>
                                                        <a href="data-siswa.php?edit=<?php echo $rowSiswa['id'] ?>" class="<?php echo $rowSiswa['status'] == 1 ? 'btn btn-warning' : 'btn btn-success' ?>"><?php echo $rowSiswa['status'] == 1 ? 'Lolos' : 'Wawancara' ?></a>
                                                    </td>
                                                    <td>| <a href="details-siswa.php?edit=<?php echo $rowSiswa['id'] ?>"><i class='bx bx-edit-alt'></i></a> | | <a href="data-siswa.php?delete=<?php echo $rowSiswa['id'] ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini??')"><i class='bx bx-trash'></i> |</a></td>
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

                    <?php include '../inc/koneksi.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>