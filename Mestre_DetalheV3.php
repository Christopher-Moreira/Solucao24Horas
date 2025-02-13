<?php

use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Form\THtmlEditor;
use Adianti\Wrapper\BootstrapFormBuilder;


class Mestre_DetalheV3 extends TPage {

    private $form; // form de Dados Pessoais
    private $formVinculos; // form de Vínculos
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'api';
    private static $activeRecord = 'LeadsGov';
    private static $primaryKey = 'id_servidor_portal';
    private static $formName = 'Mestre_DetalheV3';
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
        


        

        $notebook = new TNotebook('LeadsGov');

    
        $column_cpf = new TDataGridColumn('cpf', "Cpf", 'left');
        $column_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_responsavel_id = new TDataGridColumn('responsavel_id', 'Carteira', 'left');
        $flag_ativo = new TDataGridColumn('flag_ativo', 'Ativo', 'left');
        $flag_ativo->setTransformer(function($value) {
            return $value == 1 ? 'Sim' : 'Não';
        });
        
            
        $order_id_servidor_portal = new TAction(array($this, 'onReload'));
        $order_id_servidor_portal->setParameter('order', 'id_servidor_portal');
        
        $this->datagrid->addColumn($column_cpf);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_responsavel_id);
        $this->datagrid->addColumn($flag_ativo);
        

        $notebook->appendPage('Listagem da Carteira', $this->datagrid);

        $action_onEdit = new TDataGridAction(array('Mestre_DetalheV3', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Vizualizar");
        $action_onEdit->setImage('far:eye #48c48c');
        $action_onEdit->setField(self::$primaryKey);
     
        

        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $this->datagrid->addAction($action_onEdit);

        $this->datagrid->createModel();


        //FORM


        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setFormTitle('Dados Pessoais');

        
            $notebook2 = new TNotebook('telefones');
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

                $telefone = new TEntry('telefone');
                    $telefone->setEditable(false);
                    $telefone->setMaxLength(14);
                    $telefone->setSize('60%');
            
                // Adicionando campos ao formulário de Dados Pessoais
                $this->form->addFields([new TLabel('Nome:')], [$nome]);
                $this->form->addFields([new TLabel('CPF:')], [$cpf]);
                //$this->form->addFields([new TLabel('Email:')], [$email]);
                //$this->form->addFields([new TLabel('Número:')], [$telefone]);
                $this->form->addFields([new TLabel('Data de Nascimento:')], [$nasc]);

            
                

                //$this->form->addFields([new TLabel('Parente:')], [$parentesco_nome]);

        // Notebook para as diferentes seções
    
        $notebook2->appendPage('Dados Pessoais', $this->form);
        

    

            $this->formContato = new BootstrapFormBuilder('formContato');
            $this->formContato->setFormTitle('Contato');

                $obs = new THtmlEditor('observacoes');
                $obs->setSize('100%', height:'100');


                $primeiro_contato =  new TEntry('data_do_contato');
                    $primeiro_contato->setEditable(false);
                    $primeiro_contato->setMaxLength(14);
                    $primeiro_contato->setSize('60%');

                $proximo_contato = new TEntry('proximo_contato');
                    $proximo_contato->setEditable(false);
                    $proximo_contato->setMaxLength(14);
                    $proximo_contato->setSize('60%');

                


                $this->formContato->addFields([new TLabel('Observação:')], [$obs]);
                $this->formContato->addContent([new TElement('br')]);
                $this->formContato->addFields([new TLabel('Primeiro Contato')], [$primeiro_contato]);
                $this->formContato->addFields([new TLabel('Próximo Contato')], [$proximo_contato]);

                $btn_contato = $this->formContato->addAction("Salvar", new TAction([$this, 'onSaveContato']), 'fas:save #ffffff');
                $this->btn_contato = $btn_contato;
                $btn_contato->addStyleClass('btn-success');
                $btn_contato->style = 'background-color: #48c48c; color: white;';

                $btn_contato2 = $this->formContato->addAction("Mostrar Anotações", new TAction([$this, 'onShowListContato']), 'fas:list #ffffff');
                $this->btn_contato = $btn_contato2;
                $btn_contato2->addStyleClass('btn-success');
                $btn_contato2->style = 'background-color: #48c48c; color: white;';


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

            $this->formEmail = new BootstrapFormBuilder('formEmail');
            $this->formEmail->setFormTitle('Email');

            $email = new TEntry('email');
            $email->setEditable(false);
            $email->setMaxLength(14);
            $email->setSize('60%');

            $this->formEmail->addFields([new TLabel('Email:')], [$email]);

        $notebook2->appendPage('Email', $this->formEmail);

            $this->formTelefone = new BootstrapFormBuilder('formTelefone');
            $this->formTelefone->setFormTitle('Telefone');

            $telefone = new TEntry('telefone');
            $telefone->setEditable(false);
            $telefone->setMaxLength(14);
            $telefone->setSize('60%');

            $this->formTelefone->addFields([new TLabel('Telefone:')], [$telefone]);

        $notebook2->appendPage('Telefone', $this->formTelefone);
            $this->formTelefoneFixo = new BootstrapFormBuilder('formTelefoneFixo');
            $this->formTelefoneFixo->setFormTitle('Telefone Fixo');

            $telefone_fixo = new TEntry('telefone_fixo');
            $telefone_fixo->setEditable(false);
            $telefone_fixo->setMaxLength(14);
            $telefone_fixo->setSize('60%');

            $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo:')], [$telefone_fixo]);

        $notebook2->appendPage('Telefone Fixo', $this->formTelefoneFixo);


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


        //Flag

        $this->formFlag = new BootstrapFormBuilder('formFlag');
        $this->formFlag->setFormTitle('Continuar Contato?');
        
        $notebook3 = new TNotebook('carteira');
        
        $escolha = new TEntry('nome');
            $escolha->setEditable(false);

            $this->formFlag->addFields([new TLabel('')], []);


        $btn_carteira = $this->formFlag->addAction("Escolha <i class='fas fa-arrow-right'></i> ", $action = new TAction(['Mestre_DetalheFlag', 'onReload']), 'fas:circle #ffffff');
        $this->btn_carteira = $btn_carteira;
        $btn_carteira->addStyleClass('btn-success');
        $btn_carteira->style = 'background-color: #48c48c; color: white;';
        
        
        $notebook3->appendPage('Contato', $this->formFlag);


        



        
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
        
        // FormLado
        $formLadoWrapper = new TElement('div');
        $formLadoWrapper->style = 'flex: 0 0 45%; padding: 10px;';
        $formLadoWrapper->add($notebook2); 
        $hbox->add($formLadoWrapper);
        
        // FormLado3
        $formLado3Wrapper = new TElement('div');
        $formLado3Wrapper->style = 'flex: 0 0 30%; padding: 10px;';
        $formLado3Wrapper->add($notebook3); 
        $hbox->add($formLado3Wrapper);

        
        
        $vbox->add($hbox);
        
        parent::add($vbox);
        


    }
    
    public function onSave($param = null) 
    {
      
    } 
 
    public function onSaveContato($param)
    {
   
    }


    public function onShowListContato($param){
        parent::__construct();

        $this->datagridDescritivo = new TDataGrid;
        $this->datagridDescritivo->disableHtmlConversion();
        $this->datagridDescritivo->setId(__CLASS__.'_datagrid');
        $this->datagridDescritivo = new BootstrapDatagridWrapper($this->datagridDescritivo);

        $this->filter_criteria = new TCriteria;

        $this->datagridDescritivo->style = 'width: 100%';
        $this->datagridDescritivo->setHeight(320);

        $notebook4 = new TNotebook('descritivo');

        $column_id = new TDataGridColumn('id', "ID", 'center', '50%');
        $column_descritivo = new TDataGridColumn('descritivo', "Descritivo", 'center', '50%');
        
        $this->datagridDescritivo->addColumn($column_id);
        $this->datagridDescritivo->addColumn($column_descritivo);

        $notebook4->appendPage('Listagem de Anotação', $this->datagridDescritivo);
       
        $this->datagridDescritivo->createModel();

        $vbox = new TVBox;
        $vbox->style = 'width: 100%;';
    
        $hbox = new TElement('div');
        $hbox->style = 'display: flex; justify-content: center; width: 100%;';  // Modificado para centralizar
    
        // O notebook4 é exibido no centro
        $formLado4Wrapper = new TElement('div');
        $formLado4Wrapper->style = 'flex: 1; padding: 10px; max-width: 75%;';  // Definido max-width para limitar a largura
        $formLado4Wrapper->add($notebook4);  // Adiciona o notebook4
        $hbox->add($formLado4Wrapper);
    
        $vbox->add($hbox);
    
        parent::add($vbox);
    }
    public function onReload($param = null)
{
    try {
        // Inicia a transação com o banco de dados
        TTransaction::open('api');

        // Cria um repositório para os registros ativos
        $repository = new TRepository(self::$activeRecord);
        
        // Clona os critérios de filtro
        $criteria = clone $this->filter_criteria;

        // Verifica se há um responsavel_id e adiciona ao critério
        if (!empty($param['responsavel_id'])) {
            $criteria->add(new TFilter('responsavel_id', '=', $param['responsavel_id']));
        }

        // Define a ordenação padrão se não estiver definida
        if (empty($param['order'])) {
            $param['order'] = 'id_servidor_portal';
        }
        if (empty($param['direction'])) {
            $param['direction'] = 'desc';
        }

        // Define propriedades do critério (ordenação, offset)
        $criteria->setProperties($param);
        $criteria->setProperty('limit', $this->limit);

        // Adiciona filtros da sessão, se existirem
        if ($filters = TSession::getValue(__CLASS__.'_filters')) {
            foreach ($filters as $filter) {
                $criteria->add($filter);
            }
        }

        // Carrega os objetos de acordo com o critério
        $objects = $repository->load($criteria, FALSE);

        // Limpa o datagrid antes de adicionar novos itens
        $this->datagrid->clear();
        if ($objects) {
            foreach ($objects as $object) {
                $row = $this->datagrid->addItem($object);
                $row->id = "row_{$object->id_servidor_portal}"; // Ajuste do ID da linha
            }
        }

        // Reseta os critérios para a contagem de registros
        $criteria->resetProperties();
        $count = $repository->count($criteria);

        $this->pageNavigation->setCount($count); // Conta os registros
        $this->pageNavigation->setProperties($param); // Propriedades de navegação
        $this->pageNavigation->setLimit($this->limit); // Limite

        // Finaliza a transação
        TTransaction::close();
        $this->loaded = true;

        return $objects;
    } catch (Exception $e) {
        // Exibe mensagem de erro e finaliza a transação
        new TMessage('error', $e->getMessage());
        TTransaction::rollback();
    }
}

public function onEdit($param){

    try {
        if (isset($param['key'])) {
            $key = $param['key'];  // pega o parâmetro $key
            TTransaction::open(self::$database); // abre uma transação

            // Busca os dados da tabela 'telefones'
            $telefone = new LeadsGov($key);
            if ($telefone->flag_ativo != 1) {
                // Exibe uma mensagem de erro se o registro não está ativo
                new TMessage('error', 'Ação não permitida: o registro não está ativo.');
                return;
            }
            
            $email = LeadsGov::where('id_servidor_portal', '=', $telefone->id_servidor_portal)->first();
            $parente_nome = LeadsGov::where('id_servidor_portal', '=', $telefone->id_servidor_portal)->first();
            
            $nasc = LeadsGov::where('id_servidor_portal', '=', $telefone->id_servidor_portal)->first();

            $nome = LeadsGov::where('id_servidor_portal', '=', $telefone->id_servidor_portal)->first();
            


            // Preenche o formulário
            $this->form->setData($telefone);
            $this->form->setData($email); 
            $this->form->setData($parente_nome);
            $this->form->setData($nasc);
            

            $this->formContato->setData($telefone);

            $this->formCargo->setData($telefone);
        
            $this->formRemuneracao->setData($telefone);

            $this->formGov->setData($telefone);

            $this->formFlag->setData($telefone);
         
        


            TTransaction::close(); // fecha a transação
        } else {
            $this->form->clear();
        }
    } catch (Exception $e) {
        new TMessage('error', $e->getMessage());
        TTransaction::rollback();
    }
    
}




private function loadData($param) {
        
    // Carregar dados pessoais
    $this->loadPersonalData($param);

    // Carregar vínculos
    $this->loadRelationships($param);

    // Carregar contatos
    $this->loadContacts($param);
}
private function loadPersonalData($param) {
  
}
private function loadRelationships($param) {
     
}

private function loadContacts($param) {
   
    
}






    public function onShow($param = null)
    {

    }

    /**
     * method show()
     * Shows the page
     */
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

}