<?php require_once 'config/koneksi.php';

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

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $sql = "SELECT * FROM buku WHERE namaBuku LIKE '%$search%' OR
                                     penerbit LIKE '%$search%' OR
                                     penulis LIKE '%$search%' OR 
                                     tahunTerbit LIKE '%$search%'";

    // Execute SQL query
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Mybooks</title>
    <link rel="icon" href="<?= base_url('assets/img/bahan/logo.jpg'); ?>" />

    <!-- My style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/mycss.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/fontawesome/css/all.min.css') ?>">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url('assets/modules/jqvmap/dist/jqvmap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/summernote/summernote-bs4.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/datatables/datatables.min.css') ?>">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') ?>">

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

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="index.php" class="navbar-brand sidebar-gone-hide">Mybooks</a>
                <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
                <div class="nav-collapse">
                    <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a href="aboutme.php" class="nav-link">Tentang Kami</a></li>
                        <li class="nav-item active"><a href="ttcrpeminjaman.php" class="nav-link">Tata Cara
                                Peminjaman</a>
                        </li>
                    </ul>
                </div>
                <form class="form-inline ml-auto" action="cari.php" method="get" onsubmit="return validateSearch()">
                    <ul class="navbar-nav">
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                    class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <input id="searchInput" class="form-control" type="search" name="search"
                            placeholder="Pencarian Judul, Penulis, Penerbit, Tahun Terbit" aria-label="Search"
                            data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                    </div>
                </form>

                <ul class="navbar-nav navbar-right">

                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="assets/img/images.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, Selamat Datang </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="login.php" class="dropdown-item has-icon">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>

                            <a class="dropdown-item has-icon" href="daftar.php">
                                <i class="fas fa-registered"></i> Register
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="index.php" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a>
                        </li>
                        <li class="nav-item ">
                            <a href="#" onclick="tampilkanKonfirmasi()" class="nav-link"><i
                                    class="fas fa-list"></i><span>Book
                                    List</span></a>
                        </li>
                        <li class="nav-item ">
                            <a href="#" onclick="tampilkanKonfirmasi()" class="nav-link"><i
                                    class="fas fa-book"></i><span>Bookmark</span></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i
                                    class="far fa-clone"></i><span>Peminjaman</span></a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a href="#" onclick="tampilkanKonfirmasi()"
                                        class="nav-link">Dipinjam</a></li>
                                <li class="nav-item"><a href="#" onclick="tampilkanKonfirmasi()"
                                        class="nav-link">Riwayat</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Top Navigation</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="index.php">Home</a></div>
                            <div class="breadcrumb-item ">Search</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">MyBooks</h2>

                        <div class="row justify-content-center">
                            <?php
                if (isset($result) && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Memeriksa panjang sinopsis
                        $sinopsis = $row['sinopsis'];
                        if (strlen($sinopsis) > 100) {
                            $sinopsis = substr($sinopsis, 0, 100) . "...";
                        }
                ?>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <article class="article shadow">
                                    <div class="article-header">
                                        <div class="article-image"
                                            data-background="assets/img/buku/<?php echo $row['gambar']; ?>"></div>
                                        <div class="article-title">
                                            <h2><a href="#"><?php echo $row['namaBuku']; ?></a></h2>
                                        </div>
                                    </div>
                                    <div class="article-details">
                                        <p><?php echo $sinopsis; ?></p>
                                        <div class="article-cta">
                                            <a href="#" onclick="tampilkanKonfirmasi()"
                                                class="btn btn-primary">Details</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <?php
                    }
                } else {
                    // No results found
                    echo '<div class="col-md-10 justify-content-center">';
                    echo '<div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Pencarian tidak ditemukan.
                    </div>
                </div>'; 
                echo '</div>'; 
                }
                ?>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
    <footer class="main-footer">
        <div class="footer-left">
            Copyright &copy; 2024 <div class="bullet"></div> Create By <a href="#">KeiTzy/Imams</a>
        </div>
        <div class="footer-right">

        </div>
    </footer>
    </div>
    </div>

    <script>
    // Fungsi untuk menampilkan pesan konfirmasi
    function tampilkanKonfirmasi() {
        // Menggunakan SweetAlert untuk menampilkan pesan konfirmasi
        swal({
                title: "Warning",
                text: "Anda Harus Login Terlebih Dahulu Agar, Dapat Membaca Dengan Nyaman!!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((akanDiarahkan) => {
                if (akanDiarahkan) {
                    // Jika pengguna menekan tombol "OK", redirect ke halaman detail
                    window.location.href = "login.php";
                }
            });
    }
    </script>
    <!-- my JS -->
    <script src="assets/js/js.js"></script>

    <!-- General JS Scripts -->
    <script src="<?= base_url('assets/modules/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/popper.js') ?>"></script>
    <script src="<?= base_url('assets/modules/tooltip.js') ?>"></script>
    <script src="<?= base_url('assets/modules/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/nicescroll/jquery.nicescroll.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/moment.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/stisla.js') ?>"></script>

    <!-- JS Libraies -->
    <script src="<?= base_url('assets/modules/jquery.sparkline.min.js'); ?>"></script>
    <script src="<?= base_url('assets/modules/chart.min.js'); ?>"></script>
    <script src="<?= base_url('assets/modules/owlcarousel2/dist/owl.carousel.min.js'); ?>"></script>
    <script src="<?= base_url('assets/modules/summernote/summernote-bs4.js'); ?>"></script>
    <script src="<?= base_url('assets/modules/chocolat/dist/js/jquery.chocolat.min.js'); ?>"></script>
    <script src="<?= base_url('assets/modules/sweetalert/sweetalert.min.js'); ?>"></script>
    <script src="<?= base_url('assets/modules/datatables/datatables.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') ?>">
    </script>
    <script src="<?= base_url('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') ?>"></script>
    <script src="<?= base_url('assets/modules/jquery-ui/jquery-ui.min.js') ?>"></script>

    <!-- Page Specific JS File -->
    <script src="<?= base_url('assets/js/page/modules-datatables.js'); ?>"></script>
    <script src="<?= base_url('assets/js/page/index.js'); ?>"></script>
    <script src="<?= base_url('assets/js/page/modules-sweetalert.js'); ?>"></script>

    <!-- Template JS File -->
    <script src="<?= base_url('assets/js/scripts.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom.js') ?>"></script>
</body>

</html>