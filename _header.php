<?php require_once 'config/koneksi.php';

if (!isset($_SESSION['userID'])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}

$userID = $_SESSION['userID'];

$sql =  "SELECT * FROM user WHERE userID = '$userID'";
$result2 = $conn->query($sql);
if ($result2) {
    $row = mysqli_fetch_assoc($result2);
    $id = $row['userID'];
    $namaUser = $row['namaLengkap'];
    $gambar = $row['gambar'];
    $username = $row['username'];
    $status = $row['status'];
    $notelp = $row['notelp'];
    $alamat = $row['alamat'];
    $coin = $row['coin'];
    $penjelasan = $row['penjelasan'];

    // Periksa apakah status pengguna nonaktif
    if ($status != 'Aktif') {
        // Hapus sesi
        session_unset();
        session_destroy();

        // Hapus cookie remember_me jika ada
        if (isset($_COOKIE['remember_me'])) {
            // Hapus cookie
            setcookie('remember_me', '', time() - 3600, '/');
        }

        // Alihkan ke halaman login
        echo "<script>alert('Maaf, status anda nonaktif. Silahkan hubungi admin untuk mengaktifkannya'); window.location='login.php';</script>";
        exit;
    }
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
    <link rel="stylesheet" href="<?= base_url('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') ?>">

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
                <a href="home.php" class="navbar-brand sidebar-gone-hide">Mybooks</a>
                <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
                <div class="nav-collapse">
                    <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a href="tentangKami.php" class="nav-link">Tentang Kami</a></li>
                        <li class="nav-item active"><a href="caraPinjam.php" class="nav-link">Tata Cara Peminjaman</a></li>
                    </ul>
                </div>
                <form class="form-inline ml-auto" action="search.php" method="get" onsubmit="return validateSearch()">
                    <ul class="navbar-nav">
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <input id="searchInput" class="form-control" type="search" name="search" placeholder="Pencarian Judul, Penulis, Penerbit, Tahun Terbit" aria-label="Search" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                    </div>
                </form>

                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i class="fas fa-bolt"></i><?php echo !empty($coin) ? $coin : '0'; ?></a>
                    </li>
                    <?php
$sql = "SELECT * FROM notif WHERE userID = '$userID' AND status IN ('belumDibaca', 'Dibaca') ORDER BY notifID DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows into an array

    echo '<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg';
    // Tambahkan kelas beep jika ada notifikasi belum dibaca
    $hasUnread = false;
    foreach ($rows as $row) {
        if ($row['status'] === 'belumDibaca') {
            $hasUnread = true;
            break;
        }
    }
    if ($hasUnread) {
        echo ' beep';
    }
    echo '"><i class="far fa-bell"></i></a>';
    echo '<div class="dropdown-menu dropdown-list dropdown-menu-right">';
    echo '<div class="dropdown-header">Notifications';
    echo '<div class="float-right"><a active onclick="markAllAsRead(event)">Mark All As Read</a></div></div>';
    echo '<div class="dropdown-list-content dropdown-list-icons">';

    // Mengatur kelas 'dropdown-item-unread' berdasarkan status
    foreach ($rows as $row) {
        $statusClass = ($row['status'] === 'belumDibaca') ? 'dropdown-item-unread' : '';
        echo '<a href="#" class="dropdown-item ' . $statusClass . '">';
        echo '<div class="dropdown-item-icon bg-info text-white"><i class="far fa-envelope"></i></div>';
        echo '<div class="dropdown-item-desc">' . $row["pesan"];
        echo '<div class="time text-primary">' . $row["tgl"] . '</div>';
        echo '</div></a>';
    }

    echo '</div></div></li>';
} else {
    echo '<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>';
    echo '<div class="dropdown-menu dropdown-list dropdown-menu-right">';
    echo '<div class="dropdown-header">Notifications';
    echo '<div class="float-right"><a class="active" onclick="markAllAsRead(event)">Mark All As Read</a></div></div>';
    echo '<div class="dropdown-list-content dropdown-list-icons">';
    echo '<div class="dropdown-item alert alert-info">Tidak Ada Notifications</div>';
    echo '</div></div></li>';
}
?>


                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="assets/img/user/<?= $gambar; ?>" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= $namaUser; ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="profil.php" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <!-- Tambahkan SweetAlert CSS -->
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.7/sweetalert2.min.css">

                            <!-- Tambahkan SweetAlert JavaScript -->
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.7/sweetalert2.min.js">
                            </script>

                            <a class="dropdown-item has-icon text-danger" href="#" onclick="confirmLogout()">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="home.php" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a>
                        </li>
                        <li class="nav-item ">
                            <a href="booklist.php" class="nav-link"><i class="fas fa-list"></i><span>Book List</span></a>
                        </li>
                        <li class="nav-item ">
                            <a href="bookmark.php" class="nav-link"><i class="fas fa-book"></i><span>Bookmark</span></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="far fa-clone"></i><span>Peminjaman</span></a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a href="<?= base_url('dipinjam.php') ?>" class="nav-link">Dipinjam</a></li>
                                <li class="nav-item"><a href="riwayat.php" class="nav-link">Riwayat</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <script>
                function confirmLogout() {
                    Swal.fire({
                        title: 'Konfirmasi Logout',
                        text: 'Apakah Anda yakin ingin keluar?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logout(); // Panggil fungsi logout jika pengguna menekan tombol "Ya, Logout"
                        }
                    });
                }

                function logout() {
                    window.location.href = "logout.php"; // Mengarahkan ke halaman logout
                }
            </script>

            <script>
                function validateSearch() {
                    var searchInput = document.getElementById('searchInput').value;
                    if (searchInput.length < 3) {
                        alert('Pencarian harus memiliki minimal 3 karakter.');
                        return false; // Prevent form submission
                    }
                    return true; // Allow form submission
                }
            </script>

            <!-- JavaScript untuk menangani "Mark All As Read" -->
            <script>
                function markAllAsRead(event) {
                    event.preventDefault(); // Mencegah tindakan default (mis. mengikuti tautan)

                    // Kirim permintaan AJAX ke backend untuk menandai semua notifikasi sebagai "Dibaca"
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'mark_all_as_read.php', true); // Ganti 'mark_all_as_read.php' dengan URL backend yang sesuai
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            // Perbarui tampilan notifikasi setelah menandai semua sebagai "Dibaca"
                            // Misalnya, hapus kelas 'beep' dari elemen nav-link
                            document.querySelector('.notification-toggle').classList.remove('beep');

                            // Kemudian perbarui tampilan daftar notifikasi sesuai kebutuhan
                            // Misalnya, muat ulang daftar notifikasi atau tampilkan pesan sukses
                        } else {
                            // Tindakan yang sesuai jika permintaan gagal
                        }
                    };
                    xhr.send(); // Kirim permintaan
                }
            </script>