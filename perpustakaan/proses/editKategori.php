<?php require_once '../../config/koneksi.php';
include '../_header.php';


if(isset($_GET['kategoriID'])){
    $kategoriID = $_GET['kategoriID'];

    $query = "SELECT * FROM kategori WHERE kategoriID = '$kategoriID'";
    $result3 = $conn->query($query);

    if($result3){
        $row = mysqli_fetch_assoc($result3);
        $kategoriID = $row['kategoriID'];
        $namaKategori1 = $row['namaKategori'];
    }else {
        echo "Error:" . mysqli_error($conn);
    }
}

if(isset($_POST['submit'])){
    $kategoriID = $_GET['kategoriID'];
    $namaKategori = $_POST['namaKategori'];

    $sql = "UPDATE kategori SET namaKategori = '$namaKategori' WHERE kategoriID = '$kategoriID'";
    
    if($conn->query($sql) === TRUE){
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Edit Data Berhasil',
                text: 'Data berhasil diedit!',
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                window.location.href = '../kategori.php'; // Redirect setelah menutup SweetAlert
            });
        </script>";
        exit();
    }else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error: " . $conn->error . "',
            });
        </script>";
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
                            <input type="hidden" name="kategoriID" value="<?= $kategoriID; ?>">
                                <div class="form-group">
                                    <label for="namaKategori">Nama Kategori</label>
                                    <input type="text" name="namaKategori" value="<?= $namaKategori1 ?>" class="form-control" placeholder="Masukan Nama Kategori" autofocus>
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