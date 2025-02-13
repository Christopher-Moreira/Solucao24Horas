<?php
// Conexão com o banco de dados
$host = 'localhost'; // ou o endereço do seu servidor
$db = 'sol60829_leads'; // substitua pelo nome do seu banco
$user = 'sol60829_leads'; // substitua pelo seu usuário do banco
$pass = '._yaSq]uGNc/8k]('; // substitua pela sua senha do banco

$nomes = array("31916708072");
$resultado = array("Lista de dados");
header('Content-type: application/json; charset=utf-8');

foreach ($nomes as $nome) {
    $conn = new mysqli($host, $user, $pass, $db);
  
echo "aqui";
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

    $nomeFULL = '{"doc":"' . $nome . '"}';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://paineljob.com.br/api/v2/api_dados_pf.php',
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
    ));

    $response = curl_exec($curl);
   $resultado[] = $response; // Corrigido para $resultado
    curl_close($curl);


// Extraindo os dados necessários
foreach ($resultado as $response) {
    $person = json_decode($response, true)['RETORNO'][1] ?? null;
    if ($person) {
        $nome = $conn->real_escape_string($person['NOME'] ?? 'Não encontrado');
        $cpf = $conn->real_escape_string($person['CPF'] ?? 'Não encontrado');
        $idade = $conn->real_escape_string($person['idade'] ?? 'Não encontrado');
        $dataNasc = $conn->real_escape_string($person['DataNasc'] ?? 'Não encontrado');
        $rg = $conn->real_escape_string($person['RG']?? 0);

//////////////////////////////////////////////
/////////////////ENDEREÇO//////////////////////
//////////////////////////////////////////////
$jsonString = $response;
$data = json_decode($jsonString, true); // Decodificando o JSON
$enderecos = []; // Inicializando um array para armazenar os endereços
foreach ($data['RETORNO'] as $consulta) {
    // Verificando se a chave 'ENDERECOS' existe
    if (isset($consulta['ENDERECOS'])) {
        $enderecos = $consulta['ENDERECOS']; // Armazenando os endereços
        break; // Para sair do loop após encontrar os endereços
    }
}

if (!empty($enderecos)) {
    foreach ($enderecos as $endereco) {
		$lgrNome=$endereco['LOGR_NOME'];
		$lgrNumero=$endereco['LOGR_NUMERO'];
		$bairro= $endereco['BAIRRO'];
		$cidade= $endereco['CIDADE'];
		$uf=$endereco['UF'];
		$cep=$endereco['CEP'];
       $sqlendereco = "INSERT INTO enderecos( cpf, lgr_numero, lgr_nome, bairro, cidade, uf, cep) VALUES($cpf,$lgrNumero, '$lgrNome', '$bairro', '$cidade', '$uf', $cep)";
	       if ($conn->query($sqlendereco) === TRUE) {
             echo "Registro inserido com sucesso!";
            } else {
             echo "Erro ao inserir: " . $conn->error;
        }
    }
} else {
    echo "Nenhum endereço encontrado.\n";
}
//////////////////////////////////////////////
/////////////////CELULAR//////////////////////
//////////////////////////////////////////////
$jsonString = $response;
$data = json_decode($jsonString, true); // Decodificando o JSON
$celular = []; // Inicializando um array para armazenar os endereços

foreach ($data['RETORNO'] as $consulta) {
    // Verificando se a chave 'ENDERECOS' existe
    if (isset($consulta['CELULAR'])) {
        $celular = $consulta['CELULAR']; // Armazenando os endereços
        break; // Para sair do loop após encontrar os endereços
    }
}

if (!empty($celular)) {
    foreach ($celular as $celular) {
		$celularsql= $celular['CELULAR'] ;
		$flgWhatsApp=$celular['flg_WhatsAPP'];
		$sqlcelular = "INSERT INTO celulares( cpf, celular, flag_whatsapp) VALUES($cpf, $celularsql, $flgWhatsApp)";
	       if ($conn->query($sqlendereco) === TRUE) {
             echo "Registro inserido com sucesso!";
            } else {
             echo "Erro ao inserir: " . $conn->error;
        }
    }
} else {
    echo "Nenhum celular encontrado.\n";
}
//////////////////////////////////////////////
/////////////////TELEFONE//////////////////////
//////////////////////////////////////////////
$jsonString = $response;
$data = json_decode($jsonString, true); // Decodificando o JSON
$dados = []; // Inicializando um array para armazenar os endereços

foreach ($data['RETORNO'] as $consulta) {
    // Verificando se a chave 'ENDERECOS' existe
    if (isset($consulta['TELEFONE_FIXO'])) {
        $dados = $consulta['TELEFONE_FIXO']; // Armazenando os endereços
        break; // Para sair do loop após encontrar os endereços
    }
}

if (!empty($dados)) {
    foreach ($dados as $dados) {
		$telefoneFixo= $dados['TELEFONE'] ;
	$sqltelefone = "INSERT INTO telefone_fixo(cpf,telefone_fixo)values($cpf, $telefoneFixo)";
	       if ($conn->query($sqltelefone) === TRUE) {
             echo "Registro inserido com sucesso!";
            } else {
             echo "Erro ao inserir: " . $conn->error;
        }
    }
} else {
    echo "Nenhum telefone encontrado.\n";
}
//////////////////////////////////////////////
//////////////////////////////////////////////
/////////////////EMAIL//////////////////////
//////////////////////////////////////////////
$jsonString = $response;
$data = json_decode($jsonString, true); // Decodificando o JSON
$dados = []; // Inicializando um array para armazenar os endereços

foreach ($data['RETORNO'] as $consulta) {
    if (isset($consulta['EMAIL'])) {
        $dados = $consulta['EMAIL']; // Armazenando os endereços
        break; // Para sair do loop após encontrar os endereços
    }
}

if (!empty($dados)) {
    foreach ($dados as $dados) {
		$email= $dados['EMAIL'] ;
	echo	$sqlemail = "INSERT INTO emails(cpf,email)values($cpf, '$email')";
	       if ($conn->query($sqlemail) === TRUE) {
             echo "Registro inserido com sucesso!";
            } else {
             echo "Erro ao inserir: " . $conn->error;
        }
    }
} else {
    echo "Nenhum email encontrado.\n";
}
//////////////////////////////////////////////
	$nome= $nome ?? '';
	$cpf= $cpf ?? '';
	$idade= $idade ?? 0;
	if($idade=='')
		$idade=0;
	$dataNasc= $dataNasc ?? '';
	$celularsql= $celularsql ?? '';
	$flgWhatsApp= $flgWhatsApp ?? 0;
	if($flgWhatsApp=='')
		$flgWhatsApp=0;
	$telefoneFixo= $telefoneFixo ?? '';
	$email= $email ?? '';
	$lgrNumero= $lgrNumero ?? '';
	$lgrNome= $lgrNome ?? '';
	$bairro= $bairro ?? '';
	$cidade= $cidade ?? '';
	$uf= $uf ?? '';
	$cep= $cep ?? '';
	if($rg=='')
	$rg=0;
	if(is_string($rg))
		$rg=0;
	
        // Preparando a consulta SQL
      $sql = "INSERT INTO leads_api (nome, cpf, idade, data_nasc, celular, flg_whatsapp, telefone_fixo, email, lgr_numero, lgr_nome, bairro, cidade, uf, cep,rg) 
                VALUES ('$nome', '$cpf', '$idade', '$dataNasc', '$celularsql', $flgWhatsApp, '$telefoneFixo', '$email', '$lgrNumero', '$lgrNome', '$bairro', '$cidade', '$uf', '$cep',$rg)";
        // Executando a consulta
        if ($conn->query($sql) === TRUE) {
            echo "Registro inserido com sucesso!";
        } else {
            echo "Erro ao inserir: " . $conn->error;
        }
    } 
}
 
$conn->close();
}
// Fechando a conexão

?>