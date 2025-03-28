<?php
// Conexão com o banco de dados
try {
    $host = 'localhost'; // ou o endereço do seu servidor
                $db = 'sol60829_leads'; // substitua pelo nome do seu banco
                $user = 'sol60829_leads'; // substitua pelo seu usuário do banco
                $pass = '._yaSq]uGNc/8k]('; // substitua pela sua senha do banco
                $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se foram selecionadas consultas
    if (isset($_POST['consultas']) && is_array($_POST['consultas'])) {
        $consultas = $_POST['consultas'];

        // Loop para processar cada consulta selecionada
        foreach ($consultas as $id_consulta) {
            // Aqui você pode adicionar a lógica para processar cada consulta
            // Por exemplo, uma chamada a uma API ou outro processamento necessário






$dadosBulk = json_encode(array("user"=>"alextelocken@gmail.com","psw"=>"hivros@qujrop@2jezDo","id_lote_consulta"=>"y6IbRZ241102_114506"));

$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://paineljob.com.br/api/v2/api_dados_bulk_out.php',
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

$jsonData = curl_exec($curl);
curl_close($curl);


$data = json_decode($jsonData, true); // Decodifica o JSON em um array associativo

// Conexão com o banco de dados
try {
    // Laço para inserir cada lead na tabela lead_api
    foreach ($data['bulk'] as $lead) {
        // Prepare a consulta de inserção
        $stmt = $conn->prepare("INSERT INTO leads_api (
            CPF, NOME, RG, Escolaridade,
            data_nasc, idade, NOME_MAE, NOME_PAI, SEXO,
            cel_1, cel_2, cel_3, cel_4, cel_5, cel_6, cel_7, cel_8,
            cel_9, cel_10, fixo_1, fixo_2, fixo_3, fixo_4, fixo_5,
            fixo_6, fixo_7, fixo_8, fixo_9, fixo_10, Email_1, Email_2,
            Email_3, Email_4, Email_5, Email_6, Email_7, Email_8,
            Email_9, Email_10, end_tipo_logradouro_1, end_logradouro_1,
            end_num_1, end_complemento_1, end_bairro_1, end_cidade_1,
            end_estado_1, end_cep_1, end_tipo_logradouro_2, end_logradouro_2,
            end_num_2, end_complemento_2, end_bairro_2, end_cidade_2,
            end_estado_2, end_cep_2, end_tipo_logradouro_3, end_logradouro_3,
            end_num_3, end_complemento_3, end_bairro_3, end_cidade_3,
            end_estado_3, end_cep_3, end_tipo_logradouro_4, end_logradouro_4,
            end_num_4, end_complemento_4, end_bairro_4, end_cidade_4,
            end_estado_4, end_cep_4, end_tipo_logradouro_5, end_logradouro_5,
            end_num_5, end_complemento_5, end_bairro_5, end_cidade_5,
            end_estado_5, end_cep_5
        ) VALUES (
            :cpf, :nome,:rg, :escolaridade,
            :dataNasc, :idade, :nomeMae, :nomePai, :sexo, 
            :cel1, :cel2, :cel3, :cel4, :cel5, :cel6, :cel7, :cel8,
            :cel9, :cel10, :fixo1, :fixo2, :fixo3, :fixo4, :fixo5,
            :fixo6, :fixo7, :fixo8, :fixo9, :fixo10, :email1, :email2,
            :email3, :email4, :email5, :email6, :email7, :email8,
            :email9, :email10, :endTipoLogradouro1, :endLogradouro1,
            :endNum1, :endComplemento1, :endBairro1, :endCidade1,
            :endEstado1, :endCep1, :endTipoLogradouro2, :endLogradouro2,
            :endNum2, :endComplemento2, :endBairro2, :endCidade2,
            :endEstado2, :endCep2, :endTipoLogradouro3, :endLogradouro3,
            :endNum3, :endComplemento3, :endBairro3, :endCidade3,
            :endEstado3, :endCep3, :endTipoLogradouro4, :endLogradouro4,
            :endNum4, :endComplemento4, :endBairro4, :endCidade4,
            :endEstado4, :endCep4, :endTipoLogradouro5, :endLogradouro5,
            :endNum5, :endComplemento5, :endBairro5, :endCidade5,
            :endEstado5, :endCep5
        )");

        // Bind dos parâmetros
        $stmt->bindParam(':cpf', $lead['CPF']);
        $stmt->bindParam(':nome', $lead['NOME']);
        $stmt->bindParam(':rg', $lead['RG']);
        $stmt->bindParam(':escolaridade', $lead['Escolaridade']);
        $stmt->bindParam(':dataNasc', $lead['DataNasc']);
        $stmt->bindParam(':idade', $lead['idade']);
        $stmt->bindParam(':nomeMae', $lead['NOME_MAE']);
        $stmt->bindParam(':nomePai', $lead['NOME_PAI']);
        $stmt->bindParam(':sexo', $lead['SEXO']);
        $stmt->bindParam(':cel1', $lead['cel_1']);
        $stmt->bindParam(':cel2', $lead['cel_2']);
        $stmt->bindParam(':cel3', $lead['cel_3']);
        $stmt->bindParam(':cel4', $lead['cel_4']);
        $stmt->bindParam(':cel5', $lead['cel_5']);
        $stmt->bindParam(':cel6', $lead['cel_6']);
        $stmt->bindParam(':cel7', $lead['cel_7']);
        $stmt->bindParam(':cel8', $lead['cel_8']);
        $stmt->bindParam(':cel9', $lead['cel_9']);
        $stmt->bindParam(':cel10', $lead['cel_10']);
        $stmt->bindParam(':fixo1', $lead['fixo_1']);
        $stmt->bindParam(':fixo2', $lead['fixo_2']);
        $stmt->bindParam(':fixo3', $lead['fixo_3']);
        $stmt->bindParam(':fixo4', $lead['fixo_4']);
        $stmt->bindParam(':fixo5', $lead['fixo_5']);
        $stmt->bindParam(':fixo6', $lead['fixo_6']);
        $stmt->bindParam(':fixo7', $lead['fixo_7']);
        $stmt->bindParam(':fixo8', $lead['fixo_8']);
        $stmt->bindParam(':fixo9', $lead['fixo_9']);
        $stmt->bindParam(':fixo10', $lead['fixo_10']);
        $stmt->bindParam(':email1', $lead['Email_1']);
        $stmt->bindParam(':email2', $lead['Email_2']);
        $stmt->bindParam(':email3', $lead['Email_3']);
        $stmt->bindParam(':email4', $lead['Email_4']);
        $stmt->bindParam(':email5', $lead['Email_5']);
        $stmt->bindParam(':email6', $lead['Email_6']);
        $stmt->bindParam(':email7', $lead['Email_7']);
        $stmt->bindParam(':email8', $lead['Email_8']);
        $stmt->bindParam(':email9', $lead['Email_9']);
        $stmt->bindParam(':email10', $lead['Email_10']);
        $stmt->bindParam(':endTipoLogradouro1', $lead['end_tipo_logradouro_1']);
        $stmt->bindParam(':endLogradouro1', $lead['end_logradouro_1']);
        $stmt->bindParam(':endNum1', $lead['end_num_1']);
        $stmt->bindParam(':endComplemento1', $lead['end_complemento_1']);
        $stmt->bindParam(':endBairro1', $lead['end_bairro_1']);
        $stmt->bindParam(':endCidade1', $lead['end_cidade_1']);
        $stmt->bindParam(':endEstado1', $lead['end_estado_1']);
        $stmt->bindParam(':endCep1', $lead['end_cep_1']);
        $stmt->bindParam(':endTipoLogradouro2', $lead['end_tipo_logradouro_2']);
        $stmt->bindParam(':endLogradouro2', $lead['end_logradouro_2']);
        $stmt->bindParam(':endNum2', $lead['end_num_2']);
        $stmt->bindParam(':endComplemento2', $lead['end_complemento_2']);
        $stmt->bindParam(':endBairro2', $lead['end_bairro_2']);
        $stmt->bindParam(':endCidade2', $lead['end_cidade_2']);
        $stmt->bindParam(':endEstado2', $lead['end_estado_2']);
        $stmt->bindParam(':endCep2', $lead['end_cep_2']);
        $stmt->bindParam(':endTipoLogradouro3', $lead['end_tipo_logradouro_3']);
        $stmt->bindParam(':endLogradouro3', $lead['end_logradouro_3']);
        $stmt->bindParam(':endNum3', $lead['end_num_3']);
        $stmt->bindParam(':endComplemento3', $lead['end_complemento_3']);
        $stmt->bindParam(':endBairro3', $lead['end_bairro_3']);
        $stmt->bindParam(':endCidade3', $lead['end_cidade_3']);
        $stmt->bindParam(':endEstado3', $lead['end_estado_3']);
        $stmt->bindParam(':endCep3', $lead['end_cep_3']);
        $stmt->bindParam(':endTipoLogradouro4', $lead['end_tipo_logradouro_4']);
        $stmt->bindParam(':endLogradouro4', $lead['end_logradouro_4']);
        $stmt->bindParam(':endNum4', $lead['end_num_4']);
        $stmt->bindParam(':endComplemento4', $lead['end_complemento_4']);
        $stmt->bindParam(':endBairro4', $lead['end_bairro_4']);
        $stmt->bindParam(':endCidade4', $lead['end_cidade_4']);
        $stmt->bindParam(':endEstado4', $lead['end_estado_4']);
        $stmt->bindParam(':endCep4', $lead['end_cep_4']);
        $stmt->bindParam(':endTipoLogradouro5', $lead['end_tipo_logradouro_5']);
        $stmt->bindParam(':endLogradouro5', $lead['end_logradouro_5']);
        $stmt->bindParam(':endNum5', $lead['end_num_5']);
        $stmt->bindParam(':endComplemento5', $lead['end_complemento_5']);
        $stmt->bindParam(':endBairro5', $lead['end_bairro_5']);
        $stmt->bindParam(':endCidade5', $lead['end_cidade_5']);
        $stmt->bindParam(':endEstado5', $lead['end_estado_5']);
        $stmt->bindParam(':endCep5', $lead['end_cep_5']);

        // Executa a consulta
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratar erro de inserção
            echo 'Erro ao inserir o lead: ' . $e->getMessage();
        }
    }

    echo "Todos os leads foram inseridos com sucesso.";
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
}

        

            // Para o exemplo, vamos apenas marcar como utilizado
            $updateStmt = $conn->prepare("UPDATE consulta_api SET flag_utilizado = 1 WHERE id = ?");
            $updateStmt->execute([$id_consulta]);
        }

        echo '<div style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; margin-top: 20px;">
                <strong>Consultas executadas com sucesso!</strong><br>
                As consultas selecionadas foram marcadas como utilizadas.
              </div>';
    } else {
        echo '<div style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin-top: 20px;">
                <strong>Erro!</strong><br>
                Nenhuma consulta foi selecionada para execução.
              </div>';
    }
} catch (PDOException $e) {
    echo '<div style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin-top: 20px;">
            <strong>Erro de conexão!</strong><br>
            ' . htmlspecialchars($e->getMessage()) . '
          </div>';
}
?>
