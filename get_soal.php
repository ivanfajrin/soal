<?php
// Koneksi ke database
$pdo = new PDO('mysql:host=localhost;dbname=SoalPilihanGandaLengkap', 'root', '');

// Dapatkan tabel dan ID soal dari query parameter
$table = $_GET['table'];
$id_soal = $_GET['id'];

// Periksa apakah tabel yang diminta valid
$allowedTables = ['soalIPA', 'soalPkn', 'soalMatematika', 'soalIndonesia'];
if (!in_array($table, $allowedTables)) {
    die('Invalid table selected');
}

// Query untuk mengambil data soal berdasarkan ID soal
$sql = "SELECT * FROM $table WHERE id_soal = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_soal]);

// Ambil data soal
$soal = $stmt->fetch(PDO::FETCH_ASSOC);

// Periksa apakah soal ditemukan
if ($soal) {
    header('Content-Type: application/json');
    echo json_encode($soal); // Kirim data soal dalam format JSON
} else {
    echo json_encode(['error' => 'Soal tidak ditemukan']);
}
