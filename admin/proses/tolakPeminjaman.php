<?php
require_once '../../config/koneksi.php';
include '../_header.php';

if (isset($_GET['pinjamID'])) {
    $pinjamID = $_GET['pinjamID'];

    // Retrieve the current status of the loan request
    $status_query = "SELECT * FROM peminjaman WHERE pinjamID = $pinjamID";
    $status_result = $conn->query($status_query);

    if ($status_result) {
        $row = $status_result->fetch_assoc();
        $statusPeminjaman = $row['statusPeminjaman'];
        $userP = $row['userID'];
        $bukuID = $row['bukuID'];
        $coin = $row['coin'];
        $namaBuku = $row['namaBuku'];
        $jumlah = $row['jumlah'];

        // Check if the status is "Pengajuan"
        if ($statusPeminjaman != 'Pengajuan') {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Status peminjaman bukan Pengajuan, tidak dapat ditolak!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
                    });
                </script>";
            exit();
        }

        $user = $userID;
        $namaPetugas = $username;
        $tglPeminjaman = date('d-m-Y');

        $update_query = "UPDATE peminjaman SET statusPeminjaman = 'Ditolak', tglPeminjaman = '$tglPeminjaman',
                         petugasID = '$userID', namaPetugas = '$namaPetugas'  WHERE pinjamID = $pinjamID";
        $update_result = $conn->query($update_query);

        if ($update_result) {
            // Insert notification
            $notif_query = "INSERT INTO notif (userID, pesan, tgl, status) VALUES ('$userP', 'Mohon Maaf Pengajuan Peminjaman buku $namaBuku, tidak dapat dikonfirmasi', NOW(), 'belumDibaca')";
            $notif_result = $conn->query($notif_query);

            // Update book stock
            $stockBuku = "UPDATE buku SET keluar = keluar - $jumlah, total = total + $jumlah WHERE bukuID = '$bukuID'";
            $resultStock = $conn->query($stockBuku);

            // Update user's coin balance
            $coinUser = "UPDATE user SET coin = coin + $coin WHERE userID = '$userP'";
            $resultCoin = $conn->query($coinUser);

            // Check if all queries were successful
            if ($notif_result && $resultStock && $resultCoin) {
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Peminjaman berhasil ditolak!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {
                            window.location.href = '../peminjaman.php?status=success'; // Redirect setelah menutup SweetAlert
                        });
                    </script>";
                exit();
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memperbarui stok buku atau coin pengguna atau menyisipkan notifikasi!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {
                            window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
                        });
                    </script>";
                exit();
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal menolak peminjaman!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
                    });
                </script>";
            exit();
        }
    } else {
        // Failed to retrieve status
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal mengambil status peminjaman!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function () {
                    window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
                });
            </script>";
        exit();
    }
} else {
    // Parameter pinjamID tidak ditemukan
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Parameter pinjamID tidak ditemukan!',
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
            });
        </script>";
    exit();
}
?>
