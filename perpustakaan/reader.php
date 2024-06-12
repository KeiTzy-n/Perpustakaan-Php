<?php require_once '../config/koneksi.php';
include '_header.php';

// Check if user ID is provided
if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];

    // Query untuk menghapus pengguna dari database
    $hapus_query = "DELETE FROM user WHERE userID = $userID";

    // Ambil nama file gambar dari database
    $query_nama_gambar = "SELECT gambar FROM user WHERE userID = $userID";
    $result_nama_gambar = $conn->query($query_nama_gambar);
    $nama_gambar = $result_nama_gambar->fetch_assoc()['gambar'];

    // Hapus file gambar dari direktori
    $file_path = '../assets/img/user/' . $nama_gambar;
    if (file_exists($file_path)) {
        unlink($file_path); // Hapus file gambar
    }

    // Eksekusi query untuk menghapus pengguna dari database
    if ($conn->query($hapus_query) === TRUE) {
        echo "<script>
                Swal.fire({
                    title: 'Penghapusan Berhasil',
                    text: 'Data berhasil dihapus.',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'reader.php';
                });
            </script>";
    } else {
        echo "Error: " . $hapus_query . "<br>" . $conn->error;
    }
}

// query users
$users = "SELECT * FROM user";
$result = $conn->query($users);

?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>DataTables</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="reader.php">Reader</a></div>
                <div class="breadcrumb-item">Reader</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Reader</h2>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4><a href="proses/tambahReader.php" data-toggle="tooltip" data-placement="right" title="Tambah Reader" class="btn btn-info"><i class="fas fa-plus"></i> Reader</a></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-cog"></i></th>
                                            <th>Gambar</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Coin</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $nomor = 1; // Inisialisasi nomor baris
                                        while ($staf = $result->fetch_assoc()) {
                                            $readerID = $staf['userID'];
                                        ?>
                                            <tr>
                                                <td><?= $nomor++; ?></td> <!-- Urutan nomor baris -->
                                                <td>
                                                    <div class="gallery">
                                                        <div class="gallery-item" data-image="../assets/img/user/<?= $staf['gambar']; ?>" data-title="<?= $staf['namaLengkap'] ?>"></div>
                                                    </div>
                                                </td>
                                                <td><?= $staf['namaLengkap']; ?></td>
                                                <td><?= $staf['notelp']; ?></td>
                                                <td><?= $staf['coin']; ?></td>
                                                <td> <?php
                                                        if ($staf['status'] == 'Aktif') {
                                                            echo '<p class="badge badge-success">' . $staf['status'] . '</p>';
                                                        } else {
                                                            echo '<p class="badge badge-danger">' . $staf['status'] . '</p>';
                                                        }
                                                        ?>
                                                </td>
                                                <td>
                                                    <!-- Tambah Coin -->
                                                    <a data-toggle="tooltip" data-placement="top" title="Detail Reader" href="proses/viewReader.php?userID=<?= $staf['userID']; ?>" data-gambar="<?= $staf['gambar']; ?>" data-nama="<?= $staf['namaLengkap']; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    <!-- Tambah Coin -->
                                                    <a data-toggle="tooltip" data-placement="top" title="Tambah Coin" href="proses/tambahCoin.php?userID=<?= $staf['userID']; ?>" data-gambar="<?= $staf['gambar']; ?>" data-nama="<?= $staf['namaLengkap']; ?>" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                    <!-- tambah stock -->
                                                    <a data-toggle="tooltip" data-placement="top" title="Ubah Status" href="proses/ubahReader.php?id=<?= $staf['userID']; ?>" data-gambar="<?= $staf['gambar']; ?>" data-nama="<?= $staf['namaLengkap']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-user" aria-hidden="true"></i></a>
                                                    <!-- Tambah Coin -->
                                                    <form id="deleteForm" action="" method="post" class="d-inline-block">
                                                        <input type="hidden" name="userID" value="<?= $staf['userID']; ?>">
                                                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Delete Data" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?');" data-toggle="modal" data-target="#confirmDelete">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '_footer.php'; ?>