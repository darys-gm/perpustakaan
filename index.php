<?php

// Memanggil koneksi database
include "KONEKSI/koneksi.php";


// Menghitung jumlah seluruh anggota
$query_anggota = mysqli_query($conn, "

    SELECT COUNT(*) AS total

    FROM anggota

");

$data_anggota = mysqli_fetch_assoc($query_anggota);

$jumlah_anggota = $data_anggota['total'];


// Menghitung jumlah seluruh judul buku
$query_buku = mysqli_query($conn, "

    SELECT COUNT(*) AS total

    FROM buku

");

$data_buku = mysqli_fetch_assoc($query_buku);

$jumlah_buku = $data_buku['total'];


// Menghitung jumlah buku yang sedang dipinjam
// Peminjaman yang belum memiliki data pengembalian
$query_dipinjam = mysqli_query($conn, "

    SELECT COUNT(*) AS total

    FROM peminjaman p

    LEFT JOIN pengembalian pr
        ON p.id_peminjaman = pr.id_peminjaman

    WHERE pr.id_peminjaman IS NULL

");

$data_dipinjam = mysqli_fetch_assoc($query_dipinjam);

$jumlah_dipinjam = $data_dipinjam['total'];


// Menghitung seluruh stok buku yang tersedia
$query_stok = mysqli_query($conn, "

    SELECT COALESCE(SUM(stok), 0) AS total

    FROM buku

");

$data_stok = mysqli_fetch_assoc($query_stok);

$jumlah_stok = $data_stok['total'];


// Mengambil beberapa data peminjaman terbaru
// Peminjaman yang sudah dikembalikan tidak akan ditampilkan
$query_terbaru = mysqli_query($conn, "

    SELECT

        p.id_peminjaman,

        a.nama_anggota,

        b.judul_buku,

        p.tanggal_peminjaman,

        p.tgl_jatuh_tempo


    FROM peminjaman p


    JOIN anggota a

        ON p.id_anggota = a.id_anggota


    JOIN buku b

        ON p.id_buku = b.id_buku


    LEFT JOIN pengembalian pr

        ON p.id_peminjaman = pr.id_peminjaman


    WHERE pr.id_peminjaman IS NULL


    ORDER BY p.id_peminjaman DESC


    LIMIT 5

");

?>


<!DOCTYPE html>

<html lang="id">


<head>


    <meta charset="UTF-8">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Dashboard Perpustakaan</title>


    <!-- CSS utama -->

    <link rel="stylesheet" href="CSS/style.css">


    <!-- Font Awesome lokal agar aplikasi tetap offline -->

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">


</head>


<body>


    <!-- Sidebar -->

    <aside class="sidebar">


        <!-- Logo aplikasi -->

        <div class="sidebar-logo">


            <div class="logo-icon">

                <i class="fa-solid fa-book-open"></i>

            </div>


            <div>

                <h2>LIBRARY</h2>

                <span>Management System</span>

            </div>


        </div>


        <!-- Menu utama -->

        <div class="menu-section">


            <p class="menu-title">

                MENU UTAMA

            </p>


            <a href="index.php" class="menu-item active">

                <i class="fa-solid fa-house"></i>

                <span>Dashboard</span>

            </a>


            <a href="pages/anggota.php" class="menu-item">

                <i class="fa-solid fa-users"></i>

                <span>Data Anggota</span>

            </a>


            <a href="pages/buku.php" class="menu-item">

                <i class="fa-solid fa-book"></i>

                <span>Data Buku</span>

            </a>


            <a href="pages/petugas.php" class="menu-item">

                <i class="fa-solid fa-user-tie"></i>

                <span>Data Petugas</span>

            </a>


        </div>


        <!-- Menu transaksi -->

        <div class="menu-section">


            <p class="menu-title">

                TRANSAKSI

            </p>


            <a href="pages/peminjaman.php" class="menu-item">

                <i class="fa-solid fa-book-open-reader"></i>

                <span>Peminjaman</span>

            </a>


            <a href="pages/pengembalian.php" class="menu-item">

                <i class="fa-solid fa-arrow-rotate-left"></i>

                <span>Pengembalian</span>

            </a>


        </div>


        <!-- Bagian bawah sidebar -->

        <div class="sidebar-bottom">


            <a href="#" class="menu-item">

                <i class="fa-solid fa-gear"></i>

                <span>Pengaturan</span>

            </a>


        </div>


    </aside>


    <!-- Konten utama -->

    <main class="main-content">


        <!-- Header -->
        <header class="topbar">

            <div>

                <h1>Dashboard</h1>

                <p>
                    Kelola aktivitas perpustakaan dengan mudah.
                </p>

            </div>

            <div class="topbar-right">

                <!-- Tombol notifikasi -->
                <button type="button" class="icon-button" title="Notifikasi">
                    <i class="fa-regular fa-bell"></i>
                </button>
                <!-- Profil admin -->
                <div class="profile">

                    <div class="profile-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div class="profile-info">
                        <strong>Admin</strong>
                        <span>Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Isi dashboard -->
        <section class="dashboard-content">

            <!-- Banner selamat datang -->
            <div class="welcome-box">
                <div>
                    <span>
                        Selamat datang kembali 👋
                    </span>

                    <h2>
                        Kelola perpustakaan dengan lebih mudah.
                    </h2>

                    <p>
                        Pantau anggota, buku, peminjaman,
                        dan pengembalian dalam satu tempat.
                    </p>

                </div>

                <div class="welcome-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>

            </div>

            <!-- Statistik perpustakaan -->
            <div class="stats-grid">

                <!-- Total anggota -->
                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="fa-solid fa-users"></i>

                    </div>

                    <div class="stat-info">

                        <span>Total Anggota</span>

                        <h3>

                            <?= $jumlah_anggota; ?>

                        </h3>

                    </div>

                </div>

                <!-- Total judul buku -->

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="fa-solid fa-book"></i>
                    </div>

                    <div class="stat-info">

                        <span>Total Judul Buku</span>

                        <h3>

                            <?= $jumlah_buku; ?>

                        </h3>

                    </div>

                </div>

                <!-- Buku yang sedang dipinjam -->
                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>

                    <div class="stat-info">

                        <span>Sedang Dipinjam</span>

                        <h3>
                            <?= $jumlah_dipinjam; ?>
                        </h3>

                    </div>

                </div>

                <!-- Total stok buku -->
                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>

                    <div class="stat-info">

                        <span>Buku Tersedia</span>

                        <h3>
                            <?= $jumlah_stok; ?>

                        </h3>

                    </div>

                </div>

            </div>

            <!-- Bagian aktivitas dashboard -->
            <div class="dashboard-grid">

                <!-- Peminjaman terbaru -->
                <div class="dashboard-card">

                    <div class="card-header">

                        <div>

                            <h3>
                                Peminjaman Terbaru
                            </h3>

                            <span>
                                Aktivitas peminjaman terakhir
                            </span>

                        </div>

                        <a href="pages/peminjaman.php">

                            Lihat semua
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>

                    <!-- Daftar peminjaman -->
                    <div class="recent-list">
                        <?php

                        // Mengecek apakah ada data peminjaman
                        if (mysqli_num_rows($query_terbaru) > 0) {

                            // Menampilkan data peminjaman satu per satu
                            while ($row = mysqli_fetch_assoc($query_terbaru)) {

                        ?>

                        <div class="recent-item">

                            <div class="recent-icon">

                                <i class="fa-solid fa-book"></i>

                            </div>

                            <div class="recent-info">

                                <strong>

                                    <?= htmlspecialchars($row['nama_anggota']); ?>

                                </strong>

                                <span>

                                    <?= htmlspecialchars($row['judul_buku']); ?>
                                </span>

                            </div>

                            <div class="recent-date">

                                <?= $row['tanggal_peminjaman']; ?>

                            </div>

                        </div>

                        <?php

                            }

                        } else {

                        ?>

                        <!-- Tampilan jika tidak ada peminjaman aktif -->
                        <div class="empty-state">

                            <i class="fa-solid fa-book-open"></i>
                            <p>
                                Belum ada buku yang sedang dipinjam.
                            </p>
                        </div>
                        <?php
                        }

                        ?>

                    </div>

                </div>

                <!-- Menu akses cepat -->
                <div class="dashboard-card">

                    <div class="card-header">
                        <div>
                            <h3>
                                Akses Cepat
                            </h3>
                            <span>
                                Menu yang sering digunakan
                            </span>

                        </div>

                    </div>

                    <div class="quick-menu">

                        <!-- Tambah anggota -->
                        <a href="pages/anggota.php">
                            <i class="fa-solid fa-user-plus"></i>

                            <span>
                                Tambah Anggota
                            </span>
                        </a>

                        <!-- Tambah buku -->
                        <a href="pages/buku.php">
                            <i class="fa-solid fa-book-medical"></i>
                            <span>

                                Tambah Buku
                            </span>
                        </a>

                        <!-- Peminjaman baru -->
                        <a href="pages/peminjaman.php">

                            <i class="fa-solid fa-plus"></i>

                            <span>

                                Peminjaman Baru
                            </span>

                        </a>

                        <!-- Pengembalian -->
                        <a href="pages/pengembalian.php">

                            <i class="fa-solid fa-arrow-rotate-left"></i>

                            <span>

                                Pengembalian
                            </span>
                        </a>
                    </div>
                </div>
            </div>

        </section>

    </main>
</body>

</html>