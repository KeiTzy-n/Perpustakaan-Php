<?php include '_header.php';


if (isset($_GET['buku'])) {
    $bukuID = $_GET['buku'];

    // Query untuk mendapatkan buku berdasarkan bukuID
    $query = "SELECT * FROM buku WHERE bukuID = $bukuID";
    $lihat = $conn->query($query);
    if ($lihat) {
        $row = mysqli_fetch_assoc($lihat);
        $bukuID = $row['bukuID'];
        $judul = $row['namaBuku'];

        $penulis = $row['penulis'];
        $penerbit = $row['penerbit'];
        $tahunTerbit = $row['tahunTerbit'];
        $sinopsis = $row['sinopsis'];
        $gambarBuku = $row['gambar'];
        $link = $row['link'];
        $kategori = $row['kategori'];
        $coinDibutuhkan = $row['coin'];
        $totalBuku = $row['total'];
    } else {
        echo "Error:" . mysqli_error($conn);
    }
}

if (isset($_POST['pinjam'])) {
    // Ambil nilai dari form
    $userID = $_POST['userID'];
    $bukuID = $_POST['bukuID'];
    $namaBuku = $_POST['namaBuku'];
    $namaUser = $_POST['namaUser'];
    $jumlah = $_POST['jumlah'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];
    $gambarPeminjam = $_POST['gambarUser'];
    $statusPeminjaman = 'Pengajuan';
    $tgl = date('d-m-Y');

    // Query untuk menghitung jumlah peminjaman buku yang belum dikembalikan oleh pengguna
    $query_count = "SELECT SUM(jumlah) AS total_pinjaman FROM peminjaman WHERE userID = $userID AND (statusPeminjaman = 'Dipinjamkan' OR statusPeminjaman = 'Pengajuan')";
    $result_count = $conn->query($query_count);
    $row_count = $result_count->fetch_assoc();
    $total_pinjaman = $row_count['total_pinjaman'];

    // Query untuk mengambil total buku yang tersedia dalam stok
    $query_total_buku = "SELECT total FROM buku WHERE bukuID = $bukuID";
    $result_total_buku = $conn->query($query_total_buku);
    $row_total_buku = $result_total_buku->fetch_assoc();
    $total_buku_stok = $row_total_buku['total'];

    // Periksa apakah jumlah peminjaman buku yang belum dikembalikan sudah mencapai batas maksimum (3)
    if ($total_pinjaman >= 3) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Maaf, Anda telah mencapai batas peminjaman buku yang diizinkan (maksimal 3 buku). Tolong kembalikan buku yang dipinjam terlebih dahulu untuk dapat meminjam buku kembali',
                confirmButtonColor: '#3085d6',
                timer: 3000, 
                showConfirmButton: false
            }).then((result) => {
                window.location.href = 'peminjaman.php?buku=$bukuID';
            });
        </script>";
        exit();
    } elseif ($jumlah > $total_buku_stok) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Maaf, jumlah buku yang ingin Anda pinjam melebihi stok yang tersedia',
                showConfirmButton: false,
                timer: 3000,
                showConfirmButton: false
            }).then((result) => {
                window.location.href = 'peminjaman.php?buku=$bukuID';
            });
        </script>";
        exit();
    } else {
        $coinBuku = $_POST['coinBuku'];
        $coin = $_POST['coin'];

        if ($coin >= $coinBuku * $jumlah) {
            // Query untuk mengupdate stok buku dan keluaran buku
            $stock_buku = "UPDATE buku SET keluar = keluar + $jumlah, total = total - $jumlah WHERE bukuID = $bukuID";

            // Query untuk mengurangi jumlah coin pengguna
            $coinUser = "UPDATE user SET coin = coin - ($coinBuku * $jumlah) WHERE userID = $userID";

            $totalCoin = $coinBuku * $jumlah;

            function generateRandomNumber()
            {
                return str_pad(mt_rand(1, 99999999), 8, '1', STR_PAD_LEFT);
            }

            // Membuat bukuID dengan format MYB-nomor
            $pinjamID = generateRandomNumber();

            // Query untuk melakukan insert ke tabel peminjaman
            $query = "INSERT INTO peminjaman (pinjamID, userID, bukuID,  namaUser, jumlah, alamat, notelp, statusPeminjaman, namaBuku, coin, gambarBuku, gambarUser) 
                      VALUES ('$pinjamID', '$userID', '$bukuID', '$namaUser', '$jumlah', '$alamat', '$notelp', '$statusPeminjaman', '$namaBuku', '$totalCoin', '$gambarBuku', '$gambar')";

            $notif = "INSERT INTO notif2 (userID, pesan, tgl, bukuID, namaBuku, namaUser, status, hakAkses, filePeminjam)
                                 VALUES ('$userID', 'Ada Peminjaman buku baru atas nama $namaUser, Dengan Judul buku $namaBuku, Mohon melakukan Konfirmasi untuk peminjaman.', '$tgl', '$bukuID', '$namaBuku', '$namaUser', 'belumDibaca', 'Admin,Pustakawan', '$gambar')";

            if ($conn->query($stock_buku) === TRUE && $conn->query($coinUser) === TRUE && $conn->query($query) === TRUE && $conn->query($notif) === TRUE) {
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Peminjaman berhasil!',
                    text: 'Tunggu Konfirmasi Admin.',
                    confirmButtonColor: '#3085d6',
                    timer: 3000,
                    showConfirmButton: false
                }).then((result) => {
                    window.location.href = 'peminjaman.php?buku=$bukuID';
                });
              </script>";
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Maaf',
        text: 'Jumlah coin Anda tidak mencukupi untuk meminjam buku ini.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location='coin.php';
        }
    });
