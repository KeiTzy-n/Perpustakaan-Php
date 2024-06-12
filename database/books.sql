-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Apr 2024 pada 05.49
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookmark`
--

CREATE TABLE `bookmark` (
  `ID` int(11) NOT NULL,
  `userID` varchar(50) NOT NULL,
  `bukuID` varchar(50) NOT NULL,
  `bookmarkStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookmark`
--

INSERT INTO `bookmark` (`ID`, `userID`, `bukuID`, `bookmarkStatus`) VALUES
(12, '12', '12', ''),
(15, '7', '12', ''),
(16, '7', '20', ''),
(21, '8', '18', ''),
(24, '8', '12', ''),
(25, '9', '12', ''),
(27, '9', '21', ''),
(28, '9', '22', ''),
(29, '9', '20', ''),
(30, '9', '18', ''),
(31, '10', '21', ''),
(34, '11', '24', 'Public'),
(42, '11', '26', 'Public'),
(43, '11', '23', 'Public'),
(44, '12', '22812267', 'Public'),
(45, '29334411', '33615598', 'Public'),
(46, '19929779', '33615598', 'Public'),
(47, '29334411', '69475852', 'Public'),
(59, '29334411', '17483188', 'Public'),
(61, '35442957', '82705936', 'Public');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `bukuID` int(10) NOT NULL,
  `namaBuku` varchar(50) NOT NULL,
  `penulis` varchar(50) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `tahunTerbit` varchar(50) NOT NULL,
  `rate` varchar(10) NOT NULL,
  `sinopsis` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `coin` varchar(255) NOT NULL,
  `masuk` varchar(20) NOT NULL,
  `keluar` varchar(20) NOT NULL,
  `total` varchar(20) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `bukuPDF` varchar(255) NOT NULL,
  `upload` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`bukuID`, `namaBuku`, `penulis`, `penerbit`, `tahunTerbit`, `rate`, `sinopsis`, `gambar`, `link`, `kategori`, `coin`, `masuk`, `keluar`, `total`, `rating`, `bukuPDF`, `upload`) VALUES
(12096616, 'Layla &amp; Majnun', 'Nizami Ganjavi', 'Javanica', '2012', 'Remaja', 'Dalam cerita ini, Qais dan Layla jatuh cinta satu sama lain ketika mereka masih muda. Namun, ayah Layla tidak merestui hubungan asmara mereka berdua. Layla kemudian dinikahkan oleh ayahnya dengan seorang saudagar kaya. Meskipun Layla dinikahkan, ia tidak dapat merasakan kebahagiaan dan tetap merindukan Qais. Setelah hidup bersama suaminya, Layla meninggal dalam keadaan menanggung kerinduan kepada Qais. Qais pun menyusulnya pergi ke alam baka dan dimakamkan di dekat Layla, sebagai tanda cinta yang tak terpisahkan meskipun tragis ', '660b7b70697e07.61527943.jpg', 'https://online.fliphtml5.com/quzle/aeoq/', 'Romance,Fiction', '50', '11', '', '11', '', '660b7b706980c5.51684005.pdf', 'Updated by. Atala'),
(17483188, 'Cantik Itu Luka ', 'Eka Kurniawan', 'Javanica', '2002', 'Remaja', 'Novel ini berfokus pada kisah hidup Dewi Ayu, seorang pelacur cantik di zaman kolonial. Kehidupan dan keturunan Dewi Ayu sangat unik, mulai dari silsilah ayah-ibu hingga anak-anaknya yang kelak banyak membawa pengaruh di Halimunda, wilayah rekaan Eka Kurniawan. Dewi Ayu memiliki empat anak perempuan, dan kecantikan mereka membawa nasib yang berbeda-beda. Anak keempatnya, Cantik, memiliki fisik yang buruk, namun nasibnya berbanding terbalik dengan kecantikannya.', '660b7c8f622a90.74975036.png', 'https://online.fliphtml5.com/quzle/aabc/', 'Fiction,Historical', '50', '10', '-1', '11', '', '660b7c8f622b07.27991022.pdf', 'Updated by. admin'),
(35907516, 'Kim ji-yeong', 'Kim Ji Yeong ', 'Gramedia', '2019', 'Dewasa', 'Kim Ji-yeong adalah anak perempuan yang terlahir dalam keluarga yang mengharapkan anak laki-laki, yang menjadi bulan-bulanan para guru pria di sekolah, dan yang disalahkan ayahnya ketika ia diganggu anak laki-laki dalam perjalanan pulang dari sekolah di malam hari. Kim Ji-yeong adalah mahasiswi yang tidak pernah direkomendasikan dosen untuk pekerjaan magang di perusahaan ternama, karyawan teladan yang tidak pernah mendapat promosi, dan istri yang melepaskan karier serta kebebasannya demi mengasuh anak. Kim Ji-yeong mulai bertingkah aneh. Kim Ji-yeong mulai mengalami depresi. Kim Ji-yeong adalah sosok manusia yang memiliki jati dirinya sendiri. Namun, Kim Ji-yeong adalah bagian dari semua perempuan di dunia. Kim Ji-yeong, Lahir Tahun 1982 adalah novel sensasional dari Korea Selatan yang ramai dibicarakan di seluruh dunia. Kisah kehidupan seorang wanita muda yang terlahir di akhir abad ke-20 ini membangkitkan pertanyaan-pertanyaan tentang praktik misoginis dan penindasan institusional yang relevan bagi kita semua. ', '660b80d34de0b1.69197620.png', 'https://anyflip.com/bfaju/oeal/', 'Romance,Fiction,Historical', '50', '10', '-1', '11', '', '660b80d34de119.56756382.pdf', 'upload by. admin'),
(44944087, 'Daun Yang Jatuh', 'Tere Liye ', 'Gramedia ', '2010', 'Remaja', 'Dia bagai malaikat bagi keluarga kami. Merengkuh aku, adikku, dan Ibu dari kehidupan jalanan yang miskin dan nestapa. Memberikan makan, tempat berteduh, sekolah, dan janji masa depan yang lebih baik. \r\n\r\nDia sungguh bagai malaikat bagi keluarga kami. Memberikan kasih sayang, perhatian, dan teladan tanpa mengharap budi sekali pun. Dan lihatlah, aku membalas itu semua dengan membiarkan mekar perasaan ini. \r\n\r\nIbu benar, tak layak aku mencintai malaikat keluarga kami. Tak pantas. Maafkan aku, Ibu. Perasaan kagum, terpesona, atau entahlah itu muncul tak tertahankan bahkan sejak rambutku masih dikepang dua. \r\n\r\nSekarang, ketika aku tahu dia boleh jadi tidak pernah menganggapku lebih dari seorang adik yang tidak tahu diri, biarlah... Biarlah aku luruh ke bumi seperti sehelai daun... daun yang tidak pernah membenci angin meski harus terenggutkan dari tangkai pohonnya. ', '660b7f5987fb17.97953161.jpg', 'https://online.fliphtml5.com/quzle/wxbv/', 'Fiction', '50', '10', '', '10', '', '660b7f5987fbb3.80023848.pdf', 'upload by. admin'),
(64435329, 'Sebuah Seni Untuk Bersikap Bodo Amat', 'Mark Manson', 'Gramedia ', '2016', 'Remaja', 'Selama beberapa tahun belakangan, Mark Manson—melalui blognya yang sangat populer—telah membantu mengoreksi harapan-harapan delusional kita, baik mengenai diri kita sendiri maupun dunia. Ia kini menuangkan buah pikirnya yang keren itu di dalam buku hebat ini. \r\n \r\n\r\n“Dalam hidup ini, kita hanya punya kepedulian dalam jumlah yang terbatas. Makanya, Anda harus bijaksana dalam menentukan kepedulian Anda.” Manson menciptakan momen perbincangan yang serius dan mendalam, dibungkus dengan cerita-cerita yang menghibur dan “kekinian”, serta humor yang cadas. Buku ini merupakan tamparan di wajah yang menyegarkan untuk kita semua, supaya kita bisa mulai menjalani kehidupan yang lebih memuaskan, dan apa adanya.', '660b7de7270892.79558486.jpg', 'https://anyflip.com/bfaju/hqqx/', 'Fiction,Relationship', '50', '10', '0', '10', '', '660b7de7270923.25614030.pdf', 'upload by. admin'),
(78729296, 'My Public Speaking', 'Hilbram Dunar ', 'Gramedia ', '2015', 'Remaja', 'My Public Speaking ditulis berdasarkan pengalaman Hilbram Dunar selama dua belas tahun menjadi seorang public speaker. Bermula sebagai penyiar di MS Tri FM, karier Hilbram melejit dan membawanya menjadi penyiar di sejumlah radio ternama di Indonesia seperti Hard Rock FM, Cosmopolitan FM, dan Motion FM. Selain di radio, Hilbram pun kemudian juga menjadi host di program yang tayang di SCTV, Global TV, RCTI, Trans TV, TVRI, TV One, O Channel, dan Metro TV. \r\nBuku ini berisi kiat jitu agar Anda memiliki kemampuan public speaking yang tepat. Sehingga apa pun jenis acaranya, seperti mengawal seminar, menjual suatu produk, atau menginformasikan berita, Anda bisa tampil maksimal dengan penggunaan teknik yang benar. Berbagai tips yang dikemukakan Hilbram dapat melatih kreativitas, mengatur grogi, dan mengenali audience dengan tepat. Selain kemampuan berbicara, buku My Public Speaking juga mengajarkan cara bertanya, menjawab, sampai penggunaan bahasa tubuh yang meyakinkan. \r\nSebagai bonus, Hilbram juga berbagi teknik menjadi pembawa acara televisi, penyiar radio dan master of ceremonies. Buku ini juga memiliki bab ekstra tentang Berkarier di Dunia Hiburan. ', '660b7fdf3d45e8.53710531.png', 'https://anyflip.com/bfaju/sdyl/', 'Romance', '50', '10', '2', '8', '', '660b7fdf3d4688.56570216.pdf', 'upload by. admin'),
(82705936, 'Hujan', 'Tere Liye ', 'Gramedia', '2016', 'Remaja', 'Di masa depan, pada tahun 2042, dunia dipenuhi dengan teknologi-teknologi canggih. Peran manusia tergantikan oleh ilmu pengetahuan dan mesin mutakhir pada masa itu. Lail adalah seorang perempuan berusia 13 tahun. Ketika hari pertama sekolah, Lail dihadapkan dengan bencana gunung meletus dan gempa dahsyat yang menghantam kota tempat ia tinggal. Bencana itu meluluhlantakkan kota dan merenggut nyawa kedua orang tua Lail. Beruntungnya, Lail diselamatkan oleh remaja laki-laki berusia 15 tahun, Esok namanya. Sayangnya, kedua kaki ibu Esok harus diamputasi. Lail dan Esok menjadi dekat dan tinggal bersama di pengungsian. Keduanya seperti kakak-adik yang tak terpisahkan. Namun, penutupan tempat pengungsian membuat mereka berpisah. Lail menetap di panti sosial, sedangkan Esok diadopsi oleh salah satu keluarga. Di panti sosial, Lail bertemu dengan Maryam, teman sekamarnya yang ceria dan penuh semangat. Meskipun Lail dan Esok berpisah, mereka memiliki jadwal pertemuan setiap sebulan sekali. Bagi Lail, pertemuan itu sangat berarti.', '660b80780d1219.54079278.jpg', 'https://online.fliphtml5.com/quzle/bzos/', 'Romance,Fiction', '50', '10', '1', '9', '', '660b80780d1524.54531109.pdf', 'upload by. admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `kategoriID` int(11) NOT NULL,
  `namaKategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`kategoriID`, `namaKategori`) VALUES
