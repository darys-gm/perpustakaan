<?php

// Hubungkan ke database
include "../KONEKSI/koneksi.php";


// Proses simpan pengembalian
if (isset($_POST['simpan'])) {

    // Ambil data dari form
    $id_peminjaman = $_POST['id_peminjaman'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $denda = $_POST['denda'];
    $keterangan = $_POST['keterangan'];


    // Ambil ID buku dari data peminjaman
    $cek_peminjaman = mysqli_query($conn, "

        SELECT id_buku

        FROM peminjaman

        WHERE id_peminjaman = '$id_peminjaman'

    ");


    // Cek apakah peminjaman ditemukan
    if (!$cek_peminjaman) {

        die(
            "Gagal mengambil data peminjaman: "
            . mysqli_error($conn)
        );

    }


    $data_peminjaman = mysqli_fetch_assoc($cek_peminjaman);


    if (!$data_peminjaman) {

        echo "<script>

            alert('Data peminjaman tidak ditemukan');

        </script>";

    } else {

        $id_buku = $data_peminjaman['id_buku'];


        // Cek apakah peminjaman sudah pernah dikembalikan
        $cek_pengembalian = mysqli_query($conn, "

            SELECT id_pengembalian

            FROM pengembalian

            WHERE id_peminjaman = '$id_peminjaman'

        ");


        if (!$cek_pengembalian) {

            die(
                "Gagal mengecek pengembalian: "
                . mysqli_error($conn)
            );

        }


        // Kalau sudah ada data pengembalian
        if (mysqli_num_rows($cek_pengembalian) > 0) {

            echo "<script>

                alert('Peminjaman ini sudah dikembalikan');

            </script>";

        } else {


            // Simpan data pengembalian
            $simpan = mysqli_query($conn, "

                INSERT INTO pengembalian
                (
                    id_peminjaman,
                    tgl_kembali,
                    denda,
                    keterangan
                )

                VALUES
                (
                    '$id_peminjaman',
                    '$tgl_kembali',
                    '$denda',
                    '$keterangan'
                )

            ");


            // Cek apakah data berhasil disimpan
            if ($simpan) {

                // Tambahkan stok buku sebanyak 1
                $tambah_stok = mysqli_query($conn, "

                    UPDATE buku

                    SET stok = stok + 1

                    WHERE id_buku = '$id_buku'

                ");


                // Cek apakah stok berhasil ditambahkan
                if ($tambah_stok) {

                    echo "<script>

                        alert('Buku berhasil dikembalikan');

                        window.location='pengembalian.php';

                    </script>";

                    exit;

                } else {

                    echo "<script>

                        alert('Data berhasil disimpan, tetapi stok gagal diperbarui');

                    </script>";

                }

            } else {

                echo "<script>

                    alert('Data pengembalian gagal disimpan');

                </script>";

            }

        }

    }

}

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pengembalian</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

</head>

<body>

    <div class="container">
        <h2>Data Pengembalian</h2>
        <p>
            Kelola data pengembalian buku perpustakaan
        </p>
        <!-- Tombol kembali -->

        <a href="../index.php" class="back-button">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>


        <br>
        <br>


        <!-- Form pengembalian -->

        <form method="POST" action="">


            <table>


                <tr>

                    <td>Peminjaman</td>

                    <td>

                        <select name="id_peminjaman" required>

                            <option value="">
                                -- Pilih Peminjaman --
                            </option>


                            <?php

                        // Ambil peminjaman yang belum dikembalikan

                        $peminjaman = mysqli_query($conn, "

                            SELECT

                                p.id_peminjaman,
                                a.nama_anggota,
                                b.judul_buku,
                                p.tanggal_peminjaman

                            FROM peminjaman p

                            JOIN anggota a

                                ON p.id_anggota =
                                   a.id_anggota

                            JOIN buku b

                                ON p.id_buku =
                                   b.id_buku

                            LEFT JOIN pengembalian pr

                                ON p.id_peminjaman =
                                   pr.id_peminjaman

                            WHERE pr.id_peminjaman IS NULL

                            ORDER BY
                                p.id_peminjaman DESC

                        ");


                        // Cek apakah query berhasil

                        if (!$peminjaman) {

                            die(
                                "Gagal mengambil data peminjaman: "
                                . mysqli_error($conn)
                            );

                        }


                        // Tampilkan peminjaman yang tersedia

                        while (
                            $row = mysqli_fetch_assoc($peminjaman)
                        ) {

                        ?>

                            <option value="<?= $row['id_peminjaman']; ?>">

                                <?= $row['nama_anggota']; ?>

                                -

                                <?= $row['judul_buku']; ?>

                                -

                                <?= $row['tanggal_peminjaman']; ?>

                            </option>

                            <?php } ?>

                        </select>

                    </td>

                </tr>


                <tr>

                    <td>Tanggal Kembali</td>

                    <td>

                        <input type="date" name="tgl_kembali" required>

                    </td>

                </tr>


                <tr>

                    <td>Denda</td>

                    <td>

                        <input type="number" name="denda" value="0" min="0">

                    </td>

                </tr>


                <tr>

                    <td>Keterangan</td>

                    <td>

                        <textarea name="keterangan"
                            placeholder="Contoh: Buku dikembalikan dalam kondisi baik"></textarea>

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


        <h3>Data Pengembalian</h3>


        <!-- Tabel data pengembalian -->

        <table border="1" cellpadding="10" cellspacing="0">


            <tr>

                <th>ID</th>

                <th>Anggota</th>

                <th>Buku</th>

                <th>Tanggal Pinjam</th>

                <th>Tanggal Kembali</th>

                <th>Denda</th>

                <th>Keterangan</th>

                <th>Aksi</th>

            </tr>


            <?php

        // Ambil data pengembalian

        $data = mysqli_query($conn, "

            SELECT

                pr.id_pengembalian,

                a.nama_anggota,

                b.judul_buku,

                p.tanggal_peminjaman,

                pr.tgl_kembali,

                pr.denda,

                pr.keterangan

            FROM pengembalian pr

            JOIN peminjaman p

                ON pr.id_peminjaman =
                   p.id_peminjaman

            JOIN anggota a

                ON p.id_anggota =
                   a.id_anggota

            JOIN buku b

                ON p.id_buku =
                   b.id_buku

            ORDER BY
                pr.id_pengembalian DESC

        ");


        // Cek apakah query berhasil

        if (!$data) {

            die(
                "Gagal mengambil data pengembalian: "
                . mysqli_error($conn)
            );

        }


        // Tampilkan data satu per satu

        while ($row = mysqli_fetch_assoc($data)) {

        ?>


            <tr>


                <td>

                    <?= $row['id_pengembalian']; ?>

                </td>


                <td>

                    <?= $row['nama_anggota']; ?>

                </td>


                <td>

                    <?= $row['judul_buku']; ?>

                </td>


                <td>

                    <?= $row['tanggal_peminjaman']; ?>

                </td>


                <td>

                    <?= $row['tgl_kembali']; ?>

                </td>


                <td>

                    <?= $row['denda']; ?>

                </td>


                <td>

                    <?= $row['keterangan']; ?>

                </td>


                <!-- Tombol aksi -->

                <td>

                    <div class="action-buttons">


                        <!-- Tombol edit -->

                        <a href="edit_pengembalian.php?id=<?= $row['id_pengembalian']; ?>" class="btn-edit">

                            <i class="fa-solid fa-pen-to-square"></i>

                            Edit

                        </a>


                        <!-- Tombol hapus -->

                        <a href="hapus_pengembalian.php?id=<?= $row['id_pengembalian']; ?>" class="btn-hapus"
                            onclick="return confirm('Yakin mau hapus data pengembalian ini?')">

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