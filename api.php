<?php
$host = "localhost";
$user = "root"; // Ganti dengan username database Anda
$pass = ""; // Ganti dengan password database Anda
$db = "soalpilihangandalengkap";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM Soal";
$result = $conn->query($sql);
$soalArray = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $soalArray[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($soalArray);

$conn->close();
?>
