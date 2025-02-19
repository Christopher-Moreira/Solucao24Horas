<?php

use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Form\THtmlEditor;
use Adianti\Widget\Wrapper\TDBRadioGroup;
use Adianti\Wrapper\BootstrapFormBuilder;


class Mestre_DetalheTeste extends TPage {

    private $form; // form de Dados Pessoais
    private $formVinculos; // form de Vínculos
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'api';
    private static $activeRecord = 'Leads';
    private static $primaryKey = 'id';
    private static $formName = 'Mestre_DetalheTeste';
    private $showMethods = ['onReload', 'onSearch'];
    private $limit = 20;

    public function __construct($param) {
        parent::__construct();

        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->setId(__CLASS__.'_datagrid');
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);

        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);


        $notebook = new TNotebook('Leads');
        
        $column_id = new TDataGridColumn('id', "ID", 'left');
        $column_cpf = new TDataGridColumn('cpf', "Cpf", 'left');
        $column_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_carteira_id = new TDataGridColumn('carteira_id', 'Carteira ID', 'left');
        $column_flag_ativo = new TDataGridColumn('flag_ativo', "Ativo", 'left');
        $column_flag_ativo->setTransformer(function($value, $object) {
            return $object->flag_descontinuar == 0 ? 'Sim' : 'Não';
        });

        $order_id_servidor_portal = new TAction(array($this, 'onReload'));
        $order_id_servidor_portal->setParameter('order', 'id_servidor_portal');
        
            $this->datagrid->addcolumn($column_id);
            $this->datagrid->addColumn($column_cpf);
            $this->datagrid->addColumn($column_nome);
            $this->datagrid->addColumn($column_carteira_id);
            $this->datagrid->addColumn($column_flag_ativo);

            $this->datagrid->style = 'width: 100%;';
$this->datagrid->setHeight(320);

// Adiciona um contêiner para a barra de rolagem
$scrollContainer = new TElement('div');
$scrollContainer->style = 'height: 750px; overflow-y: auto;'; // Define a altura e a rolagem

// Adiciona a datagrid ao contêiner
$scrollContainer->add($this->datagrid);

