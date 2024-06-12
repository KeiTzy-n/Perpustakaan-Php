<?php
require_once '../../config/koneksi.php';
include '../_header.php';

// Handle Konfirmasi Peminjaman
if(isset($_GET['pinjamID'])) {
    $pinjamID = $_GET['pinjamID'];

    // Ambil informasi peminjaman berdasarkan pinjamID
    $query = "SELECT * FROM peminjaman WHERE pinjamID = '$pinjamID'";
    $Result = $conn->query($query);

    if($Result) {
        $row = mysqli_fetch_assoc($Result);

        // Periksa apakah status peminjaman sudah dikembalikan
        if($row['statusPeminjaman'] == 'Dikembalikan') {
            echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Status peminjaman sudah dikembalikan!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../peminjaman.php';
                    });
                  </script>";
            exit();
        }

        // Periksa apakah status peminjaman adalah 'Pengajuan' atau 'Dibatalkan'
        if($row['statusPeminjaman'] == 'Pengajuan' || $row['statusPeminjaman'] == 'Dibatalkan' || $row['statusPeminjaman'] == 'Ditolak') {
            echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Status peminjaman tidak dapat dikonfirmasi!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../peminjaman.php'; 
                    });
                  </script>";
            exit();
        }

        $tglDikembalikan = date('d-m-Y');

        $sql = "UPDATE peminjaman SET statusPeminjaman = 'Dikembalikan', tglDikembalikan = '$tglDikembalikan' WHERE pinjamID = '$pinjamID'";
        $result = $conn->query($sql);

        if($result){
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Status peminjaman berhasil diperbarui!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../pengembalian.php?status=success';
                    });
                  </script>";
            exit();
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memperbarui status peminjaman!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../peminjaman.php?status=error'; 
                    });
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal mengambil informasi peminjaman!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function () {
                    window.location.href = '../peminjaman.php?status=error'; 
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
                window.location.href = '../peminjaman.php?status=error'; 
            });
          </script>";
    exit();
}
?>
