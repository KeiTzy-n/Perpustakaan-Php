<?php require_once '../config/koneksi.php';
include '_header.php';

// Check if user ID is provided
if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];

    // Query untuk menghapus pengguna dari database
    $hapus_query = "DELETE FROM user2 WHERE userID = $userID";

    // Ambil nama file gambar dari database
    $query_nama_gambar = "SELECT gambar FROM user2 WHERE userID = $userID";
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
                    window.location.href = 'staff.php';
                });
            </script>";
    } else {
        echo "Error: " . $hapus_query . "<br>" . $conn->error;
    }
}

// query users
$users = "SELECT * FROM user2";
$result = $conn->query($users);

?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>DataTables</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="staff.php">Staff</a></div>
                <div class="breadcrumb-item">Staff</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Staff</h2>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4><a href="proses/tambahStaff.php" data-toggle="tooltip" data-placement="right"
                                    title="Tambah Staff" class="btn btn-info"><i class="fas fa-plus"></i> Staff</a></h4>
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
                                            <th>Pengguna</th>
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
                                                    <div class="gallery-item"
                                                        data-image="../assets/img/user/<?= $staf['gambar']; ?>"
                                                        data-title="<?= $staf['namaUser'] ?>"></div>
                                                </div>
                                            </td>
                                            <td><?= $staf['namaUser']; ?></td>
                                            <td><?= $staf['notelp']; ?></td>
                                            <td><?= $staf['hakAkses']; ?></td>
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
                                                <a href="proses/viewStaff.php?userID=<?= $staf['userID']; ?>"
                                                    data-gambar="<?= $staf['gambar']; ?>"
                                                    data-nama="<?= $staf['namaUser']; ?>" class="btn btn-info btn-sm"><i
                                                        class="fa fa-eye" aria-hidden="true" data-toggle="tooltip"
                                                        data-placement="top" title="Detail Staff"></i></a>
                                                <?php
            // Tampilkan tombol hapus hanya jika userID tidak cocok dengan sesi saat ini
            if ($staf['userID'] != $_SESSION['userID']) {
        ?>
                                                <!-- tambah stock -->
                                                <a href="proses/ubahStaff.php?id=<?= $staf['userID']; ?>"
                                                    data-gambar="<?= $staf['gambar']; ?>"
                                                    data-nama="<?= $staf['namaUser']; ?>"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-user"
                                                        aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                                        title="Ubah status"></i></a>
                                                <!-- Tambah Coin -->

                                                <form id="deleteForm" action="" method="post" class="d-inline-block">
                                                    <input type="hidden" name="userID" value="<?= $staf['userID']; ?>">
                                                    <button type="submit" data-toggle="tooltip" data-placement="top"
                                                        title="Delete Data" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus?');"
                                                        data-toggle="modal" data-target="#confirmDelete">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                <?php } ?>
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