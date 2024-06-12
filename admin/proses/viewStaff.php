<?php require_once '../../config/koneksi.php';
include '../_header.php';

if (isset($_GET['userID'])) {
    $user = $_GET['userID'];

    $select = "SELECT * FROM user2 WHERE userID = '$user'";
    $resultSelect = $conn->query($select);

    if ($resultSelect) {
        // Ambil hasil query
        $row = $resultSelect->fetch_assoc();
        $username = $row['username'];
        $namaLengkap = $row['namaUser'];
        $notelp = $row['notelp'];
        $status = $row['status'];
        $gambar = $row['gambar'];
        $hakAkses = $row['hakAkses'];
    }
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../staff.php">Staff</a></div>
                <div class="breadcrumb-item">Detail Staff</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Detail Staff</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <center class="mb-3">
                                    <img src="../../assets/img/user/<?= $gambar; ?>" class="img-fluid " height="400" alt="">
                                </center>
                            </div>
                            <div class="col-md-7">
                                <div class="card profile-widget">
                                    <div class="profile-widget-description shadow">
                                        <table class="table ">
                                            <tbody>
                                                <tr>
                                                    <td><span class="h5">username</span> : <?= $username ?></td>
                                                    <td><span class="h5">Nama</span> : <?= $namaLengkap ?></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="h5">No Telp</span> : <?= $notelp ?></td>
                                                    <td><span class="h5">Akses</span> : <?= $hakAkses ?></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="h5">Status</span> : <?= $status ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../_footer.php'; ?>