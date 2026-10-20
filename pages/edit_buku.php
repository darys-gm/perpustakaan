<?php
// Memanggil koneksi database
include "../KONEKSI/koneksi.php";

// Mengambil ID buku dari URL
$id = $_GET['id'];

// Mengambil data buku berdasarkan ID
$query = mysqli_query($conn, "
    SELECT *
    FROM buku
    WHERE id_buku = '$id'
");

// Mengambil hasil query
$row = mysqli_fetch_assoc($query);

// Mengecek apakah data buku ditemukan
if (!$row) {
    die("Data buku tidak ditemukan.");
}

// Proses update data
if (isset($_POST['update'])) {

    // Mengambil data dari form
    $judul_buku = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    // Query untuk mengubah data buku
    $sql = "
        UPDATE buku
        SET
            judul_buku = '$judul_buku',
            penulis = '$penulis',
            penerbit = '$penerbit',
            tahun_terbit = '$tahun_terbit',
            stok = '$stok'
        WHERE id_buku = '$id'
    ";

    // Menjalankan query update
    $update = mysqli_query($conn, $sql);

    // Mengecek apakah update berhasil
    if ($update) {

        echo "<script>
                alert('Data buku berhasil diupdate');
                window.location='buku.php';
              </script>";

        exit;

    } else {
        echo "<script>
                alert('Data buku gagal diupdate');
              </script>";

    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

</head>

<body>

    <div class="container">
        <!-- Judul halaman -->

        <h2>Edit Data Buku</h2>


        <!-- Tombol kembali -->

        <a href="buku.php" class="back-button">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>


        <!-- Form edit buku -->

        <form method="POST">


            <table>


                <!-- Judul buku -->

                <tr>

                    <td>Judul Buku</td>

                    <td>

                        <input type="text" name="judul_buku" value="<?= $row['judul_buku']; ?>" required>

                    </td>

                </tr>


                <!-- Penulis -->

                <tr>

                    <td>Penulis</td>

                    <td>

                        <input type="text" name="penulis" value="<?= $row['penulis']; ?>" required>

                    </td>

                </tr>


                <!-- Penerbit -->

                <tr>

                    <td>Penerbit</td>

                    <td>

                        <input type="text" name="penerbit" value="<?= $row['penerbit']; ?>" required>

                    </td>

                </tr>


                <!-- Tahun terbit -->

                <tr>

                    <td>Tahun Terbit</td>

                    <td>

                        <input type="number" name="tahun_terbit" value="<?= $row['tahun_terbit']; ?>" required>

                    </td>

                </tr>


                <!-- Stok -->

                <tr>

                    <td>Stok</td>

                    <td>

                        <input type="number" name="stok" value="<?= $row['stok']; ?>" min="0" required>

                    </td>

                </tr>


                <!-- Tombol -->

                <tr>

                    <td></td>

                    <td>

                        <button type="submit" name="update">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Update

                        </button>


                        <a href="buku.php" class="back-button">

                            Batal

                        </a>

                    </td>

                </tr>


            </table>


        </form>


    </div>


</body>

</html>