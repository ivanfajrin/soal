
<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database kamu
$password = ""; // Ganti dengan password database kamu
$dbname = "login_system"; // Ganti dengan nama database yang sesuai

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari tabel menu_header
$sql = "SELECT nama_menu, url_menu, icon_menu FROM menu_header ORDER BY urutan_menu ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Soal</title>
 <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="menu-header">
    <ul>
        <?php
        // Menampilkan menu header
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<li class="menu-item">';
                echo '<a href="' . $row["url_menu"] . '">';
                if (!empty($row["icon_menu"])) {
                    echo '<img src="' . $row["icon_menu"] . '" alt="' . $row["nama_menu"] . '" width="20" height="20">';
                }
                echo $row["nama_menu"] . '</a></li>';
            }
        } else {
            echo "Menu tidak tersedia";
        }
        ?>
    </ul>
</header>
<h2>Lihat Soal</h2>

<form id="formViewSoal" onsubmit="event.preventDefault(); viewSoal();">
    <label for="tableSelect">Pilih Tabel:</label>
    <select id="tableSelect">
        <option value="soalIPA">Soal IPA</option>
        <option value="soalPkn">Soal PKN</option>
        <option value="soalMatematika">Soal Matematika</option>
        <option value="soalIndonesia">Soal Indonesia</option>
    </select>

    <label for="idSoal">Masukkan ID Soal:</label>
    <input type="number" id="idSoal" required>

    <button type="submit">Lihat Soal</button>
</form>

<div id="soalContainer" class="soal-container hidden">
    <h3>Detail Soal</h3>
    <p><strong>ID Soal:</strong> <span id="soalId"></span></p>
    <p><strong>Pertanyaan:</strong> <span id="pertanyaan"></span></p>
    <p><strong>Gambar:</strong> <span id="gambar"></span></p>
    <p><strong>Pilihan A:</strong> <span id="pilihanA"></span></p>
    <p><strong>Pilihan B:</strong> <span id="pilihanB"></span></p>
    <p><strong>Pilihan C:</strong> <span id="pilihanC"></span></p>
    <p><strong>Pilihan D:</strong> <span id="pilihanD"></span></p>
    <p><strong>Pilihan E:</strong> <span id="pilihanE"></span></p>

    <button id="tampilkanJawabanButton" onclick="toggleJawaban()">Tampilkan Kunci Jawaban dan Pembahasan</button>

    <div id="jawabanContainer" class="hidden">
        <p><strong>Kunci Jawaban:</strong> <span id="kunciJawaban"></span></p>
        <p><strong>Pembahasan:</strong> <span id="pembahasan"></span></p>
    </div>

    <p><strong>Kelas:</strong> <span id="kelas"></span></p>
    <p><strong>Tingkat Kesulitan:</strong> <span id="tingkatKesulitan"></span></p>
</div>

<script>
    function viewSoal() {
        const table = document.getElementById('tableSelect').value;
        const idSoal = document.getElementById('idSoal').value;

        // Fetch data soal berdasarkan id dan tabel yang dipilih
        fetch(`get_soal.php?table=${table}&id=${idSoal}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Tampilkan data soal
                    document.getElementById('soalId').innerText = data.id_soal;
                    document.getElementById('pertanyaan').innerText = data.pertanyaan;
                    document.getElementById('gambar').innerText = data.gambar;
                    document.getElementById('pilihanA').innerText = data.pilihan_a;
                    document.getElementById('pilihanB').innerText = data.pilihan_b;
                    document.getElementById('pilihanC').innerText = data.pilihan_c;
                    document.getElementById('pilihanD').innerText = data.pilihan_d;
                    document.getElementById('pilihanE').innerText = data.pilihan_e;
                    document.getElementById('kunciJawaban').innerText = data.kunci_jawaban;
                    document.getElementById('pembahasan').innerText = data.pembahasan;
                    document.getElementById('kelas').innerText = data.kelas;
                    document.getElementById('tingkatKesulitan').innerText = data.tingkat_kesulitan;

                    // Tampilkan kontainer soal
                    document.getElementById('soalContainer').classList.remove('hidden');
                    document.getElementById('jawabanContainer').classList.add('hidden'); // Sembunyikan jawaban
                }
            })
            .catch(error => console.error('Error fetching soal:', error));
    }

    function toggleJawaban() {
        const jawabanContainer = document.getElementById('jawabanContainer');
        jawabanContainer.classList.toggle('hidden'); // Menyembunyikan atau menampilkan jawaban
    }
</script>

</body>
</html>
