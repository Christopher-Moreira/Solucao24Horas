<?php

//<fileHeader>

//</fileHeader>

class LeadsGovHeaderList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'api';
    private static $activeRecord = 'LeadsGov';
    private static $primaryKey = 'id_servidor_portal';
    private static $formName = 'formList_LeadsGov';
    private $showMethods = ['onReload', 'onSearch'];
    private $limit = 20;

    //<classProperties>

    //</classProperties>

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

        //<onBeginPageCreation>

        //</onBeginPageCreation>

        $cpf = new TEntry('cpf');
        $ano_aposentadoria = new TEntry('ano_aposentadoria');
        $ano_ingresso = new TEntry('ano_ingresso');
        $descricao_cargo = new TEntry('descricao_cargo');
        $id_servidor_portal = new TEntry('id_servidor_portal');
        $nome = new TEntry('nome');
        $jornada_de_trabalho = new TEntry('jornada_de_trabalho');
        $cargo_id = new TEntry('cargo_id');
        $matricula = new TEntry('matricula');
        $org_lotacao = new TEntry('org_lotacao');
        $orgsup_lotacao = new TEntry('orgsup_lotacao');
        $regime_juridico = new TEntry('regime_juridico');
        $situacao_vinculo = new TEntry('situacao_vinculo');
        $tipo_aposentadoria = new TEntry('tipo_aposentadoria');
        $tipo_vinculo = new TEntry('tipo_vinculo');
        $uorg_lotacao = new TEntry('uorg_lotacao');
        $ferias = new TEntry('ferias');
        $fundo_de_saude = new TEntry('fundo_de_saude');
        $irrf = new TEntry('irrf');
        $mes = new TEntry('mes');
        $pensao_militar = new TEntry('pensao_militar');
        $remuneracao_apos_deducoes = new TEntry('remuneracao_apos_deducoes');
        $remuneracao_bruta = new TEntry('remuneracao_bruta');
        $verbas_indenizatorias = new TEntry('verbas_indenizatorias');
        $flag_usado = new TEntry('flag_usado');

        $cpf->exitOnEnter();
        $ano_aposentadoria->exitOnEnter();
        $ano_ingresso->exitOnEnter();
        $descricao_cargo->exitOnEnter();
        $id_servidor_portal->exitOnEnter();
        $nome->exitOnEnter();
        $jornada_de_trabalho->exitOnEnter();
        $cargo_id->exitOnEnter();
        $matricula->exitOnEnter();
        $org_lotacao->exitOnEnter();
        $orgsup_lotacao->exitOnEnter();
        $regime_juridico->exitOnEnter();
        $situacao_vinculo->exitOnEnter();
        $tipo_aposentadoria->exitOnEnter();
        $tipo_vinculo->exitOnEnter();
        $uorg_lotacao->exitOnEnter();
        $ferias->exitOnEnter();
        $fundo_de_saude->exitOnEnter();
        $irrf->exitOnEnter();
        $mes->exitOnEnter();
        $pensao_militar->exitOnEnter();
        $remuneracao_apos_deducoes->exitOnEnter();
        $remuneracao_bruta->exitOnEnter();
        $verbas_indenizatorias->exitOnEnter();
        $flag_usado->exitOnEnter();

        $cpf->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $ano_aposentadoria->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $ano_ingresso->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $descricao_cargo->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $id_servidor_portal->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $nome->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $jornada_de_trabalho->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $cargo_id->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $matricula->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $org_lotacao->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $orgsup_lotacao->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $regime_juridico->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $situacao_vinculo->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $tipo_aposentadoria->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $tipo_vinculo->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $uorg_lotacao->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $ferias->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $fundo_de_saude->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $irrf->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $mes->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $pensao_militar->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $remuneracao_apos_deducoes->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $remuneracao_bruta->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $verbas_indenizatorias->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $flag_usado->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));

        $cpf->setSize('100%');
        $mes->setSize('100%');
        $nome->setSize('100%');
        $irrf->setSize('100%');
        $ferias->setSize('100%');
        $cargo_id->setSize('100%');
        $matricula->setSize('100%');
        $org_lotacao->setSize('100%');
        $ano_ingresso->setSize('100%');
        $tipo_vinculo->setSize('100%');
        $uorg_lotacao->setSize('100%');
        $orgsup_lotacao->setSize('100%');
        $fundo_de_saude->setSize('100%');
        $pensao_militar->setSize('100%');
        $descricao_cargo->setSize('100%');
        $regime_juridico->setSize('100%');
        $situacao_vinculo->setSize('100%');
        $ano_aposentadoria->setSize('100%');
        $remuneracao_bruta->setSize('100%');
        $id_servidor_portal->setSize('100%');
        $tipo_aposentadoria->setSize('100%');
        $jornada_de_trabalho->setSize('100%');
        $verbas_indenizatorias->setSize('100%');
        $remuneracao_apos_deducoes->setSize('100%');
        $flag_usado->setSize('100%');

        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>

        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm(self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_cpf = new TDataGridColumn('cpf', "Cpf", 'left');
        $column_ano_aposentadoria = new TDataGridColumn('ano_aposentadoria', "Ano aposentadoria", 'left');
        $column_ano_ingresso = new TDataGridColumn('ano_ingresso', "Ano ingresso", 'left');
        $column_descricao_cargo = new TDataGridColumn('descricao_cargo', "Descrição cargo", 'left');
        $column_id_servidor_portal = new TDataGridColumn('id_servidor_portal', "Id servidor portal", 'center' , '70px');
        $column_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_jornada_de_trabalho = new TDataGridColumn('jornada_de_trabalho', "Jornada de trabalho", 'left');
        $column_cargo_id = new TDataGridColumn('cargo_id', "Cargo id", 'left');
        $column_matricula = new TDataGridColumn('matricula', "Matricula", 'left');
        $column_org_lotacao = new TDataGridColumn('org_lotacao', "Org lotação", 'left');
        $column_orgsup_lotacao = new TDataGridColumn('orgsup_lotacao', "Orgsup lotação", 'left');
        $column_regime_juridico = new TDataGridColumn('regime_juridico', "Regime jurídico", 'left');
        $column_situacao_vinculo = new TDataGridColumn('situacao_vinculo', "Situação vínculo", 'left');
        $column_tipo_aposentadoria = new TDataGridColumn('tipo_aposentadoria', "Tipo aposentadoria", 'left');
        $column_tipo_vinculo = new TDataGridColumn('tipo_vinculo', "Tipo vínculo", 'left');
        $column_uorg_lotacao = new TDataGridColumn('uorg_lotacao', "Uorg lotação", 'left');
        $column_ferias = new TDataGridColumn('ferias', "Ferias", 'left');
        $column_fundo_de_saude = new TDataGridColumn('fundo_de_saude', "Fundo de saúde", 'left');
        $column_irrf = new TDataGridColumn('irrf', "Irrf <br> <=", 'left');
        $column_mes = new TDataGridColumn('mes', "Mes", 'left');
        $column_pensao_militar = new TDataGridColumn('pensao_militar', "Pensão militar", 'left');
        $column_remuneracao_apos_deducoes = new TDataGridColumn('remuneracao_apos_deducoes', "Remuneração após deduções", 'left');
        $column_remuneracao_bruta = new TDataGridColumn('remuneracao_bruta', "Remuneração bruta <br> >=", 'left');
        $column_verbas_indenizatorias = new TDataGridColumn('verbas_indenizatorias', "Verbas indenizatórias", 'left');
        $column_flag_usado = new TDataGridColumn('verbas_indenizatorias', "Flag Utilizado 1=Sim <br> 0=Não", 'left');
        $column_flag_usado->setTransformer(function($value, $object) {
                return $object->flag_usado == 1 ? 'Sim' : 'Não';
            });

        $order_id_servidor_portal = new TAction(array($this, 'onReload'));
        $order_id_servidor_portal->setParameter('order', 'id_servidor_portal');
        $column_id_servidor_portal->setAction($order_id_servidor_portal);

        //<onBeforeColumnsCreation>

        //</onBeforeColumnsCreation>

        $this->datagrid->addColumn($column_cpf);
        $this->datagrid->addColumn($column_ano_aposentadoria);
        $this->datagrid->addColumn($column_ano_ingresso);
        $this->datagrid->addColumn($column_descricao_cargo);
        $this->datagrid->addColumn($column_id_servidor_portal);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_jornada_de_trabalho);
        $this->datagrid->addColumn($column_cargo_id);
        $this->datagrid->addColumn($column_matricula);
        $this->datagrid->addColumn($column_org_lotacao);
        $this->datagrid->addColumn($column_orgsup_lotacao);
        $this->datagrid->addColumn($column_regime_juridico);
        $this->datagrid->addColumn($column_situacao_vinculo);
        $this->datagrid->addColumn($column_tipo_aposentadoria);
        $this->datagrid->addColumn($column_tipo_vinculo);
        $this->datagrid->addColumn($column_uorg_lotacao);
        $this->datagrid->addColumn($column_ferias);
        $this->datagrid->addColumn($column_fundo_de_saude);
        $this->datagrid->addColumn($column_irrf);
        $this->datagrid->addColumn($column_mes);
        $this->datagrid->addColumn($column_pensao_militar);
        $this->datagrid->addColumn($column_remuneracao_apos_deducoes);
        $this->datagrid->addColumn($column_remuneracao_bruta);
        $this->datagrid->addColumn($column_verbas_indenizatorias);
        $this->datagrid->addColumn($column_flag_usado);

        //<onAfterColumnsCreation>

        //</onAfterColumnsCreation>

        $action_onEdit = new TDataGridAction(array('LeadsGovForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('LeadsGovHeaderList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        //<onAfterActionsCreation>

        //</onAfterActionsCreation>

        // create the datagrid model
        $this->datagrid->createModel();

        $tr = new TElement('tr');
        $this->datagrid->prependRow($tr);

        if(!$action_onEdit->isHidden())
        {
            $tr->add(TElement::tag('td', ''));
        }
        if(!$action_onDelete->isHidden())
        {
            $tr->add(TElement::tag('td', ''));
        }
        $td_cpf = TElement::tag('td', $cpf);
        $tr->add($td_cpf);
        $td_ano_aposentadoria = TElement::tag('td', $ano_aposentadoria);
        $tr->add($td_ano_aposentadoria);
        $td_ano_ingresso = TElement::tag('td', $ano_ingresso);
        $tr->add($td_ano_ingresso);
        $td_descricao_cargo = TElement::tag('td', $descricao_cargo);
        $tr->add($td_descricao_cargo);
        $td_id_servidor_portal = TElement::tag('td', $id_servidor_portal);
        $tr->add($td_id_servidor_portal);
        $td_nome = TElement::tag('td', $nome);
        $tr->add($td_nome);
        $td_jornada_de_trabalho = TElement::tag('td', $jornada_de_trabalho);
        $tr->add($td_jornada_de_trabalho);
        $td_cargo_id = TElement::tag('td', $cargo_id);
        $tr->add($td_cargo_id);
        $td_matricula = TElement::tag('td', $matricula);
        $tr->add($td_matricula);
        $td_org_lotacao = TElement::tag('td', $org_lotacao);
        $tr->add($td_org_lotacao);
        $td_orgsup_lotacao = TElement::tag('td', $orgsup_lotacao);
        $tr->add($td_orgsup_lotacao);
        $td_regime_juridico = TElement::tag('td', $regime_juridico);
        $tr->add($td_regime_juridico);
        $td_situacao_vinculo = TElement::tag('td', $situacao_vinculo);
        $tr->add($td_situacao_vinculo);
        $td_tipo_aposentadoria = TElement::tag('td', $tipo_aposentadoria);
        $tr->add($td_tipo_aposentadoria);
        $td_tipo_vinculo = TElement::tag('td', $tipo_vinculo);
        $tr->add($td_tipo_vinculo);
        $td_uorg_lotacao = TElement::tag('td', $uorg_lotacao);
        $tr->add($td_uorg_lotacao);
        $td_ferias = TElement::tag('td', $ferias);
        $tr->add($td_ferias);
        $td_fundo_de_saude = TElement::tag('td', $fundo_de_saude);
        $tr->add($td_fundo_de_saude);
        $td_irrf = TElement::tag('td', $irrf);
        $tr->add($td_irrf);
        $td_mes = TElement::tag('td', $mes);
        $tr->add($td_mes);
        $td_pensao_militar = TElement::tag('td', $pensao_militar);
        $tr->add($td_pensao_militar);
        $td_remuneracao_apos_deducoes = TElement::tag('td', $remuneracao_apos_deducoes);
        $tr->add($td_remuneracao_apos_deducoes);
        $td_remuneracao_bruta = TElement::tag('td', $remuneracao_bruta);
        $tr->add($td_remuneracao_bruta);
        $td_verbas_indenizatorias = TElement::tag('td', $verbas_indenizatorias);
        $tr->add($td_verbas_indenizatorias);
        $td_flag_usado = TElement::tag('td', $flag_usado);
        $tr->add($td_flag_usado);

        $this->datagrid_form->addField($cpf);
        $this->datagrid_form->addField($ano_aposentadoria);
        $this->datagrid_form->addField($ano_ingresso);
        $this->datagrid_form->addField($descricao_cargo);
        $this->datagrid_form->addField($id_servidor_portal);
        $this->datagrid_form->addField($nome);
        $this->datagrid_form->addField($jornada_de_trabalho);
        $this->datagrid_form->addField($cargo_id);
        $this->datagrid_form->addField($matricula);
        $this->datagrid_form->addField($org_lotacao);
        $this->datagrid_form->addField($orgsup_lotacao);
        $this->datagrid_form->addField($regime_juridico);
        $this->datagrid_form->addField($situacao_vinculo);
        $this->datagrid_form->addField($tipo_aposentadoria);
        $this->datagrid_form->addField($tipo_vinculo);
        $this->datagrid_form->addField($uorg_lotacao);
        $this->datagrid_form->addField($ferias);
        $this->datagrid_form->addField($fundo_de_saude);
        $this->datagrid_form->addField($irrf);
        $this->datagrid_form->addField($mes);
        $this->datagrid_form->addField($pensao_militar);
        $this->datagrid_form->addField($remuneracao_apos_deducoes);
        $this->datagrid_form->addField($remuneracao_bruta);
        $this->datagrid_form->addField($verbas_indenizatorias);
        $this->datagrid_form->addField($flag_usado);

        $this->datagrid_form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Listagem de lead gov");
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

        $button_cadastrar = new TButton('button_button_cadastrar');
        $button_cadastrar->setAction(new TAction(['LeadsGovForm', 'onShow']), "Cadastrar");
        $button_cadastrar->addStyleClass('btn-default');
        $button_cadastrar->setImage('fas:plus #69aa46');

        $this->datagrid_form->addField($button_cadastrar);

        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['LeadsGovHeaderList', 'onExportCsv'],['static' => 1]), self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['LeadsGovHeaderList', 'onExportXls'],['static' => 1]), self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['LeadsGovHeaderList', 'onExportPdf'],['static' => 1]), self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['LeadsGovHeaderList', 'onExportXml'],['static' => 1]), self::$formName, 'far:file-code #95a5a6' );

        $head_left_actions->add($button_cadastrar);

        $head_right_actions->add($dropdown_button_exportar);

        //<onAfterHeaderActionsCreation>

        //</onAfterHeaderActionsCreation>

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Básico","Lead GOV"]));
        }

        $container->add($panel);
        //<onAfterPageCreation>

        //</onAfterPageCreation>

        parent::add($container);

    }