// Adiciona a datagrid com rolagem ao notebook
$notebook->appendPage('Listagem da Carteira', $scrollContainer);

      

        $action_onEdit = new TDataGridAction(array('Mestre_DetalheTeste', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Vizualizar");
        $action_onEdit->setImage('far:eye #48c48c');
        $action_onEdit->setField('id');
        $action_onEdit->setParameter('responsavel_id', $param['responsavel_id']); 
        $action_onEdit->setParameter('cpf', '{cpf}');
        
        

        $this->datagrid->addAction($action_onEdit);

        $this->datagrid->createModel();

     

        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setFormTitle('Dados Pessoais');

        
            $notebook2 = new TNotebook('leads');
            // Campos para dados pessoais
                $nome = new TEntry('nome');
                    $nome->setEditable(false);
                    $nome->setMaxLength(14);
                    $nome->setSize('60%');


                $cpf = new TEntry('cpf');
                    $cpf->setEditable(false);
                    $cpf->setMaxLength(14);
                    $cpf->setSize('60%');


                $email = new TEntry('email');
                    $email->setEditable(false);
                    $email->setMaxLength(14);
                    $email->setSize('60%');


                $parentesco_nome = new TEntry ('parentesco_nome');
                    $parentesco_nome->setEditable(false);
                    $parentesco_nome->setMaxLength(14);
                    $parentesco_nome->setSize('60%');

                $nasc = new TEntry('data_nasc');
                    $nasc->setEditable(false);
                    $nasc->setMaxLength(14);
                    $nasc->setSize('60%');

                    $rg = new TEntry('rg');
                        $rg->setEditable(false);
                        $rg->setMaxLength(100);
                        $rg->setSize('60%');

                $telefone = new TEntry('telefone');
                    $telefone->setEditable(false);
                    $telefone->setMaxLength(14);
                    $telefone->setSize('60%');
            
                // Adicionando campos ao formulário de Dados Pessoais
                $this->form->addFields([new TLabel('Nome:')], [$nome]);
                $this->form->addFields([new TLabel('CPF:')], [$cpf]);
                $this->form->addFields([new TLabel('Email:')], [$email]);
                //$this->form->addFields([new TLabel('Número:')], [$telefone]);
                $this->form->addFields([new TLabel('Data de Nascimento:')], [$nasc]);
                $this->form->addFields([new TLabel('RG:')], [$rg]);

                $cpfValue = isset($param['cpf']) ? $param['cpf'] : null;
                
                try {
                    TTransaction::open('api'); // Substitua 'api' pelo nome da sua conexão configurada no Adianti

                    // Consulta para obter os dados do endereço baseado no CPF
                    $sql = "SELECT email FROM emails WHERE cpf = :cpf";
                    $conn = TTransaction::get(); // Obtém a conexão ativa
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([':cpf' => $cpfValue]);

                    // Se o registro existir, preenche os campos
                    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                       
                      $email->setValue($row['email']);
                    }

                    TTransaction::close(); // Fecha a transação
                } catch (Exception $e) {
                    // Em caso de erro, exibe a mensagem e desfaz a transação
                    new TMessage('error', $e->getMessage());
                    TTransaction::rollback();
                }

                $notebook2->appendPage('Dados Pessoais', $this->form);


        

    

                $this->formContato = new BootstrapFormBuilder('formContato');
                $this->formContato->setFormTitle('Contato');
    
                    /*$obs = new THtmlEditor('observacoes');
                    $obs->setSize('100%', height:'100');*/
    
    
                    $primeiro_contato =  new TEntry('data_do_contato');
                        $primeiro_contato->setEditable(false);
                        $primeiro_contato->setMaxLength(14);
                        $primeiro_contato->setSize('60%');
    
                    $proximo_contato = new TEntry('proximo_contato');
                        $proximo_contato->setEditable(false);
                        $proximo_contato->setMaxLength(14);
                        $proximo_contato->setSize('60%');
    
                    
    
    
                   // $this->formContato->addFields([new TLabel('Observação:')], [$obs]);
                    //$this->formContato->addContent([new TElement('br')]);
                    $this->formContato->addFields([new TLabel('Primeiro Contato')], [$primeiro_contato]);
                    $this->formContato->addFields([new TLabel('Próximo Contato')], [$proximo_contato]);
    
                    $btn_contato = $this->formContato->addAction("Fazer anotação", new TAction(['ContatoObservacaoForm', 'onShow']), 'fas:save #ffffff');
                    $this->btn_contato = $btn_contato;
                    $btn_contato->addStyleClass('btn-success');
                    $btn_contato->style = 'background-color: #48c48c; color: white;';

                    $btn_flag = $this->formContato->addAction("<i class='fas fa-user'></i> Continuar Contato?", new TAction(['Mestre_DetalheFlag', 'onShow']), '#ffffff');
                    $this->btn_flag = $btn_flag;
                    $btn_flag->addStyleClass('btn-success');
                    $btn_flag->style = 'background-color: #48c48c; color: white;';
    
    
    
            $notebook2->appendPage('Contato', $this->formContato);
    
    
                $this->formCargo = new BootstrapFormBuilder('formCargo');
                $this->formCargo->setFormTitle('LeadsGov');
    
                    $cargo = new TEntry('descricao_cargo');
                        $cargo->setEditable(false);
                        $cargo->setMaxLength(14);
                        $cargo->setSize('60%');
    
    
                    $ano_ingresso = new TEntry('ano_ingresso');
                        $ano_ingresso->setEditable(false);
                        $ano_ingresso->setMaxLength(14);
                        $ano_ingresso->setSize('60%');
    
                    $ano_aposentadoria = new TEntry('ano_aposentadoria');
                        $ano_aposentadoria->setEditable(false);
                        $ano_aposentadoria->setMaxLength(14);
                        $ano_aposentadoria->setSize('60%');
    
                    $jornada_de_trabalho = new TEntry('jornada_de_trabalho');
                        $jornada_de_trabalho->setEditable(false);
                        $jornada_de_trabalho->setMaxLength(14);
                        $jornada_de_trabalho->setSize('60%');
    
                    $org_lotacao = new TEntry('org_lotacao');
                        $org_lotacao->setEditable(false);
                        $org_lotacao->setMaxLength(14);
                        $org_lotacao->setSize('60%');
    
                    
    
    
                    $this->formCargo->addFields([new TLabel('Cargo:')], [$cargo]);
                    $this->formCargo->addFields([new TLabel('Ano de Ingresso:')], [$ano_ingresso]);
                    $this->formCargo->addFields([new TLabel('Ano de Aposentadoria:')], [$ano_aposentadoria]);
                    $this->formCargo->addFields([new TLabel('Jornada de Trabalho:')], [$jornada_de_trabalho]);
                    $this->formCargo->addFields([new TLabel('Lotação:')], [$org_lotacao]);
    

            $notebook2->appendPage('Cargo', $this->formCargo);
    
    
                $this->formRemuneracao = new BootstrapFormBuilder('formRemuneracao');
                $this->formRemuneracao->setFormTitle('Remuneração');
    
                $remuneracao_bruta = new TEntry('remuneracao_bruta');
                    $remuneracao_bruta->setEditable(false);
                    $remuneracao_bruta->setMaxLength(14);
                    $remuneracao_bruta->setSize('60%');
    
                
    
                $remuneracao_apos_deducoes = new TEntry('remuneracao_apos_deducoes');
                    $remuneracao_apos_deducoes->setEditable(false);
                    $remuneracao_apos_deducoes->setMaxLength(14);
                    $remuneracao_apos_deducoes->setSize('60%');
    
                    $this->formRemuneracao->addFields([new TLabel('Remuneração Bruta:')], [$remuneracao_bruta]);
                    $this->formRemuneracao->addFields([new TLabel('Remuneração Após Deduções:')], [$remuneracao_apos_deducoes]);
    
    
    
    
    
            $notebook2->appendPage('Remuneração', $this->formRemuneracao);
    
                /*$this->formEmail = new BootstrapFormBuilder('formEmail');
                $this->formEmail->setFormTitle('Email');
    
                $email = new TEntry('email');
                $email->setEditable(false);
                $email->setMaxLength(14);
                $email->setSize('60%');
    
                $this->formEmail->addFields([new TLabel('Email:')], [$email]);
    
            $notebook2->appendPage('Email', $this->formEmail);*/
    
               /* $this->formTelefone = new BootstrapFormBuilder('formTelefone');
                $this->formTelefone->setFormTitle('Telefone');
    
                $telefone = new TEntry('celular');
                $telefone->setEditable(false);
                $telefone->setMaxLength(14);
                $telefone->setSize('60%');
    
                $this->formTelefone->addFields([new TLabel('Telefone:')], [$telefone]);
    
            $notebook2->appendPage('Telefone', $this->formTelefone); */


              /*  $this->formTelefoneFixo = new BootstrapFormBuilder('formTelefoneFixo');
                $this->formTelefoneFixo->setFormTitle('Telefone Fixo');
    
                $telefone_fixo = new TEntry('telefone_fixo');
                $telefone_fixo->setEditable(false);
                $telefone_fixo->setMaxLength(14);
                $telefone_fixo->setSize('60%');
    
                $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo:')], [$telefone_fixo]); 
    
            $notebook2->appendPage('Telefone Fixo', $this->formTelefoneFixo);*/
    
    
            $this->formGov = new BootstrapFormBuilder('formGov');
            $this->formGov->setFormTitle('GOV');
    
            $orgsup_lotacao = new TEntry('orgsup_lotacao');
                $orgsup_lotacao->setEditable(false);
                $orgsup_lotacao->setMaxLength(14);
                $orgsup_lotacao->setSize('60%');
    
            $regime_juridico = new TEntry('regime_juridico');
                $regime_juridico->setEditable(false);
                $regime_juridico->setMaxLength(14);
                $regime_juridico->setSize('60%');
    
            $pensao_militar = new TEntry('pensao_militar');
                $pensao_militar->setEditable(false);
                $pensao_militar->setMaxLength(14);
                $pensao_militar->setSize('60%');
    
            $irrf = new TEntry('irrf');
                $irrf->setEditable(false);
                $irrf->setMaxLength(14);
                $irrf->setSize('60%');
    
            $fundo_de_saude = new TEntry('fundo_de_saude');
                $fundo_de_saude->setEditable(false);
                $fundo_de_saude->setMaxLength(14);
                $fundo_de_saude->setSize('60%');
    
            $verbas_indenizatorias = new TEntry('verbas_indenizatorias');
                $verbas_indenizatorias->setEditable(false);
                $verbas_indenizatorias->setMaxLength(14);
                $verbas_indenizatorias->setSize('60%');
    
            $situacao_vinculo = new TEntry('situacao_vinculo');
                $situacao_vinculo->setEditable(false);
                $situacao_vinculo->setMaxLength(14);
                $situacao_vinculo->setSize('60%');
    
            $tipo_aposentadoria = new TEntry('tipo_aposentadoria');
                $tipo_aposentadoria->setEditable(false);
                $tipo_aposentadoria->setMaxLength(14);
                $tipo_aposentadoria->setSize('60%');
    
            $tipo_vinculo = new TEntry('tipo_vinculo');
                $tipo_vinculo->setEditable(false);
                $tipo_vinculo->setMaxLength(14);
                $tipo_vinculo->setSize('60%');
    
            $uorg_lotacao = new TEntry('uorg_lotacao');
                $uorg_lotacao->setEditable(false);
                $uorg_lotacao->setMaxLength(14);
                $uorg_lotacao->setSize('60%');
            
            $ferias = new TEntry('ferias');
                $ferias->setEditable(false);
                $ferias->setMaxLength(14);
                $ferias->setSize('60%');
    
            $mes = new TEntry('mes');
                $mes ->setEditable(false);
                $mes ->setMaxLength(14);
                $mes ->setSize('60%');
    
                $this->formGov->addFields([new TLabel('Orgão Suporte Lotação:')], [$orgsup_lotacao]);
                $this->formGov->addFields([new TLabel('Regime Juridico:')], [$regime_juridico]);
                $this->formGov->addFields([new TLabel('Vinculo:')], [$situacao_vinculo]);
                $this->formGov->addFields([new TLabel('Tipo de Aposentadoria:')], [$tipo_aposentadoria]);
                $this->formGov->addFields([new TLabel('Tipo de Vinculo:')], [$tipo_vinculo]);
                $this->formGov->addFields([new TLabel('Uorg Lotação:')], [$uorg_lotacao]);
                $this->formGov->addFields([new TLabel('Ferias:')], [$ferias]);
                $this->formGov->addFields([new TLabel('Mês:')], [$mes]);
                $this->formGov->addFields([new TLabel('Pensão Militar:')], [$pensao_militar]);
                $this->formGov->addFields([new TLabel('IRRF:')], [$irrf]);
                $this->formGov->addFields([new TLabel('Fundo de Saúde:')], [$fundo_de_saude]);
                $this->formGov->addFields([new TLabel('Verbas indenizatorias:')], [$verbas_indenizatorias]);
    
        
            $notebook2->appendPage('GOV', $this->formGov);

             

            

                /*$formFlag = new BootstrapFormBuilder('formFlag');
                $formFlag->setFormTitle('Alterar Estado de Descontinuação');
            
                $lead_id = new TEntry('id');
                $lead_id->setEditable(false);
                $lead_id->setMaxLength(100);
                $lead_id->setSize('60%');
            


                $this->formOutros->addFields([new TLabel('id:')], [$lead_id]);*/

$this->formCelular = new BootstrapFormBuilder('formCelular');
$this->formCelular->setFormTitle('Celulares');

// Criação dos campos do formulário com base nas novas colunas


$celular1 = new TEntry('celular');
    $celular1->setMaxLength(10);
    $celular1->setSize('60%');
    $celular1->setEditable(false);

$celular2 = new TEntry('celular2');
    $celular2->setMaxLength(10);
    $celular2->setSize('60%');
    $celular2->setEditable(false);

$celular3 = new TEntry('celular3');
    $celular3->setMaxLength(10);
    $celular3->setSize('60%');
    $celular3->setEditable(false);

$celular4 = new TEntry('celular4');
    $celular4->setMaxLength(10);
    $celular4->setSize('60%');
    $celular4->setEditable(false);

$celular5 = new TEntry('celular5');
    $celular5->setMaxLength(10);
    $celular5->setSize('60%');
    $celular5->setEditable(false);
// Adicionando os campos ao formulário

$this->formCelular->addFields([new TLabel('Celular 1:')], [$celular1]);
$this->formCelular->addFields([new TLabel('Celular 2:')], [$celular2]);
$this->formCelular->addFields([new TLabel('Celular 3:')], [$celular3]);
$this->formCelular->addFields([new TLabel('Celular 4:')], [$celular4]);
$this->formCelular->addFields([new TLabel('Celular 5:')], [$celular5]);

// Carregando os dados do banco de dados
$cpfValue = isset($param['cpf']) ? $param['cpf'] : null;

$cpfValue = isset($param['cpf']) ? $param['cpf'] : null;

try {
    TTransaction::open('api'); // Substitua 'api' pelo nome da sua conexão configurada no Adianti

    // Consulta para obter os dados dos celulares baseado no CPF, ordenando
    $sql = "SELECT celular FROM celulares WHERE cpf = :cpf ORDER BY id"; // Supondo que você tenha um campo 'id' para ordenar
    $conn = TTransaction::get(); // Obtém a conexão ativa
    $stmt = $conn->prepare($sql); 
    $stmt->execute([':cpf' => $cpfValue]);

    // Inicializa um contador para preencher os campos
    $counter = 1;

    // Preenche os campos de celular
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($counter == 1) {
            $celular1->setValue($row['celular']);
        } elseif ($counter == 2) {
            $celular2->setValue($row['celular']);
        } elseif ($counter == 3) {
            $celular3->setValue($row['celular']);
        } elseif ($counter == 4) {
            $celular4->setValue($row['celular']);
        } elseif ($counter == 5) {
            $celular5->setValue($row['celular']);
        }
        $counter++;
    }

    TTransaction::close(); // Fecha a transação
} catch (Exception $e) {
    // Em caso de erro, exibe a mensagem e desfaz a transação
    new TMessage('error', $e->getMessage());
    TTransaction::rollback();
}


