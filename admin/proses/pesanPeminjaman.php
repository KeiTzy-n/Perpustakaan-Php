<?php require_once '../../config/koneksi.php';
include '../_header.php';

if(isset($_GET['pinjamID'])){
    $pinjamID = $_GET['pinjamID'];

    $select = "SELECT * FROM peminjaman WHERE pinjamID = '$pinjamID'";
    $resultSelect = $conn->query($select);

    if($resultSelect){
        $row = mysqli_fetch_assoc($resultSelect);

        $user = $row['userID'];
        $namaBuku = $row['namaBuku'];
    }
}

if(isset($_POST['submit'])){
    $pesan = htmlspecialchars($_POST['pesan']);

    $insert = "INSERT INTO notif (userID, pesan, tgl, status) VALUES ('$user', '$pesan', NOW(), 'belumDibaca')";
    $resultInsert = $conn->query($insert);

    if($resultInsert){
            echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Pesan berhasil terkirim!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {
                            window.location.href = '../peminjaman.php?status=success';
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
            <h1>Tambah Reader</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../peminjaman.php">Peminjaman</a></div>
                <div class="breadcrumb-item">Form Pesan</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Forms</h2>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="card card-primary shadow">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="pesan">Pesan</label>
                                    <textarea name="pesan"
                                        class="form-control">Haraf Segera mengembalikan Buku <?= $namaBuku ;?>. </textarea>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-comment"></i>
                                    Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../_footer.php'; ?>