//<generated-DatagridAction-onDelete>
    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                // instantiates object
                $object = new LeadsGov($key, FALSE); //</blockLine>

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                TToast::show('success', AdiantiCoreTranslator::translate('Record deleted'), 'topRight', 'far:check-circle');
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }
//</generated-DatagridAction-onDelete>
//<generated-DatagridHeaderAction-onExportCsv>
    public function onExportCsv($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.csv';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    $handler = fopen($output, 'w');
                    TTransaction::open(self::$database);

                    foreach ($objects as $object)
                    {
                        $row = [];
                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();

                            if (isset($object->$column_name))
                            {
                                $row[] = is_scalar($object->$column_name) ? $object->$column_name : '';
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos((string)$column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $row[] = $object->render($column_name);
                            }
                        }

                        fputcsv($handler, $row);
                    }

                    fclose($handler);
                    TTransaction::close();
                }
                else
                {
                    throw new Exception(_t('No records found'));
                }

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
//</generated-DatagridHeaderAction-onExportCsv>
//<generated-DatagridHeaderAction-onExportXls>
    public function onExportXls($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.xls';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $widths = [];
                $titles = [];

                foreach ($this->datagrid->getColumns() as $column)
                {
                    $titles[] = $column->getLabel();
                    $width    = 100;

                    if (is_null($column->getWidth()))
                    {
                        $width = 100;
                    }
                    else if (strpos((string)$column->getWidth(), '%') !== false)
                    {
                        $width = ((int) $column->getWidth()) * 5;
                    }
                    else if (is_numeric($column->getWidth()))
                    {
                        $width = $column->getWidth();
                    }

                    $widths[] = $width;
                }

                $table = new \TTableWriterXLS($widths);
                $table->addStyle('title',  'Helvetica', '10', 'B', '#ffffff', '#617FC3');
                $table->addStyle('data',   'Helvetica', '10', '',  '#000000', '#FFFFFF', 'LR');

                $table->addRow();

                foreach ($titles as $title)
                {
                    $table->addCell($title, 'center', 'title');
                }

                $this->limit = 0;
                $objects = $this->onReload();

                TTransaction::open(self::$database);
                if ($objects)
                {
                    foreach ($objects as $object)
                    {
                        $table->addRow();
                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();
                            $value = '';
                            if (isset($object->$column_name))
                            {
                                $value = is_scalar($object->$column_name) ? $object->$column_name : '';
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos((string)$column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $value = $object->render($column_name);
                            }

                            $transformer = $column->getTransformer();
                            if ($transformer)
                            {
                                $value = strip_tags((string)call_user_func($transformer, $value, $object, null));
                            }

                            $table->addCell($value, 'center', 'data');
                        }
                    }
                }
                $table->save($output);
                TTransaction::close();

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
//</generated-DatagridHeaderAction-onExportXls>
//<generated-DatagridHeaderAction-onExportPdf>
    public function onExportPdf($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.pdf';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $this->datagrid->prepareForPrinting();
                $this->onReload();

                $html = clone $this->datagrid;
                $contents = file_get_contents('app/resources/styles-print.html') . $html->getContents();

                $dompdf = new \Dompdf\Dompdf;
                $dompdf->loadHtml($contents);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                file_put_contents($output, $dompdf->output());

                $window = TWindow::create('PDF', 0.8, 0.8);
                $object = new TElement('iframe');
                $object->src  = $output;
                $object->type  = 'application/pdf';
                $object->style = "width: 100%; height:calc(100% - 10px)";

                $window->add($object);
                $window->show();
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
//</generated-DatagridHeaderAction-onExportPdf>
//<generated-DatagridHeaderAction-onExportXml>
    public function onExportXml($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.xml';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    TTransaction::open(self::$database);

                    $dom = new DOMDocument('1.0', 'UTF-8');
                    $dom->{'formatOutput'} = true;
                    $dataset = $dom->appendChild( $dom->createElement('dataset') );

                    foreach ($objects as $object)
                    {
                        $row = $dataset->appendChild( $dom->createElement( self::$activeRecord ) );

                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();
                            $column_name_raw = str_replace(['(','{','->', '-','>','}',')', ' '], ['','','_','','','','','_'], $column_name);

                            if (isset($object->$column_name))
                            {
                                $value = is_scalar($object->$column_name) ? $object->$column_name : '';
                                $row->appendChild($dom->createElement($column_name_raw, $value)); 
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos((string)$column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $value = $object->render($column_name);
                                $row->appendChild($dom->createElement($column_name_raw, $value));
                            }
                        }
                    }

                    $dom->save($output);

                    TTransaction::close();
                }
                else
                {
                    throw new Exception(_t('No records found'));
                }

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
//</generated-DatagridHeaderAction-onExportXml>

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        // get the search form data
        $data = $this->datagrid_form->getData();
        $filters = [];

        //<onBeforeDatagridSearch>

        //</onBeforeDatagridSearch> 

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->cpf) AND ( (is_scalar($data->cpf) AND $data->cpf !== '') OR (is_array($data->cpf) AND (!empty($data->cpf)) )) )
        {

            $filters[] = new TFilter('cpf', 'like', "%{$data->cpf}%");// create the filter 
        }

        if (isset($data->ano_aposentadoria) AND ( (is_scalar($data->ano_aposentadoria) AND $data->ano_aposentadoria !== '') OR (is_array($data->ano_aposentadoria) AND (!empty($data->ano_aposentadoria)) )) )
        {

            $filters[] = new TFilter('ano_aposentadoria', '=', $data->ano_aposentadoria);// create the filter 
        }

        if (isset($data->ano_ingresso) AND ( (is_scalar($data->ano_ingresso) AND $data->ano_ingresso !== '') OR (is_array($data->ano_ingresso) AND (!empty($data->ano_ingresso)) )) )
        {

            $filters[] = new TFilter('ano_ingresso', '=', $data->ano_ingresso);// create the filter 
        }

        if (isset($data->descricao_cargo) AND ( (is_scalar($data->descricao_cargo) AND $data->descricao_cargo !== '') OR (is_array($data->descricao_cargo) AND (!empty($data->descricao_cargo)) )) )
        {

            $filters[] = new TFilter('descricao_cargo', 'like', "%{$data->descricao_cargo}%");// create the filter 
        }

        if (isset($data->id_servidor_portal) AND ( (is_scalar($data->id_servidor_portal) AND $data->id_servidor_portal !== '') OR (is_array($data->id_servidor_portal) AND (!empty($data->id_servidor_portal)) )) )
        {

            $filters[] = new TFilter('id_servidor_portal', '=', $data->id_servidor_portal);// create the filter 
        }

        if (isset($data->nome) AND ( (is_scalar($data->nome) AND $data->nome !== '') OR (is_array($data->nome) AND (!empty($data->nome)) )) )
        {

            $filters[] = new TFilter('nome', 'like', "%{$data->nome}%");// create the filter 
        }

        if (isset($data->jornada_de_trabalho) AND ( (is_scalar($data->jornada_de_trabalho) AND $data->jornada_de_trabalho !== '') OR (is_array($data->jornada_de_trabalho) AND (!empty($data->jornada_de_trabalho)) )) )
        {

            $filters[] = new TFilter('jornada_de_trabalho', 'like', "%{$data->jornada_de_trabalho}%");// create the filter 
        }

        if (isset($data->cargo_id) AND ( (is_scalar($data->cargo_id) AND $data->cargo_id !== '') OR (is_array($data->cargo_id) AND (!empty($data->cargo_id)) )) )
        {

            $filters[] = new TFilter('cargo_id', '=', $data->cargo_id);// create the filter 
        }

        if (isset($data->matricula) AND ( (is_scalar($data->matricula) AND $data->matricula !== '') OR (is_array($data->matricula) AND (!empty($data->matricula)) )) )
        {

            $filters[] = new TFilter('matricula', 'like', "%{$data->matricula}%");// create the filter 
        }

        if (isset($data->org_lotacao) AND ( (is_scalar($data->org_lotacao) AND $data->org_lotacao !== '') OR (is_array($data->org_lotacao) AND (!empty($data->org_lotacao)) )) )
        {

            $filters[] = new TFilter('org_lotacao', 'like', "%{$data->org_lotacao}%");// create the filter 
        }

        if (isset($data->orgsup_lotacao) AND ( (is_scalar($data->orgsup_lotacao) AND $data->orgsup_lotacao !== '') OR (is_array($data->orgsup_lotacao) AND (!empty($data->orgsup_lotacao)) )) )
        {

            $filters[] = new TFilter('orgsup_lotacao', 'like', "%{$data->orgsup_lotacao}%");// create the filter 
        }

        if (isset($data->regime_juridico) AND ( (is_scalar($data->regime_juridico) AND $data->regime_juridico !== '') OR (is_array($data->regime_juridico) AND (!empty($data->regime_juridico)) )) )
        {

            $filters[] = new TFilter('regime_juridico', 'like', "%{$data->regime_juridico}%");// create the filter 
        }

        if (isset($data->situacao_vinculo) AND ( (is_scalar($data->situacao_vinculo) AND $data->situacao_vinculo !== '') OR (is_array($data->situacao_vinculo) AND (!empty($data->situacao_vinculo)) )) )
        {

            $filters[] = new TFilter('situacao_vinculo', 'like', "%{$data->situacao_vinculo}%");// create the filter 
        }

        if (isset($data->tipo_aposentadoria) AND ( (is_scalar($data->tipo_aposentadoria) AND $data->tipo_aposentadoria !== '') OR (is_array($data->tipo_aposentadoria) AND (!empty($data->tipo_aposentadoria)) )) )
        {

            $filters[] = new TFilter('tipo_aposentadoria', 'like', "%{$data->tipo_aposentadoria}%");// create the filter 
        }

        if (isset($data->tipo_vinculo) AND ( (is_scalar($data->tipo_vinculo) AND $data->tipo_vinculo !== '') OR (is_array($data->tipo_vinculo) AND (!empty($data->tipo_vinculo)) )) )
        {

            $filters[] = new TFilter('tipo_vinculo', 'like', "%{$data->tipo_vinculo}%");// create the filter 
        }

        if (isset($data->uorg_lotacao) AND ( (is_scalar($data->uorg_lotacao) AND $data->uorg_lotacao !== '') OR (is_array($data->uorg_lotacao) AND (!empty($data->uorg_lotacao)) )) )
        {

            $filters[] = new TFilter('uorg_lotacao', 'like', "%{$data->uorg_lotacao}%");// create the filter 
        }

        if (isset($data->ferias) AND ( (is_scalar($data->ferias) AND $data->ferias !== '') OR (is_array($data->ferias) AND (!empty($data->ferias)) )) )
        {

            $filters[] = new TFilter('ferias', '=', $data->ferias);// create the filter 
        }

        if (isset($data->fundo_de_saude) AND ( (is_scalar($data->fundo_de_saude) AND $data->fundo_de_saude !== '') OR (is_array($data->fundo_de_saude) AND (!empty($data->fundo_de_saude)) )) )
        {

            $filters[] = new TFilter('fundo_de_saude', '=', $data->fundo_de_saude);// create the filter 
        }

        if (isset($data->irrf) AND ( (is_scalar($data->irrf) AND $data->irrf !== '') OR (is_array($data->irrf) AND (!empty($data->irrf)) )) )
        {

            $filters[] = new TFilter('irrf', '<=', $data->irrf);// create the filter 
        }

        if (isset($data->mes) AND ( (is_scalar($data->mes) AND $data->mes !== '') OR (is_array($data->mes) AND (!empty($data->mes)) )) )
        {

            $filters[] = new TFilter('mes', '=', $data->mes);// create the filter 
        }

        if (isset($data->pensao_militar) AND ( (is_scalar($data->pensao_militar) AND $data->pensao_militar !== '') OR (is_array($data->pensao_militar) AND (!empty($data->pensao_militar)) )) )
        {

            $filters[] = new TFilter('pensao_militar', '=', $data->pensao_militar);// create the filter 
        }

        if (isset($data->remuneracao_apos_deducoes) AND ( (is_scalar($data->remuneracao_apos_deducoes) AND $data->remuneracao_apos_deducoes !== '') OR (is_array($data->remuneracao_apos_deducoes) AND (!empty($data->remuneracao_apos_deducoes)) )) )
        {

            $filters[] = new TFilter('remuneracao_apos_deducoes', '<=', $data->remuneracao_apos_deducoes);// create the filter 
        }

        if (isset($data->remuneracao_bruta) AND ( (is_scalar($data->remuneracao_bruta) AND $data->remuneracao_bruta !== '') OR (is_array($data->remuneracao_bruta) AND (!empty($data->remuneracao_bruta)) )) )
        {

            $filters[] = new TFilter('remuneracao_bruta', '>=', $data->remuneracao_bruta);// create the filter 
        }

        if (isset($data->verbas_indenizatorias) AND ( (is_scalar($data->verbas_indenizatorias) AND $data->verbas_indenizatorias !== '') OR (is_array($data->verbas_indenizatorias) AND (!empty($data->verbas_indenizatorias)) )) )
        {

            $filters[] = new TFilter('verbas_indenizatorias', '=', $data->verbas_indenizatorias);// create the filter 
        }
        if (isset($data->flag_usado) AND ( (is_scalar($data->flag_usado) AND $data->flag_usado !== '') OR (is_array($data->flag_usado) AND (!empty($data->flag_usado)) )) )
        {

            $filters[] = new TFilter('flag_usado', '=', $data->flag_usado);// create the filter 
        }

        //<onDatagridSearch>

        //</onDatagridSearch>

        // fill the form with data again
        $this->datagrid_form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        if (isset($param['static']) && ($param['static'] == '1') )
        {
            $class = get_class($this);
            $onReloadParam = ['offset' => 0, 'first_page' => 1, 'target_container' => $param['target_container'] ?? null];
            AdiantiCoreApplication::loadPage($class, 'onReload', $onReloadParam);
            TScript::create('$(".select2").prev().select2("close");');
        }
        else
        {
            $this->onReload(['offset' => 0, 'first_page' => 1]);
        }
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'api'
            TTransaction::open(self::$database);

            // creates a repository for LeadsGov
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'id_servidor_portal';    
            }
            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            //<onBeforeDatagridLoad>

            //</onBeforeDatagridLoad>

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    //<onBeforeDatagridAddItem>

                    //</onBeforeDatagridAddItem>
                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->id_servidor_portal}";
                    //<onAfterDatagridAddItem>

                    //</onAfterDatagridAddItem>
                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

            //<onBeforeDatagridTransactionClose>

            //</onBeforeDatagridTransactionClose>

            // close the transaction
            TTransaction::close();
            $this->loaded = true;

            return $objects;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {
        //<onShow>

        //</onShow>
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

    //</hideLine> <addUserFunctionsCode/>

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

    //<userCustomFunctions>

    //</userCustomFunctions>

}