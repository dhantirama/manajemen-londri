<?php
include '../koneksi.php';
//aksi untuk tambah
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $id_level = $_POST['id_level'];

    $insert = mysqli_query($koneksi, "INSERT INTO  user  (id_level, nama, password, email, username) VALUES ('$id_level','$nama', '$password', '$email', '$username')");
    header("location:user.php?tambah=berhasil");
}

//aksi untuk edit
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $id_level = $_POST['id_level'];

    //jika password diisi dengan user
    if ($_POST['password']) {
        $password = $_POST['password'];
    } else {
        $password = $rowEdit['password'];
    }

    $update = mysqli_query($koneksi, "UPDATE user SET id_level= '$id_level', nama='$nama', email='$email', password='$password'  WHERE id='$id'");
    header("location:user.php?edit=berhasil");
}

$queryLvl = mysqli_query($koneksi, "SELECT * FROM level");
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
                                    <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> User</div>
                                    <div class="card-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3 row">
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="" name="nama" placeholder="Masukkan Nama Anda" required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['nama'] : '' ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="" name="email" placeholder="Masukkan Email Anda" required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['email'] : '' ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Username</label>
                                                    <input type="text" name="username" class="form-control" id="" value="<?php echo isset($_GET['edit']) ? $rowEdit['username'] : '' ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control" id="">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Nama Level</label>
                                                    <select name="id_level" class="form-control" id="">
                                                        <option value="">Pilih Level</option>
                                                        <?php while ($rowLevel = mysqli_fetch_assoc($queryLvl)): ?>
                                                            <option <?php echo isset($_GET['edit']) ? ($rowLevel['id'] == $rowEdit['id_level'] ? 'selected' : '') : '' ?> value="<?php echo $rowLevel['id'] ?>">
                                                                <?php echo $rowLevel['nama_level'] ?>
                                                            </option>
                                                        <?php endwhile ?>
                                                    </select>
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