$notebook2->appendPage('Celulares', $this->formCelular);
        
//////////////////////////////////////////////////////////////////////////////////////////////////////
                
        

$this->formTelefone = new BootstrapFormBuilder('formTelefone');
$this->formTelefone->setFormTitle('Telefones Fixos');

// Criação dos campos do formulário com base nas novas colunas


$telefone_fixo1 = new TEntry('telefone_fixo');
    $telefone_fixo1->setMaxLength(10);
    $telefone_fixo1->setSize('60%');
    $telefone_fixo1->setEditable(false);

$telefone_fixo2 = new TEntry('telefone_fixo2');
    $telefone_fixo2->setMaxLength(10);
    $telefone_fixo2->setSize('60%');
    $telefone_fixo2->setEditable(false);

$telefone_fixo3 = new TEntry('telefone_fixo3');
    $telefone_fixo3->setMaxLength(10);
    $telefone_fixo3->setSize('60%');
    $telefone_fixo3->setEditable(false);

$telefone_fixo4 = new TEntry('telefone_fixo4');
    $telefone_fixo4->setMaxLength(10);
    $telefone_fixo4->setSize('60%');
    $telefone_fixo4->setEditable(false);

$telefone_fixo5 = new TEntry('telefone_fixo5');
    $telefone_fixo5->setMaxLength(10);
    $telefone_fixo5->setSize('60%');
    $telefone_fixo5->setEditable(false);
