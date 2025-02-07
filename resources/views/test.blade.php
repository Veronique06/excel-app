<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Importer un fichier XLSX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        /* Centrage du formulaire */
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 450px;
            border-radius: 10px;
            border: none;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            z-index: 10;
            background: white;
        }

        .file-upload {
            position: relative;
            text-align: center;
        }

        .file-upload input[type="file"] {
            opacity: 0;
            width: 100%;
            height: 50px;
            position: absolute;
            cursor: pointer;
        }

        .file-label {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border-radius: 5px;
            display: inline-block;
            cursor: pointer;
            width: 100%;
            text-align: center;
            font-weight: bold;
        }

        .file-label:hover {
            background-color: #0056b3;
        }

        /* Aperçu du fichier en pleine largeur */
        .preview-container {
            width: 100%;
            margin-top: 40px;
            display: none; /* Caché par défaut */
            padding: 20px;
            background-color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            background-color: white;
        }

        .separator {
            width: 100%;
            height: 2px;
            background-color: #ddd;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <!-- Formulaire d'importation -->
    <div class="card shadow">
        <h2 class="text-center mb-4">Importer un fichier Excel</h2>

        <div class="file-upload">
            <input type="file" id="fileInput" accept=".xlsx" class="form-control">
            <label for="fileInput" class="file-label">
                <i class="bi bi-upload"></i> Choisir un fichier XLSX
            </label>
            <p id="fileName" class="text-muted mt-2">Aucun fichier sélectionné</p>
        </div>

        <button id="uploadBtn" class="btn btn-primary w-100 mt-3" disabled>Importer</button>
    </div>

    <!-- Séparateur -->
    {{-- <div class="separator"></div> --}}

    <!-- Aperçu du fichier en pleine largeur -->
    <div id="previewContainer" class="preview-container">
        <h5 class="text-center">Aperçu du fichier</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead id="tableHead"></thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById("fileInput").addEventListener("change", function (event) {
            const file = event.target.files[0];
            const fileName = document.getElementById("fileName");
            const uploadBtn = document.getElementById("uploadBtn");
            const previewContainer = document.getElementById("previewContainer");
            const tableHead = document.getElementById("tableHead");
            const tableBody = document.getElementById("tableBody");

            if (file) {
                fileName.textContent = `Fichier sélectionné : ${file.name}`;
                uploadBtn.disabled = false;

                const reader = new FileReader();
                reader.readAsBinaryString(file);

                reader.onload = function (e) {
                    const data = e.target.result;
                    const workbook = XLSX.read(data, { type: "binary" });
                    const firstSheet = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[firstSheet];
                    const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

                    // Afficher l'aperçu du tableau
                    tableHead.innerHTML = "";
                    tableBody.innerHTML = "";

                    if (jsonData.length > 0) {
                        const headerRow = document.createElement("tr");
                        jsonData[0].forEach(header => {
                            const th = document.createElement("th");
                            th.textContent = header;
                            headerRow.appendChild(th);
                        });
                        tableHead.appendChild(headerRow);

                        jsonData.slice(1, 6).forEach(row => {
                            const tr = document.createElement("tr");
                            row.forEach(cell => {
                                const td = document.createElement("td");
                                td.textContent = cell;
                                tr.appendChild(td);
                            });
                            tableBody.appendChild(tr);
                        });

                        previewContainer.style.display = "block"; // Afficher l'aperçu
                    }
                };
            } else {
                fileName.textContent = "Aucun fichier sélectionné";
                uploadBtn.disabled = true;
                previewContainer.style.display = "none"; // Cacher l'aperçu si aucun fichier n'est sélectionné
            }
        });
    </script>
    <script>
        uploadBtn.addEventListener("click", function () {
            const formData = new FormData();
            formData.append("file", document.getElementById("fileInput").files[0]);

            fetch("/import-excel", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.text()) // Change JSON en text() pour voir ce qui est retourné
            .then(data => {
                console.log("Réponse du serveur :", data); // Vérifie la réponse dans la console
                alert("Import réussi !");
            })
            .catch(error => console.error("Erreur :", error));

        });

    </script>

</body>

</html>
