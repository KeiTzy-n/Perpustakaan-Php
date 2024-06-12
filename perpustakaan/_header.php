<?php
if (!isset($_SESSION['userID'])) {
    echo "<script>window.location='../login2.php';</script>";
    exit;
}

$userID = $_SESSION['userID'];

$sql =  "SELECT * FROM user2 WHERE userID = '$userID'";
$result2 = $conn->query($sql);
if ($result2) {
    $row = mysqli_fetch_assoc($result2);
    $id = $row['userID'];
    $username = $row['username'];
    $namaUser = $row['namaUser'];
    $gambar = $row['gambar'];
    $status = $row['status'];
    $hakAkses = $row['hakAkses'];

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
        echo "<script>alert('Maaf, status anda nonaktif. Silahkan hubungi admin untuk mengaktifkannya'); window.location='../login2.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>MyBooks || Admin</title>
    <link rel="icon" href="<?= base_url('assets/img/bahan/logo.jpg'); ?>" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/fontawesome/css/all.min.css') ?>">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url('assets/modules/chocolat/dist/css/chocolat.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/jqvmap/dist/jqvmap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/summernote/summernote-bs4.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/select2/dist/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/jquery-selectric/selectric.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/datatables/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') ?>">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <?php
                    $sql = "SELECT * FROM notif2 WHERE hakAkses LIKE '%$hakAkses%' AND status IN ('belumDibaca', 'Dibaca') ORDER BY notifID DESC";
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
                            <img alt="image" src="../assets/img/user/<?= $gambar ?>" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= $username ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= base_url('perpustakaan/profil.php') ?>" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('perpustakaan/logout.php'); ?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="<?= base_url('perpustakaan/index.php') ?>">MyBooks</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li class="dropdown ">
                            <a href="<?= base_url('perpustakaan/index.php') ?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                        </li>
                        <li class="menu-header">Starter</li>
                        <li>
                            <a class="nav-link" href="<?= base_url('perpustakaan/book.php') ?>"><i class="fas fa-book"></i>
                                <span>Books</span></a>
                        </li>
                        <li>
                            <a class="nav-link" href="<?= base_url('perpustakaan/kategori.php') ?>"><i class="fas fa-list"></i>
                                <span>Category</span></a>
                        </li>
                        <li>
                            <a class="nav-link" href="<?= base_url('perpustakaan/reader.php') ?>"><i class="fas fa-users"></i>
                                <span>Reader</span></a>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i>
                                <span>Peminjaman</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="<?= base_url('perpustakaan/peminjaman.php') ?>">
                                        <span>Peminjaman</span></a>
                                </li>
                                <li>
                                    <a class="nav-link" href="<?= base_url('perpustakaan/pengembalian.php') ?>">
                                        <span>Pengembalian</span></a>
                                </li>
                                <li>
                                    <a class="nav-link" href="<?= base_url('perpustakaan/success.php') ?>">
                                        <span>Peminjaman Berhasil</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </aside>
            </div>