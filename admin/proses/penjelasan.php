<?php require_once '../../config/koneksi.php';
include '../_header.php';

if (isset($_GET['pinjam'])) {
    $pinjamID = $_GET['pinjam'];

    $sql = "SELECT * FROM peminjaman WHERE pinjamID = '$pinjamID'";
    $result = $conn->query($sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        $peminjamID = $row['userID'];
        $bukuID = $row['bukuID'];
        $namaPeminjam = $row['namaUser'];
        $namaBuku = $row['namaBuku'];
        $jumlah = $row['jumlah'];
        $coin = $row['coin'];
    }
}

if (isset($_POST['kembalikan'])) {
    $penjelasan = $_POST['penjelasan'];
    $potonganCoin = $_POST['PotonganCoin'];
    $statusBuku = $_POST['keadaan'];
    $bukuDikembalikan = $_POST['bukuDikembalikan'];
    $pesan = $_POST['pesan'];

    // Perbarui tabel peminjaman dengan informasi yang diberikan
    $updateQuery = "UPDATE peminjaman SET bukuDikembalikan = '$bukuDikembalikan', statusPeminjaman = 'Success', penjelasan = '$penjelasan', potonganCoin = '$potonganCoin', statusBuku = '$statusBuku' WHERE pinjamID = '$pinjamID'";

    if ($conn->query($updateQuery) === TRUE) {
        // Mengembalikan jumlah buku ke tabel buku
        $updateBukuQuery = "UPDATE buku SET keluar = keluar - $bukuDikembalikan, total = total + $bukuDikembalikan WHERE bukuID = '$bukuID'";
        $conn->query($updateBukuQuery);

        $petugasID = $_SESSION['userID'];
        $namaPetugas = $_SESSION['namaUser'];
        $tanggal = date('d-m-Y');
        $pesan = "INSERT INTO notif (petugasID, namaPetugas, userID, pesan, tgl, status) VALUES ('$petugasID', '$namaPetugas', '$peminjamID', '$pesan', '$tanggal', 'belumDibaca')";
        $conn->query($pesan);

        // Mengambil nilai potongan coin, jika tidak diisi, dianggap sebagai 0
        $potonganCoin = isset($_POST['PotonganCoin']) ? floatval($_POST['PotonganCoin']) : 0;

        // Menghitung jumlah koin yang harus dikembalikan
        $coinAkhir = $coin - $potonganCoin;

        // Mengembalikan koin ke tabel user
        $updateUserQuery = "UPDATE user SET coin = coin + $coinAkhir WHERE userID = '$peminjamID'";
        $conn->query($updateUserQuery);

        // Jika tidak ada potongan coin, masukkan kembali coin sebelumnya
        if ($potonganCoin == 0) {
            $updateUserQuery = "UPDATE user SET coin = coin + $coin WHERE userID = '$peminjamID'";
            $conn->query($updateUserQuery);
        }

        // Tampilkan pesan sukses menggunakan Sweet Alert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Pengembalian buku berhasil!',
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                window.location='../pengembalian.php';
            });
        </script>";
        exit();
    } else {
        // Tampilkan pesan error menggunakan Sweet Alert
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memperbarui rekaman: " . $conn->error . "',
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                window.location='../pengembalian.php';
            });
        </script>";
        exit();
    }
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Penjelasan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../pengembalian.php">Pegembalian</a></div>
                <div class="breadcrumb-item">Form penjelasan</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Forms</h2>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-10">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <ul>
                                        <h4>Nama Peminjam <span class="text-primary h2"><?= $namaPeminjam ?></span> </h4>
                                        <h4 class="mb-2">Nama Buku Dipinjam <span class="text-primary h2"><?= $namaBuku ?></span> Jumlah
                                            <span class="text-primary"><?= $jumlah; ?></span>
                                        </h4>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="bukuDikembalikan">Jumlah Buku Dikembalikan</label>
                                    <input type="text" name="bukuDikembalikan" max="<?= $jumlah ?>" value="<?= $jumlah ?>" class="form-control" placeholder="Jumlah Buku" required>
                                </div>
                                <div class="form-group">
                                    <label for="keadaan">Keadaan Buku</label>
                                    <select name="keadaan" id="keadaan" class="form-control">
                                        <option value="Sangat Baik">Sangat Baik</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Buruk">Buruk</option>
                                        <option value="Sangat Buruk">Sangat Buruk</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="penjelasan">Penjelasan</label>
                                    <textarea name="penjelasan" id="penjelasan" class="form-control" placeholder="Masukan Penjelasan Keadaan Buku" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="coin" class="col-form-label">Coin Awal dan Potongan</label>
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="coin" readonly value="<?= $coin; ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Coin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="PotonganCoin" placeholder="Potongan Coin" max="<?= $coin; ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Coin</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pesan">Pesan kepada <span class="text-primary"><?= $namaPeminjam ?></span></label>
                                    <textarea name="pesan" class="form-control" placeholder="Berikan Pesan kepada <?= $namaPeminjam ?>">Pengembalian buku <?= $namaBuku ?> dengan jumlah <?= $jumlah ?>, berhasil dikonfirmasi. Terima Kasih Telah Menggunakan Jasa Kami, Semoga buku ini memberikan inspirasi dan pengetahuan yang berharga bagi Anda dan jangan ragu untuk kembali menggunakan layanan kami di masa depan.😊</textarea>
                                </div>
                                <button type="submit" name="kembalikan" class="btn btn-primary">Konfirmasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../_footer.php'; ?>