// Adicionando os campos ao formulário

$this->formTelefone->addFields([new TLabel('Telefone Fixo 1:')], [$telefone_fixo1]);
$this->formTelefone->addFields([new TLabel('Telefone Fixo 2:')], [$telefone_fixo2]);
$this->formTelefone->addFields([new TLabel('Telefone Fixo 3:')], [$telefone_fixo3]);
$this->formTelefone->addFields([new TLabel('Telefone Fixo 4:')], [$telefone_fixo4]);
$this->formTelefone->addFields([new TLabel('Telefone Fixo 5:')], [$telefone_fixo5]);

// Carregando os dados do banco de dados
$cpfValue = isset($param['cpf']) ? $param['cpf'] : null;


try {
    TTransaction::open('api'); // Substitua 'api' pelo nome da sua conexão configurada no Adianti

    // Consulta para obter os dados dos celulares baseado no CPF, ordenando
    $sql = "SELECT telefone_fixo FROM telefone_fixo WHERE cpf = :cpf ORDER BY id"; // Supondo que você tenha um campo 'id' para ordenar
    $conn = TTransaction::get(); // Obtém a conexão ativa
    $stmt = $conn->prepare($sql);
    $stmt->execute([':cpf' => $cpfValue]);

    // Inicializa um contador para preencher os campos
    $counter = 1;

    // Preenche os campos de celular
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($counter == 1) {
            $telefone_fixo1->setValue($row['telefone_fixo']);
        } elseif ($counter == 2) {
            $telefone_fixo2->setValue($row['telefone_fixo']);
        } elseif ($counter == 3) {
            $telefone_fixo3->setValue($row['telefone_fixo']);
        } elseif ($counter == 4) {
            $telefone_fixo4->setValue($row['telefone_fixo']);
        } elseif ($counter == 5) {
            $telefone_fixo5->setValue($row['telefone_fixo']);
        }
        $counter++;
    }

    TTransaction::close(); // Fecha a transação
} catch (Exception $e) {
    // Em caso de erro, exibe a mensagem e desfaz a transação
    new TMessage('error', $e->getMessage());
    TTransaction::rollback();
}


