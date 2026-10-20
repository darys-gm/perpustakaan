<?php
// Hubungkan ke database
include "../KONEKSI/koneksi.php";

// Ambil ID peminjaman dari URL
$id = $_GET['id'];

// Ambil ID buku dari peminjaman yang akan dihapus
$data = mysqli_query($conn, "
    SELECT id_buku
    FROM peminjaman
    WHERE id_peminjaman = '$id'
");

// Ambil data buku
$row = mysqli_fetch_assoc($data);

// Cek apakah data peminjaman ditemukan
if (!$row) {
    echo "<script>
        alert('Data peminjaman tidak ditemukan');
        window.location='peminjaman.php';
    </script>";
    exit;
}

// Simpan ID buku
$id_buku = $row['id_buku'];

// Kembalikan stok buku
$stok = mysqli_query($conn, "
    UPDATE buku
    SET stok = stok + 1
    WHERE id_buku = '$id_buku'
");

// Hapus data peminjaman
$hapus = mysqli_query($conn, "
    DELETE FROM peminjaman
    WHERE id_peminjaman = '$id'
");

// Cek apakah proses hapus berhasil
if ($hapus) {
    echo "<script>
        alert('Data peminjaman berhasil dihapus');
        window.location='peminjaman.php';
    </script>";
} else {
    echo "<script>
        alert('Data peminjaman gagal dihapus');
        window.location='peminjaman.php';
    </script>";
}

?>