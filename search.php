<?php
include '_header.php';

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $sql = "SELECT * FROM buku WHERE namaBuku LIKE '%$search%' OR
                                     penerbit LIKE '%$search%' OR
                                     penulis LIKE '%$search%' OR 
                                     tahunTerbit LIKE '%$search%'";

    // Execute SQL query
    $result = $conn->query($sql);
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="home.php">Home</a></div>
                <div class="breadcrumb-item ">Search</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">MyBooks</h2>

            <div class="row justify-content-center">
                <?php
                if (isset($result) && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
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
                    // No results found
                    echo '<div class="col-md-10 justify-content-center">';
                    echo '<div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Pencarian tidak ditemukan.
                    </div>
                </div>'; 
                echo '</div>'; 
                }
                ?>
            </div>
        </div>
    </section>
</div>

<?php include '_footer.php'; ?>