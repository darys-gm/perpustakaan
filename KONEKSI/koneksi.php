    <?php

    // Tentukan lokasi file .env (satu level di atas folder config)
$env_file = __DIR__ . '/../.env';

// Cek apakah file .env ada
if (!file_exists($env_file)) {
    die("Error: File .env tidak ditemukan. Silakan copy .env.example menjadi .env dan isi konfigurasi database.");
}

// Baca file .env
$env = parse_ini_file($env_file);

// Validasi apakah parsing berhasil
if ($env === false) {
    die("Error: Gagal membaca file .env. Periksa format penulisannya.");
}

// Ambil nilai dari .env dengan fallback default
$host     = $env['DB_HOST']     ?? 'localhost';
$username = $env['DB_USERNAME'] ?? 'root';
$password = $env['DB_PASSWORD'] ?? '';
$database = $env['DB_NAME']     ?? 'perpustakaan';


    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    ?>