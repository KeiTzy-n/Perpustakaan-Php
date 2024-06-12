<?php include '../config/koneksi.php';
require_once '_header.php';

$query = "SELECT COUNT(*) AS total_reader FROM user";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalReader = $row['total_reader'];

$query = "SELECT COUNT(*) AS total_buku FROM buku";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalBuku = $row['total_buku'];

$query = "SELECT COUNT(*) AS total_buku_dipinjam FROM peminjaman WHERE statusPeminjaman = 'Dipinjamkan'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalBukuDipinjam = $row['total_buku_dipinjam'];


$query = "SELECT COUNT(*) AS total_buku_belum_dikembalikan FROM peminjaman WHERE statusPeminjaman = 'Success'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalBukuBelumDikembalikan = $row['total_buku_belum_dikembalikan'];

?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Reader</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $totalReader; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Buku</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $totalBuku; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Buku Dipinjam</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $totalBukuDipinjam; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Peminjaman Berhasil</h4>
                        </div>
                        <div class="card-body">
                            <?php echo $totalBukuBelumDikembalikan; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="section-title">Daftar Buku</h2>
        <div class="card shadow card-primary">
            <div class="card-body">
            <div class="row justify-content-center">
            <?php
            // Jumlah item per halaman
            $items_per_page = 12;

            // Halaman saat ini (jika tidak diset, default adalah halaman 1)
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

            // Perhitungan offset
            $offset = ($current_page - 1) * $items_per_page;

            // Query untuk mendapatkan jumlah total buku
            $total_books_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku");
            $total_books = mysqli_fetch_assoc($total_books_query)['total'];

            // Jumlah halaman
            $total_pages = ceil($total_books / $items_per_page);

            // Query untuk mendapatkan data buku dengan limit dan offset
            $query = "SELECT * FROM buku ORDER BY bukuID DESC LIMIT $offset, $items_per_page";
            $result = mysqli_query($conn, $query);

            // Memeriksa apakah ada data buku
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Memeriksa panjang sinopsis
                    $sinopsis = $row['sinopsis'];
                    if (strlen($sinopsis) > 50) {
                        $sinopsis = substr($sinopsis, 0, 50) . "...";
                    }

                    // Menampilkan data buku
            ?>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article shadow">
                            <div class="article-header">
                                <div class="article-image" data-background="../assets/img/buku/<?php echo $row['gambar']; ?>"></div>
                                <div class="article-title">
                                    <h2><a href="#"><?php echo $row['namaBuku']; ?></a></h2>
                                </div>
                            </div>
                            <div class="article-details">
                                <p><?php echo $sinopsis; ?></p>
                                <div class="article-cta">
                                    <a href="proses/viewbuku.php?bukuID=<?= $row['bukuID'] ?>" class="btn btn-primary">Details</a>
                                </div>
                            </div>
                        </article>
                    </div>
            <?php
                }
            } else {
                echo '<div class="col-md-10 justify-content-center">';
                echo '<div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Belum Ada Data Buku.
                    </div>
                </div>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- Pagination -->
        <div class="pagination justify-content-center mt-4">
            <?php if ($current_page > 1) : ?>
                <a class="btn btn-primary" href="index.php?page=<?= $current_page - 1 ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a class="btn btn-primary <?php if ($current_page == $i) echo 'active'; ?>" href="index.php?page=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages) : ?>
                <a class="btn btn-primary" href="index.php?page=<?= $current_page + 1 ?>">Next</a>
            <?php endif; ?>
        </div>
        <!-- End Pagination -->
            </div>
        </div>

    </section>
</div>

<?php require_once '_footer.php'; ?>