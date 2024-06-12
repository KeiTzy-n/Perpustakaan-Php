<?php require_once '../config/koneksi.php';
include '_header.php'; 
// Ambil informasi pengguna dari database
$sql = "SELECT * FROM user2 WHERE userID = '$userID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $namaLengkap = $row['namaUser'];
    $notelp = $row['notelp'];
    $gambar = $row['gambar'];
    $alamat = $row['alamat']; 
    $hakAkses = $row['hakAkses'];
} else {
    echo "Data pengguna tidak ditemukan";
    exit(); // Stop further execution
}

// Pesan default untuk umpan balik
$feedback_message = "";

// Pastikan tombol save ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek apakah file gambar yang diunggah valid
    if (!empty($_FILES["gambar"]["name"])) { // Periksa apakah file gambar baru dipilih
        // Mendapatkan informasi file gambar yang diunggah
        $file_name = $_FILES["gambar"]["name"];
        $file_size = $_FILES["gambar"]["size"];
        $file_tmp = $_FILES["gambar"]["tmp_name"];
        $file_type = $_FILES["gambar"]["type"];

        // Mendapatkan ekstensi file
        // Mendapatkan ekstensi file
        $file_name_parts = explode('.', $file_name);
        $file_ext = strtolower(end($file_name_parts));


        // Ekstensi yang diperbolehkan
        $extensions = array("jpeg", "jpg", "png");

        // Cek apakah ekstensi file sesuai dengan yang diperbolehkan
        if (in_array($file_ext, $extensions) === false) {
            $feedback_message = "Ekstensi file tidak diperbolehkan, pilih file JPEG atau PNG.";
        } elseif ($file_size > 2097152) { // Cek apakah ukuran file tidak melebihi batas yang ditentukan (di sini, 2MB)
            $feedback_message = "Ukuran file terlalu besar. Pilih file dengan ukuran kurang dari 2MB.";
        } else {
            // Tentukan direktori tempat file gambar akan disimpan
            $upload_dir = "../assets/img/user/";

            // Generate nama unik untuk file gambar baru
            $new_file_name = uniqid() . "." . $file_ext;

            // Tentukan lokasi akhir penyimpanan gambar
            $target_file = $upload_dir . $new_file_name;

            // Pindahkan file gambar ke direktori tujuan
            if (move_uploaded_file($file_tmp, $target_file)) {
                // Hapus gambar lama jika ada
                if (!empty($gambar)) {
                    unlink($upload_dir . $gambar);
                }
                // File berhasil diunggah, lakukan pembaruan nama file gambar di database
                $userID = $_SESSION['userID'];
                $sql_update = "UPDATE user2 SET gambar='$new_file_name' WHERE userID='$userID'";
                if ($conn->query($sql_update) === true) {
                    $feedback_message = "Gambar profil berhasil diperbarui.";
                    // Perbarui variabel $gambar dengan nama file gambar yang baru
                    $gambar = $new_file_name;
                } else {
                    $feedback_message = "Terjadi kesalahan: " . $conn->error;
                }
            } else {
                $feedback_message = "Maaf, terjadi kesalahan saat mengunggah file gambar.";
            }
        }
    } else {
        // Gunakan gambar profil yang sudah ada sebelumnya
        $new_file_name = $gambar; // Gunakan nama file gambar yang sudah ada sebelumnya
        // Perbarui informasi pengguna di database
        $namaUserBaru = $_POST['namaUser'];
        $notelpBaru = $_POST['notelp'];
        $alamatBaru = $_POST['alamat'];
        $sql_update = "UPDATE user2 SET namaUser='$namaUserBaru', notelp='$notelpBaru', alamat= '$alamatBaru' WHERE userID='$userID'";
        if ($conn->query($sql_update) === true) {
            $feedback_message = "Informasi pengguna berhasil diperbarui.";
            // Perbarui variabel $namaUser dan $notelp dengan data baru
            $namaUser = $namaUserBaru;
            $notelp = $notelpBaru;
        } else {
            $feedback_message = "Terjadi kesalahan: " . $conn->error;
        }
    }

    // Ubah kata sandi jika password lama cocok dan password baru valid
    $passwordOld = $_POST['passwordOld'];
    $passwordNew = $_POST['password'];

    // Ambil password hash dari database untuk membandingkan dengan password lama yang dimasukkan
    $password_query = "SELECT password FROM user2 WHERE userID = '$userID'";
    $password_result = $conn->query($password_query);

    if ($password_result->num_rows > 0) {
        $password_row = $password_result->fetch_assoc();
        $hashed_password = $password_row['password'];

        // Verifikasi password lama
        if (password_verify($passwordOld, $hashed_password)) {
            // Password lama cocok, hash password baru dan simpan ke database
            $hashed_new_password = password_hash($passwordNew, PASSWORD_DEFAULT);
            $update_password_query = "UPDATE user2 SET password='$hashed_new_password' WHERE userID='$userID'";
            if ($conn->query($update_password_query) === true) {
                $feedback_message .= " Kata sandi berhasil diperbarui.";
            } else {
                $feedback_message .= " Terjadi kesalahan saat memperbarui kata sandi: " . $conn->error;
            }
        } else {
            $feedback_message .= " Password lama tidak valid.";
        }
    } else {
        $feedback_message .= " Tidak dapat memeriksa password saat ini.";
    }

    // Setelah proses selesai, segarkan halaman untuk menampilkan pesan umpan balik
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, <?= $namaUser ?> || <?= $hakAkses ?></h2>


            <!-- Content Row -->
            <div class="row">

                <!-- Profile Picture -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                    src="<?= base_url('assets/img/user/') . $gambar; ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Profile Form -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h5 class="m-0 font-weight-bold text-primary">Edit User Information</h5>
                            <hr>
                            <?php if (!empty($feedback_message)) : ?>
                            <div class="alert alert-info"><?= $feedback_message; ?></div>
                            <?php endif; ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="gambar">Gambar Profil</label><br>
                                    <img src="../assets/img/user/<?= $gambar ?>" width="100" alt="Gambar Lama"><br>
                                    <input type="file" name="gambar" id="gambar" class="form-control-file">
                                </div>
                                <div class="form-group">
                                    <label for="namaUser"><strong>Nama:</strong></label>
                                    <input type="text" class="form-control" id="namaUser" name="namaUser"
                                        value="<?= $namaLengkap; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="notelp" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="notelp" name="notelp"
                                        pattern="^08[0-9]{7,15}$" title="Masukkan nomor telepon yang valid" required
                                        value="<?= $notelp; ?>">
                                    <div class="invalid-feedback">Masukkan nomor telepon yang valid.</div>
                                    <small>Diawali dengan 08...</small>
                                </div>
                                <div class="form-group">
                                    <label for="alamat"><strong>Alamat:</strong></label>
                                    <textarea name="alamat" id="alamat" class="form-control"><?= $alamat; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="passwordOld">Password Sebelumnya</label>
                                    <input type="password" name="passwordOld" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="password" name="password" minlength="8" class="form-control">
                                    <div class="invalid-feedback">Password harus memiliki minimal 8 karakter.</div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.row -->

        </div>
    </section>
</div>

<?php include '_footer.php'; ?>