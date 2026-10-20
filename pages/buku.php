<?php
// Hubungkan ke database
include "../KONEKSI/koneksi.php";

// Proses simpan data buku
if (isset($_POST['simpan'])) {

    $judul_buku = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];


    // Simpan data buku
    $simpan = mysqli_query($conn, "

        INSERT INTO buku
        (
            judul_buku,
            penulis,
            penerbit,
            tahun_terbit,
            stok
        )

        VALUES
        (
            '$judul_buku',
            '$penulis',
            '$penerbit',
            '$tahun_terbit',
            '$stok'
        )

    ");

    // Cek hasil simpan
    if ($simpan) {
        echo "<script>
            alert('Data buku berhasil disimpan');
            window.location='buku.php';
        </script>";
        exit;

    } else {
        echo "<script>
            alert('Data buku gagal disimpan');
        </script>";

    }

}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Data Buku</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

</head>

<body>


    <div class="container">


        <h2>Data Buku</h2>


        <p>
            Kelola data buku perpustakaan
        </p>


        <!-- Tombol kembali -->

        <a href="../index.php" class="back-button">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>


        <br>
        <br>


        <!-- Form input buku -->

        <form method="POST" action="">

            <table>

                <tr>

                    <td>Judul Buku</td>

                    <td>

                        <input type="text" name="judul_buku" placeholder="Masukkan judul buku" required>

                    </td>

                </tr>


                <tr>

                    <td>Penulis</td>

                    <td>

                        <input type="text" name="penulis" placeholder="Masukkan nama penulis" required>

                    </td>

                </tr>


                <tr>

                    <td>Penerbit</td>

                    <td>

                        <input type="text" name="penerbit" placeholder="Masukkan nama penerbit" required>

                    </td>

                </tr>


                <tr>

                    <td>Tahun Terbit</td>

                    <td>

                        <input type="number" name="tahun_terbit" placeholder="Contoh: 2024" min="1000" max="9999"
                            required>

                    </td>

                </tr>


                <tr>

                    <td>Stok</td>

                    <td>

                        <input type="number" name="stok" placeholder="Masukkan jumlah stok" min="0" required>

                    </td>

                </tr>


                <tr>

                    <td></td>

                    <td>

                        <button type="submit" name="simpan">
                            Simpan
                        </button>


                        <button type="reset">
                            Reset
                        </button>

                    </td>

                </tr>

            </table>

        </form>


        <hr>


        <h3>Data Buku</h3>


        <!-- Tabel data buku -->

        <table border="1" cellpadding="10" cellspacing="0">

            <tr>

                <th>ID</th>

                <th>Judul Buku</th>

                <th>Penulis</th>

                <th>Penerbit</th>

                <th>Tahun Terbit</th>

                <th>Stok</th>

                <th>Aksi</th>

            </tr>


            <?php

        // Ambil semua data buku
        $data = mysqli_query($conn, "

            SELECT *

            FROM buku

            ORDER BY id_buku DESC

        ");


        // Tampilkan data satu per satu
        while ($row = mysqli_fetch_assoc($data)) {

        ?>

            <tr>

                <td>

                    <?= $row['id_buku']; ?>

                </td>


                <td>

                    <?= $row['judul_buku']; ?>

                </td>


                <td>

                    <?= $row['penulis']; ?>

                </td>


                <td>

                    <?= $row['penerbit']; ?>

                </td>


                <td>

                    <?= $row['tahun_terbit']; ?>

                </td>


                <td>

                    <?= $row['stok']; ?>

                </td>


                <td>

                    <a href="edit_buku.php?id=<?= $row['id_buku']; ?>" class="btn-edit">

                        <i class="fa-solid fa-pen-to-square"></i>

                        Edit

                    </a>


                    <!-- Tombol hapus -->

                    <a href="hapus_buku.php?id=<?= $row['id_buku']; ?>" class="btn-hapus"
                        onclick="return confirm('Yakin mau hapus buku ini?')">

                        <i class="fa-solid fa-trash"></i>

                        Hapus

                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>


    </div>


</body>

</html>