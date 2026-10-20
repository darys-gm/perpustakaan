<?php
// Hubungkan ke database
include "../KONEKSI/koneksi.php";

// Ambil ID pengembalian dari URL
$id_pengembalian = $_GET['id'];

// Ambil ID peminjaman dari data pengembalian
$query = mysqli_query($conn, "
    SELECT id_peminjaman
    FROM pengembalian
    WHERE id_pengembalian = '$id_pengembalian'
");

// Ambil hasil query
$data = mysqli_fetch_assoc($query);

// Cek apakah data pengembalian ditemukan
if (!$data) {
    die("Data pengembalian tidak ditemukan.");
}

// Simpan ID peminjaman
$id_peminjaman = $data['id_peminjaman'];

// Ambil ID buku dari data peminjaman
$query_buku = mysqli_query($conn, "
    SELECT id_buku
    FROM peminjaman
    WHERE id_peminjaman = '$id_peminjaman'
");

// Ambil hasil query buku
$data_buku = mysqli_fetch_assoc($query_buku);

// Cek apakah data peminjaman ditemukan
if (!$data_buku) {
    die("Data peminjaman tidak ditemukan.");
}

// Simpan ID buku
$id_buku = $data_buku['id_buku'];

// Hapus data pengembalian
$hapus = mysqli_query($conn, "
    DELETE FROM pengembalian
    WHERE id_pengembalian = '$id_pengembalian'
");

// Cek apakah penghapusan berhasil
if (!$hapus) {
    die(
        "Gagal menghapus pengembalian: "
        . mysqli_error($conn)
    );
}

// Karena data pengembalian dihapus,
// buku dianggap belum dikembalikan
// sehingga stok dikurangi kembali 1
$update_stok = mysqli_query($conn, "
    UPDATE buku
    SET stok = stok - 1
    WHERE id_buku = '$id_buku'
");

// Cek apakah stok berhasil diperbarui
if (!$update_stok) {
    die(
        "Gagal mengubah stok buku: "
        . mysqli_error($conn)
    );
}

// Kalau semua berhasil,
// kembali ke halaman pengembalian
echo "<script>
    alert('Data pengembalian berhasil dihapus');
    window.location='pengembalian.php';
</script>";

?>