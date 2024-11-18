<?php

include '../koneksi.php';
$paket = mysqli_query($koneksi,"SELECT * FROM paket ORDER BY id DESC");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM paket WHERE id='$id'");
    header("location: paket.php?hapus=berhasil");
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
                                <h5 class="card-header">Daftar Paket</h5>
                                    <div align="right">
                                        <a href="add_paket.php" class="btn btn-success"><i class="fa-solid fa-square-plus"></i>Tambah</a>
                                    </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Paket</th>
                                                <th>Harga</th>
                                                <th>Deskripsi</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <?php $no = 1;
                                            while ($rowPaket = mysqli_fetch_assoc($paket)) : ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $rowPaket['nama_paket'] ?></td>
                                                    <td><?php echo $rowPaket['harga'] ?></td>
                                                    <td><?php echo $rowPaket['deskripsi'] ?></td>
                                                    <td>| <a href="add_paket.php?edit=<?php echo $rowPaket['id'] ?>"><i class='bx bx-edit-alt'></i></a> | | <a href="paket.php?delete=<?php echo $rowPaket['id'] ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini??')"><i class='bx bx-trash'></i> |</a></td>
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