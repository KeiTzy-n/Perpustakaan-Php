<?php include '_header.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="home.php">Home</a></div>
                <div class="breadcrumb-item"><a href="booklist.php">BookList</a></div>
                <div class="breadcrumb-item">BookList</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">BookList</h2>
            <p class="section-lead">Halo</p>

            <div class="card card-primary shadow">

                <div class="card-body">
                    <div class="row justify-content-center mb-4">
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php
                                    // Query untuk mendapatkan daftar kategori
                                    $query_kategori = "SELECT * FROM kategori";
                                    $result_kategori = mysqli_query($conn, $query_kategori);
                                    ?>

                                    <div class="form-group">
                                        <label for="category">Kategori</label>
                                        <select name="category" class="form-control">
                                            <option value="">Semua Kategori</option>
                                            <?php
                                            // Menampilkan pilihan kategori
                                            while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
                                                $kategori_id = $row_kategori['kategoriID'];
                                                $kategori_nama = $row_kategori['namaKategori'];
                                                echo "<option value=\"$kategori_nama\">$kategori_nama</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rate">Rate</label>
                                        <select name="rate" class="form-control">
                                            <option value="">Semua Rate</option>
                                            <option value="Dewasa">Dewasa</option>
                                            <option value="Remaja">Remaja</option>
                                            <option value="Anak">Anak-anak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sort">Urutkan</label>
                                        <select name="sort" class="form-control">
                                            <option value="">Tanpa Urutan</option>
                                            <option value="az">A-Z</option>
                                            <option value="za">Z-A</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="row mt-2">


                        <?php
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

// Mendapatkan nilai kategori dari URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Memastikan nilai kategori dalam tanda kutip jika mengandung koma di depan
$category = mysqli_real_escape_string($conn, $category);

// Mengecek apakah nilai kategori mengandung koma di depan
if (strpos($category, ',') === 0) {
    $category = "'" . $category . "'";
}

// Mendapatkan nilai rate dari URL
$rate = isset($_GET['rate']) ? $_GET['rate'] : '';

// Memastikan nilai rate dalam tanda kutip jika mengandung koma
$rate = mysqli_real_escape_string($conn, $rate);

// Membuat query tambahan berdasarkan kategori
$category_query = '';
if (!empty($category)) {
    $category_query = " WHERE kategori LIKE '%{$category}%'";
}

// Membuat query tambahan berdasarkan rate
$rate_query = '';
if (!empty($rate)) {
    if ($category_query !== '') {
        $rate_query = " AND rate = '$rate'";
    } else {
        $rate_query = " WHERE rate = '$rate'";
    }
}

// Membuat query tambahan berdasarkan pengurutan
$sort_query = '';
if (!empty($sort)) {
    if ($sort == 'az') {
        $sort_query = " ORDER BY namaBuku ASC";
    } elseif ($sort == 'za') {
        $sort_query = " ORDER BY namaBuku DESC";
    }
}

// Menggabungkan query tambahan ke query utama
$query = "SELECT * FROM buku" . $category_query . $rate_query . $sort_query . " LIMIT $offset, $items_per_page";
$result = mysqli_query($conn, $query);

                        // Memeriksa apakah ada data buku
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Memeriksa panjang sinopsis
                                $sinopsis = $row['sinopsis'];
                                if (strlen($sinopsis) > 100) {
                                    $sinopsis = substr($sinopsis, 0, 100) . "...";
                                }

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
                                Pencarian Tidak Ditemukan.
                            </div>
                        </div>'; 
                        echo '</div>'; 
                        }
                        ?>
                    </div>
                </div>
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