$notebook2->appendPage('Telefones Fixos', $this->formTelefone);

                
//////////////////////////////////////////////////////////////////////////////////////////////////////

             




$this->formEnderecos = new BootstrapFormBuilder('formEnderecos');
$this->formEnderecos->setFormTitle('Enderecos');

// Criação dos campos do formulário com base nas novas colunas


$lgr_numero = new TEntry('lgr_numero');
$lgr_numero->setMaxLength(10);
$lgr_numero->setSize('60%');
$lgr_numero->setEditable(false);

$lgr_nome = new TEntry('lgr_nome');
$lgr_nome->setMaxLength(50);
$lgr_nome->setSize('60%');
$lgr_nome->setEditable(false);

$bairro = new TEntry('bairro');
$bairro->setMaxLength(50);
$bairro->setSize('60%');
$bairro->setEditable(false);

$cidade = new TEntry('cidade');
$cidade->setMaxLength(50);
$cidade->setSize('60%');
$cidade->setEditable(false);

$uf = new TEntry('uf');
$uf->setMaxLength(2);
$uf->setSize('60%');
$uf->setEditable(false);

$cep = new TEntry('cep');
$cep->setMaxLength(10);
$cep->setSize('60%');
$cep->setEditable(false);

// Adicionando os campos ao formulário

