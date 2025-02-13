<?php
// Dados de conexão com o banco de dados
$host = 'localhost'; // ou o endereço do seu servidor
$db = 'sol60829_leads'; // substitua pelo nome do seu banco
$user = 'sol60829_leads'; // substitua pelo seu usuário do banco
$pass = '._yaSq]uGNc/8k]('; // substitua pela sua senha do banco

// Variável CPF que será usada na busca
$cpf_informado = '70312672934'; // Altere para o CPF desejado

try {
    // Conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query para buscar os dados onde o CPF é igual ao informado
    $query = "SELECT celular,flag_whatsapp FROM `celulares` WHERE cpf=:cpf";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':cpf', $cpf_informado);
    $stmt->execute();

    // Vetor para armazenar os resultados
    $dados = [];

    // Loop para adicionar os resultados no vetor
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dados[] = [
            'celular' => $row['celular'],
            'flag_whatsapp' => $row['flag_whatsapp']
        ];
    }

    // Exibe os dados em uma tabela HTML
    if (!empty($dados)) {
        echo "<table border='1'>";
        echo "<tr><th>Celular</th><th>WhatsApp</th></tr>";

        foreach ($dados as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['celular']) . "</td>";
            echo "<td>" . ($row['flag_whatsapp'] ? 'Sim' : 'Não') . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Nenhum resultado encontrado para o CPF informado.";
    }

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
