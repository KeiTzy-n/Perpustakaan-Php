<?php require_once '../../config/koneksi.php';
include '../_header.php';

if(isset($_POST['submit'])){
    $namaKategori = $_POST['namaKategori'];
    function generateRandomNumber()
    {
        return str_pad(mt_rand(1, 99999999), 8, '1', STR_PAD_LEFT);
    }

    // Membuat bukuID dengan format MYB-nomor
    $kategoriID = generateRandomNumber();

    $sql = "INSERT INTO kategori (kategoriID, namaKategori) VALUES ('$kategoriID', '$namaKategori')";

    if(mysqli_query($conn, $sql)){
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Kategori buku berhasil ditambahkan.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = '../kategori.php';
                });
              </script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Categori</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../book.php">Books</a></div>
                <div class="breadcrumb-item">Book Categori</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Forms</h2>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-10">
                    <div class="card card-primary shadow">
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="namaKategori">Nama Kategori</label>
                                    <input type="text" name="namaKategori" class="form-control" placeholder="Masukan Nama Kategori" autofocus>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Tambah Kategori</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../_footer.php'; ?>