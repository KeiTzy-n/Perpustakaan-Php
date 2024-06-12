<?php include '_header.php'; 

if(isset($_GET['pinjam'])){
    $pinjamID = $_GET['pinjam'];

    $peminjaman = "SELECT * FROM peminjaman WHERE pinjamID = '$pinjamID'";
    $resultPeminjaman = $conn->query($peminjaman);

    if($resultPeminjaman){
        $row = mysqli_fetch_assoc($resultPeminjaman);

        $tglPengembalian = $row['tglPengembalian'];
        $statusPeminjaman = $row['statusPeminjaman'];

        // Cek status peminjaman
        if ($statusPeminjaman != 'Dipinjamkan') {
            echo "<script>
                Swal.fire({
                    title: 'Maaf, peminjaman tidak bisa diperpanjang karena status bukan Dipinjamkan',
                    icon: 'error',
                    showConfirmButton: false
                });
            </script>";
            echo "<script>
                setTimeout(function(){ 
                    window.history.go(-1); 
                }, 2000);
            </script>";
            exit;
        }
    }
}

if(isset($_POST['submit'])){
    $pinjamID = $_POST['pinjamID'];
    $tambahWaktu = $_POST['tambahWaktu'];

    // Mendapatkan jumlah coin pengguna sebelum perpanjangan
    $getUserCoinsQuery = "SELECT coin FROM user WHERE userID = (SELECT userID FROM peminjaman WHERE pinjamID = '$pinjamID')";
    $userCoinsResult = $conn->query($getUserCoinsQuery);
    $userCoins = 0;

    if ($userCoinsResult->num_rows > 0) {
        $userCoinsRow = $userCoinsResult->fetch_assoc();
        $userCoins = $userCoinsRow['coin'];
    }

    // Mendapatkan jumlah hari perpanjangan
    $perpanjanganHari = intval($tambahWaktu);

    // Mengurangi coin dari jumlah pengguna
    $coinSisa = $userCoins - (5 * $perpanjanganHari);

    if ($coinSisa >= 0) {
        // Perbarui jumlah coin pengguna di database
        $updateCoinsQuery = "UPDATE user SET coin = $coinSisa WHERE userID = (SELECT userID FROM peminjaman WHERE pinjamID = '$pinjamID')";
        $conn->query($updateCoinsQuery);

        // Hitung tanggal pengembalian baru
        $tglPengembalianBaru = date('d-m-Y', strtotime("$tglPengembalian + $perpanjanganHari days"));

        // Perpanjang tanggal pengembalian
        $perpanjangTanggalQuery = "UPDATE peminjaman SET tglPengembalian = '$tglPengembalianBaru' WHERE pinjamID = '$pinjamID'";
        $conn->query($perpanjangTanggalQuery);

        if ($conn->affected_rows > 0) {
            echo "<script>
            Swal.fire({
                title: 'Perpanjangan peminjaman berhasil',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000
            });
        
            // Setelah menampilkan pesan Swal, tunggu selama 2 detik (2000 milidetik), lalu alihkan pengguna ke halaman tujuan
            setTimeout(function(){
                window.location.href = 'dipinjam.php'; 
            }, 2000); 
        </script>";
              
        } else {
            echo "<script>Swal.fire('Maaf, terjadi kesalahan saat memperpanjang peminjaman', '', 'error');</script>";
        }
    } else {
        echo "<script>Swal.fire('Maaf, jumlah coin tidak mencukupi untuk perpanjangan', '', 'error');</script>";
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="home.php">Home</a></div>
                <div class="breadcrumb-item active"><a href="dipinjam.php">Peminjaman</a></div>
                <div class="breadcrumb-item ">Peminjaman</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Perpanjang Peminjaman</h2>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card card-primary shadow-lg">
                        <div class="card-body">
                            <form action="" method="post">
                                <p class="alert alert-danger">Perpanjangan batas waktu perhari membutuhkan
                                    <span>5</span> coin, Dan coin untuk perpanjangan batas waktu tidak
                                    akan
                                    dikembalikan</p>
                                <input type="hidden" name="pinjamID" value="<?= $pinjamID; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tglPengembalian">Batas Waktu</label>
                                            <input type="text" readonly name="tglPengembalian"
                                                value="<?= $tglPengembalian; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tambahWaktu">Perpanjang Waktu</label>
                                            <input type="text" name="tambahWaktu" class="form-control" pattern="[1-7]"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">Perpanjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '_footer.php'; ?>