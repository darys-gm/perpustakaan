<?php
// Hubungkan ke database
include "../KONEKSI/koneksi.php";

// Ambil ID pengembalian dari URL
$id = $_GET['id'];

// Ambil data pengembalian berdasarkan ID
$query = mysqli_query($conn, "
    SELECT *
    FROM pengembalian
    WHERE id_pengembalian = '$id'
");

// Ambil data pengembalian
$data = mysqli_fetch_assoc($query);

// Cek apakah data ditemukan
if (!$data) {
    echo "<script>
        alert('Data pengembalian tidak ditemukan');
        window.location='pengembalian.php';
    </script>";

    exit;

}

// Proses update data
if (isset($_POST['update'])) {

    // Ambil data dari form
    $tgl_kembali = $_POST['tgl_kembali'];
    $denda = $_POST['denda'];
    $keterangan = $_POST['keterangan'];

    // Update data pengembalian
    $update = mysqli_query($conn, "
        UPDATE pengembalian
        SET
            tgl_kembali = '$tgl_kembali',
            denda = '$denda',
            keterangan = '$keterangan'
        WHERE id_pengembalian = '$id'
    ");

    // Cek apakah update berhasil
    if ($update) {
        echo "<script>
            alert('Data pengembalian berhasil diperbarui');
            window.location='pengembalian.php';
        </script>";

        exit;

    } else {
        echo "<script>
            alert('Data pengembalian gagal diperbarui');
        </script>";
    }

}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengembalian</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

</head>
<body>

    <div class="container">

        <h2>Edit Pengembalian</h2>

        <p>
            Ubah data pengembalian buku
        </p>


        <!-- Form edit pengembalian -->

        <form method="POST">


            <table>


                <tr>

                    <td>ID Peminjaman</td>

                    <td>

                        <input type="text" value="<?= $data['id_peminjaman']; ?>" readonly>

                    </td>

                </tr>


                <tr>

                    <td>Tanggal Kembali</td>

                    <td>

                        <input type="date" name="tgl_kembali" value="<?= $data['tgl_kembali']; ?>" required>

                    </td>

                </tr>


                <tr>

                    <td>Denda</td>

                    <td>

                        <input type="number" name="denda" value="<?= $data['denda']; ?>" min="0">

                    </td>

                </tr>


                <tr>

                    <td>Keterangan</td>

                    <td>

                        <textarea name="keterangan"><?= $data['keterangan']; ?></textarea>

                    </td>

                </tr>


                <tr>

                    <td></td>

                    <td>

                        <!-- Tombol update -->

                        <button type="submit" name="update">
                            Update
                        </button>


                        <!-- Tombol kembali -->

                        <a href="pengembalian.php" class="back-button">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali
                        </a>

                    </td>

                </tr>


            </table>


        </form>


    </div>


</body>

</html>