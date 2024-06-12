<?php include '_header.php';

if (isset($_GET['buku'])) {
    $bukuID = $_GET['buku'];

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
        $coin = $row['coin'];
        $BukuID = $row['bukuID'];
    } else {
        echo "Error:" . mysqli_error($conn);
    }
}

// Periksa apakah ada nilai rating yang diterima dari form
if (isset($_POST['rating'])) {
    // Validasi dan bersihkan nilai rating
    $userID = $_SESSION['userID'];
    $rating = intval($_POST['rating']); // Ubah menjadi bilangan bulat

    // Lakukan query untuk memeriksa apakah sudah ada rating yang disimpan oleh pengguna untuk buku ini
    $checkQuery = "SELECT * FROM rating WHERE userID = '$userID' AND bukuID = '$bukuID'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        // Jika sudah ada rating yang disimpan, tampilkan pesan bahwa rating sudah pernah disimpan sebelumnya
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Rating sudah pernah disimpan',
                    text: 'Anda hanya bisa memberikan satu rating untuk buku ini',
                });
            </script>";
    } else {
        // Jika belum ada rating yang disimpan, lanjutkan untuk menyimpan rating
        $tgl = date('d-m-Y'); // Format tanggal menjadi Y-m-d

        // Lakukan query untuk menyimpan rating ke dalam database
        $query = "INSERT INTO rating (userID, bukuID, rating, tglRating) VALUES ('$userID', '$bukuID', '$rating', '$tgl')";
        $result = $conn->query($query);

        if ($result) {
            // Jika penyimpanan berhasil, tampilkan pesan sukses menggunakan Sweet Alert
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'TerimaKasih!!, Rating berhasil disimpan',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>";
        } else {
            // Jika terjadi kesalahan, tampilkan pesan error menggunakan Sweet Alert
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }
}


// Query untuk menghitung jumlah orang yang mengikuti buku tertentu berdasarkan bukuID
$queryFollowers = "SELECT COUNT(*) AS total_followers FROM bookmark WHERE bukuID = $bukuID";
$resultFollowers = $conn->query($queryFollowers);

// Inisialisasi jumlah pengikut
$totalFollowers = 0;

if ($resultFollowers && $resultFollowers->num_rows > 0) {
    // Ambil hasil query
    $rowFollowers = $resultFollowers->fetch_assoc();
    $totalFollowers = $rowFollowers['total_followers'];
}

// Query untuk menghitung rata-rata rating dari tabel rating
$rating_query = "SELECT AVG(rating) AS avg_rating FROM rating WHERE bukuID = $bukuID";
$rating_result = $conn->query($rating_query);
$rating_row = $rating_result->fetch_assoc();
$avg_rating = round($rating_row['avg_rating'], 1); // Membulatkan rating ke satu desimal

$queryRandom = "SELECT * FROM buku ORDER BY RAND() LIMIT 12";
$resultRandom = $conn->query($queryRandom);

if (isset($_POST['rating'])) {
    // Validasi dan bersihkan nilai rating
    $userID = $_SESSION['userID'];
    $rating = intval($_POST['rating']);
    $bukuID = $BukuID;

    // Lakukan query untuk memeriksa apakah sudah ada rating yang disimpan oleh pengguna untuk buku ini
    $checkQuery = "SELECT * FROM rating WHERE userID = '$userID' AND bukuID = '$bukuID'";
    $checkResult = $conn->query($checkQuery);

    // Jika belum ada rating yang disimpan, lanjutkan untuk menyimpan rating
    $tgl = date('d-m-Y'); // Format tanggal menjadi Y-m-d

    // Lakukan query untuk menyimpan rating ke dalam database
    $query = "INSERT INTO rating (userID, bukuID, rating, tglRating) VALUES ('$userID', '$bukuID', '$rating', '$tgl')";
    $result = $conn->query($query);

    if ($result) {
        // Jika penyimpanan berhasil, tampilkan pesan sukses menggunakan Sweet Alert
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'TerimaKasih!!, Rating berhasil disimpan',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>";
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error menggunakan Sweet Alert
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}


// Insert Komentar
if (isset($_POST['komen'])) {
    $bukuID = $_POST['bukuID'];
    $gambar = $_POST['gambar'];
    $userID = $_SESSION['userID'];
    $namaUser = $_SESSION['namaUser'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']); // Escape string
    $tgl = date('H:i:s / m-d');

    // Query untuk memasukkan komentar
    $query = "INSERT INTO komentar (userID, bukuID, komentar, tgl, gambar, namaUser) VALUES ('$userID', '$bukuID', '$komentar', '$tgl', '$gambar', '$namaUser')";

    if ($conn->query($query) === TRUE) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Komentar Berhasil!',
                showConfirmButton: false,
                timer: 1500
            });
        </script>";
    }
}