$this->formEnderecos->addFields([new TLabel('Número da Logradouro:')], [$lgr_numero]);
$this->formEnderecos->addFields([new TLabel('Nome do Logradouro:')], [$lgr_nome]);
$this->formEnderecos->addFields([new TLabel('Bairro:')], [$bairro]);
$this->formEnderecos->addFields([new TLabel('Cidade:')], [$cidade]);
$this->formEnderecos->addFields([new TLabel('UF:')], [$uf]);
$this->formEnderecos->addFields([new TLabel('CEP:')], [$cep]);

// Carregando os dados do banco de dados
$cpfValue = isset($param['cpf']) ? $param['cpf'] : null;

try {
    TTransaction::open('api'); // Substitua 'api' pelo nome da sua conexão configurada no Adianti

    // Consulta para obter os dados do endereço baseado no CPF
    $sql = "SELECT cpf, lgr_numero, lgr_nome, bairro, cidade, uf, cep FROM enderecos WHERE cpf = :cpf";
    $conn = TTransaction::get(); // Obtém a conexão ativa
    $stmt = $conn->prepare($sql);
    $stmt->execute([':cpf' => $cpfValue]);

    // Se o registro existir, preenche os campos
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      
        $lgr_numero->setValue($row['lgr_numero']);
        $lgr_nome->setValue($row['lgr_nome']);
        $bairro->setValue($row['bairro']);
        $cidade->setValue($row['cidade']);
        $uf->setValue($row['uf']);
        $cep->setValue($row['cep']);
    }

    TTransaction::close(); // Fecha a transação
} catch (Exception $e) {
    // Em caso de erro, exibe a mensagem e desfaz a transação
    new TMessage('error', $e->getMessage());
    TTransaction::rollback();
}

