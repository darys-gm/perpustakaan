<?php
// Hubungkan ke database
include "../KONEKSI/koneksi.php";

// Ambil ID petugas dari URL
$id = $_GET['id'];

// Ambil data petugas berdasarkan ID
$query = mysqli_query($conn, "
    SELECT *
    FROM petugas
    WHERE id_petugas = '$id'
");

// Ambil hasil data
$row = mysqli_fetch_assoc($query);

// Cek apakah data ditemukan
if (!$row) {
    echo "<script>
        alert('Data petugas tidak ditemukan');
        window.location='petugas.php';
    </script>";
    exit;
}

// Proses update data
if (isset($_POST['update'])) {
    // Ambil data dari form
    $nama_petugas = $_POST['nama_petugas'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];

    // Update data petugas
    $update = mysqli_query($conn, "
        UPDATE petugas
        SET
            nama_petugas = '$nama_petugas',
            jabatan = '$jabatan',
            no_hp = '$no_hp'
        WHERE id_petugas = '$id'
    ");


    // Cek apakah update berhasil
    if ($update) {
        echo "<script>
            alert('Data petugas berhasil diperbarui');
            window.location='petugas.php';
        </script>";
        exit;

    } else {
        echo "<script>
            alert('Data petugas gagal diperbarui');
        </script>";

    }

}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Petugas</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

</head>

<body>


    <div class="container">


        <h2>Edit Data Petugas</h2>

        <p>
            Ubah data petugas yang dipilih
        </p>


        <!-- Form edit petugas -->

        <form method="POST">


            <table>


                <tr>

                    <td>Nama Petugas</td>

                    <td>

                        <input type="text" name="nama_petugas" value="<?= $row['nama_petugas']; ?>" required>

                    </td>

                </tr>


                <tr>

                    <td>Jabatan</td>

                    <td>

                        <input type="text" name="jabatan" value="<?= $row['jabatan']; ?>" required>

                    </td>

                </tr>


                <tr>

                    <td>No. HP</td>

                    <td>

                        <input type="text" name="no_hp" value="<?= $row['no_hp']; ?>" required>

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

                        <a href="../index.php" class="back-button">
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