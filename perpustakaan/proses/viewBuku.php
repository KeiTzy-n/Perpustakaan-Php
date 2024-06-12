<?php require_once '../../config/koneksi.php';
include '../_header.php';

if (isset($_GET['bukuID'])) {
    $bukuID = $_GET['bukuID'];

    // Query untuk mendapatkan informasi buku berdasarkan bukuID
    $query = "SELECT * FROM buku WHERE bukuID = $bukuID";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Ambil hasil query
        $row = $result->fetch_assoc();
        $namaBuku = $row['namaBuku'];
        $penulis = $row['penulis'];
        $penerbit = $row['penerbit'];
        $tahunTerbit = $row['tahunTerbit'];
        $sinopsis = $row['sinopsis'];
        $gambarBuku = $row['gambar'];
        $link = $row['link'];
        $rate = $row['rate'];
        $pdf = $row['bukuPDF'];
        $kategori = $row['kategori'];
        $upload = $row['upload'];
        $coin = $row['coin'];
        $BukuID = $row['bukuID'];
    } else {
        echo "Error:" . mysqli_error($conn);
    }
}

// Query untuk menghitung rata-rata rating dari tabel rating
$rating_query = "SELECT AVG(rating) AS avg_rating FROM rating WHERE bukuID = $bukuID";
$rating_result = $conn->query($rating_query);
$rating_row = $rating_result->fetch_assoc();
$avg_rating = round($rating_row['avg_rating'], 1); // Membulatkan rating ke satu desimal

?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../book.php">Books</a></div>
                <div class="breadcrumb-item">Detail Buku</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Detail Buku</h2>
        </div>

        <div class="row justify-content-center">
            
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <center class="mb-3">
                                    <img src="../../assets/img/buku/<?= $gambarBuku; ?>" class="img-fluid " height="400" alt="">
                                </center>
                            </div>
                            <div class="col-md-7">
                                <div class="col-md-12 mb-3">
                                    <p style="text-align: justify;" name="sinopsis"><?= $sinopsis; ?></p>
                                    <table class="table mt-4">
                                        <tbody>
                                            <tr>
                                                <td>Penulis : <?= $penulis; ?></td>
                                                <td>Tahun Terbit : <?= $tahunTerbit; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Penerbit : <?= $penerbit; ?></td>

                                                <td>Rating : <?= $avg_rating; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Kategori : <?= $kategori ?></td>
                                                <td>Rate : <?= $rate ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="alert alert-info"><?= $upload ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
    </section>
</div>

<?php include '../_footer.php'; ?>