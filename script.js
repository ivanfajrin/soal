document.addEventListener("DOMContentLoaded", () => {
    fetch("api.php") // Ganti dengan endpoint server yang benar
        .then(response => response.json())
        .then(data => {
            const soalContainer = document.getElementById("soal-container");
            data.forEach(soal => {
                const soalDiv = document.createElement("div");
                soalDiv.className = "soal";

                // Menampilkan pertanyaan
                soalDiv.innerHTML = `
                    <h2>${soal.pertanyaan}</h2>
                    ${soal.gambar ? `<img src="${soal.gambar}" alt="Ilustrasi">` : ''}
                    <ul>
                        <li>A. ${soal.pilihan_a}</li>
                        <li>B. ${soal.pilihan_b}</li>
                        <li>C. ${soal.pilihan_c}</li>
                        <li>D. ${soal.pilihan_d}</li>
                        <li>E. ${soal.pilihan_e}</li>
                    </ul>
                    <p><strong>Kunci Jawaban:</strong> ${soal.kunci_jawaban}</p>
                    <p><strong>Pembahasan:</strong> ${soal.pembahasan}</p>
                `;
                soalContainer.appendChild(soalDiv);
            });
        }).catch(error => console.error('Error fetching data:', error));
});
