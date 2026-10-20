<?php

// Hubungkan ke database
include "../KONEKSI/koneksi.php";


// Proses simpan peminjaman
if (isset($_POST['simpan'])) {

    // Ambil data dari form
    $id_anggota = $_POST['id_anggota'];
    $id_petugas = $_POST['id_petugas'];
    $id_buku = $_POST['id_buku'];
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
    $tgl_jatuh_tempo = $_POST['tgl_jatuh_tempo'];


    // Cek stok buku
    $cek_buku = mysqli_query($conn, "

        SELECT stok

        FROM buku

        WHERE id_buku = '$id_buku'

    ");


    $buku_data = mysqli_fetch_assoc($cek_buku);


    // Pastikan buku masih tersedia
    if (!$buku_data || $buku_data['stok'] <= 0) {

        echo "<script>

            alert('Stok buku sudah habis');

        </script>";

    } else {


        // Simpan data peminjaman
        $simpan = mysqli_query($conn, "

            INSERT INTO peminjaman
            (
                id_anggota,
                id_petugas,
                id_buku,
                tanggal_peminjaman,
                tgl_jatuh_tempo
            )

            VALUES
            (
                '$id_anggota',
                '$id_petugas',
                '$id_buku',
                '$tanggal_peminjaman',
                '$tgl_jatuh_tempo'
            )

        ");


        // Cek apakah peminjaman berhasil
        if ($simpan) {

            // Kurangi stok buku sebanyak 1
            $kurangi_stok = mysqli_query($conn, "

                UPDATE buku

                SET stok = stok - 1

                WHERE id_buku = '$id_buku'

            ");


            // Cek apakah stok berhasil dikurangi
            if ($kurangi_stok) {

                echo "<script>

                    alert('Peminjaman berhasil disimpan');

                    window.location='peminjaman.php';

                </script>";

                exit;

            } else {

                echo "<script>

                    alert('Peminjaman berhasil, tetapi stok gagal diperbarui');

                </script>";

            }

        } else {

            echo "<script>

                alert('Data peminjaman gagal disimpan');

            </script>";

        }

    }

}

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Peminjaman</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

</head>

<body>
    <div class="container">
        <h2>Data Peminjaman</h2>
        <p>
            Kelola data peminjaman buku perpustakaan
        </p>

        <!-- Tombol kembali -->
        <a href="../index.php" class="back-button">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        <br>
        <br>

        <!-- Form peminjaman -->
        <form method="POST" action="">
            <table>
                <tr>
                    <td>Anggota</td>
                    <td>
                        <select name="id_anggota" required>
                            <option value="">
                                -- Pilih Anggota --
                            </option>
                            <?php
                        // Ambil data anggota
                        $anggota = mysqli_query($conn, "
                            SELECT *
                            FROM anggota
                            ORDER BY nama_anggota ASC
                        ");

                        // Tampilkan anggota
                        while ($row = mysqli_fetch_assoc($anggota)) {

                        ?>

                            <option value="<?= $row['id_anggota']; ?>">

                                <?= $row['nama_anggota']; ?>

                            </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Petugas</td>
                    <td>
                        <select name="id_petugas" required>
                            <option value="">
                                -- Pilih Petugas --
                            </option>
                            <?php

                        // Ambil data petugas
                        $petugas = mysqli_query($conn, "
                            SELECT *
                            FROM petugas
                            ORDER BY nama_petugas ASC
                        ");

                        // Tampilkan petugas
                        while ($row = mysqli_fetch_assoc($petugas)) {
                        ?>
                            <option value="<?= $row['id_petugas']; ?>">
                                <?= $row['nama_petugas']; ?>
                            </option>

                            <?php } ?>

                        </select>

                    </td>

                </tr>


                <tr>

                    <td>Buku</td>

                    <td>

                        <select name="id_buku" required>

                            <option value="">
                                -- Pilih Buku --
                            </option>

                            <?php
                        // Ambil data buku dan stok
                        $buku = mysqli_query($conn, "
                            SELECT
                                id_buku,
                                judul_buku,
                                stok
                            FROM buku
                            ORDER BY judul_buku ASC
                        ");

                        // Tampilkan buku
                        while ($row = mysqli_fetch_assoc($buku)) {
                        ?>
                            <option value="<?= $row['id_buku']; ?>" <?= ($row['stok'] <= 0) ? 'disabled' : ''; ?>>

                                <?= $row['judul_buku']; ?>
                                - Stok:
                                <?= $row['stok']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Peminjaman</td>
                    <td>
                        <input type="date" name="tanggal_peminjaman" required>
                    </td>
                </tr>

                <tr>
                    <td>Tanggal Jatuh Tempo</td>
                    <td>
                        <input type="date" name="tgl_jatuh_tempo" required>
                    </td>
                </tr>

                <tr>

                    <td></td>

                    <td>

                        <!-- Tombol simpan -->

                        <button type="submit" name="simpan">
                            Simpan
                        </button>


                        <!-- Tombol reset -->

                        <button type="reset">
                            Reset
                        </button>

                    </td>

                </tr>


            </table>


        </form>


        <hr>


        <h3>Data Peminjaman</h3>


        <!-- Tabel data peminjaman -->

        <table border="1" cellpadding="10" cellspacing="0">


            <tr>

                <th>ID</th>

                <th>Anggota</th>

                <th>Petugas</th>

                <th>Buku</th>

                <th>Tanggal Pinjam</th>

                <th>Jatuh Tempo</th>

                <th>Aksi</th>

            </tr>


            <?php

        // Ambil data peminjaman
        // JOIN dipakai supaya yang tampil nama, bukan ID

        $data = mysqli_query($conn, "

            SELECT

                peminjaman.id_peminjaman,

                anggota.nama_anggota,

                petugas.nama_petugas,

                buku.judul_buku,

                peminjaman.tanggal_peminjaman,

                peminjaman.tgl_jatuh_tempo

            FROM peminjaman

            JOIN anggota

                ON peminjaman.id_anggota =
                   anggota.id_anggota

            JOIN petugas

                ON peminjaman.id_petugas =
                   petugas.id_petugas

            JOIN buku

                ON peminjaman.id_buku =
                   buku.id_buku

            ORDER BY
                peminjaman.id_peminjaman DESC

        ");


        // Tampilkan data satu per satu

        while ($row = mysqli_fetch_assoc($data)) {

        ?>


            <tr>


                <td>

                    <?= $row['id_peminjaman']; ?>

                </td>


                <td>

                    <?= $row['nama_anggota']; ?>

                </td>


                <td>

                    <?= $row['nama_petugas']; ?>

                </td>


                <td>

                    <?= $row['judul_buku']; ?>

                </td>


                <td>

                    <?= $row['tanggal_peminjaman']; ?>

                </td>


                <td>

                    <?= $row['tgl_jatuh_tempo']; ?>

                </td>


                <!-- Tombol aksi -->

                <td>

                    <div class="action-buttons">


                        <!-- Tombol edit -->

                        <a href="edit_peminjaman.php?id=<?= $row['id_peminjaman']; ?>" class="btn-edit">

                            <i class="fa-solid fa-pen-to-square"></i>

                            Edit

                        </a>


                        <!-- Tombol hapus -->

                        <a href="hapus_peminjaman.php?id=<?= $row['id_peminjaman']; ?>" class="btn-hapus"
                            onclick="return confirm('Yakin mau hapus peminjaman ini?')">

                            <i class="fa-solid fa-trash"></i>

                            Hapus

                        </a>


                    </div>

                </td>


            </tr>


            <?php } ?>


        </table>


    </div>


</body>

</html>