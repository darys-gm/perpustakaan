<?php

// Hubungkan ke database
include "../KONEKSI/koneksi.php";


// Cek apakah tombol Simpan ditekan
if (isset($_POST['simpan'])) {

    // Ambil data dari form
    $nama_petugas = $_POST['nama_petugas'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];


    // Simpan data petugas ke database
    $sql = "

        INSERT INTO petugas
        (
            nama_petugas,
            jabatan,
            no_hp
        )

        VALUES
        (
            '$nama_petugas',
            '$jabatan',
            '$no_hp'
        )

    ";


    // Jalankan query simpan
    $query = mysqli_query($conn, $sql);


    // Cek apakah data berhasil disimpan
    if ($query) {

        echo "<script>

            alert('Data petugas berhasil disimpan');

            window.location='petugas.php';

        </script>";

        exit;

    } else {

        echo "<script>

            alert('Data petugas gagal disimpan');

        </script>";

    }

}

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Petugas</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
</head>

<body>
    <div class="container">
        <h2>Data Petugas</h2>
        <p>
            Kelola data petugas perpustakaan
        </p>
        <!-- Tombol kembali ke dashboard -->

        <a href="../index.php" class="back-button">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <br>
        <br>

        <!-- Form input petugas -->

        <form method="POST" action="">
            <table>
                <tr>
                    <td>Nama Petugas</td>
                    <td>
                        <input type="text" name="nama_petugas" placeholder="Masukkan nama petugas" required>

                    </td>
                </tr>

                <tr>
                    <td>Jabatan</td>
                    <td>
                        <input type="text" name="jabatan" placeholder="Masukkan jabatan petugas" required>
                    </td>
                </tr>

                <tr>
                    <td>No. HP</td>
                    <td>
                        <input type="text" name="no_hp" placeholder="Contoh: 081234567890" required>
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


        <h3>Data Petugas</h3>


        <!-- Tabel menampilkan data petugas -->

        <table border="1" cellpadding="10" cellspacing="0">


            <tr>

                <th>ID</th>

                <th>Nama Petugas</th>

                <th>Jabatan</th>

                <th>No. HP</th>

                <th>Aksi</th>

            </tr>

            <?php
        // Ambil semua data petugas
        $data = mysqli_query($conn, "
            SELECT *
            FROM petugas
            ORDER BY id_petugas DESC
        ");


        // Tampilkan data satu per satu
        while ($row = mysqli_fetch_assoc($data)) {

        ?>


            <tr>


                <td>

                    <?= $row['id_petugas']; ?>

                </td>


                <td>

                    <?= $row['nama_petugas']; ?>

                </td>


                <td>

                    <?= $row['jabatan']; ?>

                </td>


                <td>

                    <?= $row['no_hp']; ?>

                </td>

                <td>

                <div class="action-buttons">


                    <!-- Tombol edit -->

                    <a
                        href="edit_petugas.php?id=<?= $row['id_petugas']; ?>"
                        class="btn-edit"
                    >

                        <i class="fa-solid fa-pen-to-square"></i>

                        Edit

                    </a>


                    <!-- Tombol hapus -->

                    <a
                        href="hapus_petugas.php?id=<?= $row['id_petugas']; ?>"
                        class="btn-hapus"
                        onclick="return confirm('Yakin mau hapus data petugas ini?')"
                    >

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