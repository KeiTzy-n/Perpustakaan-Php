<?php
// Pastikan bukuID tersedia di permintaan POST
if(isset($_POST['bkm'])) {
    $bukuID = $_POST['bkm'];
    
    // Lakukan koneksi ke database
    require_once 'config/koneksi.php';

    // Siapkan kueri SQL untuk memeriksa apakah buku sudah ada di bookmark
    $check_sql = "SELECT * FROM bookmark WHERE userID = ? AND bukuID = ?";
    $check_stmt = $conn->prepare($check_sql);
    if ($check_stmt) {
        // Ganti nilai userID dengan sesuai nilai sesi
        $userID = $_SESSION['userID']; // Ganti dengan nilai userID yang sesuai
        // Bind parameter ke statement
        $check_stmt->bind_param("ii", $userID, $bukuID);
        // Eksekusi statement
        $check_stmt->execute();
        // Ambil hasil query
        $check_result = $check_stmt->get_result();
        // Periksa apakah buku sudah ada di bookmark
        if ($check_result->num_rows > 0) {
            // Buku sudah ada di bookmark, maka hapus dari bookmark
            $delete_sql = "DELETE FROM bookmark WHERE userID = ? AND bukuID = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            if ($delete_stmt) {
                // Bind parameter ke statement
                $delete_stmt->bind_param("ii", $userID, $bukuID);
                // Eksekusi statement
                if ($delete_stmt->execute()) {
                    // Berhasil menghapus buku dari bookmark
                    echo json_encode(array("message" => "Buku telah dihapus dari bookmark.", "status" => "success"));
                } else {
                    // Gagal menghapus buku dari bookmark
                    echo json_encode(array("message" => "Gagal menghapus buku dari bookmark: " . $delete_stmt->error, "status" => "error"));
                }
                // Tutup statement
                $delete_stmt->close();
            } else {
                // Gagal menyiapkan statement SQL untuk penghapusan bookmark
                echo json_encode(array("message" => "Gagal menyiapkan statement SQL untuk penghapusan bookmark: " . $conn->error, "status" => "error"));
            }
        } else {
            // Buku belum ada di bookmark, tambahkan ke bookmark
            $insert_sql = "INSERT INTO bookmark (userID, bukuID, bookmarkStatus) VALUES (?, ?, 'Public')";
            // Persiapkan statement SQL menggunakan prepared statement untuk mencegah SQL injection
            $insert_stmt = $conn->prepare($insert_sql);
            if ($insert_stmt) {
                // Bind parameter ke statement
                $insert_stmt->bind_param("ii", $userID, $bukuID);
                // Eksekusi statement
                if ($insert_stmt->execute()) {
                    // Berhasil menambahkan buku ke bookmark
                    echo json_encode(array("message" => "Buku telah ditambahkan ke bookmark!", "status" => "berhasil"));
                } else {
                    // Gagal menambahkan buku ke bookmark
                    echo json_encode(array("message" => "Gagal menambahkan buku ke bookmark: " . $insert_stmt->error, "status" => "error"));
                }
                // Tutup statement
                $insert_stmt->close();
            } else {
                // Gagal menyiapkan statement SQL untuk penambahan bookmark
                echo json_encode(array("message" => "Gagal menyiapkan statement SQL untuk penambahan bookmark: " . $conn->error, "status" => "error"));
            }
        }
        // Tutup statement pemeriksaan
        $check_stmt->close();
    } else {
        // Gagal menyiapkan statement SQL untuk pemeriksaan bookmark
        echo json_encode(array("message" => "Gagal menyiapkan statement SQL untuk pemeriksaan bookmark: " . $conn->error, "status" => "error"));
    }

    // Tutup koneksi ke database
    $conn->close();
} else {
    // Jika bukuID tidak tersedia, kirimkan pesan error
    echo json_encode(array("message" => "Gagal menambahkan buku ke bookmark. ID buku tidak ditemukan.", "status" => "error"));
}
?>
