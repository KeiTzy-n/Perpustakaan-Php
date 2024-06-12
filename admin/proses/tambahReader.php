<?php
require_once '../../config/koneksi.php';
include '../_header.php';

// Proses pengunggahan gambar jika formulir disubmit
if (isset($_POST['tambah'])) {
    // Tangkap data yang dikirimkan melalui form
    $namaUser = htmlspecialchars($_POST['namaUser']);
    $notelp = htmlspecialchars($_POST['notelp']);
    $status = htmlspecialchars($_POST['status']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $tgl = date('d-m-Y');
    
    function generateRandomNumber()
    {
        return str_pad(mt_rand(1, 99999999), 8, '1', STR_PAD_LEFT);
    }

    // Membuat bukuID dengan format MYB-nomor
    $user = generateRandomNumber();
    
    // Query untuk memeriksa apakah username sudah terdaftar
    $query_check_username = "SELECT * FROM user WHERE username = '$username'";
    $result_check_username = mysqli_query($conn, $query_check_username);

    // Cek apakah query mengembalikan hasil atau tidak
    if (mysqli_num_rows($result_check_username) > 0) {
        // Jika username sudah terdaftar, tampilkan pesan kesalahan menggunakan SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Username sudah terdaftar. Silakan gunakan username lain.'
            });
        </script>";
    } else {
        // Mendapatkan informasi tentang file yang diunggah
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_size = $_FILES['gambar']['size'];
        $gambar_error = $_FILES['gambar']['error'];

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
                        // Proses operasi SQL INSERT untuk menyimpan data pembaca ke dalam tabel
                        // Masukkan data ke dalam database
                        $query = "INSERT INTO user (userID, namaLengkap, notelp, status, username, password, gambar, tgl_daftar) 
                                  VALUES ('$user', '$namaUser', '$notelp',  '$status', '$username', '$password', '$gambar_new_name', '$tgl')";

                        // Jalankan query INSERT
                        if (mysqli_query($conn, $query)) {
                            // Tampilkan SweetAlert untuk memberi tahu pengguna bahwa data telah ditambahkan
                            echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Tambah Data Reader berhasil'
                                }).then(function() {
                                    window.location.href = '../reader.php';
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
                                title: 'Oops...',
                                text: 'Error saat mengunggah gambar.'
                            });
                        </script>";
                    }
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error saat mengunggah gambar.'
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ekstensi file gambar tidak diizinkan.'
                    });
                </script>";
            }
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
                        <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="gambar">Foto Profil</label>
                            <input type="file" class="form-control" id="gambar" required name="gambar">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="namaUser">Nama</label>
                                    <input type="text" name="namaUser" class="form-control" id="namaUser"
                                        pattern="[A-Za-z\s]+" placeholder="Masukan Nama Reader" required>
                                    <div class="invalid-feedback">Hanya huruf yang diperbolehkan.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="notelp">Nomor Telepon</label>
                                    <input type="text" name="notelp"  class="form-control" id="notelp"
                                    placeholder="Masukan No Telepon Reader" pattern="^08[0-9]{7,15}$" required>
                                    <div class="invalid-feedback">Masukkan nomor telepon yang valid.</div>
                                    <small>Diawali dengan 08...</small>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                    <input type="text" minlength="5" placeholder="Masukan Username Reader" name="username" class="form-control" id="username" required>
                                </div>
                                <div class="invalid-feedback">Usename harus memiliki minimal 5 karakter.</div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" minlength="8" placeholder="Masukan Password Reader" class="form-control" id="password" required>
                                </div>
                                <div class="invalid-feedback">Password harus memiliki minimal 8 karakter.</div>
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

<?php
include '../_footer.php';
?>
