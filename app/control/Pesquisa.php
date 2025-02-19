<?php

class Pesquisa extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'api';
    private static $activeRecord = 'ContatoObservacao';
    private static $primaryKey = 'id';
    private static $formName = 'Pesquisa';
    private $showMethods = ['onReload', 'onSearch'];
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();
        // creates the form

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        $this->limit = 20;

        $criteria_gestao_de_carteira_id = new TCriteria();

        //Campos para pesquisas


        $id = new TEntry('id');
            $id->exitOnEnter();
            $id->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
            $id->setSize('100%');
         

        $carteira = new TEntry('nome');
            $carteira->exitOnEnter();
            $carteira->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
            $carteira->setSize('100%');

        $nome_lead_api = new TEntry('NOME');
            $nome_lead_api->exitOnEnter();
            $nome_lead_api->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
            $nome_lead_api->setSize('100%');

        $data_do_contato = new TEntry('data_do_contato');
            $data_do_contato->exitOnEnter();
            $data_do_contato->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
            $data_do_contato->setSize('100%');

        $data_do_proximo_contato = new TEntry('proximo_contato');
            $data_do_proximo_contato->exitOnEnter();
            $data_do_proximo_contato->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
            $data_do_proximo_contato->setSize('100%');

        $observacao = new TEntry('observacao');
            $observacao->exitOnEnter();
            $observacao->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
            $observacao->setSize('100%');

            //Criando a visao da datagrid principal
        $this->datagrid = new TDataGrid;

                $this->datagrid->disableHtmlConversion();
                $this->datagrid->setId(__CLASS__.'_datagrid');
        
                $this->datagrid_form = new TForm(self::$formName);
                $this->datagrid_form->onsubmit = 'return false';
        
                $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
                $this->filter_criteria = new TCriteria;
        
                $this->datagrid->style = 'width: 100%';
                $this->datagrid->setHeight(320);

                //Definindo as Colunas

                    //$column_id  = new TDataGridColumn('gestao_de_carteira_id', "ID", 'center' , '70px');
                    $column_carteira = new TDataGridColumn('nome', "Carteira", 'left');
                    $column_lead_api = new TDataGridColumn('NOME', "Nome", 'left');
                    $column_data_do_contato = new TDataGridColumn('data_do_contato', "Data do Contato", 'left');
                    $column_data_do_proximo_contato = new TDataGridColumn('proximo_contato', "Proximo contato", 'left');
                    $column_observacao = new TDataGridColumn('observacoes', "Obervação", 'left');

                    //Definindo ordenação pelo nome da Leads
                        /*$order_id = new TAction(array($this, 'onReload'));
                        $order_id->setParameter('order', 'id');
                        $column_lead_api->setAction($order_id); */

                    //Colocando colunas na DataGrid
                    $this->datagrid->addColumn($column_data_do_proximo_contato);
                        //$this->datagrid->addColumn($column_id);
                        $this->datagrid->addColumn($column_carteira);
                        $this->datagrid->addColumn($column_lead_api);
                        $this->datagrid->addColumn($column_data_do_contato);
                        $this->datagrid->addColumn($column_observacao);

        $this->datagrid->createModel();


        //Setando TRS
            $tr = new TElement('tr');
            $this->datagrid->prependRow($tr);

           
         //   $td_id = TElement::tag('td', $id);
          //  $tr->add($td_id);
           /* $td_carteira = TElement::tag('td', $carteira);
            $tr->add($td_carteira);
            $td_nome_lead_api = TElement::tag('td', $nome_lead_api);
            $tr->add($td_nome_lead_api);
            $td_data_do_contato = TElement::tag('td', $data_do_contato);
            $tr->add($td_data_do_contato);
            $td_data_do_proximo_contato = TElement::tag('td', $data_do_proximo_contato);
            $tr->add($td_data_do_proximo_contato);
            $td_observacao = TElement::tag('td', $observacao);
            $tr->add($td_observacao); */

            //Adicionando os campos no Form
            $this->datagrid_form->addField($id);
                $this->datagrid_form->addField($carteira);
                $this->datagrid_form->addField($nome_lead_api);
                $this->datagrid_form->addField($data_do_contato);
                $this->datagrid_form->addField($data_do_proximo_contato);
                $this->datagrid_form->addField($observacao);
        
            $this->datagrid_form->setData( TSession::getValue(__CLASS__.'_filter_data') );

            //Navegacao
            $this->pageNavigation = new TPageNavigation;
                $this->pageNavigation->enableCounters();
                $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
                $this->pageNavigation->setWidth($this->datagrid->getWidth());

            //Painel que vai conter os dois grids
                $panel = new TPanelGroup("Pesquisar dados");
                    $panel->datagrid = 'datagrid-container';
                    $this->datagridPanel = $panel;
                    $panel->getBody()->class .= ' table-responsive';


                  $panel->addFooter($this->pageNavigation);

                  $headerActions = new TElement('div');
                  $headerActions->class = ' datagrid-header-actions ';
          
                  $head_left_actions = new TElement('div');
                  $head_left_actions->class = ' datagrid-header-actions-left-actions ';
          
                  $head_right_actions = new TElement('div');
                  $head_right_actions->class = ' datagrid-header-actions-left-actions ';
          
                  $headerActions->add($head_left_actions);
                  $headerActions->add($head_right_actions);
          
                  $this->datagrid_form->add($this->datagrid);
                  $panel->add($headerActions);
                  $panel->add($this->datagrid_form);


        $container = new TVBox;
            $container->style = 'width: 100%';
            if(empty($param['target_container']))
            {
                $container->add(TBreadCrumb::create(["Básico","Lista de Observações"]));
            }

            $container->add($panel);

            parent::add($container);

                

    }



    public function onReload()
{
    // Limpa o datagrid
    $this->datagrid->clear();

    try {
        TTransaction::open(self::$database);

        // Busca todos os registros de contato_observacao
        $contatos = ContatoObservacao::all(); // Obtém todos os registros da tabela ContatoObservacao

        // Itera sobre cada contato encontrado
        foreach ($contatos as $contato) {
            // Busca a gestao_de_carteira correspondente ao contato
            $gestao_de_carteira = GestaoDeCarteira::where('id', '=', $contato->gestao_de_carteira_id)->first();
            if ($gestao_de_carteira) {
                // Busca o participante correspondente
                $participante = Participantes::where('id', '=', $gestao_de_carteira->participantes_id)->first();
                if ($participante) {
                    // Busca a carteira correspondente
                    $carteira = Carteira::where('id', '=', $participante->carteira_id)->first();
                    if ($carteira) {
                        $contato->nome = $carteira->nome; // Preenche o nome da carteira
                    } else {
                        $contato->nome = 'Carteira não encontrada'; // Mensagem padrão se não encontrar a carteira
                    }

                    // Busca o lead correspondente
                    $lead = Leads::where('id', '=', $participante->leads_id)->first();
                    if ($lead) {
                        // Busca o leads_api correspondente
                        $leads_api = LeadsApi::where('id', '=', $lead->leads_api_id)->first();
                        if ($leads_api) {
                            $contato->NOME = $leads_api->nome; // Preenche o nome da leads_api
                        } else {
                            $contato->NOME = 'Leads API não encontrada'; // Mensagem padrão se não encontrar o leads_api
                        }
                    } else {
                        $contato->NOME = 'Lead não encontrado'; // Mensagem padrão se não encontrar o lead
                    }
                } else {
                    $contato->nome = 'Participante não encontrado'; // Mensagem padrão se não encontrar o participante
                }
            } else {
                $contato->nome = 'Gestão de carteira não encontrada'; // Mensagem padrão se não encontrar a gestão de carteira
            }

            // Adiciona o contato ao datagrid
            $this->datagrid->addItem($contato);
        }

        TTransaction::close();
    } catch (Exception $e) {
        TTransaction::rollback();
        new TMessage('error', $e->getMessage());
    }
}
    



public function onSearch($param = null)
{
    // Limpa o datagrid
   
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

        $object = new Leads($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}