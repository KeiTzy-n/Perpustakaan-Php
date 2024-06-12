<?php include '_header.php'; 


$userID = $_SESSION['userID'];

// query books
$peminjamann = "SELECT * FROM peminjaman WHERE statusPeminjaman = 'success' AND userID = '$userID'";
$result2 = $conn->query($peminjamann);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="home.php">Home</a></div>
                <div class="breadcrumb-item active"><a href="riwayat.php">Riwayat</a></div>
                <div class="breadcrumb-item ">Riwayat Peminjaman</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Peminjaman</h2>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-cog"></i></th>
                                            <th>Detail</th>
                                            <th>Peminjaman</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $nomor = 1; // Inisialisasi nomor baris
                                        while ($peminjaman = $result2->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= $nomor++; ?></td>
                                            <td>
                                                <span class="text-dark">Peminjam</span> :
                                                <?= $peminjaman['namaUser'] ?><br>
                                                <span class="text-dark">Buku</span> : <?= $peminjaman['namaBuku'] ?><br>
                                                <span class="text-dark">Jumlah</span> : <?= $peminjaman['jumlah'] ?><br>
                                                <span class="text-dark">Pengurus</span> :
                                                <?= $peminjaman['namaPetugas'] ?>
                                            </td>
                                            <td>
                                                <span class="text-dark">Dipinjam</span> : <?= $peminjaman['tglPeminjaman']; ?> <br>
                                                <span class="text-dark">Batas Waktu</span> : <?= $peminjaman['tglPengembalian'] ?><br>
                                                <span class="text-dark">Dikembalikan</span> : <?= $peminjaman['tglDikembalikan'] ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-success"><?= $peminjaman['statusPeminjaman']; ?></span>
                                            </td>
                                            <td>
                                                <a data-toggle="tooltip" data-placement="top" title="Detail Peminjaman"
                                                    href="success.php?pinjam=<?= $peminjaman['pinjamID']; ?>"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php include '_footer.php'; ?>