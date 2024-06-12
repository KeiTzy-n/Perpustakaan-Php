<?php require_once '../config/koneksi.php';
include '_header.php';

// query users
$kategori = "SELECT * FROM kategori";
$result = $conn->query($kategori);

// Jika ada permintaan untuk menghapus kategori
if(isset($_GET['kategoriID'])) {
    $kategoriID = $_GET['kategoriID'];
    
    // Query untuk menghapus kategori berdasarkan kategoriID
    $hapus_kategori = "DELETE FROM kategori WHERE kategoriID = '$kategoriID'";
    
    // Melakukan query penghapusan
    if ($conn->query($hapus_kategori) === TRUE) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Kategori berhasil dihapus",
                    showConfirmButton: false,
                    timer: 2000
                }).then(function () {
                    window.location.href = "kategori.php";
                });
             </script>';
        exit();
    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Terjadi kesalahan: ' . $conn->error . '",
                    showConfirmButton: false,
                    timer: 3000
                });
             </script>';
    }    
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>DataTables</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="book.php">Books</a></div>
                <div class="breadcrumb-item">Daftar Category</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Daftar Category</h2>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4><a href="proses/tambahKategori.php" data-toggle="tooltip" data-placement="right" title="Tambah Kategori" class="btn btn-info"><i class="fas fa-plus"></i> Tambah Category</a></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-cog"></i></th>
                                            <th>Nama Kategori</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $nomor = 1; // Inisialisasi nomor baris
                                        while ($kategorii = $result->fetch_assoc()) {
                                            $kategoriID = $kategorii['kategoriID'];
                                        ?>
                                            <tr>
                                                <td><?= $nomor++; ?></td> <!-- Urutan nomor baris -->
                                                <td><?= $kategorii['namaKategori']; ?></td> <!-- Menampilkan nama kategori -->
                                                <td>
                                                    <a data-toggle="tooltip" data-placement="right" title="Edit Kategori" href="proses/editKategori.php?kategoriID=<?= $kategoriID; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                    <button data-toggle="tooltip" data-placement="right" title="Delete Data" type="button" class="btn btn-danger btn-sm btn-delete" data-kategoriid="<?= $kategoriID; ?>">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
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

<script>
// Menangani klik tombol hapus
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const kategoriID = this.getAttribute('data-kategoriid');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan bisa mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete page with category ID
                    window.location.href = 'kategori.php?kategoriID=' + kategoriID;
                }
            });
        });
    });
});
</script>

<?php include '_footer.php'; ?>