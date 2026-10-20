<?php
// Hubungkan ke database
include "../KONEKSI/koneksi.php";

// Ambil ID anggota dari URL
$id = $_GET['id'];

// Ambil data anggota berdasarkan ID
$query = mysqli_query($conn, "
    SELECT *
    FROM anggota
    WHERE id_anggota = '$id'
");

// Ambil hasil query
$row = mysqli_fetch_assoc($query);

// Cek apakah data anggota ditemukan
if (!$row) {
    echo "<script>
        alert('Data anggota tidak ditemukan');
        window.location='anggota.php';
    </script>";
    exit;

}

// Proses update data
if (isset($_POST['update'])) {
    // Ambil data baru dari form
    $nama_anggota = $_POST['nama_anggota'];
    $alamat = $_POST['alamat'];
    $no_tlpn = $_POST['no_tlpn'];
    $tgl_daftar = $_POST['tgl_daftar'];

    // Update data anggota
    $update = mysqli_query($conn, "
        UPDATE anggota
        SET
            nama_anggota = '$nama_anggota',
            alamat = '$alamat',
            no_tlpn = '$no_tlpn',
            tgl_daftar = '$tgl_daftar'
        WHERE id_anggota = '$id'

    ");

    // Cek apakah update berhasil
    if ($update) {

        echo "<script>
            alert('Data anggota berhasil diperbarui');
            window.location='anggota.php';
        </script>";

        exit;

    } else {
        echo "<script>
            alert('Data anggota gagal diperbarui');
        </script>";

    }

}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Anggota</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

</head>
<body>

    <div class="container">

        <h2>Edit Data Anggota</h2>

        <!-- Form edit anggota -->

        <form method="POST">


            <table>


                <tr>

                    <td>Nama Anggota</td>

                    <td>

                        <input type="text" name="nama_anggota" value="<?= $row['nama_anggota']; ?>" required>

                    </td>

                </tr>


                <tr>

                    <td>Alamat</td>

                    <td>

                        <textarea name="alamat" required><?= $row['alamat']; ?></textarea>

                    </td>

                </tr>


                <tr>

                    <td>No. Telepon</td>

                    <td>

                        <input type="text" name="no_tlpn" value="<?= $row['no_tlpn']; ?>" required>

                    </td>

                </tr>


                <tr>

                    <td>Tanggal Daftar</td>

                    <td>

                        <input type="date" name="tgl_daftar" value="<?= $row['tgl_daftar']; ?>" required>

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

                        <a href="anggota.php" class="back-button">
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