// hapus Komentar
if (isset($_POST['hapusKomen'])) {
    $komen = $_POST['komentarID'];

    $hapusKomen = "DELETE FROM komentar WHERE komentarID = '$komen'";
    if ($conn->query($hapusKomen) === TRUE) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Hapus Komentar Berhasil!',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>";
    }
}

if ($rate === "Dewasa" || $rate === "Remaja") {
    echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Buku ini memiliki rating untuk kategori $rate. Perhatikan konten sebelum membaca buku.',
            });
        </script>";
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="home.php">Home</a></div>
                <div class="breadcrumb-item active"><a href="#">Details</a></div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header">
                <h3><?= $namaBuku; ?></h3>
            </div>
            <div class="card-body row mb-3">
                <div class="col-md-5 mb-3">
                    <center class="mb-3">
                        <img src="assets/img/buku/<?= $gambarBuku; ?>" class="img-fluid " height="300" alt="">
                    </center>
                    <div class="col-2"></div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button id="bookmarkBtn" class="btn btn-primary d-grid gap-2 col-12 mx-auto">
                            <i class="fa fa-bookmark" aria-hidden="true"></i> Bookmark
                        </button>
                        <small class="text-center">Followed by <?= $totalFollowers; ?> people</small>

                    </div>
                </div>
                <div class="col-md-7 mb-3">
                    <p style="text-align: justify;" name="sinopsis"><?= $sinopsis; ?></p>
                    <table class="table mt-4">
                        <tbody>
                            <tr>
                                <td>Penulis : <a class="text-decoration-none"
                                        href="penulis.php?penulis=<?= $penulis; ?>"><?= $penulis; ?></a></td>
                                <td>Tahun Terbit : <?= $tahunTerbit; ?></td>
                            </tr>
                            <tr>
                                <td>Penerbit : <a class="text-decorartion-none"
                                        href="penerbit.php?penerbit=<?= $penerbit; ?>"><?= $penerbit; ?></a></td>

                                <td>Rating : <?= $avg_rating; ?></td>
                            </tr>
                            <tr>

                                <td>Rate : <a href="rate.php?rate=<?= $rate ?>"><?= $rate ?></a></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <?php
                        $daftar_kategori = explode(",", $kategori);
                        $total_kategori = count($daftar_kategori);
                        $counter = 0;

                        // Iterasi melalui setiap kategori
                        foreach ($daftar_kategori as $kategori) {
                            // Membuat tombol untuk setiap kategori dengan margin kanan kecuali untuk tombol terakhir
                            echo '<div class="mb-2';
                            if ($counter < $total_kategori - 1) {
                                echo ' mr-2'; // Tambahkan margin kanan kecuali untuk tombol terakhir
                            }
                            echo '">';
                            echo '<a class="btn btn-outline-info" href="kategori.php?kategori=' . urlencode(trim($kategori)) . '">' . trim($kategori) . '</a>';
                            echo '</div>';
                            $counter++;
                        }
                        ?>
                    </div>



                    <?php
                    $queryGetRating = "SELECT rating FROM rating WHERE userID = '$userID' AND bukuID = '$bukuID'";
                    $resultGetRating = $conn->query($queryGetRating);

                    if ($resultGetRating && $resultGetRating->num_rows > 0) {
                        $rowGetRating = $resultGetRating->fetch_assoc();
                        $userRating = $rowGetRating['rating'];
                    } else {
                        $userRating = 0;

                    ?>
                    <!-- Form Rating -->
                    <form action="" method="post">
                        <input type="hidden" name="bukuID" value="<?= $bukuID; ?>">
                        <div class="rating-container justify-content-center">
                            <div class="rating-stars h3">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="0">
                        </div>
                        <div id="selected-rating" class="mb-2">Rating: 0</div>
                        <button type="submit" class="btn btn-primary">Kirim Rating</button>
                    </form>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-md-3">
                    <?php if (!empty($pdf) && $pdf !== '0') : ?>
                    <a href="assets/pdf/<?= $pdf ?>" download="<?= $pdf ?>"
                        class="btn btn-icon icon-left btn-primary d-grid gap-2 col-12 mx-auto mt-2">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <a href="bacaOnline.php?buku=<?= $BukuID ?>"
                        class="btn btn-icon icon-left btn-success d-grid gap-2 col-12 mx-auto mt-2"><i
                            class="fas fa-book"></i> Baca Online</a>
                </div>
                <div class="col-md-3">
                    <a href="peminjaman.php?buku=<?= $BukuID ?>"
                        class="btn btn-icon icon-left btn-light d-grid gap-2 col-12 mx-auto mt-2"><i
                            class="fas fa-book"></i> Pinjam Buku</a>
                </div>
                <div class="col-md-3">
                    <a href="#komentar" class="btn btn-icon icon-left btn-warning d-grid gap-2 col-12 mx-auto mt-2"><i
                            class="fas fa-comments"></i> Ulasan</a>
                </div>
            </div>
        </div>


        <div class="card shadow">
            <div class="card-header">
                <h4>Mungkin Anda Tertarik</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    while ($rowRandom = $resultRandom->fetch_assoc()) {
                        // Ambil sinopsis dari baris acak
                        $sinopsis = $rowRandom['sinopsis'];

                        // Jika panjang sinopsis lebih dari 200 karakter, potong
                        if (strlen($sinopsis) > 100) {
                            $sinopsis = substr($sinopsis, 0, 100) . '...';
                        }
                    ?>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article shadow">
                            <div class="article-header">
                                <div class="article-image"
                                    data-background="assets/img/buku/<?php echo $rowRandom['gambar']; ?>"></div>
                                <div class="article-title">
                                    <h2><a href="#"><?php echo $rowRandom['namaBuku']; ?></a></h2>
                                </div>
                            </div>
                            <div class="article-details">
                                <!-- Gunakan variabel $sinopsis yang telah dipotong -->
                                <p><?php echo $sinopsis; ?></p>
                                <div class="article-cta">
                                    <a href="detail.php?buku=<?= $rowRandom['bukuID'] ?>"
                                        class="btn btn-primary">Details</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>

        <!-- Komen -->
        <div id="komentar" class="col-lg-12 col-md-12 col-12 col-sm-12" >
            <div class="card shadow">
                <div class="card-header">
                    <h4>Ulasan Pembaca</h4>
                </div>
                <div class="card-body mb-5">
                    <div style="overflow-y: auto; max-height: 400px;">
                        <?php
                    $sql = "SELECT * FROM komentar WHERE bukuID = '$BukuID' ORDER BY komentarID DESC";
                    $result = $conn->query($sql);

                    // Periksa apakah ada baris data yang diambil
                    if ($result->num_rows > 0) {
                        // Output data setiap baris
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="card">';
                            echo '<div class="card-body">';
                            echo '<ul class="list-unstyled list-unstyled-border list-unstyled-noborder">';
                            echo '<li class="media">';
                            echo '<img alt="image" class="mr-3 rounded-circle" width="70" src="assets/img/user/' . $row["gambar"] . '">';
                            echo '<div class="media-body">';
                            echo '<div class="media-right"></div>';
                            echo '<div class="media-title mb-1">' . $row["namaUser"] . '</div>';
                            echo '<div class="text-time">' . $row["tgl"] . '</div>';
                            echo '<div class="media-description text-muted">' . $row["komentar"] . '</div>';


                            // Check if the comment belongs to the logged-in user
                            if ($row["userID"] == $_SESSION["userID"]) {
                                echo '<br>';
                                echo '<form action="" method="POST">';
                                echo '<input type="hidden" name="komentarID" value="' . $row["komentarID"] . '">';
                                echo '<button type="submit" name="hapusKomen" class="btn btn-danger">Hapus</button>';
                                echo '</form>';
                            }

                            echo '</div>';
                            echo '</li>';
                            echo '</ul>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>&times;</span>
              </button>
              Belum ada ulasan untuk buku ini
            </div>
          </div>';
                    }
                    ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <form action="" method="post">
                                <input type="hidden" name="bukuID" value="<?= $bukuID ?>">
                                <input type="hidden" name="gambar" value="<?= $gambar ?>">
                                <label for="komentar">Masukan Komentar</label>
                                <textarea name="komentar" class="form-control"></textarea>
                                <button type="submit" name="komen" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <p>You can write a book review and share your experiences. Other readers will always be
                                interested in your opinion of the books you've read. Whether you've loved the book or
                                not, if you give your honest and detailed thoughts then people will find new books that
                                are right for them.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    integrity="sha512-0kLuKJh9PbcX7NsYH5D5W9zxCsxdy1S/jPObO/ygbGD0bNTaXAqwIMx4pibcSz9J9cCZ1fbMOEmNqEelPnM2Uw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
// Variabel untuk menyimpan status bookmark
var bookmarked = false;

// Ketika tombol bookmark diklik
document.getElementById('bookmarkBtn').addEventListener('click', function() {
    // Kirim permintaan AJAX ke server
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'tambahbookmark.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Tangkap respons dari server
            var response = JSON.parse(xhr.responseText);
            // Tangani respons dari server
            handleResponse(response);
        }
    };
    // Kirim data bukuID ke server
    xhr.send('bkm=<?= $bukuID ?>');
});

