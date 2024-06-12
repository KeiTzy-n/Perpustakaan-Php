<?php include '_header.php'; ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="home.php">Home</a></div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">MyBooks</h2>

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
                        if (strlen($sinopsis) > 100) {
                            $sinopsis = substr($sinopsis, 0, 100) . "...";
                        }

                        // Menampilkan data buku
                        ?>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <article class="article shadow">
                                <div class="article-header">
                                    <div class="article-image" data-background="assets/img/buku/<?php echo $row['gambar']; ?>"></div>
                                    <div class="article-title">
                                        <h2><a href="#"><?php echo $row['namaBuku']; ?></a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p><?php echo $sinopsis; ?></p>
                                    <div class="article-cta">
                                        <a href="detail.php?buku=<?= $row['bukuID'] ?>" class="btn btn-primary">Details</a>
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
                    <a class="btn btn-primary" href="home.php?page=<?= $current_page - 1 ?>">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a class="btn btn-primary <?php if ($current_page == $i) echo 'active'; ?>" href="home.php?page=<?= $i ?>"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages) : ?>
                    <a class="btn btn-primary" href="home.php?page=<?= $current_page + 1 ?>">Next</a>
                <?php endif; ?>
            </div>
            <!-- End Pagination -->
        </div>
    </section>
</div>
<?php include '_footer.php'; ?>
