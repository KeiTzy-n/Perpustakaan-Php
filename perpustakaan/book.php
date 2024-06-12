<?php
require_once '../config/koneksi.php';
include '_header.php';

// Check if book ID is provided
if (isset($_GET['bukuID'])) {
    $bukuID = intval($_GET['bukuID']);

    // Query untuk menghapus buku dari database
    $hapus_query = "DELETE FROM buku WHERE bukuID = $bukuID";

    // Ambil nama file gambar dari database
    $query_nama_gambar = "SELECT gambar FROM buku WHERE bukuID = $bukuID";
    $result_nama_gambar = $conn->query($query_nama_gambar);
    $nama_gambar = $result_nama_gambar->fetch_assoc()['gambar'];

    // Hapus file gambar dari direktori
    $file_path = '../assets/img/buku/' . $nama_gambar;
    if (file_exists($file_path)) {
        unlink($file_path); // Hapus file gambar
    }

    if ($conn->query($hapus_query) === TRUE) {
        // Jika query penghapusan berhasil
        echo "<script>
                Swal.fire({
                    title: 'Penghapusan Berhasil',
                    text: 'Data berhasil dihapus.',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then(() => {
                    // Redirect ke halaman lain atau lakukan tindakan lainnya jika diperlukan
                    window.location.href = 'book.php';
                });
            </script>";
    } else {
        // Jika terjadi kesalahan saat menjalankan query penghapusan
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menghapus data.',
                    icon: 'error',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            </script>";
    }
}

// query books
$books = "SELECT * FROM buku";
$result = $conn->query($books);
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>DataTables</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="book.php">Books</a></div>
                <div class="breadcrumb-item">Daftar Buku</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Daftar Buku</h2>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4><a href="proses/tambahBuku.php" data-toggle="tooltip" data-placement="right" title="Tambah Buku" class="btn btn-info"><i class="fas fa-plus"></i> Tambah Buku</a></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-cog"></i></th>
                                            <th>Gambar</th>
                                            <th>Detail</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nomor = 1; // Inisialisasi nomor baris
                                        while ($book = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= $nomor++; ?></td> <!-- Urutan nomor baris -->
                                            <td>
                                                <div class="gallery">
                                                    <div class="gallery-item" data-image="../assets/img/buku/<?= $book['gambar']; ?>"
                                                        data-title="<?= $book['namaBuku'] ?>"></div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="h6">Judul: <?= $book['namaBuku']; ?></span><br>
                                                <span>Penulis: <?= $book['penulis']; ?></span><br>
                                                <span>Penerbit: <?= $book['penerbit']; ?></span><br>
                                                <span class="text-info"><?= $book['upload']; ?></span>
                                            </td>
                                            <td><?= $book['total']; ?></td>
                                            <td>
                                                <!-- tambah stock -->
                                                <a data-toggle="tooltip" data-placement="top" title="Detail Buku" href="proses/viewBuku.php?bukuID=<?= $book['bukuID']; ?>"
                                                    data-gambar="<?= $book['gambar']; ?>"
                                                    data-nama="<?= $book['namaBuku']; ?>"
                                                    class="btn btn-info btn-sm"><i class="fa fa-eye"
                                                        aria-hidden="true"></i></a>
                                                <!-- tambah stock -->
                                                <a data-toggle="tooltip" data-placement="top" title="Tambah Stock" href="proses/tambahStock.php?bukuID=<?= $book['bukuID']; ?>"
                                                    data-gambar="<?= $book['gambar']; ?>"
                                                    data-nama="<?= $book['namaBuku']; ?>"
                                                    class="btn btn-success btn-sm"><i class="fa fa-book"
                                                        aria-hidden="true"></i></a>
                                                <!-- Tombol Edit -->
                                                <a data-toggle="tooltip" data-placement="top" title="Edit Data" href="proses/editBuku.php?bukuID=<?= $book['bukuID']; ?>"
                                                    data-gambar="<?= $book['gambar']; ?>"
                                                    data-nama="<?= $book['namaBuku']; ?>"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"
                                                        aria-hidden="true"></i></a>
                                                <!-- Tombol Hapus -->
                                                <button data-toggle="tooltip" data-placement="top" title="Delete Data" class="btn btn-danger btn-sm btn-delete"
                                                    data-bukuid="<?= $book['bukuID']; ?>"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></button>
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
<script>
$(document).ready(function() {
    $('.btn-delete').click(function() {
        var bukuID = $(this).data('bukuid'); 

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'book.php?bukuID=' + bukuID;
            }
        });
    });
});
</script>