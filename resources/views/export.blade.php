<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export XLSX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 400px;">
        <h4 class="text-center mb-3">Exporter un fichier XLSX</h4>
        <form action="{{ route('export.xlsx') }}" method="GET">
            <div class="mb-3">
                <label for="filter" class="form-label">Filtre (optionnel)</label>
                <input type="text" class="form-control" id="filter" name="filter" placeholder="Ex : Nom, Classe...">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-download"></i> Exporter le fichier
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
