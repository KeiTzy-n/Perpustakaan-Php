<?php require_once '../../config/koneksi.php';
include '../_header.php';

if (isset($_GET['userID'])) {
    $user = $_GET['userID'];

    $select = "SELECT * FROM user WHERE userID = '$user'";
    $resultSelect = $conn->query($select);

    if ($resultSelect) {
        // Ambil hasil query
        $row = $resultSelect->fetch_assoc();
        $username = $row['username'];
        $namaLengkap = $row['namaLengkap'];
        $notelp = $row['notelp'];
        $alamat = $row['alamat'];
        $penjelasan = $row['penjelasan'];
        $coin = $row['coin'];
        $status = $row['status'];
        $gambar = $row['gambar'];
        $tgl_daftar = $row['tgl_daftar'];
    }
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../reader.php">Reader</a></div>
                <div class="breadcrumb-item">Detail Reader</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Detail Reader</h2>
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
                                                    <td>username : <?= $username ?></td>
                                                    <td>Nama : <?= $namaLengkap ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat : <?= $alamat ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Coin : <?= $coin ?></td>
                                                    <td>Status : <?= $status ?></td>
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