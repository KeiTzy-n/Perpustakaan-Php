<?php require_once '../config/koneksi.php';
include '_header.php';

if (isset($_GET['pinjamID'])) {
    $pinjamID = $_GET['pinjamID'];

    $hapus_query = "DELETE FROM peminjaman WHERE pinjamID = $pinjamID";

    if ($conn->query($hapus_query) === TRUE) {
        echo "<script>
        Swal.fire({
            title: 'Penghapusan Berhasil',
            text: 'Data berhasil dihapus.',
            icon: 'success',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        }).then(() => {
            // Redirect ke halaman peminjaman setelah SweetAlert ditutup
            window.location.href = 'peminjaman.php';
        });
      </script>";
    } else {
        echo "Error: " . $hapus_query . "<br>" . $conn->error;
    }
} else {
}



// query books
$peminjamann = "SELECT * FROM peminjaman WHERE statusPeminjaman = 'Dikembalikan'";
$result2 = $conn->query($peminjamann);
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>DataTables</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="pengembalian.php">Pengembalian</a></div>
                <div class="breadcrumb-item">Pengembalian</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Pengembalian</h2>
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
                                            <th>Batas Waktu</th>
                                            <th>Pengembalian</th>
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
                                            <td><?= $nomor++; ?></td> <!-- Urutan nomor baris -->
                                            <td>
                                                <span class="text-dark">Peminjam</span> :
                                                <?= $peminjaman['namaUser'] ?><br>
                                                <span class="text-dark">Buku</span> : <?= $peminjaman['namaBuku'] ?><br>
                                                <span class="text-dark">Jumlah</span> : <?= $peminjaman['jumlah'] ?><br>
                                                <span class="text-dark">Pengurus</span> :
                                                <?= $peminjaman['namaPetugas'] ?>
                                            </td>
                                            <td><?= $peminjaman['tglPeminjaman']; ?> </td>
                                            <td><?= $peminjaman['tglPengembalian']; ?> </td>
                                            <td><?= $peminjaman['tglDikembalikan']; ?> </td>
                                            <td>
                                                <?php
                                                    $status = $peminjaman['statusPeminjaman'];
                                                    $badgeClass = '';

                                                    switch ($status) {
                                                        case 'Pengajuan':
                                                            $badgeClass = 'badge-info';
                                                            break;
                                                        case 'Dipinjamkan':
                                                            $badgeClass = 'badge-success';
                                                            break;
                                                        case 'Dikembalikan':
                                                            $badgeClass = 'badge-danger';
                                                            break;
                                                        default:
                                                            $badgeClass = 'badge-dark';
                                                            break;
                                                    }
                                                    ?>
                                                <span class="badge <?= $badgeClass; ?>"><?= $status; ?></span>
                                            </td>
                                            <td>
                                                <a data-toggle="tooltip" data-placement="top" title="Detail Peminjaman"
                                                    href="proses/viewPeminjaman.php?pinjam=<?= $peminjaman['pinjamID']; ?>"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>

                                                <a data-toggle="tooltip" data-placement="top" title="Konfirmasi Pengembalian"
                                                    href="proses/penjelasan.php?pinjam=<?= $peminjaman['pinjamID']; ?>"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
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