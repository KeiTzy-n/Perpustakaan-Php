<?php
require_once '../../config/koneksi.php';
include '../_header.php';

// Periksa apakah ada parameter userID yang dikirim melalui URL
if(isset($_GET['id'])) {
    // Tangkap nilai userID dari URL
    $userID = $_GET['id'];

    // Query untuk mengambil data staf berdasarkan userID
    $query = "SELECT * FROM user2 WHERE userID = $userID";
    $result = $conn->query($query);

    // Periksa apakah query berhasil dieksekusi dan data ditemukan
    if($result && $result->num_rows > 0) {
        // Ambil data staf dari hasil query
        $staf = $result->fetch_assoc();

        // Ubah status staf dari 'Aktif' menjadi 'Nonaktif', atau sebaliknya
        $newStatus = ($staf['status'] == 'Aktif') ? 'Nonaktif' : 'Aktif';

        // Query untuk memperbarui status staf
        $updateQuery = "UPDATE user2 SET status = '$newStatus' WHERE userID = $userID";

        // Eksekusi query untuk memperbarui status
        if($conn->query($updateQuery)) {
            // Menampilkan SweetAlert jika berhasil memperbarui status staf
    
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Status staf berhasil diperbarui!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../staff.php?status=success'; // Redirect setelah menutup SweetAlert
                    });
                </script>";
            exit();
        } else {
            // Menampilkan SweetAlert jika gagal memperbarui status staf
    
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memperbarui status staf!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        window.location.href = '../staff.php?status=error'; // Redirect setelah menutup SweetAlert
                    });
                </script>";
            exit();
        }
    } else {
        // Menampilkan SweetAlert jika data staf tidak ditemukan

        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data staf tidak ditemukan!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function () {
                    window.location.href = '../staff.php?status=error'; // Redirect setelah menutup SweetAlert
                });
            </script>";
        exit();
    }
} else {
    // Menampilkan SweetAlert jika parameter userID tidak ditemukan
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Parameter userID tidak ditemukan!',
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                window.location.href = '../staff.php?status=error'; // Redirect setelah menutup SweetAlert
            });
        </script>";
    exit();
}
?>
