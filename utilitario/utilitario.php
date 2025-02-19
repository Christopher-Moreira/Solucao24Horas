<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['csvFile']['tmp_name'];
        $originalFileName = $_FILES['csvFile']['name'];
        $lines = file($uploadedFile);

        if ($lines === false) {
            echo "<p class='error'>Erro ao ler o arquivo.</p>";
            exit;
        }

        $chunks = array_chunk($lines, 30);
        $zip = new ZipArchive();
        $zipFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . "_parts.zip";

        if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
            echo "<p class='error'>Não foi possível criar o arquivo zip.</p>";
            exit;
        }

        $fileCount = 1;
        foreach ($chunks as $chunk) {
            $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . "_part$fileCount.csv";
            $fileContent = implode("", $chunk);

            // Adiciona o conteúdo ao arquivo zip
            $zip->addFromString($newFileName, $fileContent);
            $fileCount++;
        }

        $zip->close();

        // Envia o arquivo zip para o navegador para download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
        header('Content-Length: ' . filesize($zipFileName));
        readfile($zipFileName);

        // Remove o arquivo zip temporário após o envio
        unlink($zipFileName);
    } else {
        echo "<p class='error'>Erro ao fazer upload do arquivo.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload e Divisão de Arquivo CSV</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="file"] {
            display: block;
            margin: 10px auto 20px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Divisor de Arquivo CSV</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="csvFile">Selecione um arquivo CSV para upload:</label>
            <input type="file" name="csvFile" id="csvFile" accept=".csv">
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>