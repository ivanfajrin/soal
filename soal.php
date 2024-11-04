<?php
// Koneksi ke database
$pdo = new PDO('mysql:host=localhost;dbname=SoalPilihanGandaLengkap', 'root', '');

// Periksa apakah ada parameter ID dan tabel yang dikirim
if (isset($_GET['table']) && isset($_GET['id'])) {
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
        // Tampilkan soal
        echo "<h3>Detail Soal</h3>";
        echo "<p><strong>ID Soal:</strong> " . htmlspecialchars($soal['id_soal']) . "</p>";
        echo "<p><strong>Pertanyaan:</strong> " . htmlspecialchars($soal['pertanyaan']) . "</p>";
        echo "<p><strong>Gambar:</strong> <img src='" . htmlspecialchars($soal['gambar']) . "' alt='Gambar Soal' /></p>";
        echo "<p><strong>Pilihan A:</strong> " . htmlspecialchars($soal['pilihan_a']) . "</p>";
        echo "<p><strong>Pilihan B:</strong> " . htmlspecialchars($soal['pilihan_b']) . "</p>";
        echo "<p><strong>Pilihan C:</strong> " . htmlspecialchars($soal['pilihan_c']) . "</p>";
        echo "<p><strong>Pilihan D:</strong> " . htmlspecialchars($soal['pilihan_d']) . "</p>";
        echo "<p><strong>Pilihan E:</strong> " . htmlspecialchars($soal['pilihan_e']) . "</p>";
        echo "<p><strong>Kelas:</strong> " . htmlspecialchars($soal['kelas']) . "</p>";
        echo "<p><strong>Tingkat Kesulitan:</strong> " . htmlspecialchars($soal['tingkat_kesulitan']) . "</p>";
        
        // Menyembunyikan kunci jawaban dan pembahasan
        echo "<div id='jawabanContainer' class='hidden'>";
        echo "<p><strong>Kunci Jawaban:</strong> " . htmlspecialchars($soal['kunci_jawaban']) . "</p>";
        echo "<p><strong>Pembahasan:</strong> " . htmlspecialchars($soal['pembahasan']) . "</p>";
        echo "</div>";

    } else {
        echo "Soal tidak ditemukan.";
    }
} else {
    echo "ID soal dan tabel tidak valid.";
