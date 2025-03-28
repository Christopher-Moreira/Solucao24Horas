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
    </style>
    <script>
        function showLoading() {
            document.querySelector('.loading').style.display = 'block';
        }
    </script>
</head>

<body>
    <h1>Solução 24 Horas - Geração das Carteiras</h1>
    <p>Por favor, insira um arquivo CSV para realizar o agrupamento dos dados em carteiras.</p>

    <div class="form-container">
        <!-- Formulário para upload do arquivo -->
        <form action="" method="post" enctype="multipart/form-data" onsubmit="showLoading()">
            <label for="arquivo">Escolha um arquivo CSV:</label>
            <input type="file" name="arquivo" id="arquivo" accept=".csv" required>
            <button type="submit" name="submit">Upload</button>
        </form>
    </div>

    <!-- Animação de carregamento -->
    <div class="loading">
        <div class="spinner"></div> Processando...
    </div>

    <div class="result-container">
        <?php
         $host = 'localhost'; // ou o endereço do seu servidor
         $db = 'sol60829_leads'; // substitua pelo nome do seu banco
         $user = 'sol60829_leads'; // substitua pelo seu usuário do banco
         $pass = '._yaSq]uGNc/8k]('; // substitua pela sua senha do banco
         $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
       }
        if (isset($_POST['submit'])) {

            // Verifica se o arquivo foi enviado sem erros
            if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {

                $arquivoTmp = $_FILES['arquivo']['tmp_name'];

                // Abre o arquivo para leitura
                if (($handle = fopen($arquivoTmp, 'r')) !== false) {

                    // Lê a primeira linha para identificar as colunas
                    $cabecalho = fgetcsv($handle, 1000, ',');

                    // Verifica se há pelo menos 6 colunas
                    if (count($cabecalho) < 6) {

                        echo "<p style='color: red;'>Erro: O arquivo CSV deve ter pelo menos 6 colunas.</p>";

                    } else {

                        $dadosCarteira = [];

                        // Lê os valores da 1ª posição (CPF) e da 6ª posição e armazena em um array
                        while (($dados = fgetcsv($handle, 1000, ',')) !== false) {
                            if (isset($dados[0]) && isset($dados[5])) {
                                $dadosCarteira[] = [
                                    'cpf' => htmlspecialchars($dados[0]),
                                    'nome' => htmlspecialchars($dados[5])
                                ];
                            }
                        }

                        // Fecha o arquivo
                        fclose($handle);

                        // Exibe os dados em carteiras de 100 em 100
                        $totalDados = count($dadosCarteira);
                        $carteira = 1;
                        $dataAtual = date("Y-m-d"); // Captura a data atual no formato "YYYY-MM-DD"
        
                        echo "<h3>Carteiras de Dados:</h3>";
                        
                        for ($i = 0; $i < $totalDados; $i += 150) {
                               $dados=[];
                            // Concatena o nome da carteira e a data atual em uma única variável
                            $cabecalhoCarteira = "Carteira {$carteira} - {$dataAtual}";


                            $host = 'localhost'; // ou o endereço do seu servidor
                            $db = 'sol60829_leads'; // substitua pelo nome do seu banco
                            $user = 'sol60829_leads'; // substitua pelo seu usuário do banco
                            $pass = '._yaSq]uGNc/8k]('; // substitua pela sua senha do banco
                            $conn1 = new mysqli($host, $user, $pass, $db);
                            $carteira = "INSERT INTO carteira( responsavel_id, flag_ativo, nome) VALUES (1,1,'$cabecalhoCarteira')";
                            if ($conn1->query($carteira) === TRUE) {
                                echo "Registro inserido com sucesso!";
                            } else {
                                echo "Erro ao inserir: " . $conn1->error;
                            }
                            $conn1->close();


                            // Exibe o cabeçalho da carteira
                            echo "<h4>{$cabecalhoCarteira}</h4><ul>";

                            // Imprime até 100 dados por carteira
                            for ($j = $i; $j < $i + 150 && $j < $totalDados; $j++) {
                                echo "<li><strong>CPF:</strong> " . $dadosCarteira[$j]['cpf'] . " | <strong>nome:</strong> " . $dadosCarteira[$j]['nome'] . "</li>";
                                echo $cpfLimpo = str_replace('.', '', $dadosCarteira[$j]['cpf']);
                                echo $dadosCarteira[$j]['nome'];
                                echo $nome = $dadosCarteira[$j]['nome'];
                                $resultado = array("Lista de dados");
                                header('Content-type: application/json; charset=utf-8');
                                $nomeFULL = '{"nome":"' . $nome . '"}';
                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                                curl_setopt_array(
                                    $curl,
                                    array(
                                        CURLOPT_URL => 'https://paineljob.com.br/api/v2/api_dados_nome.php',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'POST',
                                        CURLOPT_POSTFIELDS => $nomeFULL,
                                        CURLOPT_HTTPHEADER => array(
                                            'Content-Type: application/json',
                                            'Authorization: Bearer TVRNeE5USXdNalF0TVRBdE1qUWdNakU2TVRBNk1UYzJOSFpxTm1oM2JRPT0yMDI0MTAyODE1MjQwOEhSWU9tdHhHNWpsS2dTdTY='
                                        ),
                                    )
                                );
                                $response = curl_exec($curl);
                                $data = json_decode($response, true);
                                curl_close($curl);
                                // Verifica se a decodificação foi bem-sucedida
                                if ($data !== null) {
                                    // Itera sobre os itens no array "RETORNO"
                                 
                                    foreach ($data['RETORNO'] as $item) {
                                        // Verifica se o campo "DOCUMENTO" existe no item
                                        if (isset($item['DOCUMENTO'])) {
                                            // Imprime o campo "DOCUMENTO"
                                            //    echo "DOCUMENTO: " . $item['DOCUMENTO'] . "<br>";
        
                                            // Corrigido para capturar a substring corretamente
                                            $documento = $item['DOCUMENTO'];
                                            
                                            $substring = substr($documento, 3, 6); // Captura a substring do índice 4 com comprimento 6
        
                                           if ($substring === $dadosCarteira[$j]['cpf']) {
                                                // é aqui que chamo o resto da integração.
                                             $dados[] = array("dado" => $documento, "tipo" => "PF");
                                             break;
                                               
                                           }
        
                                        
                                        }
                                    }
                                 
                                    
                                } else {
                                    echo 'Erro ao decodificar JSON.';
                                }


                            }
                        $dadosBulk = json_encode(array("bulk" => $dados));
                         /*Alteração Bulk*/
                        

                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                            curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://paineljob.com.br/api/v2/api_dados_bulk.php',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => $dadosBulk, // Agora é uma string JSON válida
                            CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: Bearer TVRNeE5USXdNalF0TVRBdE1qUWdNakU2TVRBNk1UYzJOSFpxTm1oM2JRPT0yMDI0MTAyODE1MjQwOEhSWU9tdHhHNWpsS2dTdTY='
                            ),
                            ));

                            $response = curl_exec($curl);
                            curl_close($curl);
                           // echo $response;
                            $data = json_decode($response, true);
                            $id_lote_retorno = $data['RETORNO']['id_lote_consulta'];
                            
                            
                            $host = 'localhost'; // ou o endereço do seu servidor
                            $db = 'sol60829_leads'; // substitua pelo nome do seu banco
                            $user = 'sol60829_leads'; // substitua pelo seu usuário do banco
                            $pass = '._yaSq]uGNc/8k]('; // substitua pela sua senha do banco
                            $conn1 = new mysqli($host, $user, $pass, $db);
                            $carteira = "INSERT INTO consulta_api( id_lote_consulta) VALUES ('$id_lote_retorno')";
                            if ($conn1->query($carteira) === TRUE) {
                                echo '<div style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; margin-top: 20px;">
                                            <strong>Registro inserido com sucesso!</strong><br>
                                            Aguarde o processamento do lote pela API do InfoQuali!
                                            </div>';
                            } else {
                                echo "Erro ao inserir: " . $conn1->error;
                            }
                            $conn1->close();


                         /*Fim ALteração Bulk*/
                         
                         
                         
                         
                         
                                    
                        echo "</ul>";

                        $carteira++;
                        }

                    }

                } else {
                    echo "<p style='color: red;'>Erro: Não foi possível abrir o arquivo.</p>";
                }

            } else {
                echo "<p style='color: red;'>Erro: Problema no upload do arquivo.</p>";
            }

        }
     $conn->close();    ?>
    </div>
</body>

</html>