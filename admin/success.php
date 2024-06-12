<?php require_once '../config/koneksi.php';
include '_header.php';

if(isset($_POST['hapus_pinjamID'])) {
    $pinjamID = $_POST['hapus_pinjamID'];
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
            // Redirect ke halaman ini setelah SweetAlert ditutup
            window.location.href = 'success.php';
        });
      </script>";
    } else {
        echo "Error: " . $hapus_query . "<br>" . $conn->error;
    }
}

// query books
$peminjamann = "SELECT * FROM peminjaman WHERE statusPeminjaman = 'Success'";
$result2 = $conn->query($peminjamann);
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>DataTables</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="success.php">Success</a></div>
                <div class="breadcrumb-item">Success</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Success</h2>
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
                                            <th>Status</th>
                                            <th>View</th>
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
                                                <span
                                                    class="badge badge-success"><?= $peminjaman['statusPeminjaman']; ?></span>
                                            </td>
                                            <td>
                                                <a data-toggle="tooltip" data-placement="top" title="Detail Peminjaman"
                                                    href="proses/success.php?pinjam=<?= $peminjaman['pinjamID']; ?>"
                                                    class="btn btn-info btn-sm mb-2">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <!-- Tombol hapus dengan form -->
                                                <form action="" method="post">
                                                    <input type="hidden" name="hapus_pinjamID"
                                                        value="<?= $peminjaman['pinjamID']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus?');">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
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