// Adicionando o formulário a um notebook ou container
$notebook2->appendPage('Enderecos', $this->formEnderecos);

               
                

        
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        
        // Cria um HBox para colocar formBaixo e formLado lado a lado
        $hbox = new TElement('div');
        $hbox->style = 'display: flex; width: 100%;';
        
        // FormBaixo
        $formBaixoWrapper = new TElement('div');
        $formBaixoWrapper->style = 'flex: 0 0 20%; padding: 10px;'; 
        $formBaixoWrapper->add($notebook); 
        $hbox->add($formBaixoWrapper);

        $formLadoWrapper = new TElement('div');
        $formLadoWrapper->style = 'flex: 0 0 45%; padding: 10px;';
        $formLadoWrapper->add($notebook2); 
        $hbox->add($formLadoWrapper);


       


        $vbox->add($hbox);
        //$hbox->add($formLado2Wrapper);
       
        parent::add($vbox);
        }

        public function onSave($param) {
            // Verifica se o ID do lead e o valor da flag foram passados
          
        }


        public function onEdit($param) {
            // Verifica se o ID do lead foi passado
            if (isset($param['id'])) {
                $lead_id = $param['id'];

                try {
                    TTransaction::open(self::$database);

                    // Busca o lead na tabela leads
                    $lead = Leads::find($lead_id);
                    if ($lead) {
                        if ($lead->flag_descontinuar == 0) {
                        // Busca os dados do lead na tabela leads_api
                        $leads_api = LeadsApi::where('id', '=', $lead->leads_api_id)->first();
                        
                        // Busca os dados do servidor na tabela leads_gov
                        $leads_gov = LeadsGov::where('id_servidor_portal', '=', $lead->leads_gov_id)->first();
                        
                        $endereco = Enderecos::where('id', '=', $lead->id)->first();
                        
                        // Preenche o formulário com os dados do lead
                       
                        if ($leads_api) {
                            $this->form->setData((object) [
                                'nome' => $leads_api->nome,
                                'cpf' => $leads_api->cpf,
                                'data_nasc' => $leads_api->data_nasc,
                                'rg' => $leads_api->rg,  
                                
                            ]);
                        }
                        /*if ($leads_api) {
                            $this->formOutros->setData((object) [
                                'lgr_numero' => $leads_api->lgr_numero,
                                'lgr_nome'=> $leads_api->lgr_nome,
                                'bairro' => $leads_api->bairro,
                                'cidade' => $leads_api->cidade,
                                'uf' => $leads_api->uf,
                                'cep' => $leads_api->cep,
                                
                            ]);
                        } */

                        if ($leads_gov) {
                            $this->formCargo->setData((object) [
                                'descricao_cargo' => $leads_gov->descricao_cargo,
                                'ano_ingresso' => $leads_gov->ano_ingresso,
                                'ano_aposentadoria' => $leads_gov->ano_aposentadoria,
                                'jornada_de_trabalho' => $leads_gov->jornada_de_trabalho,
                                'org_lotacao' => $leads_gov->org_lotacao,
                            ]);
                        }
                        
                        if($leads_gov){
                            $this->formRemuneracao->setData((object) [
                                
                                'remuneracao_bruta' => $leads_gov->remuneracao_bruta,
                                'remuneracao_apos_deducoes' => $leads_gov->remuneracao_apos_deducoes,


                            ]);
                           
                        }
                        if ($leads_gov) {
                            $this->formGov->setData((object) [
                                'orgsup_lotacao' => $leads_gov->orgsup_lotacao,
                                'regime_juridico' => $leads_gov->regime_juridico,
                                'pensao_militar' => $leads_gov->pensao_militar,
                                'irrf' => $leads_gov->irrf,
                                'fundo_de_saude' => $leads_gov->fundo_de_saude,
                                'verbas_indenizatorias' => $leads_gov->verbas_indenizatorias,
                                'situacao_vinculo' => $leads_gov->situacao_vinculo,
                                'tipo_aposentadoria' => $leads_gov->tipo_aposentadoria,
                                'tipo_vinculo' => $leads_gov->tipo_vinculo,
                                'uorg_lotacao' => $leads_gov->uorg_lotacao,
                                'ferias' => $leads_gov->ferias,
                                'mes' => $leads_gov->mes,
                            ]);
                        }
                       
                       /* if ($leads_api) {
                            $this->formEmail->setData((object) [
                                'email' => $leads_api->email,
                                
                            ]);
                        }
                      /*  if ($leads_api) {
                            $this->formTelefone->setData((object) [
                                'celular' => $leads_api->celular,
                                
                            ]);
                        } */
                       /* if ($leads_api) {
                            $this->formTelefoneFixo->setData((object) [
                                'telefone_fixo' => $leads_api->telefone_fixo,
                                
                            ]); */
                        
                    } else {
                        new TMessage('error', 'Este registro está desativado e não pode ser editado.');
                    }
                } else {
                    new TMessage('error', 'Lead não encontrado.');
                }
                
                TTransaction::close();
            } catch (Exception $e) {
                TTransaction::rollback();
                new TMessage('error', $e->getMessage());
                }
            }

           
        }
        



        public function onSaveContato($param){

        }
        public function onShowListContato($param){

        }
    

        public function onReload($param = null) {
            
            // Verifica se o parâmetro 'responsavel_id' foi passado
            if (isset($param['responsavel_id'])) {
                $carteira_id = $param['responsavel_id'];
                $cpf = isset($param['cpf']) ? $param['cpf'] : null;
                // Cria um critério para buscar os leads com a carteira_id correspondente
                $this->filter_criteria->add(new TFilter('carteira_id', '=', $carteira_id));
        
                // Limpa o datagrid
                $this->datagrid->clear();
        
                // Busca os leads com base no critério
                try {
                    TTransaction::open(self::$database);
                    $leads = Leads::where('carteira_id', '=', $carteira_id)->load();
        
                    // Adiciona os leads ao datagrid
                    foreach ($leads as $lead) {
                        // Busca os dados do servidor na tabela leads_api
                        $leads_api = LeadsApi::where('id', '=', $lead->leads_api_id)->first();
        
                        // Se encontrar o leads_api, preenche os campos
                        if ($leads_api) {
                            $lead->nome = $leads_api->nome; // Preenche o nome
                            $lead->cpf = $leads_api->cpf;   // Preenche o CPF
                            // Você pode adicionar mais campos aqui, se necessário
                        }
        
                        $this->datagrid->addItem($lead);
                    }
        
                    TTransaction::close();
                } catch (Exception $e) {
                    TTransaction::rollback();
                    new TMessage('error', $e->getMessage());
                }
            }
        }
        

  
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

    public static function manageRow($id)
    {
        $list = new self([]);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new LeadsGov($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id_servidor_portal}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }
    public function onShow($param = null)
    {

    }

}