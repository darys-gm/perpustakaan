<?php
// Hubungkan ke database
include "../KONEKSI/koneksi.php";

// Ambil ID anggota dari URL
$id = $_GET['id'];

// Hapus data anggota berdasarkan ID
$query = mysqli_query($conn, "
    DELETE FROM anggota
    WHERE id_anggota = '$id'
");

// Cek apakah data berhasil dihapus
if ($query) {
    echo "<script>
        alert('Data anggota berhasil dihapus');
        window.location='anggota.php';
    </script>";

} else {
    echo "<script>
        alert('Data anggota gagal dihapus');
        window.location='anggota.php';
    </script>";
}

?>