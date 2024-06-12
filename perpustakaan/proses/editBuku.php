<?php
require_once '../../config/koneksi.php';
include '../_header.php';

// Periksa apakah parameter bukuID telah diberikan dalam URL
if (!isset($_GET['bukuID'])) {
    echo "<script>window.location='book.php';</script>";
    exit();
}

$bukuID = $_GET['bukuID'];

// Query untuk mengambil informasi buku berdasarkan bukuID
$sql = "SELECT * FROM buku WHERE bukuID = '$bukuID'";
$result = $conn->query($sql);

// Periksa apakah buku dengan bukuID tertentu ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Redirect jika buku tidak ditemukan
    echo "<script>window.location='book.php';</script>";
    exit();
}

// Proses pengeditan buku jika formulir disubmit
if (isset($_POST['edit'])) {
    // Mendapatkan informasi tentang file gambar yang diunggah (jika ada)
    if ($_FILES['gambar']['size'] > 0) {
        // Hapus gambar lama sebelum mengunggah yang baru
        unlink('../../assets/img/buku/' . $row['gambar']);
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_ext = strtolower(pathinfo($gambar_name, PATHINFO_EXTENSION));

        // Tentukan direktori penyimpanan gambar
        $gambar_destination = '../../assets/img/buku/';

        // Buat nama file yang unik untuk gambar baru
        $gambar_new_name = uniqid('', true) . '.' . $gambar_ext;

        // Pindahkan file gambar yang diunggah ke direktori penyimpanan dengan nama baru yang unik
        if (move_uploaded_file($gambar_tmp, $gambar_destination . $gambar_new_name)) {
            // Hapus gambar lama
            unlink($gambar_destination . $row['gambar']);

            // Update data buku termasuk gambar baru
            $sql_update_buku = "UPDATE buku SET gambar = '$gambar_new_name' WHERE bukuID = '$bukuID'";
            mysqli_query($conn, $sql_update_buku);
        }
    }

    // Mendapatkan informasi tentang file PDF yang diunggah (jika ada)
    if ($_FILES['pdf']['size'] > 0) {
        // Hapus PDF lama sebelum mengunggah yang baru
        unlink('../../assets/pdf/' . $row['bukuPDF']);
        $pdf_name = $_FILES['pdf']['name'];
        $pdf_tmp = $_FILES['pdf']['tmp_name'];
        $pdf_ext = strtolower(pathinfo($pdf_name, PATHINFO_EXTENSION));

        // Tentukan direktori penyimpanan PDF
        $pdf_destination = '../../assets/pdf/';

        // Buat nama file yang unik untuk PDF baru
        $pdf_new_name = uniqid('', true) . '.' . $pdf_ext;

        // Pindahkan file PDF yang diunggah ke direktori penyimpanan dengan nama baru yang unik
        if (move_uploaded_file($pdf_tmp, $pdf_destination . $pdf_new_name)) {
            // Hapus PDF lama
            unlink($pdf_destination . $row['bukuPDF']);

            // Update data buku termasuk PDF baru
            $sql_update_buku = "UPDATE buku SET bukuPDF = '$pdf_new_name' WHERE bukuID = '$bukuID'";
            mysqli_query($conn, $sql_update_buku);
        }
    }

    // Mengambil nilai kategori yang dipilih dari formulir
    $kategori = implode(',', $_POST['kategori']);

    // Query SQL UPDATE untuk memperbarui informasi kategori buku
    $sql_update_kategori = "UPDATE buku SET kategori = '$kategori' WHERE bukuID = '$bukuID'";

    // Jalankan query UPDATE kategori
    if (mysqli_query($conn, $sql_update_kategori)) {
        // Proses berhasil, lakukan sesuatu jika diperlukan
    } else {
        echo "Error: " . mysqli_error($conn);
    }


    // Memperbarui informasi buku yang lain (tidak termasuk gambar dan PDF)
    $namaBuku = htmlspecialchars($_POST['namaBuku']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $penerbit = htmlspecialchars($_POST['penerbit']);
    $tahunTerbit = htmlspecialchars($_POST['tahunTerbit']);
    $sinopsis = htmlspecialchars($_POST['sinopsis']);
    $link = htmlspecialchars($_POST['link']);
    $rate = $_POST['rate'];
    $coin = $_POST['coin'];
    $upload = $username;

    // Query SQL UPDATE untuk memperbarui informasi buku
    $sql_update_buku = "UPDATE buku SET namaBuku = '$namaBuku', kategori = '$kategori', penulis = '$penulis', penerbit = '$penerbit', tahunTerbit = '$tahunTerbit', sinopsis = '$sinopsis', link = '$link', rate = '$rate', coin = '$coin', upload = 'Updated by. $upload' WHERE bukuID = '$bukuID'";

    // Jalankan query UPDATE
    if (mysqli_query($conn, $sql_update_buku)) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Buku berhasil diperbarui',
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
}
?>


<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Buku</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="../index.php">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="../book.php">Books</a></div>
                <div class="breadcrumb-item">Edit</div>
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
                                            <label for="gambar">Gambar Buku</label>
                                            <input type="file" class="form-control" name="gambar" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pdf">Masukan Buku PDF</label>
                                        <input type="file" class="form-control" name="pdf" requires accept=".pdf">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namaBuku">Nama Buku/Judul</label>
                                    <input type="text" name="namaBuku" class="form-control" required
                                        value="<?php echo $row['namaBuku']; ?>">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="penulis">Penulis</label>
                                            <input type="text" name="penulis" class="form-control" required
                                                value="<?php echo $row['penulis']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="penerbit">Penerbit</label>
                                            <input type="text" name="penerbit" class="form-control" required
                                                value="<?php echo $row['penerbit']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tahunTerbit">Tahun Terbit</label>
                                            <input type="number" name="tahunTerbit" class="form-control" required
                                                value="<?php echo $row['tahunTerbit']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rate">Rate</label>
                                            <select name="rate" class="form-control">
                                                <option value="Dewasa"
                                                    <?php if ($row['rate'] == 'Dewasa') echo 'selected'; ?>>
                                                    Dewasa</option>
                                                <option value="Remaja"
                                                    <?php if ($row['rate'] == 'Remaja') echo 'selected'; ?>>
                                                    Remaja</option>
                                                <option value="Anak"
                                                    <?php if ($row['rate'] == 'Anak') echo 'selected'; ?>>Anak
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sinopsis">Sinopsis</label>
                                    <textarea name="sinopsis" class="form-control"
                                        required><?php echo $row['sinopsis']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="link">Link Buku</label>
                                    <input type="text" name="link" class="form-control" required
                                        value="<?php echo $row['link']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori Buku</label>
                                    <select name="kategori[]" id="kategori" class="form-control select2" multiple="">
                                        <?php
                                        // Query untuk mengambil data kategori dari tabel kategori
                                        $sql_kategori = "SELECT * FROM kategori";
                                        $result_kategori = $conn->query($sql_kategori);

                                        // Periksa apakah ada hasil
                                        if ($result_kategori->num_rows > 0) {
                                            // Loop melalui hasil dan menampilkan setiap kategori sebagai opsi dropdown
                                            while ($row_kategori = $result_kategori->fetch_assoc()) {
                                                $selected = '';
                                                // Periksa apakah kategori saat ini dipilih
                                                if (in_array($row_kategori['namaKategori'], explode(',', $row['kategori']))) {
                                                    $selected = 'selected';
                                                }
                                                echo "<option value='" . $row_kategori['namaKategori'] . "' $selected>" . $row_kategori['namaKategori'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value='#'>Tidak ada kategori yang tersedia</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="coin">Coin Buku</label>
                                    <input type="number" name="coin" class="form-control" oninput="validateInput(this)"
                                        required value="<?php echo $row['coin']; ?>">
                                </div>
                                <button type="submit" name="edit" class="btn btn-primary"><i class="fa fa-check"
                                        aria-hidden="true"></i> Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Fungsi untuk memvalidasi input agar tidak kurang dari 0
function validateInput(input) {
    if (input.value < 0) {
        input.value = 0; // Set nilai input menjadi 0 jika kurang dari 0
    }
}
</script>

<?php
include '../_footer.php';
?>