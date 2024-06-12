<?php include '_header.php'; 
if(isset($_GET['pinjam'])){
    $pinjamID = $_GET['pinjam'];

    // Cek status peminjaman sebelum melakukan pembaruan
    $cekStatus = "SELECT statusPeminjaman FROM peminjaman WHERE pinjamID = '$pinjamID'";
    $result = $conn->query($cekStatus);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $statusPeminjaman = $row['statusPeminjaman'];

        if ($statusPeminjaman == 'Dipinjamkan') {
            // Jika status "Dipinjamkan", tampilkan Sweet Alert
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Maaf Pembatalan Peminjaman tidak diperbolehkan',
                    text: 'Hubungi Admin/Pustakawan'
                }).then(function() {
                    window.location.href = 'dipinjam.php';
                });
            </script>";
            exit();
        } elseif ($statusPeminjaman == 'Dikembalikan') {
            // Jika status "Dikembalikan", tampilkan Sweet Alert
            echo "<script>Swal.fire('Buku sudah Dikembalikan!!', '', 'warning');</script>";
        } else {
            // Perbarui status peminjaman menjadi "Dibatalkan" jika bukan "Dipinjamkan" atau "Dikembalikan"
            $pinjamUbah = "UPDATE peminjaman SET statusPeminjaman = 'Dibatalkan' WHERE pinjamID = '$pinjamID'";
            if ($conn->query($pinjamUbah) === TRUE) {
                // Jika berhasil memperbarui status, tampilkan Sweet Alert
                
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembatalan peminjaman buku berhasil',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        window.location.href = 'dipinjam.php'; 
                    });
                </script>";
                exit();
            } else {
                echo "Error saat memperbarui record: " . $conn->error;
            }
        }
    } else {
        echo "Tidak ada peminjaman dengan ID tersebut.";
    }
}
?>