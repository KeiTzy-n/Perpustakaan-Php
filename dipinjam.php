<?php include '_header.php'; 

$peminjamann = "SELECT * FROM peminjaman WHERE (statusPeminjaman LIKE '%Pengajuan%' OR statusPeminjaman LIKE '%Dipinjamkan%') AND userID = '$id'";
$result2 = $conn->query($peminjamann);

?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Top Navigation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="home.php">Home</a></div>
                <div class="breadcrumb-item active"><a href="dipinjam.php">Peminjaman</a></div>
                <div class="breadcrumb-item ">Peminjaman</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Peminjaman</h2>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-cog"></i></th>
                                            <th>Detail</th>
                                            <th>Peminjaman</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $nomor = 1; // Inisialisasi nomor baris
                                        while ($peminjaman = $result2->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= $nomor++; ?></td>
                                            <td>
                                                <span class="text-dark">Peminjam</span> :
                                                <?= $peminjaman['namaUser'] ?><br>
                                                <span class="text-dark">Buku</span> : <?= $peminjaman['namaBuku'] ?><br>
                                                <span class="text-dark">Jumlah</span> : <?= $peminjaman['jumlah'] ?><br>
                                                <span class="text-dark">Pengurus</span> :
                                                <?= $peminjaman['namaPetugas'] ?>
                                            </td>
                                            <td>
                                                <span class="text-dark">Dipinjam</span> : <?= $peminjaman['tglPeminjaman']; ?> <br>
                                                <span class="text-dark">Batas Waktu</span> : <?= $peminjaman['tglPengembalian'] ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $status = $peminjaman['statusPeminjaman'];
                                                    $badgeClass = '';

                                                    switch ($status) {
                                                        case 'Pengajuan':
                                                            $badgeClass = 'badge-info';
                                                            break;
                                                        case 'Dipinjamkan':
                                                            $badgeClass = 'badge-success';
                                                            break;
                                                        case 'Dikembalikan':
                                                            $badgeClass = 'badge-danger';
                                                            break;
                                                        default:
                                                            $badgeClass = 'badge-dark';
                                                            break;
                                                    }
                                                    ?>
                                                <span class="badge <?= $badgeClass; ?>"><?= $status; ?></span>
                                            </td>
                                            <td>
                                                <a data-toggle="tooltip" data-placement="top" title="Detail Peminjaman"
                                                    href="detailPeminjaman.php?pinjam=<?= $peminjaman['pinjamID']; ?>"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>

                                                <a data-toggle="tooltip" data-placement="bottom" title="Batalkan Peminjaman"
                                                    href="cancel.php?pinjam=<?= $peminjaman['pinjamID']; ?>"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-ban" aria-hidden="true"></i>
                                                </a>

                                                <a data-toggle="tooltip" data-placement="right" title="Perpanjang Peminjaman"
                                                    href="perpanjang.php?pinjam=<?= $peminjaman['pinjamID']; ?>"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get all elements with class name 'text-dark' which contain the return date
        var returnDateElements = document.querySelectorAll('.text-dark');

        returnDateElements.forEach(function (element) {
            // Extract the return date from the text content of the element
            var returnDateStr = element.textContent.split(':')[1].trim();
            var returnDate = new Date(returnDateStr);

            // Get the current date
            var currentDate = new Date();

            // Calculate the difference in milliseconds between the return date and the current date
            var timeDifference = returnDate - currentDate;

            // Calculate the difference in days
            var daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

            // Check if the difference is less than 2 days
            if (daysDifference >= 0 && daysDifference <= 2) {
                // Create and append a new alert element
                var alertElement = document.createElement('div');
                alertElement.className = 'alert alert-warning';
                alertElement.innerHTML = '<strong>Perhatian!</strong> Peminjaman sudah mendekati batas waktu pengembalian.';
                document.body.insertBefore(alertElement, document.body.firstChild);
            }
        });
    });
</script>

<?php include '_footer.php'; ?>