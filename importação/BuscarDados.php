<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Solução 24 Horas - Geração das Carteiras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            margin-top: 50px;
        }

        h1,
        h3 {
            color: #333;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            text-align: left;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        input[type="file"] {
            display: block;
            margin: 10px 0 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Estilo da animação de carregamento */
        .loading {
            display: none;
            margin-top: 20px;
        }

        .spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #4CAF50;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            display: inline-block;
            vertical-align: middle;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .result-container {
            margin-top: 20px;
            text-align: left;
        }

        h4 {
            color: #4CAF50;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #e0e0e0;
            margin: 5px 0;
            padding: 8px;
            border-radius: 5px;
        }

        .success-message {
            padding: 15px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-top: 20px;
            display: none; /* Inicialmente oculto */
        }
    </style>
    <script>
        function showLoading() {
            document.querySelector('.loading').style.display = 'block';
        }

        function showSuccessMessage() {
            document.querySelector('.success-message').style.display = 'block';
        }
    </script>
</head>

<body>
    <h1>Solução 24 Horas - Geração das Carteiras</h1>
    <p>Por favor, insira um arquivo CSV para realizar o agrupamento dos dados em carteiras.</p>


    <!-- Animação de carregamento -->
    <div class="loading">
        <div class="spinner"></div> Processando...
    </div>


        <h4>Consultas Pendentes</h4>
        <form action="executar_consultas.php" method="post">
            <ul>
                <?php
                // Conexão com o banco de dados
                // Exemplo com PDO
                $host = 'localhost'; // ou o endereço do seu servidor
                $db = 'sol60829_leads'; // substitua pelo nome do seu banco
                $user = 'sol60829_leads'; // substitua pelo seu usuário do banco
                $pass = '._yaSq]uGNc/8k]('; // substitua pela sua senha do banco
                $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 echo "aqui";
                // Consulta para obter os registros com flag_utilizado = 0
                $stmt = $conn->prepare("SELECT id,id_lote_consulta FROM consulta_api where flag_utilizado=0");
                $stmt->execute();
                $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // Exibir as consultas
                foreach ($consultas as $consulta) {
                    echo '<li>
                            <input type="checkbox" name="consultas[]" value="' . $consulta['id']. '"> 
                            Lote: ' . htmlspecialchars($consulta['id_lote_consulta']) . '
                          </li>';
                }
                ?>
            </ul>
            <button type="submit" name="executar">Executar Consultas Selecionadas</button>
        </form>
    </div>
</body>

</html>
