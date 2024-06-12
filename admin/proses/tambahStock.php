<?php require_once '../../config/koneksi.php';
include '../_header.php';


if (isset($_GET['bukuID'])) {
    $bukuID = $_GET['bukuID'];

    // Ambil informasi buku berdasarkan ID
    $query_info_buku = "SELECT * FROM buku WHERE bukuID = $bukuID";
    $result_info_buku = $conn->query($query_info_buku);
    $book_info = $result_info_buku->fetch_assoc();
}

// Jika form telah disubmit 
if (isset($_POST['submit'])) {
    $additional_stock = $_POST['additional_stock'];

    // Query untuk menambahkan stok buku
    $tambah_stock_query = "UPDATE buku SET masuk = masuk + $additional_stock, 
    total = total + $additional_stock WHERE bukuID = $bukuID";

    if ($conn->query($tambah_stock_query) === TRUE) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Stok buku berhasil ditambahkan.'
            }).then(function() {
                window.location.href = '../book.php';
            });
        </script>";
        exit();
    } else {
        echo "Error: " . $tambah_stock_query . "<br>" . $conn->error;
    }
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Stock Buku</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../book.php">Books</a></div>
                <div class="breadcrumb-item">Tambah Stock Buku</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Forms</h2>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-10">
                    <div class="card card-primary shadow">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="bookName">Nama Buku</label>
                                    <input type="text" class="form-control" id="bookName" value="<?= $book_info['namaBuku']; ?>" readonly>
                                </div>
                                <div class="row">
                                    <!-- Bagian Pertama -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currentStock">Stok Saat Ini:</label>
                                            <input type="text" class="form-control" id="currentStock" value="<?= $book_info['total']; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- Bagian Kedua -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="additionalStock">Tambahkan Stok:</label>
                                            <input type="number" class="form-control" id="additionalStock" name="additional_stock" oninput="validateInput(this)" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Tambah Stok</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Fungsi untuk memvalidasi input agar tidak kurang dari 0
    function validateInput(input) {
        if (input.value < 1) {
            input.value = 1; // Set nilai input menjadi 0 jika kurang dari 0
        }
    }
</script>

<?php include '../_footer.php'; ?>