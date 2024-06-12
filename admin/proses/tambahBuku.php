<?php
require_once '../../config/koneksi.php';
include '../_header.php';

// Proses pengunggahan gambar dan file PDF jika formulir disubmit
if (isset($_POST['tambah'])) {
    // Mendapatkan informasi tentang file gambar yang diunggah
    $gambar_name = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_size = $_FILES['gambar']['size'];
    $gambar_error = $_FILES['gambar']['error'];

    // Mendapatkan informasi tentang file PDF yang diunggah
    $pdf_name = $_FILES['pdf']['name'];
    $pdf_tmp = $_FILES['pdf']['tmp_name'];
    $pdf_size = $_FILES['pdf']['size'];
    $pdf_error = $_FILES['pdf']['error'];

    // Mendapatkan ekstensi file gambar
    $gambar_ext = strtolower(pathinfo($gambar_name, PATHINFO_EXTENSION));

    // Mendapatkan ekstensi file PDF
    $pdf_ext = strtolower(pathinfo($pdf_name, PATHINFO_EXTENSION));

    // Daftar ekstensi file gambar yang diizinkan
    $allowed_ext = array('jpg', 'jpeg', 'png');

    // Daftar ekstensi file PDF yang diizinkan
    $allowed_pdf_ext = array('pdf');

    // Cek apakah ekstensi file gambar diizinkan
    if (in_array($gambar_ext, $allowed_ext)) {
        // Mengatur nilai PDF dan link jika tidak diisi
        $pdf_new_name = ''; // Default kosong jika PDF tidak dipilih
        $link = isset($_POST['link']) && !empty($_POST['link']) ? htmlspecialchars($_POST['link']) : '';

        // Cek apakah tidak ada error saat mengunggah gambar
        if ($gambar_error === 0) {
            // Tentukan direktori penyimpanan gambar
            $gambar_destination = '../../assets/img/buku/';

            // Buat nama file yang unik untuk gambar
            $gambar_new_name = uniqid('', true) . '.' . $gambar_ext;

            // Pindahkan file gambar yang diunggah ke direktori penyimpanan dengan nama baru yang unik
            if (move_uploaded_file($gambar_tmp, $gambar_destination . $gambar_new_name)) {
                // Jika file PDF dipilih, pindahkan file tersebut dan dapatkan nama baru
                if (!empty($pdf_name)) {
                    // Cek apakah ekstensi file PDF diizinkan
                    if (in_array($pdf_ext, $allowed_pdf_ext)) {
                        // Tentukan direktori penyimpanan PDF
                        $pdf_destination = '../../assets/pdf/';

                        // Buat nama file yang unik untuk PDF
                        $pdf_new_name = uniqid('', true) . '.' . $pdf_ext;

                        // Pindahkan file PDF yang diunggah ke direktori penyimpanan dengan nama baru yang unik
                        if (!move_uploaded_file($pdf_tmp, $pdf_destination . $pdf_new_name)) {
                            echo "<script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Error saat mengunggah file PDF.'
                                    });
                                  </script>";
                            exit();
                        }
                    } else {
                        echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ekstensi file PDF tidak diizinkan.'
                                });
                              </script>";
                        exit();
                    }
                }

                // Memasukkan data kategori baru jika ada
                if (!empty($_POST['kategori_baru'])) {
                    $kategori_baru = $_POST['kategori_baru'];

                    // Periksa apakah kategori baru sudah terdaftar sebelumnya
                    $sql_check_kategori = "SELECT * FROM kategori WHERE namaKategori = '$kategori_baru'";
                    $result_check_kategori = mysqli_query($conn, $sql_check_kategori);
                    if (mysqli_num_rows($result_check_kategori) > 0) {
                        echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Anda Memasukan Kategori yang sudah terdaftar.'
                                });
                              </script>";
                        exit();
                    }

                    // Jika belum terdaftar, masukkan kategori baru
                    $sql_insert_kategori = "INSERT INTO kategori (namaKategori) VALUES ('$kategori_baru')";
                    mysqli_query($conn, $sql_insert_kategori);
                    // Ambil nama kategori yang baru ditambahkan
                    $kategori_nama = implode(',', $_POST['kategori']);
                } else {
                    // Jika kategori sudah dipilih, ambil nama kategori dari dropdown
                    $kategori_nama = implode(',', $_POST['kategori']);
                }

                // Memasukkan data buku ke dalam tabel buku
                $namaBuku = htmlspecialchars($_POST['namaBuku']);
                $penulis = htmlspecialchars($_POST['penulis']);
                $penerbit = htmlspecialchars($_POST['penerbit']);
                $tahunTerbit = htmlspecialchars($_POST['tahunTerbit']);
                $sinopsis = htmlspecialchars($_POST['sinopsis']);
                $rate = $_POST['rate'];
                $coin = $_POST['coin'];
                $total = $_POST['total'];

                function generateRandomNumber()
                {
                    return str_pad(mt_rand(1, 99999999), 8, '1', STR_PAD_LEFT);
                }
                // Membuat bukuID dengan format MYB-nomor
                $bukuID = generateRandomNumber();
                $upload = $username;

                // Query SQL INSERT untuk memasukkan data buku ke dalam tabel buku
                $sql_insert_buku = "INSERT INTO buku (bukuID, namaBuku, penulis, penerbit, tahunTerbit, sinopsis, link, kategori, coin, gambar, bukuPDF, rate, total, masuk, upload) 
                VALUES ('$bukuID', '$namaBuku', '$penulis', '$penerbit', '$tahunTerbit', '$sinopsis', '$link', '$kategori_nama', '$coin', '$gambar_new_name', '$pdf_new_name', '$rate', '$total', '$total', 'upload by. $upload')";

                // Jalankan query INSERT
                if (mysqli_query($conn, $sql_insert_buku)) {
                    echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Buku berhasil ditambahkan',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                window.location.href = '../book.php';
                            });
                          </script>";
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error saat mengunggah gambar.'
                        });
                      </script>";
                exit();
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error saat mengunggah file gambar.'
                    });
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ekstensi file gambar tidak diizinkan.'
                });
              </script>";
        exit();
    }
}
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Buku</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../book.php">Books</a></div>
                <div class="breadcrumb-item">Form Tambah</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Forms</h2>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-10">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gambar">Masukan Gambar Buku</label>
                                            <input type="file" class="form-control" name="gambar" required accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pdf">Masukan Buku PDF</label>
                                        <input type="file" class="form-control" name="pdf" accept="pdf/*">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namaBuku">Nama Buku/Judul</label>
                                    <input type="text" name="namaBuku" class="form-control" id="penulis" required placeholder="Masukkan Penulis">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="penulis">Penulis</label>
                                            <input type="text" name="penulis" class="form-control" id="penulis" required placeholder="Masukkan Penulis">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="penerbit">Penerbit</label>
                                            <input type="text" name="penerbit" class="form-control" id="penerbit" required placeholder="Masukkan Penerbit">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tahun">Tahun Terbit</label>
                                            <input type="number" name="tahunTerbit" class="form-control" id="tahunTerbit" required placeholder="Masukkan Tahun Terbit" min="1800" max="2024">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="rate">Rate</label>
                                        <select name="rate" id="rate" class="form-control">
                                            <option value="Dewasa">Dewasa</option>
                                            <option value="Remaja">Remaja</option>
                                            <option value="Anak">Anak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sinopsis">Sinopsis</label>
                                    <textarea name="sinopsis" id="sinopsis" class="form-control" required placeholder="Masukan Sinopsis"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="link">Link Buku</label>
                                            <input type="text" name="link" class="form-control" id="link" placeholder="Masukan link Buku, Jika tidak ada tidak perlu diisi.">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kategori">Kategori Buku</label>
                                        <select name="kategori[]" id="kategori" class="form-control select2" multiple="">
                                            <?php
                                            // Query untuk mengambil data kategori dari tabel kategori
                                            $sql = "SELECT * FROM kategori";
                                            $result = $conn->query($sql);

                                            // Periksa apakah ada hasil
                                            if ($result->num_rows > 0) {
                                                // Loop melalui hasil dan menampilkan setiap kategori sebagai opsi dropdown
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['namaKategori'] . "'>" . $row['namaKategori'] . "</option>";
                                                }
                                            } else {
                                                echo "<option value='#'>Tidak ada kategori yang tersedia</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="coin">Coin Buku</label>
                                        <input type="number" name="coin" id="coin" placeholder="Masukkan Coin Buku" required class="form-control" oninput="validateInput(this)">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="total">Jumlah Buku</label>
                                        <input type="number" name="total" id="total" placeholder="Masukkan Jumlah Buku" required class="form-control" oninput="validateInput(this)">
                                    </div>
                                </div>

                                <button type="submit" name="tambah" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>
                                    Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function validateInput(input) {
        if (input.value < 0) {
            input.value = 0;
        }
    }
</script>

<?php
include '../_footer.php';
?>