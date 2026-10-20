<?php
// Hubungkan ke database
include "../KONEKSI/koneksi.php";

// Ambil ID peminjaman dari URL
$id = $_GET['id'];

// Ambil data peminjaman berdasarkan ID
$query = mysqli_query($conn, "
    SELECT *
    FROM peminjaman
    WHERE id_peminjaman = '$id'

");


// Ambil data peminjaman
$row = mysqli_fetch_assoc($query);

// Cek apakah data ditemukan
if (!$row) {
    echo "<script>
        alert('Data peminjaman tidak ditemukan');
        window.location='peminjaman.php';
    </script>";

    exit;

}

// Simpan ID buku yang lama
$id_buku_lama = $row['id_buku'];

// Proses update
if (isset($_POST['update'])) {

    // Ambil data dari form
    $id_anggota = $_POST['id_anggota'];
    $id_petugas = $_POST['id_petugas'];
    $id_buku_baru = $_POST['id_buku'];
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
    $tgl_jatuh_tempo = $_POST['tgl_jatuh_tempo'];

    // Cek apakah buku diganti
    if ($id_buku_baru != $id_buku_lama) {
        // Cek stok buku baru
        $cek_buku = mysqli_query($conn, "
            SELECT stok
            FROM buku
            WHERE id_buku = '$id_buku_baru'
        ");

        $data_buku = mysqli_fetch_assoc($cek_buku);

        // Pastikan buku masih tersedia
        if (!$data_buku || $data_buku['stok'] <= 0) {
            echo "<script>
                alert('Stok buku yang dipilih sudah habis');
            </script>";

        } else {

            // Kembalikan stok buku lama
            $kembalikan_stok = mysqli_query($conn, "
                UPDATE buku
                SET stok = stok + 1
                WHERE id_buku = '$id_buku_lama'
            ");

            // Kurangi stok buku baru
            $kurangi_stok = mysqli_query($conn, "
                UPDATE buku
                SET stok = stok - 1
                WHERE id_buku = '$id_buku_baru'
            ");

            // Update data peminjaman
            $update = mysqli_query($conn, "
                UPDATE peminjaman
                SET
                    id_anggota = '$id_anggota',
                    id_petugas = '$id_petugas',
                    id_buku = '$id_buku_baru',
                    tanggal_peminjaman = '$tanggal_peminjaman',
                    tgl_jatuh_tempo = '$tgl_jatuh_tempo'
                WHERE id_peminjaman = '$id'
            ");

            // Cek hasil update
            if ($update) {
                echo "<script>
                    alert('Data peminjaman berhasil diperbarui');
                    window.location='peminjaman.php';
                </script>";

                exit;

            } else {
                echo "<script>
                    alert('Data peminjaman gagal diperbarui');
                </script>";
            }
        }
    } else {

        // Kalau buku tidak diganti,
        // cukup update data peminjaman
        $update = mysqli_query($conn, "
            UPDATE peminjaman
            SET
                id_anggota = '$id_anggota',
                id_petugas = '$id_petugas',
                tanggal_peminjaman = '$tanggal_peminjaman',
                tgl_jatuh_tempo = '$tgl_jatuh_tempo'
            WHERE id_peminjaman = '$id'
        ");

        // Cek hasil update
        if ($update) {
            echo "<script>
                alert('Data peminjaman berhasil diperbarui');
                window.location='peminjaman.php';
            </script>";
            exit;

        } else {
            echo "<script>
                alert('Data peminjaman gagal diperbarui');
            </script>";

        }

    }

}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Peminjaman</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
</head>

<body>

    <div class="container">

        <h2>Edit Peminjaman</h2>
        <p>
            Ubah data peminjaman yang dipilih
        </p>

        <!-- Form edit peminjaman -->
        <form method="POST">

            <table>

                <!-- Pilih anggota -->
                <tr>

                    <td>Anggota</td>

                    <td>

                        <select name="id_anggota" required>

                            <option value="">
                                -- Pilih Anggota --
                            </option>


                            <?php

                        // Ambil semua data anggota

                        $anggota = mysqli_query(
                            $conn,
                            "SELECT * FROM anggota"
                        );


                        // Tampilkan anggota

                        while (
                            $data_anggota =
                            mysqli_fetch_assoc($anggota)
                        ) {

                        ?>

                            <option value="<?= $data_anggota['id_anggota']; ?>" <?= (
                                    $data_anggota['id_anggota']
                                    == $row['id_anggota']
                                )
                                    ? 'selected'
                                    : '';
                                ?>>

                                <?= $data_anggota['nama_anggota']; ?>

                            </option>


                            <?php } ?>


                        </select>

                    </td>

                </tr>


                <!-- Pilih petugas -->

                <tr>

                    <td>Petugas</td>

                    <td>

                        <select name="id_petugas" required>

                            <option value="">
                                -- Pilih Petugas --
                            </option>


                            <?php

                        // Ambil semua data petugas

                        $petugas = mysqli_query(
                            $conn,
                            "SELECT * FROM petugas"
                        );


                        // Tampilkan petugas

                        while (
                            $data_petugas =
                            mysqli_fetch_assoc($petugas)
                        ) {

                        ?>

                            <option value="<?= $data_petugas['id_petugas']; ?>" <?= (
                                    $data_petugas['id_petugas']
                                    == $row['id_petugas']
                                )
                                    ? 'selected'
                                    : '';
                                ?>>

                                <?= $data_petugas['nama_petugas']; ?>

                            </option>


                            <?php } ?>


                        </select>

                    </td>

                </tr>


                <!-- Pilih buku -->

                <tr>

                    <td>Buku</td>

                    <td>

                        <select name="id_buku" required>

                            <option value="">
                                -- Pilih Buku --
                            </option>


                            <?php

                        // Ambil semua data buku

                        $buku = mysqli_query($conn, "

                            SELECT *

                            FROM buku

                        ");


                        // Tampilkan buku

                        while (
                            $data_buku =
                            mysqli_fetch_assoc($buku)
                        ) {

                        ?>


                            <option value="<?= $data_buku['id_buku']; ?>" <?= (
                                    $data_buku['id_buku']
                                    == $row['id_buku']
                                )
                                    ? 'selected'
                                    : '';
                                ?> <?= (
                                    $data_buku['id_buku']
                                    != $row['id_buku']
                                    && $data_buku['stok'] <= 0
                                )
                                    ? 'disabled'
                                    : '';
                                ?>>

                                <?= $data_buku['judul_buku']; ?>

                                -

                                Stok:
                                <?= $data_buku['stok']; ?>

                            </option>


                            <?php } ?>


                        </select>

                    </td>

                </tr>


                <!-- Tanggal peminjaman -->

                <tr>

                    <td>Tanggal Peminjaman</td>

                    <td>

                        <input type="date" name="tanggal_peminjaman" value="<?= $row['tanggal_peminjaman']; ?>"
                            required>

                    </td>

                </tr>


                <!-- Tanggal jatuh tempo -->

                <tr>

                    <td>Tanggal Jatuh Tempo</td>

                    <td>

                        <input type="date" name="tgl_jatuh_tempo" value="<?= $row['tgl_jatuh_tempo']; ?>" required>

                    </td>

                </tr>


                <!-- Tombol -->

                <tr>

                    <td></td>

                    <td>

                        <button type="submit" name="update">
                            Update
                        </button>


                        <a href="peminjaman.php" class="back-button">
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