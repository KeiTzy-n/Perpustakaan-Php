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
$peminjamann = "SELECT * FROM peminjaman WHERE statusPeminjaman LIKE '%Pengajuan%' OR 
                                               statusPeminjaman LiKE '%Dipinjamkan%' OR
                                               statusPeminjaman LiKE '%Ditolak%'";
$result2 = $conn->query($peminjamann);
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>DataTables</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="peminjaman.php">Peminjaman</a></div>
                <div class="breadcrumb-item">Peminjaman</div>
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
                                            <td><?= $nomor++; ?></td>
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


                                                <!-- tambah stock -->
                                                <a data-toggle="tooltip" data-placement="top" title="Detail Peminjaman"
                                                    href="proses/viewPeminjaman.php?pinjam=<?= $peminjaman['pinjamID']; ?>"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="proses/konfirmasiPeminjaman.php?pinjamID=<?= $peminjaman['pinjamID'] ?>"
                                                    class="btn btn-success btn-sm confirm-btn"
                                                    data-pinjamID="<?= $peminjaman['pinjamID'] ?>" data-toggle="tooltip"
                                                    data-placement="top" title="Konfirmasi Peminjaman">
                                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="btn btn-warning btn-sm btn-reject"
                                                    data-pinjamID="<?= $peminjaman['pinjamID']; ?>"
                                                    data-toggle="tooltip" data-placement="top" title="Tolak Peminjaman">
                                                    <i class="fas fa-times" aria-hidden="true"></i>
                                                </a>
                                                <!-- tambah stock -->
                                                <a href="#" class="btn btn-primary btn-sm btn-return"
                                                    data-pinjamID="<?= $peminjaman['pinjamID']; ?>"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Peminjaman Dikembalikan">
                                                    <i class="fa fa-backward" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm btn-delete"
                                                    data-toggle="tooltip" data-placement="top" title="Delete Data"
                                                    data-bukuid="<?= $peminjaman['pinjamID']; ?>"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></a>
                                                <a href="proses/pesanPeminjaman.php?pinjamID=<?= $peminjaman['pinjamID'] ?>" class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                                    data-placement="top" title="Pesan kepada peminjam"><i
                                                        class="fa fa-comment" aria-hidden="true"></i></a>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmButtons = document.querySelectorAll('.confirm-btn');
    confirmButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const pinjamID = button.getAttribute('data-pinjamID');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin melanjutkan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to konfirmasiPeminjaman.php with pinjamID
                    window.location.href = 'proses/konfirmasiPeminjaman.php?pinjamID=' +
                        pinjamID;
                }
            });
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const returnButtons = document.querySelectorAll('.btn-return');
    returnButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const pinjamID = button.getAttribute('data-pinjamID');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin melanjutkan pengembalian?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to proses/pengembalian.php with pinjamID
                    window.location.href = 'proses/pengembalian.php?pinjamID=' +
                        pinjamID;
                }
            });
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rejectButtons = document.querySelectorAll('.btn-reject');
    rejectButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const pinjamID = button.getAttribute('data-pinjamID');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menolak peminjaman ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to proses/tolakPeminjaman.php with pinjamID
                    window.location.href = 'proses/tolakPeminjaman.php?pinjamID=' +
                        pinjamID;
                }
            });
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rejectButtons = document.querySelectorAll('.btn-delete');
    rejectButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const pinjamID = button.getAttribute('data-bukuid');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to proses/tolakPeminjaman.php with pinjamID
                    window.location.href = 'Peminjaman.php?pinjamID=' +
                        pinjamID;
                }
            });
        });
    });
});
</script>

<?php include '_footer.php'; ?>