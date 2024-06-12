<?php require_once '../../config/koneksi.php';
include '../_header.php';

if (isset($_POST['tambah'])) {
    // Tangkap data yang dikirimkan melalui form
    $namaUser = htmlspecialchars($_POST['namaUser']);
    $notelp = htmlspecialchars($_POST['notelp']);
    $hakAkses = htmlspecialchars($_POST['hakAkses']);
    $status = htmlspecialchars($_POST['status']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $tgl = date('d-m-Y');
    
    function generateRandomNumber()
    {
        return str_pad(mt_rand(1, 99999999), 8, '1', STR_PAD_LEFT);
    }

    // Membuat bukuID dengan format MYB-nomor
    $user = generateRandomNumber();

    // Proses pemeriksaan username
    $query_check_username = "SELECT * FROM user2 WHERE username = '$username'";
    $result_check_username = mysqli_query($conn, $query_check_username);

    if (mysqli_num_rows($result_check_username) > 0) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Username sudah digunakan. Silakan gunakan username lain.'
                });
              </script>";
    } else {
        // Jika username belum digunakan, lanjutkan proses penyimpanan data pengguna
        // Mendapatkan informasi tentang file yang diunggah
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_size = $_FILES['gambar']['size'];
        $gambar_error = $_FILES['gambar']['error'];

        // Cek apakah pengguna telah memilih file gambar
        if (!empty($gambar_name)) {
            // Mendapatkan ekstensi file gambar
            $gambar_ext = strtolower(pathinfo($gambar_name, PATHINFO_EXTENSION));

            // Daftar ekstensi file gambar yang diizinkan
            $allowed_ext = array('jpg', 'jpeg', 'png');

            // Cek apakah ekstensi file gambar diizinkan
            if (in_array($gambar_ext, $allowed_ext)) {
                // Cek apakah tidak ada error saat mengunggah
                if ($gambar_error === 0) {
                    // Tentukan direktori penyimpanan gambar
                    $gambar_destination = '../../assets/img/user/';

                    // Buat nama file yang unik
                    $gambar_new_name = time() . '.' . $gambar_ext;

                    // Pindahkan file yang diunggah ke direktori penyimpanan dengan nama baru yang unik
                    if (move_uploaded_file($gambar_tmp, $gambar_destination . $gambar_new_name)) {
                        // Masukkan data ke dalam database
                        $query = "INSERT INTO user2 (userID, namaUser, notelp, hakAkses, status, username, password, gambar, tgl_daftar, alamat) 
                                  VALUES ('$user', '$namaUser', '$notelp', '$hakAkses', '$status', '$username', '$password', '$gambar_new_name', '$tgl', '$alamat')";

                        // Jalankan query INSERT
                        if (mysqli_query($conn, $query)) {
                            echo "<script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Tambah Data Staff Berhasil',
                                        text: 'Data staff berhasil ditambahkan!',
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then(function () {
                                        window.location.href = '../staff.php'; // Redirect setelah menutup SweetAlert
                                    });
                                  </script>";
                            exit();
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    } else {
                        echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error saat mengunggah gambar.',
                                });
                              </script>";
                    }
                } else {
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error saat mengunggah gambar.',
                            });
                          </script>";
                }
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ekstensi file gambar tidak diizinkan.',
                        });
                      </script>";
            }
        } else {
            // Jika pengguna tidak memilih file gambar, lanjutkan proses tanpa validasi ekstensi file gambar
            // Proses operasi SQL INSERT untuk menyimpan data buku ke dalam tabel
            // Masukkan data ke dalam database
            $query = "INSERT INTO user2 (namaUser, notelp, hakAkses, status, username, password) 
                    VALUES ('$namaUser', '$notelp', '$hakAkses', '$status', '$username', '$password')";

            // Jalankan query INSERT
            if (mysqli_query($conn, $query)) {
                echo "<div class='container-fluid'>
                        <div class='alert alert-success text-center' role='alert'>Tambah Data Staff berhasil</div>
                    </div>";
                echo "<script>window.setTimeout(function(){ window.location.href = '../staff.php'; }, 2000);</script>";
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Staff</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../staff.php">Staff</a></div>
                <div class="breadcrumb-item">Form Tambah</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Forms</h2>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-10">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="gambar">Foto Profil</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="namaUser">Nama</label>
                                            <input type="text" name="namaUser" class="form-control" id="namaUser" pattern="[A-Za-z\s]+" placeholder="Masukan Nama Staff" required>
                                            <div class="invalid-feedback">Hanya huruf yang diperbolehkan.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="notelp">Nomor Telepon</label>
                                            <input type="text" name="notelp" class="form-control" id="notelp" placeholder="Masukan No telepon Staff" pattern="^08[0-9]{7,15}$" required>
                                            <div class="invalid-feedback">Masukkan nomor telepon yang valid.</div>
                                            <small>Diawali dengan 08...</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Masukan Alamat Staff</label>
                                    <textarea name="alamat" class="form-control" placeholder="Masukan Alamat Staff" required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hakAkses">Jabatan</label>
                                            <select id="hakAkses" name="hakAkses" class="form-control" required>
                                                <option value="Admin">Admin</option>
                                                <option value="Pustakawan">Pustakawan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Nonaktif">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" name="username" placeholder="Masukan Username Staff" class="form-control" minlength="5" id="username" required>
                                            <div class="invalid-feedback">Usename harus memiliki minimal 5 karakter.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" minlength="8" placeholder="Masukan Password Staff" class="form-control" id="password" required>
                                            <div class="invalid-feedback">Password harus memiliki minimal 8 karakter.</div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="tambah" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../_footer.php'; ?>