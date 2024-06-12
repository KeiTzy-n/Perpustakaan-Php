<?php require_once '../../config/koneksi.php';
include '../_header.php';

if (isset($_GET['pinjam'])) {
    $pinjamID = $_GET['pinjam'];

    $pinjam = "SELECT * FROM peminjaman WHERE pinjamID = '$pinjamID'";
    $pinjamResult = $conn->query($pinjam);

    if ($pinjamResult) {
        $row = mysqli_fetch_assoc($pinjamResult);

        $user = $row['userID'];
        $buku = $row['bukuID'];
        $namaPeminjam = $row['namaUser'];
        $namaBuku = $row['namaBuku'];
        $namaPetugas = $row['namaPetugas'];
        $jumlah = $row['jumlah'];
        $statusPeminjaman = $row['statusPeminjaman'];
        $tglPengembalian = $row['tglPengembalian'];
        $coin = $row['coin'];
        $gambarBuku = $row['gambarBuku'];
        $gambarUser = $row['gambarUser'];
        $noTelp = $row['notelp'];
        $almat = $row['alamat'];
        $bukuDikembalikan = $row['bukuDikembalikan'];
        $penjelasan = $row['penjelasan'];
        $coinDikembalikan = $row['potonganCoin'];
    }
}

?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../peminjaman.php">Peminjaman</a></div>
                <div class="breadcrumb-item">Detail Peminjaman</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Detail Peminjaman</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <center class="mb-3">
                                    <img src="../../assets/img/buku/<?= $gambarBuku; ?>" class="img-fluid " height="300"
                                        alt="">
                                </center>
                                <div>
                                    <table class="table">
                                        <tr>
                                            <th>
                                                <span class="text-dark">Judul</span> : <?= $namaBuku ?>
                                            </th>
                                            <th>
                                                <span class="text-dark">Jumlah Dipinjam</span> : <?= $jumlah ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <span class="text-dark">Jumlah Dikembalikan</span> : <?= $bukuDikembalikan ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <span class="text-dark">Penjelasan</span> : <?= $penjelasan ?>
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <center>
                                    <img alt="image" height="200" src="../../assets/img/user/<?= $gambarUser ?>"
                                        class="rounded-circle profile-widget-picture mb-3">
                                </center>
                                <div>
                                    <table class="table">
                                        <tr>
                                            <th>
                                                <span class="text-dark">Nama Peminjam</span> : <?= $namaPeminjam ?>
                                            </th>
                                            <th>
                                                <span class="text-dark">No Telp</span> : <?= $noTelp ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <span class="text-dark">Alamat</span> : <?= $almat ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <span class="text-dark">Coin Dipakai</span> : <?= $coin ?>
                                            </th>
                                            <th>
                                                <span class="text-dark">Batas Waktu</span> : <?= $tglPengembalian ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th><span class="text-dark">Coin Dikembalikan</span> : <?= $coin ?></th>
                                        </tr>
                                    </table>
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