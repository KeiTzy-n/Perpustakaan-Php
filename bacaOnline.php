<?php include '_header.php';
if (isset($_GET['buku'])) {
    $bukuID = intval($_GET['buku']);

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
        $kategori = $row['kategori'];
        $coin = $row['coin'];
    } else {
        echo "Error:" . mysqli_error($conn);
    }
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="home.php">Home</a></div>
                <div class="breadcrumb-item active"><a href="detail.php?buku=<?= $bukuID ?>">Detail</a></div>
                <div class="breadcrumb-item active">Baca Online</div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header">
                <h4><?= $namaBuku; ?></h4>
            </div>
            <div class="card-body">
                <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                    <?php if (!empty($link)) : ?>
                        <iframe src="<?= $link; ?>" frameborder="0" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
                    <?php else : ?>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Link tidak tersedia.'
                            });
                        </script>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
</div>

<?php include '_footer.php'; ?>