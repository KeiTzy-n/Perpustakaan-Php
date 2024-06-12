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

// Jika form login disubmit
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT userID, password, namaLengkap, status FROM user WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);

                if (password_verify($password, $row['password'])) {
                    if ($row['status'] == "Aktif") {
                        $_SESSION['userID']  = $row['userID'];
                        $_SESSION['username'] = $username; // Menggunakan $username yang didapatkan dari form
                        $_SESSION['namaUser'] = $row['namaLengkap'];

                        // Jika checkbox Remember Me dicentang
                        if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                            // Atur cookie remember me
                            setRememberMeCookie($username);
                        } else {
                            // Hapus cookie remember me jika tidak dicentang
                            removeRememberMeCookie();
                        }

                        echo "<script>window.location='home.php';</script>";
                        exit();
                    } else {
                        $error = "Maaf, status Anda nonaktif. Silahkan hubungi admin untuk mengaktifkannya.";
                    }
                } else {
                    $error = "Username / Password Salah";
                }
            } else {
                $error = "Username / Password Salah";
            }
        } else {
            $error = "Query execution failed: " . mysqli_error($conn);
        }
    }
}

// Jika ada cookie remember_me
if (isset($_COOKIE['remember_me'])) {
    $rememberedUsername = $_COOKIE['remember_me'];
    $userInfo = getUserByUsername($rememberedUsername, $conn);
    
    if ($userInfo) {
        $_SESSION['userID'] = $userInfo['userID'];
        $_SESSION['username'] = $rememberedUsername; 
        $_SESSION['namaUser'] = $userInfo['namaLengkap'];
        echo "<script>window.location='home.php';</script>";
        exit();
    } else {
        removeRememberMeCookie();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login || MyBooks</title>
    <link rel="icon" href="<?= base_url('assets/img/bahan/logo.jpg'); ?>" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

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
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="assets/img/bahan/logo.jpg" alt="logo" width="100"
                                class="shadow-light rounded-circle">
                        </div>

                        <?php
    if (isset($error)) {
        echo '
        <div class="alert alert-danger alert-dismissible show fade" role="alert">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                ' . $error . '
            </div>
        </div>';
    }
    ?>

                        <div class="card shadow card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="username" class="form-control" name="username"
                                            tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                            Masukan Username anda
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2" required>
                                        <div class="invalid-feedback">
                                            Masukan Password
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                tabindex="3" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block"
                                            tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Belum Punya Akun? <a href="daftar.php">Buat Akun</a>
                        </div>
                        <div class="mt-2 text-muted text-center">
                            <a href="index.php">Masuk Halaman</a>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; KeiTzy || Imams 2024
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var rememberCheckbox = document.getElementById('remember-me');
        var usernameInput = document.getElementById('username');
        var rememberMeCookie = getCookie('remember_me');

        if (rememberMeCookie) {
            rememberCheckbox.checked = true;
            usernameInput.value = rememberMeCookie;
        }

        rememberCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Saat tombol "Remember Me" dicentang, atur cookie dengan nama "remember_me"
                setCookie('remember_me', usernameInput.value, 30); // Cookie berlaku selama 30 hari
            } else {
                // Jika tidak dicentang, hapus cookie "remember_me"
                deleteCookie('remember_me');
            }
        });

        function setCookie(name, value, days) {
            var expires = '';
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + (value || '') + expires + '; path=/';
        }

        function getCookie(name) {
            var nameEQ = name + '=';
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1, cookie.length);
                }
                if (cookie.indexOf(nameEQ) === 0) {
                    return cookie.substring(nameEQ.length, cookie.length);
                }
            }
            return null;
        }

        function deleteCookie(name) {
            document.cookie = name + '=; Max-Age=-99999999;';
        }
    });
    </script>

    <!-- General JS Scripts -->
    <script src="assets/modules/jquery.min.js"></script>
    <script src="assets/modules/popper.js"></script>
    <script src="assets/modules/tooltip.js"></script>
    <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="assets/modules/moment.min.js"></script>
    <script src="assets/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>