<?php require_once '../../config/koneksi.php';
include '../_header.php';

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    $sql = "SELECT * FROM user WHERE userID = '$userID'";
    $result_sql = $conn->query($sql);
    $row = $result_sql->fetch_assoc();
}

// Jika form telah disubmit 
if (isset($_POST['submit'])) {
    if (isset($_POST['coin'])) {
        $coin = $_POST['coin'];
        $tgl = date('d-m-Y');

        // Query untuk menambahkan stok buku
        $tambah_stock_query = "UPDATE user SET coin = coin + $coin WHERE userID = $userID";
        $notif = "INSERT INTO notif (userID, pesan, tgl, status) VALUES ('$userID', 'Selamat Coin Anda Telah Bertambah Sebanyak $coin!', '$tgl', 'belumDibaca')";

        if ($conn->query($tambah_stock_query) === TRUE && $conn->query($notif) === TRUE) {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Coin User Berhasil ditambahkan.',
            }).then(function () {
                window.location.href = '../reader.php';
            });
            </script>";
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat menambahkan stok: " . $conn->error . "',
            });
            </script>";
        }
    } elseif (isset($_POST['kurangi'])) {
        $kurangi = $_POST['kurangi'];
        $tgl = date('d-m-Y');

        // Query untuk mengurangi coin
        $kurangi_stock_query = "UPDATE user SET coin = coin - $kurangi WHERE userID = $userID";
        $notif = "INSERT INTO notif (userID, pesan, tgl, status) VALUES ('$userID', 'Maaf, Coin Anda Telah Berkurang Sebanyak $kurangi!', '$tgl', 'belumDibaca')";

        if ($conn->query($kurangi_stock_query) === TRUE && $conn->query($notif) === TRUE) {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Coin User Berhasil dikurangi.',
            }).then(function () {
                window.location.href = '../reader.php';
            });
            </script>";
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat mengurangi coin: " . $conn->error . "',
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
                <div class="breadcrumb-item"><a href="../reader.php">Reader</a></div>
                <div class="breadcrumb-item">Form Tambah</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Forms</h2>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-10">
                    <div class="card shadow">
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group">
                                    <label for="namaUser">Nama User:</label>
                                    <input type="text" class="form-control" name="namaUser" id="namaUser" value="<?= $row['namaLengkap']; ?>" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coin">Coin Saat Ini:</label>
                                            <input type="text" class="form-control" id="coin" min="0" value="<?= $row['coin']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coinTambah">Tambahkan Coin:</label>
                                            <input type="number" oninput="validateTambah(this)" class="form-control" id="coinTambah" name="coin" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="coinKurang">Kurangi Coin</label>
                                    <input type="number" oninput="validateKurang(this)" class="form-control" name="kurangi">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Tambah/Kurangi Coin</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function validateTambah(input) {
        var kurangiInput = document.getElementById('coinKurang');
        if (input.value < 0) {
            input.value = 0;
        }
        // Disable input untuk mengurangi coin jika input untuk menambah coin diisi
        if (input.value !== "" && input.value !== "0") {
            kurangiInput.disabled = true;
        } else {
            kurangiInput.disabled = false;
        }
    }

    function validateKurang(input) {
        var tambahInput = document.getElementById('coinTambah');
        if (input.value < 0) {
            input.value = 0;
        }
        // Disable input untuk menambah coin jika input untuk mengurangi coin diisi
        if (input.value !== "" && input.value !== "0") {
            tambahInput.disabled = true;
        } else {
            tambahInput.disabled = false;
        }
    }
</script>

<?php include '../_footer.php'; ?>