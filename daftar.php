<?php
require_once 'config/koneksi.php';

// Fungsi untuk mengatur cookie remember me
function setRememberMeCookie($username) {
    // Atur cookie dengan nama "remember_me" dengan nilai username
    setcookie("remember_me", $username, time() + (86400 * 30), "/"); // Cookie berlaku selama 30 hari
}

// Fungsi untuk menghapus cookie remember me
function removeRememberMeCookie() {
    // Hapus cookie dengan nama "remember_me"
    setcookie("remember_me", "", time() - 3600, "/");
}

// Fungsi untuk mendapatkan informasi pengguna berdasarkan username
function getUserByUsername($username, $conn) {
    $query = "SELECT userID, password, namaLengkap, status FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['namaLengkap'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $confirm_password = $_POST['konfirmasiPassword'];
    $status = 'Aktif';
    
    function generateRandomNumber()
    {
        return str_pad(mt_rand(1, 99999999), 8, '1', STR_PAD_LEFT);
    }

    $userID = generateRandomNumber();

    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Cek apakah username sudah ada dalam database
        $check_query = "SELECT * FROM user WHERE username=?";
        $check_stmt = $conn->prepare($check_query);

        // Periksa apakah persiapan query berhasil
        if ($check_stmt) {
            $check_stmt->bind_param("s", $username);
            $check_stmt->execute();
            $result = $check_stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Username sudah digunakan, silahkan gunakan username yang berbeda.";
            } else {
                // Periksa apakah file gambar telah diunggah
                if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $gambar_name = $_FILES['gambar']['name'];
                    $gambar_tmp = $_FILES['gambar']['tmp_name'];

                    // Mendapatkan ekstensi file
$gambar_extension = strtolower(pathinfo($gambar_name, PATHINFO_EXTENSION));

// Memeriksa apakah ekstensi file sesuai dengan yang diizinkan
if (!in_array($gambar_extension, ['jpg', 'jpeg', 'png'])) {
    $error = "Hanya file dengan format JPG, JPEG, dan PNG yang diperbolehkan.";
                    }


                    $uniqid = uniqid();
                    $gambar_name = $uniqid . "_" . $gambar_name;
                    
                    $gambar_path = "assets/img/user/" . $gambar_name;
                    $i = 1;
                    while (file_exists($gambar_path)) {
                        $gambar_name = pathinfo($gambar_name, PATHINFO_FILENAME) . "_$i." . pathinfo($gambar_name, PATHINFO_EXTENSION);
                        $gambar_path = "assets/img/user/" . $gambar_name;
                        $i++;
                    }

                    if (move_uploaded_file($gambar_tmp, $gambar_path)) {
                        $gambar_name_only = basename($gambar_path);

                        $tanggal_daftar = date('d-m-Y');
                        $query = "INSERT INTO user (userID, username, namaLengkap, notelp, alamat, gambar, password, status, tgl_daftar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);

                        // Periksa apakah persiapan query berhasil
                        if ($stmt) {
                            $stmt->bind_param("sssssssss", $userID, $username, $nama_lengkap, $notelp, $alamat, $gambar_name_only, $hashed_password, $status, $tanggal_daftar);
                            if ($stmt->execute()) {
                                header("Location: login.php");
                                exit();
                            } else {
                                $error = "Gagal menyimpan data pengguna ke database.";
                            }
                        } else {
                            // Tangani kesalahan saat persiapan query
                            $error = "Error: " . $conn->error;
                        }
                    } else {
                        $error = "Gagal mengunggah gambar.";
                    }
                } else {
                    $error = "Harap unggah gambar profil.";
                }
            }
        } else {
            // Tangani kesalahan saat persiapan query
            $error = "Error: " . $conn->error;
        }
    }
}

// Jika ada cookie remember_me
if (isset($_COOKIE['remember_me'])) {
    $rememberedUsername = $_COOKIE['remember_me'];
    $userInfo = getUserByUsername($rememberedUsername, $conn);
    
    if ($userInfo) {
        // Set session dan langsung arahkan ke halaman index
        $_SESSION['userID'] = $userInfo['userID'];
        $_SESSION['namaUser'] = $userInfo['namaLengkap'];
        echo "<script>window.location='home.php';</script>";
        exit();
    } else {
        // Jika tidak dapat menemukan informasi pengguna, hapus cookie remember_me
        removeRememberMeCookie();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register || MyBooks</title>
  <link rel="icon" href="<?= base_url('assets/img/bahan/logo.jpg'); ?>" />

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
  </script>
  <!-- /END GA -->
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="assets/img/bahan/logo.jpg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <!-- Notifikasi -->
            <?php if (!empty($error)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?php echo $error; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif; ?>


            <div class="card shadow card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>


              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                  enctype="multipart/form-data">
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="namaLengkap">Nama Lengkap</label>
                      <input id="namaLengkap" pattern="[A-Za-z\s]+" required type="text" class="form-control"
                        name="namaLengkap" autofocus>
                      <small class="form-text text-muted">Nama tidak boleh mengandung Nomor.</small>
                    </div>
                    <div class="form-group col-6">
                      <label for="username">Username</label>
                      <input id="username" required minlength="5" type="text" class="form-control" name="username"
                        pattern="^\S+$">
                      <small class="form-text text-muted">Username tidak boleh mengandung spasi.</small>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Nomor Telepon (ID Format)</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-phone"></i>
                        </div>
                      </div>
                      <input type="text" pattern="^08[0-9]{7,15}$" name="notelp" required
                        class="form-control phone-number">
                    </div>
                    <small class="form-text text-muted">Nomor Telepon Harus diawali dengan 08 dan tidak kurang dari 10
                      dan tidak lebih dari 14</small>
                  </div>

                  <div class="form-group">
                    <label for="alamat">Alamat Anda</label>
                    <textarea name="alamat" class="form-control"></textarea>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label>Password Strength</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                          </div>
                        </div>
                        <input type="password" name="password" minlength="8" required class="form-control pwstrength"
                          data-indicator="pwindicator">
                      </div>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Password Confirmation</label>
                      <input id="password2" required type="password" class="form-control" name="konfirmasiPassword">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="gambar">Masukan Foto Profil</label>
                    <input type="file" class="form-control" name="gambar" required accept="image/*">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Sudah Memiliki Akun? <a href="login.php">Login Akun</a>
            </div>
            <div class="simple-footer">
              Copyright &copy; KeiTzy || Imams 2024
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/auth-register.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>

</html>