// Tangkap respons dari permintaan AJAX
function handleResponse(response) {
    if (response.status === "berhasil") {
        // Jika operasi berhasil
        if (bookmarked) {
            // Jika sebelumnya sudah ditandai sebagai bookmarked
            // Tampilkan Sweet Alert sukses
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Buku telah dihapus dari bookmark.',
                showConfirmButton: false,
                timer: 2000
            });
            // Ubah teks tombol menjadi "Bookmark"
            document.getElementById('bookmarkBtn').innerHTML =
                '<i class="fa fa-bookmark" aria-hidden="true"></i> Bookmark';
            // Setel status bookmark menjadi false
            bookmarked = false;
        } else {
            // Jika sebelumnya belum ditandai sebagai bookmarked
            // Tampilkan Sweet Alert sukses
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Buku telah ditambahkan ke bookmark!',
                showConfirmButton: false,
                timer: 2000
            });
            // Ubah teks tombol menjadi "Bookmarked"
            document.getElementById('bookmarkBtn').innerHTML =
                '<i class="fa fa-bookmark" aria-hidden="true"></i> Bookmarked';
            // Setel status bookmark menjadi true
            bookmarked = true;
        }
    } else {
        // Jika operasi gagal, tampilkan Sweet Alert error
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message
        });
    }
}
</script>

<?php include '_footer.php'; ?>