(2, 'Psycological'),
(3, 'Romance'),
(15427697, 'Horror'),
(15559772, 'Fiction'),
(64300290, 'Reference'),
(71942027, 'Relationship'),
(78596792, 'Historical'),
(83019782, 'Religion');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `komentarID` int(11) NOT NULL,
  `userID` int(255) NOT NULL,
  `namaUser` varchar(255) NOT NULL,
  `bukuID` int(255) NOT NULL,
  `komentar` text NOT NULL,
  `tgl` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`komentarID`, `userID`, `namaUser`, `bukuID`, `komentar`, `tgl`, `gambar`) VALUES
(5, 8, 'Ichika', 12, 'Heheheheh', '2024-02-18 20:12:24', '1708260595.jpg'),
(6, 8, 'Ichika', 12, '', '2024-02-18 21:00:29', '1708260595.jpg'),
(7, 9, 'Imams ', 16, 'hihihi\r\n', '2024-02-18 21:10:47', '65d20ea7a2eab_foto profil wa 11.jpg'),
(8, 8, 'Ichika', 16, 'Heheheh', '2024-02-18 21:11:44', '1708260595.jpg'),
(9, 9, 'Imams ', 22, 'Hooh\r\n', '2024-02-19 10:18:21', '65d20ea7a2eab_foto profil wa 11.jpg'),
(10, 9, 'Imams ', 22, 'sdsd\r\n', '2024-02-19 10:22:35', '65d20ea7a2eab_foto profil wa 11.jpg'),
(11, 10, 'Hooh', 22, 'tddgfdgd\r\n', '2024-02-19 10:23:33', '1708266729.jpg'),
(12, 10, 'Hooh', 22, 'wreqe', '2024-02-19 10:24:34', '1708266729.jpg'),
(13, 10, 'Hooh', 22, 'dafafsfsf', '2024-02-19 10:24:57', '1708266729.jpg'),
(14, 9, 'Imams ', 21, 'huuh', '2024-02-21 09:18:39', '65d20ea7a2eab_foto profil wa 11.jpg'),
(15, 9, 'Imams ', 21, 'Berotak Dungu\r\n', '2024-02-21 09:18:55', '65d20ea7a2eab_foto profil wa 11.jpg'),
(16, 10, 'Hooh', 21, 'haah\r\n', '2024-02-22 10:44:32', '1708266729.jpg'),
(17, 11, 'Udins', 23, 'Hooh', '2024-03-15 15:15:07', '1710488496.jpg'),
(19, 29334411, 'Ichika1234', 22812267, 'halo', '14:02:48 / 03-31', '660116f4b504c_g2.jpg'),
(20, 19929779, 'atala', 33615598, 'oke', '08:34:28 / 04-01', '1711935223.jpg'),
(21, 19929779, 'atala', 69475852, 'kon', '08:43:22 / 04-01', '1711935223.jpg'),
(22, 29334411, 'Ichika1234', 64435329, 'halo', '10:55:30 / 04-02', '660116f4b504c_g2.jpg'),
(23, 29334411, 'Ichika1234', 82705936, 'Buku nya bagus', '16:03:55 / 04-05', '660116f4b504c_g2.jpg'),
(24, 29334411, 'Ichika1234', 64435329, 'hooh', '16:48:05 / 04-06', '6610eb5618c67.jpg'),
(25, 29334411, 'Ichika1234', 46720706, 'haloo', '19:53:17 / 04-10', '6610eb5618c67.jpg'),
(26, 29334411, 'Ichika1234', 46720706, 'haloo lagi', '19:53:29 / 04-10', '6610eb5618c67.jpg'),
(27, 29334411, 'Ichika1234', 64435329, 'haloo ahloo', '19:56:25 / 04-10', '6610eb5618c67.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notif`
--

CREATE TABLE `notif` (
  `notifID` int(11) NOT NULL,
  `petugasID` int(255) NOT NULL,
  `userID` varchar(255) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `tgl` varchar(255) NOT NULL,
  `bukuID` int(255) NOT NULL,
  `namaBuku` varchar(255) NOT NULL,
  `namaUser` varchar(255) NOT NULL,
  `namaPetugas` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tglPengembalian` varchar(255) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `hakAkses` varchar(255) NOT NULL,
  `filePeminjam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notif`
--

INSERT INTO `notif` (`notifID`, `petugasID`, `userID`, `pesan`, `tgl`, `bukuID`, `namaBuku`, `namaUser`, `namaPetugas`, `status`, `tglPengembalian`, `jumlah`, `hakAkses`, `filePeminjam`) VALUES
(66, 8, '29334411', 'Pengembalian buku Cantik Itu Luka  dengan jumlah 1, berhasil dikonfirmasi. Terima Kasih Telah Menggunakan Jasa Kami, Semoga buku ini memberikan inspirasi dan pengetahuan yang berharga bagi Anda dan jangan ragu untuk kembali menggunakan layanan kami di mas', '05-04-2024', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(67, 8, '29334411', 'Peminjaman buku dengan judul Kim ji-yeong dengan jumlah buku sebanyak 1 telah dikonfirmasi, Haraf dijaga Buku dengan baik. Batas Waktu Peminjaman sampai 19-04-2024.', '2024-04-05 20:43:40', 35907516, 'Kim ji-yeong', 'Ichika1234', 0, 'Dibaca', '19-04-2024', 1, '', ''),
(68, 8, '29334411', 'Pengembalian buku Kim ji-yeong dengan jumlah 1, berhasil dikonfirmasi. Terima Kasih Telah Menggunakan Jasa Kami, Semoga buku ini memberikan inspirasi dan pengetahuan yang berharga bagi Anda dan jangan ragu untuk kembali menggunakan layanan kami di masa de', '05-04-2024', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(69, 8, '29334411', 'Peminjaman buku dengan judul Hujan dengan jumlah buku sebanyak 1 telah dikonfirmasi, Haraf dijaga Buku dengan baik. Batas Waktu Peminjaman sampai 19-04-2024.', '2024-04-05 20:45:46', 82705936, 'Hujan', 'Ichika1234', 0, 'Dibaca', '19-04-2024', 1, '', ''),
(70, 8, '29334411', 'Pengembalian buku Hujan dengan jumlah 1, berhasil dikonfirmasi. Terima Kasih Telah Menggunakan Jasa Kami, Semoga buku ini memberikan inspirasi dan pengetahuan yang berharga bagi Anda dan jangan ragu untuk kembali menggunakan layanan kami di masa depan.😊', '05-04-2024', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(71, 8, '29334411', 'Peminjaman buku dengan judul Berani Bahagia dengan jumlah buku sebanyak 2 telah dikonfirmasi, Haraf dijaga Buku dengan baik. Batas Waktu Peminjaman sampai 19-04-2024.', '2024-04-05 20:47:39', 83123251, 'Berani Bahagia', 'Ichika1234', 0, 'Dibaca', '19-04-2024', 2, '', ''),
(72, 8, '29334411', 'Pengembalian buku Berani Bahagia dengan jumlah 2, berhasil dikonfirmasi. Terima Kasih Telah Menggunakan Jasa Kami, Semoga buku ini memberikan inspirasi dan pengetahuan yang berharga bagi Anda dan jangan ragu untuk kembali menggunakan layanan kami di masa ', '05-04-2024', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(73, 8, '29334411', 'Pengembalian buku asdsa dengan jumlah 1, berhasil dikonfirmasi. Terima Kasih Telah Menggunakan Jasa Kami, Semoga buku ini memberikan inspirasi dan pengetahuan yang berharga bagi Anda dan jangan ragu untuk kembali menggunakan layanan kami di masa depan.😊', '05-04-2024', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(74, 8, '29334411', 'Peminjaman buku dengan judul Sebuah Seni Untuk Bersikap Bodo Amat dengan jumlah buku sebanyak 1 telah dikonfirmasi, Haraf dijaga Buku dengan baik. Batas Waktu Peminjaman sampai 19-04-2024.', '2024-04-05 20:49:24', 64435329, 'Sebuah Seni Untuk Bersikap Bodo Amat', 'Ichika1234', 0, 'Dibaca', '19-04-2024', 1, '', ''),
(75, 8, '29334411', 'Pengembalian buku Sebuah Seni Untuk Bersikap Bodo Amat dengan jumlah 1, berhasil dikonfirmasi. Terima Kasih Telah Menggunakan Jasa Kami, Semoga buku ini memberikan inspirasi dan pengetahuan yang berharga bagi Anda dan jangan ragu untuk kembali menggunakan', '05-04-2024', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(76, 0, '29334411', 'haloo', '2024-04-05 21:18:38', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(77, 0, '29334411', 'Hloo', '2024-04-05 21:20:37', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(78, 0, '29334411', 'haloo', '2024-04-05 21:21:19', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(79, 0, '29334411', 'Haraf Segera mFFGengembalikan Buku My Public Speaking. ', '2024-04-06 13:28:51', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(80, 0, '29334411', 'Mohon Maaf Pengajuan Peminjaman buku My Public Speaking, tidak dapat dikonfirmasi', '2024-04-06 14:00:12', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(81, 0, '29334411', 'Mohon Maaf Pengajuan Peminjaman buku My Public Speaking, tidak dapat dikonfirmasi', '2024-04-06 14:01:01', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(82, 0, '29334411', 'Ada Peminjaman buku baru atas nama Ichika1234, Dengan Judul buku My Public Speaking, Mohon melakukan Konfirmasi untuk peminjaman.', '06-04-2024', 78729296, 'My Public Speaking', 'Ichika1234', 0, 'Dibaca', '', 0, 'Admin,Pustakawan', '6610eb5618c67.jpg'),
(83, 56252571, '29334411', 'Peminjaman buku dengan judul My Public Speaking dengan jumlah buku sebanyak 1 telah dikonfirmasi, Haraf dijaga Buku dengan baik. Batas Waktu Peminjaman sampai 20-04-2024.', '2024-04-06 14:08:54', 78729296, 'My Public Speaking', 'Ichika1234', 0, 'Dibaca', '20-04-2024', 1, '', ''),
(84, 0, '29334411', 'Mohon Maaf Pengajuan Peminjaman buku My Public Speaking, tidak dapat dikonfirmasi', '2024-04-06 14:26:37', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(85, 0, '29334411', 'Mohon Maaf Pengajuan Peminjaman buku Hujan, tidak dapat dikonfirmasi', '2024-04-06 14:29:21', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(86, 0, '29334411', 'Mohon Maaf Pengajuan Peminjaman buku Hujan, tidak dapat dikonfirmasi', '2024-04-06 14:29:26', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(87, 0, '29334411', 'Selamat Coin Anda Telah Bertambah Sebanyak 10!', '06-04-2024', 0, '', '', 0, '', '', 0, '', ''),
(88, 0, '29334411', 'Selamat Coin Anda Telah Bertambah Sebanyak 3!', '06-04-2024', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(89, 0, '35442957', 'Selamat Coin Anda Telah Bertambah Sebanyak 100!', '06-04-2024', 0, '', '', 0, 'belumDibaca', '', 0, '', ''),
(90, 8, '35442957', 'Peminjaman buku dengan judul Hujan dengan jumlah buku sebanyak 1 telah dikonfirmasi, Haraf dijaga Buku dengan baik. Batas Waktu Peminjaman sampai 20-04-2024.', '2024-04-06 16:24:39', 82705936, 'Hujan', 'hooh', 0, 'belumDibaca', '20-04-2024', 1, '', ''),
(91, 8, '35442957', 'Pengembalian buku Hujan dengan jumlah 1, berhasil dikonfirmasi. Terima Kasih Telah Menggunakan Jasa Kami, Semoga buku ini memberikan inspirasi dan pengetahuan yang berharga bagi Anda dan jangan ragu untuk kembali menggunakan layanan kami di masa depan.😊', '06-04-2024', 0, '', '', 0, 'belumDibaca', '', 0, '', ''),
(92, 0, '29334411', 'Silahkan segera kembalikan buku karena batas waktu peminjaman buku telah habis, atau anda dapat memperpanjang waktu.', '2024-04-10 20:01:45', 0, '', '', 0, 'belumDibaca', '', 0, '', ''),
(93, 0, '37187801', 'Selamat Coin Anda Telah Bertambah Sebanyak 100!', '15-04-2024', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(94, 8, '37187801', 'Peminjaman buku dengan judul dsasda dengan jumlah buku sebanyak 1 telah dikonfirmasi, Haraf dijaga Buku dengan baik. Batas Waktu Peminjaman sampai 29-04-2024.', '2024-04-15 10:20:24', 94512886, 'dsasda', 'Desta Permana', 0, 'Dibaca', '29-04-2024', 1, '', ''),
(95, 0, '37187801', 'Haraf Segera mengembalikan Buku dsasda. ', '2024-04-15 10:21:00', 0, '', '', 0, 'Dibaca', '', 0, '', ''),
(96, 8, '37187801', 'Pengembalian buku dsasda dengan jumlah 1, berhasil dikonfirmasi. Terima Kasih Telah Menggunakan Jasa Kami, Semoga buku ini memberikan inspirasi dan pengetahuan yang berharga bagi Anda dan jangan ragu untuk kembali menggunakan layanan kami di masa depan.😊', '15-04-2024', 0, '', '', 0, 'Dibaca', '', 0, '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notif2`
--

CREATE TABLE `notif2` (
  `notifID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `pesan` longtext NOT NULL,
  `tgl` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `hakAkses` varchar(255) NOT NULL,
  `filePeminjam` varchar(255) NOT NULL,
  `bukuID` int(11) NOT NULL,
  `namaBuku` varchar(255) NOT NULL,
  `namaUser` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notif2`
--

INSERT INTO `notif2` (`notifID`, `userID`, `pesan`, `tgl`, `status`, `hakAkses`, `filePeminjam`, `bukuID`, `namaBuku`, `namaUser`) VALUES
(1, 29334411, 'Ada Peminjaman buku baru atas nama Ichika1234, Dengan Judul buku Hujan, Mohon melakukan Konfirmasi untuk peminjaman.', '06-04-2024', 'belumDibaca', 'Admin,Pustakawan', '6610eb5618c67.jpg', 82705936, 'Hujan', 'Ichika1234'),
(2, 29334411, 'Ada Peminjaman buku baru atas nama Ichika1234, Dengan Judul buku My Public Speaking, Mohon melakukan Konfirmasi untuk peminjaman.', '06-04-2024', 'belumDibaca', 'Admin,Pustakawan', '6610eb5618c67.jpg', 78729296, 'My Public Speaking', 'Ichika1234'),
(3, 35442957, 'Ada Peminjaman buku baru atas nama hooh, Dengan Judul buku Hujan, Mohon melakukan Konfirmasi untuk peminjaman.', '06-04-2024', 'belumDibaca', 'Admin,Pustakawan', '66110edad814f_g1 (2).jpg', 82705936, 'Hujan', 'hooh'),
(4, 37187801, 'Ada Peminjaman buku baru atas nama Desta Permana, Dengan Judul buku dsasda, Mohon melakukan Konfirmasi untuk peminjaman.', '15-04-2024', 'belumDibaca', 'Admin,Pustakawan', '661c991139d8e_books-1673578_1280.jpg', 94512886, 'dsasda', 'Desta Permana');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `pinjamID` int(11) NOT NULL,
  `userID` int(255) NOT NULL,
  `bukuID` int(255) NOT NULL,
  `coin` varchar(255) NOT NULL,
  `potonganCoin` varchar(255) NOT NULL,
  `tglPeminjaman` varchar(255) NOT NULL,
  `tglPengembalian` varchar(255) NOT NULL,
  `statusPeminjaman` varchar(255) NOT NULL,
  `namaUser` varchar(255) NOT NULL,
  `namaBuku` varchar(255) NOT NULL,
  `petugasID` int(255) NOT NULL,
  `namaPetugas` varchar(255) NOT NULL,
  `penjelasan` varchar(255) NOT NULL,
  `statusBuku` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `notelp` varchar(255) NOT NULL,
  `tglDikembalikan` varchar(255) NOT NULL,
  `gambarBuku` varchar(255) NOT NULL,
  `gambarUser` varchar(255) NOT NULL,
  `bukuDikembalikan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `ratingID` int(11) NOT NULL,
  `bukuID` varchar(255) NOT NULL,
  `userID` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `tglRating` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`ratingID`, `bukuID`, `userID`, `rating`, `tglRating`) VALUES
(1, '23', '11', '4', '15-03-2024'),
(2, '24', '11', '5', '19-03-2024'),
(3, '25', '11', '3', '20-03-2024'),
(4, '24', '12', '4', '21-03-2024'),
(5, '22812267', '29334411', '5', '31-03-2024'),
(6, '22812267', '29334411', '5', '31-03-2024'),
(7, '22812267', '29334411', '5', '31-03-2024'),
(8, '22812267', '29334411', '5', '31-03-2024'),
(9, '33615598', '29334411', '4', '01-04-2024'),
(10, '33615598', '29334411', '4', '01-04-2024'),
(11, '33615598', '85284250', '3', '01-04-2024'),
(12, '33615598', '85284250', '3', '01-04-2024'),
(13, '33615598', '19929779', '1', '01-04-2024'),
(14, '33615598', '19929779', '1', '01-04-2024'),
(15, '69475852', '19929779', '5', '01-04-2024'),
(16, '69475852', '19929779', '5', '01-04-2024'),
(17, '69475852', '29334411', '3', '01-04-2024'),
(18, '69475852', '29334411', '3', '01-04-2024'),
(19, '82705936', '35442957', '2', '06-04-2024'),
(20, '82705936', '35442957', '2', '06-04-2024'),
(21, '64435329', '29334411', '5', '06-04-2024'),
(22, '64435329', '29334411', '5', '06-04-2024'),
(23, '82705936', '37187801', '4', '15-04-2024'),
(24, '82705936', '37187801', '4', '15-04-2024'),
(25, '78729296', '37187801', '5', '15-04-2024'),
(26, '78729296', '37187801', '5', '15-04-2024'),
(27, '64435329', '37187801', '4', '15-04-2024'),
(28, '64435329', '37187801', '4', '15-04-2024');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `namaLengkap` varchar(50) NOT NULL,
  `notelp` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `penjelasan` text NOT NULL,
  `coin` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `tgl_daftar` varchar(255) NOT NULL,
  `hakAkses` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userID`, `username`, `namaLengkap`, `notelp`, `alamat`, `password`, `penjelasan`, `coin`, `status`, `gambar`, `tgl_daftar`, `hakAkses`) VALUES
(19929779, 'atala', 'atala', '088342934234', '', '$2y$10$t9RsEy9eBIc9RnW1Lbt0yeiUDJ/vmbvLNkcKYwAcw9MP8oko1J8aW', '', '929', 'Aktif', '1711935223.jpg', '01-04-2024', ''),
(37187801, 'Desta', 'Desta Permana', '08947346273629', 'Cimahi sdadskadj', '$2y$10$nlMdJuLHLDAq.kiDqy4XN.jnqUHoAlpE759avy6FYn0dDxQhA8Kly', '', '110', 'Aktif', '661c991139d8e_books-1673578_1280.jpg', '15-04-2024', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user2`
--

CREATE TABLE `user2` (
  `gambar` varchar(20) NOT NULL,
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `namaUser` varchar(255) NOT NULL,
  `notelp` varchar(20) NOT NULL,
  `hakAkses` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tgl_daftar` varchar(255) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user2`
--

INSERT INTO `user2` (`gambar`, `userID`, `username`, `namaUser`, `notelp`, `hakAkses`, `status`, `password`, `tgl_daftar`, `alamat`) VALUES
('66168ceea68d4.jpg', 8, 'admin', 'Admin Mybooks', '0867563536282', 'Admin', 'Aktif', '$2y$10$EQcPG.KL68OdjcSqYTpcOOraRfM3pQC9kE/VYtc.r.DifQ9/A07Ce', '', 'Kebon Kopi'),
('1713152905.png', 16666337, 'adminnnnnnnnnn', 'sdsdfsdfsd', '0894738233871', 'Pustakawan', 'Aktif', '$2y$10$Cl.G81isNNwAEMBZzB0RcerRX1d3m2sbgzgtG9ZPqYGBRs.rsLFEK', '15-04-2024', 'sdfsdf'),
('1711407953.jpg', 37833558, 'Ichika', 'Ichika', '0894738233871', 'Pustakawan', 'Nonaktif', '$2y$10$hN6JpGWbBTpp1GPOO6wzu.EMuRVPm6fDKWGsZgRPyZHU7edtfzYRW', '26-03-2024', 'Gunung Bohong'),
('1712325358.png', 56252571, 'Atala', 'Atala Maulana Aldebaran', '082732715231', 'Admin', 'Aktif', '$2y$10$fqCYF7MEkkbLBs1IXORVoO9X09VQIRwQZvN4LUlP6fjUVu2rZ34mS', '05-04-2024', 'Padasuka, Didepan Kuburan, Deidekat teteh Gorengan.'),
('661023d297d33.png', 83140855, 'Desti1234', 'Desti Lenathea ', '0867563536282', 'Pustakawan', 'Aktif', '$2y$10$amhUjW27Iw4TNB9fvzc/5.R7r8ZXTsTQ9bb1ORoVJu/lqeX/sT.Fy', '05-04-2024', 'Rumah Nya deket ESkobar, paling deket lagih');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`bukuID`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategoriID`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`komentarID`);

--
-- Indeks untuk tabel `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`notifID`);

--
-- Indeks untuk tabel `notif2`
--
ALTER TABLE `notif2`
  ADD PRIMARY KEY (`notifID`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`pinjamID`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ratingID`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indeks untuk tabel `user2`
--
ALTER TABLE `user2`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `bukuID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94512887;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `komentarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `notif`
--
ALTER TABLE `notif`
  MODIFY `notifID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT untuk tabel `notif2`
--
ALTER TABLE `notif2`
  MODIFY `notifID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `pinjamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92977507;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `ratingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
