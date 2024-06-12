<?php 
require_once '../../config/koneksi.php';
include '../_header.php';

$sql =  "SELECT * FROM user2 WHERE userID = '$userID'";
$result2 = $conn->query($sql);
if ($result2) {
    $row = mysqli_fetch_assoc($result2);
    $id = $row['userID'];
    $username = $row['username'];
    $namaUser = $row['namaUser'];
    $gambar = $row['gambar'];
    $status = $row['status'];

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
        echo "<script>alert('Maaf, status anda nonaktif. Silahkan hubungi admin untuk mengaktifkannya'); window.location='../../login2.php';</script>";
        exit;
    }
}

// Handle Konfirmasi Peminjaman
if(isset($_GET['pinjamID'])) {
    $pinjamID = $_GET['pinjamID'];

    // Ambil informasi peminjaman berdasarkan pinjamID
    $query = "SELECT * FROM peminjaman WHERE pinjamID = '$pinjamID'";
    $Result = $conn->query($query);

    if($Result) {
        $row = mysqli_fetch_assoc($Result);

        // Periksa apakah status peminjaman sudah "Dipinjamkan"
        if ($row['statusPeminjaman'] == 'Dipinjamkan'){
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Status peminjaman sudah Dipinjamkan!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
                    });
                </script>";
            exit();
        }

        // Periksa apakah status peminjaman sudah "Dikembalikan"
        if ($row['statusPeminjaman'] == 'Dikembalikan' ) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Status peminjaman sudah Dikembalikan!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
                    });
                </script>";
            exit();
        }

        // Periksa apakah status peminjaman sudah "Ditolak" atau "Dibatalkan"
        if ($row['statusPeminjaman'] == 'Ditolak' || $row['statusPeminjaman'] == 'Dibatalkan' ) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Status peminjaman sudah Ditolak atau Dibatalkan!',
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
        $peminjamID = $row['userID'];
        $jumlah = $row['jumlah'];
        $bukuID = $row['bukuID'];  
        $namabuku = $row['namaBuku'];
        $namaPeminjam = $row['namaUser'];
        $tglPeminjaman = date('d-m-Y'); // Tanggal peminjaman diambil dari tanggal saat ini
        $tglPengembalian = date('d-m-Y', strtotime($tglPeminjaman. ' + 14 days')); 

        // Update status peminjaman menjadi "Dipinjamkan"
        $update_query = "UPDATE peminjaman SET statusPeminjaman = 'Dipinjamkan', tglPeminjaman = '$tglPeminjaman', tglPengembalian = '$tglPengembalian',
                                                petugasID = '$userID', namaPetugas = '$namaPetugas'  WHERE pinjamID = $pinjamID";
        $update_result = $conn->query($update_query);

        // Jika pembaruan berhasil, tambahkan entri notifikasi
        if($update_result) {
            $insert_notif_query = "INSERT INTO notif (petugasID, userID, bukuID, namaBuku, namaUser, namaPetugas, tgl, pesan, status, tglPengembalian, jumlah) 
            VALUES ('$user', '$peminjamID', '$bukuID', '$namabuku', '$namaPeminjam', '$namaPetugas', NOW(), 'Peminjaman buku dengan judul $namabuku dengan jumlah buku sebanyak $jumlah telah dikonfirmasi, Haraf dijaga Buku dengan baik. Batas Waktu Peminjaman sampai $tglPengembalian.', 'belumDibaca', '$tglPengembalian', '$jumlah')";
            $insert_notif_result = $conn->query($insert_notif_query);

            if($insert_notif_result) {
                // Notifikasi berhasil ditambahkan
                // Redirect back to the same page or perform any other action
            
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Status peminjaman berhasil diperbarui!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {
                            window.location.href = '../peminjaman.php?status=success'; // Redirect setelah menutup SweetAlert
                        });
                    </script>";
                exit();
            } else {
                // Gagal menambahkan notifikasi
            
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menambahkan notifikasi!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {
                            window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
                        });
                    </script>";
                exit();
            }
        } else {
            // Gagal mengupdate status peminjaman
        
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memperbarui status peminjaman!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
                    });
                </script>";
            exit();
        }
    } else {
        // Gagal mengambil informasi peminjaman
    
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal mengambil informasi peminjaman!',
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
        text: 'Parameter pinjamID tidak ditemukan!',
        showConfirmButton: false,
        timer: 2000
    }).then(function () {
        window.location.href = '../peminjaman.php?status=error'; // Redirect setelah menutup SweetAlert
    });
</script>";
exit();
}