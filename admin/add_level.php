<?php
include '../koneksi.php';
if (isset($_POST['tambah'])) {
    $nama_level = $_POST['nama_level'];

    $insert = mysqli_query($koneksi, "INSERT INTO level (nama_level) VALUES ('$nama_level')");

    header("location: level.php?edit=berhasil");
}

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$editLvl = mysqli_query($koneksi, "SELECT * FROM level where id= '$id'");
$rowLvl = mysqli_fetch_assoc($editLvl);

if (isset($_POST['edit'])) {
    $nama_level = $_POST['nama_level'];

    $update = mysqli_query($koneksi, "UPDATE level SET nama_level='$nama_level' WHERE id='$id'");
    header("location: level.php?edit=berhasil");
}

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

            <?php include '../inc/sidebar.php'; ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include '../inc/nav.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="wrapper">
                    <div class="container mt-5">
                        <div class="row">
                            <div col-sm-12>
                                <fieldset class="border border-2 p-3" style="border-width: 2px; border-color: black; border-style: solid;">
                                    <legend class="float-none w-auto px-3"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Level</legend>
                                    <form action="" method="post">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Level Ke-</label>
                                            <input type="text" class="form-control" name="nama_level" placeholder="Masukkan level" value="<?php echo isset($_GET['edit']) ? $rowLvl['nama_level'] : '' ?>">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-success" name="<?php echo isset($_GET['edit']) ? 'edit' : 'tambah' ?>">Simpan</button>
                                        </div>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
        </div>
        <!-- / Layout wrapper -->
    </div>
    <div class="layout-overlay layout-menu-toggle">

        <?php include '../inc/footer.php'; ?>
    </div>
</body>

</html>