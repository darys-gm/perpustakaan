<?php

// Hubungkan ke database
include "../KONEKSI/koneksi.php";


// Ambil ID petugas dari URL
$id = $_GET['id'];


// Hapus data petugas berdasarkan ID
$query = mysqli_query($conn, "

    DELETE FROM petugas

    WHERE id_petugas = '$id'

");


// Cek apakah data berhasil dihapus
if ($query) {

    echo "<script>

        alert('Data petugas berhasil dihapus');

        window.location='petugas.php';

    </script>";

} else {

    echo "<script>

        alert('Data petugas gagal dihapus');

        window.location='petugas.php';

    </script>";

}

?>