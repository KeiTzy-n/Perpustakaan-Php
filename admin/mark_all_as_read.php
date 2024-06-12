<?php
require_once '../config/koneksi.php'; // Sesuaikan dengan lokasi file koneksi.php
include '_header.php';


// Perbarui semua notifikasi yang belum dibaca menjadi "Dibaca"
$updateSql = "UPDATE notif SET status = 'Dibaca' WHERE hakAkses LIKE '%$hakAkses%' AND status = 'belumDibaca'";
if ($conn->query($updateSql) === TRUE) {
    // Kirim respon berhasil jika pembaruan berhasil
    http_response_code(200); // OK
    echo json_encode(array("message" => "Semua notifikasi telah ditandai sebagai dibaca."));
} else {
    // Kirim respon gagal jika terjadi kesalahan
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Gagal menandai notifikasi sebagai dibaca: " . $conn->error));
}

$conn->close(); // Tutup koneksi database
?>