</script>";
        }
    }
}

?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Reader</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="detail.php?buku=<?= $bukuID ?>">Detail</a></div>
                <div class="breadcrumb-item">Form Peminjaman</div>
            </div>
        </div>


        <div class="section-body">
            <h2 class="section-title mb-4">Forms</h2>
            <!-- syarat -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-4">
                            <h6 class="m-0 font-weight-bold text-primary">Syarat Peminjaman</h6>
                        </div>
                        <div class="card-body">
                            <ul class="mb-3">
                                <li>Jumlah peminjaman buku tidak dapat lebih dari 3.</li>
                                <li>Masa Peminjaman Berlaku 14 Hari.</li>
                                <li>Mempunyai Coin yang mencukupi, sesuai buku yang ingin dipinjam.</li>
                                <li>
                                    <p>
                                        Coin hanya dijadikan pegangan kita apabila Buku yang dipinjam Rusak, Hilang, Melebihi
                                        waktu batas peminjaman, dan Tidak dikembalikan.
                                        Jika buku dikembalikan dengan keadaan semula Coin akan dikembalikan.
                                    </p>
                                </li>
                            </ul>
                            <h4 class="text-center alert alert-danger">tolong dijaga bukunya baik baik karena buku adalah sebuah
                                sumber pengetahuan yang berharga.</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="card card-primary shadow">
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" name="userID" id="userID" value="<?= $id; ?>">
                                <input type="hidden" name="bukuID" id="bukuID" value="<?= $bukuID; ?>">
                                <input type="hidden" name="namaBuku" id="namaBuku" value="<?= $judul; ?>">
                                <input type="hidden" name="gambarBuku" id="gambarBuku" value="<?= $gambarBuku; ?>">
                                <input type="hidden" name="gambarUser" id="gambarUser" value="<?= $gambar; ?>">
                                <input type="hidden" name="coinBuku" id="coinBuku" value="<?= $coinDibutuhkan; ?>">
                                <input type="hidden" name="coin" id="coin" value="<?= $coin; ?>">
                                <center class="mb-4">
                                    <h4 for="gambar"><?= isset($judul) ? $judul : "Judul Buku Tidak Tersedia"; ?></h4><br>
                                    <img src="assets/img/buku/<?= $gambarBuku ?>" width="200" alt="Gambar Buku">
                                </center>
                                <div class="form-group">
                                    <h6 class="text-primary">Coin Yang dibutuhkan untuk peminjaman buku ini.
                                        <?= $coinDibutuhkan; ?>Coin</h6>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah buku</label>
                                    <input type="number" max="3" name="jumlah" min="1" class="form-control" id="jumlah" oninput="validateInput(this)" placeholder="Masukan jumlah buku yang ingin dipinjam">
                                    <small name="jumlah" id="jumlah">Jumlah buku yang tersedia, <?= $totalBuku; ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="namaUser">Nama Anda</label>
                                    <input type="text" readonly name="namaUser" value="<?= $namaUser; ?>" class="form-control" id="namaUser" placeholder="Masukan Nama lengkap anda.">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat Anda</label>
                                    <textarea name="alamat" id="alamat" class="form-control"><?= $alamat; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="notelp" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" value="<?= $notelp; ?>" id="notelp" name="notelp" pattern="^08[0-9]{7,15}$" title="Masukkan nomor telepon yang valid" required>
                                    <div class="invalid-feedback">Masukkan nomor telepon yang valid.</div>
                                    <small>Diawali dengan 08...</small>
                                </div>
                                <button type="submit" name="pinjam" class="btn btn-primary">Pinjam</button>
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
        if (input.value < 0) {
            input.value = 0; // Set nilai input menjadi 0 jika kurang dari 0
        }
    }
</script>

<?php include '_footer.php'; ?>