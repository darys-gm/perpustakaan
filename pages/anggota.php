<?php
// Manggil koneksi database
include "../KONEKSI/koneksi.php";

// Cek tombol simpan udah dipencet atau belum
if (isset($_POST['simpan'])) {

    // Ngambil data dari form
    $nama = $_POST['nama_anggota'];
    $alamat = $_POST['alamat'];
    $no_tlpn = $_POST['no_tlpn'];
    $tgl_daftar = $_POST['tgl_daftar'];


    // Query buat nyimpen data anggota
    $sql = "INSERT INTO anggota
            (nama_anggota, alamat, no_tlpn, tgl_daftar)
            VALUES
            ('$nama', '$alamat', '$no_tlpn', '$tgl_daftar')";


    // Jalanin query
    $query = mysqli_query($conn, $sql);


    // Cek hasil penyimpanan data
    if ($query) {

        echo "<script>
                alert('Data anggota berhasil disimpan');
                window.location='anggota.php';
              </script>";

    } else {

        echo "<script>
                alert('Data anggota gagal disimpan');
              </script>";

    }

}

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

</head>

<body>
    <div class="container">

        <h2>Data Anggota</h2>

        <p>
            Kelola data anggota perpustakaan
        </p>


        <!-- Tombol kembali -->
        <a href="../index.php" class="back-button">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>


        <br>
        <br>

        <!-- Form input anggota -->

        <form method="POST" action="">


            <table>


                <!-- Input nama anggota -->

                <tr>

                    <td>Nama Anggota</td>

                    <td>

                        <input type="text" name="nama_anggota" placeholder="Masukkan nama anggota" required>

                    </td>

                </tr>


                <!-- Input alamat -->

                <tr>

                    <td>Alamat</td>

                    <td>

                        <textarea name="alamat" placeholder="Masukkan alamat anggota" required></textarea>

                    </td>

                </tr>


                <!-- Input nomor telepon -->

                <tr>

                    <td>No. Telepon</td>

                    <td>

                        <input type="text" name="no_tlpn" placeholder="Contoh: 081234567890" required>

                    </td>

                </tr>


                <!-- Input tanggal daftar -->

                <tr>

                    <td>Tanggal Daftar</td>

                    <td>

                        <input type="date" name="tgl_daftar" required>

                    </td>

                </tr>


                <!-- Tombol form -->

                <tr>

                    <td></td>

                    <td>


                        <!-- Tombol simpan -->

                        <button type="submit" name="simpan">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Simpan

                        </button>


                        <!-- Tombol reset -->

                        <button type="reset">

                            <i class="fa-solid fa-rotate-left"></i>

                            Reset

                        </button>


                    </td>

                </tr>


            </table>


        </form>


        <hr>


        <h3>Data Anggota</h3>


        <!-- Tabel data anggota -->

        <table border="1" cellpadding="10" cellspacing="0">


            <!-- Header tabel -->

            <tr>

                <th>ID</th>

                <th>Nama Anggota</th>

                <th>Alamat</th>

                <th>No. Telepon</th>

                <th>Tanggal Daftar</th>

                <th>Aksi</th>

            </tr>


            <?php

            // Ambil semua data anggota dari database

            $data = mysqli_query($conn, "

                SELECT *

                FROM anggota

                ORDER BY id_anggota DESC

            ");


            // Tampilkan data anggota satu per satu

            while ($row = mysqli_fetch_assoc($data)) {

            ?>


            <tr>


                <!-- Menampilkan ID anggota -->

                <td>

                    <?= $row['id_anggota']; ?>

                </td>


                <!-- Menampilkan nama anggota -->

                <td>

                    <?= $row['nama_anggota']; ?>

                </td>


                <!-- Menampilkan alamat anggota -->

                <td>

                    <?= $row['alamat']; ?>

                </td>


                <!-- Menampilkan nomor telepon -->

                <td>

                    <?= $row['no_tlpn']; ?>

                </td>


                <!-- Menampilkan tanggal daftar -->

                <td>

                    <?= $row['tgl_daftar']; ?>

                </td>

             <td>
                <!-- Tombol aksi -->

                <div class="action-buttons">


                    <!-- Tombol edit -->

                    <a href="edit_anggota.php?id=<?= $row['id_anggota']; ?>" class="btn-edit">

                        <i class="fa-solid fa-pen-to-square"></i>

                        Edit

                    </a>


                    <!-- Tombol hapus -->

                    <a href="hapus_anggota.php?id=<?= $row['id_anggota']; ?>" class="btn-hapus"
                        onclick="return confirm('Yakin mau hapus data anggota ini?')">

                        <i class="fa-solid fa-trash"></i>

                        Hapus

                    </a>


                </div>
             </td>
            </tr>


            <?php

            }

            ?>


        </table>


    </div>


</body>

</html>