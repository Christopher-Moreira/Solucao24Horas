<?php

class LeadsApiHeaderList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'api';
    private static $activeRecord = 'LeadsApi';
    private static $primaryKey = 'id';
    private static $formName = 'formList_LeadsApi';
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

        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $cpf = new TEntry('cpf');
        $idade = new TEntry('idade');
        $data_nasc = new TEntry('data_nasc');
        $celular = new TEntry('celular');
        $flg_whatsapp = new TEntry('flg_whatsapp');
        $telefone_fixo = new TEntry('telefone_fixo');
        $email = new TEntry('email');
        $lgr_numero = new TEntry('lgr_numero');
        $lgr_nome = new TEntry('lgr_nome');
        $bairro = new TEntry('bairro');
        $cidade = new TEntry('cidade');
        $uf = new TEntry('uf');
        $cep = new TEntry('cep');
        $created_at = new TEntry('created_at');
        $rg = new TEntry('rg');
        $column_19 = new TEntry('column_19');

        $id->exitOnEnter();
        $nome->exitOnEnter();
        $cpf->exitOnEnter();
        $idade->exitOnEnter();
        $data_nasc->exitOnEnter();
        $celular->exitOnEnter();
        $flg_whatsapp->exitOnEnter();
        $telefone_fixo->exitOnEnter();
        $email->exitOnEnter();
        $lgr_numero->exitOnEnter();
        $lgr_nome->exitOnEnter();
        $bairro->exitOnEnter();
        $cidade->exitOnEnter();
        $uf->exitOnEnter();
        $cep->exitOnEnter();
        $created_at->exitOnEnter();
        $rg->exitOnEnter();
        $column_19->exitOnEnter();

        $id->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $nome->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $cpf->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $idade->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $data_nasc->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $celular->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $flg_whatsapp->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $telefone_fixo->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $email->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $lgr_numero->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $lgr_nome->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $bairro->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $cidade->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $uf->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $cep->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $created_at->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $rg->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));
        $column_19->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container' => $param['target_container'] ?? null]));

        $id->setSize('100%');
        $uf->setSize('100%');
        $rg->setSize('100%');
        $cpf->setSize('100%');
        $cep->setSize('100%');
        $nome->setSize('100%');
        $idade->setSize('100%');
        $email->setSize('100%');
        $bairro->setSize('100%');
        $cidade->setSize('100%');
        $celular->setSize('100%');
        $lgr_nome->setSize('100%');
        $data_nasc->setSize('100%');
        $column_19->setSize('100%');
        $lgr_numero->setSize('100%');
        $created_at->setSize('100%');
        $flg_whatsapp->setSize('100%');
        $telefone_fixo->setSize('100%');

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

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_cpf = new TDataGridColumn('cpf', "Cpf", 'left');
        $column_idade = new TDataGridColumn('idade', "Idade", 'left');
        $column_data_nasc = new TDataGridColumn('data_nasc', "Data nasc", 'left');
        $column_celular = new TDataGridColumn('celular', "Celular", 'left');
        $column_flg_whatsapp = new TDataGridColumn('flg_whatsapp', "Flg whatsapp", 'left');
        $column_telefone_fixo = new TDataGridColumn('telefone_fixo', "Telefone fixo", 'left');
        $column_email = new TDataGridColumn('email', "Email", 'left');
        $column_lgr_numero = new TDataGridColumn('lgr_numero', "Lgr numero", 'left');
        $column_lgr_nome = new TDataGridColumn('lgr_nome', "Lgr nome", 'left');
        $column_bairro = new TDataGridColumn('bairro', "Bairro", 'left');
        $column_cidade = new TDataGridColumn('cidade', "Cidade", 'left');
        $column_uf = new TDataGridColumn('uf', "Uf", 'left');
        $column_cep = new TDataGridColumn('cep', "Cep", 'left');
        $column_created_at = new TDataGridColumn('created_at', "Created at", 'left');
        $column_rg = new TDataGridColumn('rg', "Rg", 'left');
        $column_column_19 = new TDataGridColumn('column_19', "Column 19", 'left');

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_cpf);
        $this->datagrid->addColumn($column_idade);
        $this->datagrid->addColumn($column_data_nasc);
        $this->datagrid->addColumn($column_celular);
        $this->datagrid->addColumn($column_flg_whatsapp);
        $this->datagrid->addColumn($column_telefone_fixo);
        $this->datagrid->addColumn($column_email);
        $this->datagrid->addColumn($column_lgr_numero);
        $this->datagrid->addColumn($column_lgr_nome);
        $this->datagrid->addColumn($column_bairro);
        $this->datagrid->addColumn($column_cidade);
        $this->datagrid->addColumn($column_uf);
        $this->datagrid->addColumn($column_cep);
        $this->datagrid->addColumn($column_created_at);
        $this->datagrid->addColumn($column_rg);
        $this->datagrid->addColumn($column_column_19);

        $action_onEdit = new TDataGridAction(array('LeadsApiForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('LeadsApiHeaderList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

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
        $td_id = TElement::tag('td', $id);
        $tr->add($td_id);
        $td_nome = TElement::tag('td', $nome);
        $tr->add($td_nome);
        $td_cpf = TElement::tag('td', $cpf);
        $tr->add($td_cpf);
        $td_idade = TElement::tag('td', $idade);
        $tr->add($td_idade);
        $td_data_nasc = TElement::tag('td', $data_nasc);
        $tr->add($td_data_nasc);
        $td_celular = TElement::tag('td', $celular);
        $tr->add($td_celular);
        $td_flg_whatsapp = TElement::tag('td', $flg_whatsapp);
        $tr->add($td_flg_whatsapp);
        $td_telefone_fixo = TElement::tag('td', $telefone_fixo);
        $tr->add($td_telefone_fixo);
        $td_email = TElement::tag('td', $email);
        $tr->add($td_email);
        $td_lgr_numero = TElement::tag('td', $lgr_numero);
        $tr->add($td_lgr_numero);
        $td_lgr_nome = TElement::tag('td', $lgr_nome);
        $tr->add($td_lgr_nome);
        $td_bairro = TElement::tag('td', $bairro);
        $tr->add($td_bairro);
        $td_cidade = TElement::tag('td', $cidade);
        $tr->add($td_cidade);
        $td_uf = TElement::tag('td', $uf);
        $tr->add($td_uf);
        $td_cep = TElement::tag('td', $cep);
        $tr->add($td_cep);
        $td_created_at = TElement::tag('td', $created_at);
        $tr->add($td_created_at);
        $td_rg = TElement::tag('td', $rg);
        $tr->add($td_rg);
        $td_column_19 = TElement::tag('td', $column_19);
        $tr->add($td_column_19);

        $this->datagrid_form->addField($id);
        $this->datagrid_form->addField($nome);
        $this->datagrid_form->addField($cpf);
        $this->datagrid_form->addField($idade);
        $this->datagrid_form->addField($data_nasc);
        $this->datagrid_form->addField($celular);
        $this->datagrid_form->addField($flg_whatsapp);
        $this->datagrid_form->addField($telefone_fixo);
        $this->datagrid_form->addField($email);
        $this->datagrid_form->addField($lgr_numero);
        $this->datagrid_form->addField($lgr_nome);
        $this->datagrid_form->addField($bairro);
        $this->datagrid_form->addField($cidade);
        $this->datagrid_form->addField($uf);
        $this->datagrid_form->addField($cep);
        $this->datagrid_form->addField($created_at);
        $this->datagrid_form->addField($rg);
        $this->datagrid_form->addField($column_19);

        $this->datagrid_form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Listagem de leads apis");
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
        $button_cadastrar->setAction(new TAction(['LeadsApiForm', 'onShow']), "Cadastrar");
        $button_cadastrar->addStyleClass('btn-default');
        $button_cadastrar->setImage('fas:plus #69aa46');

        $this->datagrid_form->addField($button_cadastrar);

        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['LeadsApiHeaderList', 'onExportCsv'],['static' => 1]), self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['LeadsApiHeaderList', 'onExportXls'],['static' => 1]), self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['LeadsApiHeaderList', 'onExportPdf'],['static' => 1]), self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['LeadsApiHeaderList', 'onExportXml'],['static' => 1]), self::$formName, 'far:file-code #95a5a6' );

        $head_left_actions->add($button_cadastrar);

        $head_right_actions->add($dropdown_button_exportar);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Básico","Leads apis"]));
        }

        $container->add($panel);

        parent::add($container);

    }

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
                $object = new LeadsApi($key, FALSE); 

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

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        // get the search form data
        $data = $this->datagrid_form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }

        if (isset($data->nome) AND ( (is_scalar($data->nome) AND $data->nome !== '') OR (is_array($data->nome) AND (!empty($data->nome)) )) )
        {

            $filters[] = new TFilter('nome', 'like', "%{$data->nome}%");// create the filter 
        }

        if (isset($data->cpf) AND ( (is_scalar($data->cpf) AND $data->cpf !== '') OR (is_array($data->cpf) AND (!empty($data->cpf)) )) )
        {

            $filters[] = new TFilter('cpf', 'like', "%{$data->cpf}%");// create the filter 
        }

        if (isset($data->idade) AND ( (is_scalar($data->idade) AND $data->idade !== '') OR (is_array($data->idade) AND (!empty($data->idade)) )) )
        {

            $filters[] = new TFilter('idade', '=', $data->idade);// create the filter 
        }

        if (isset($data->data_nasc) AND ( (is_scalar($data->data_nasc) AND $data->data_nasc !== '') OR (is_array($data->data_nasc) AND (!empty($data->data_nasc)) )) )
        {

            $filters[] = new TFilter('data_nasc', 'like', "%{$data->data_nasc}%");// create the filter 
        }

        if (isset($data->celular) AND ( (is_scalar($data->celular) AND $data->celular !== '') OR (is_array($data->celular) AND (!empty($data->celular)) )) )
        {

            $filters[] = new TFilter('celular', 'like', "%{$data->celular}%");// create the filter 
        }

        if (isset($data->flg_whatsapp) AND ( (is_scalar($data->flg_whatsapp) AND $data->flg_whatsapp !== '') OR (is_array($data->flg_whatsapp) AND (!empty($data->flg_whatsapp)) )) )
        {

            $filters[] = new TFilter('flg_whatsapp', '=', $data->flg_whatsapp);// create the filter 
        }

        if (isset($data->telefone_fixo) AND ( (is_scalar($data->telefone_fixo) AND $data->telefone_fixo !== '') OR (is_array($data->telefone_fixo) AND (!empty($data->telefone_fixo)) )) )
        {

            $filters[] = new TFilter('telefone_fixo', 'like', "%{$data->telefone_fixo}%");// create the filter 
        }

        if (isset($data->email) AND ( (is_scalar($data->email) AND $data->email !== '') OR (is_array($data->email) AND (!empty($data->email)) )) )
        {

            $filters[] = new TFilter('email', 'like', "%{$data->email}%");// create the filter 
        }

        if (isset($data->lgr_numero) AND ( (is_scalar($data->lgr_numero) AND $data->lgr_numero !== '') OR (is_array($data->lgr_numero) AND (!empty($data->lgr_numero)) )) )
        {

            $filters[] = new TFilter('lgr_numero', 'like', "%{$data->lgr_numero}%");// create the filter 
        }

        if (isset($data->lgr_nome) AND ( (is_scalar($data->lgr_nome) AND $data->lgr_nome !== '') OR (is_array($data->lgr_nome) AND (!empty($data->lgr_nome)) )) )
        {

            $filters[] = new TFilter('lgr_nome', 'like', "%{$data->lgr_nome}%");// create the filter 
        }

        if (isset($data->bairro) AND ( (is_scalar($data->bairro) AND $data->bairro !== '') OR (is_array($data->bairro) AND (!empty($data->bairro)) )) )
        {

            $filters[] = new TFilter('bairro', 'like', "%{$data->bairro}%");// create the filter 
        }

        if (isset($data->cidade) AND ( (is_scalar($data->cidade) AND $data->cidade !== '') OR (is_array($data->cidade) AND (!empty($data->cidade)) )) )
        {

            $filters[] = new TFilter('cidade', 'like', "%{$data->cidade}%");// create the filter 
        }

        if (isset($data->uf) AND ( (is_scalar($data->uf) AND $data->uf !== '') OR (is_array($data->uf) AND (!empty($data->uf)) )) )
        {

            $filters[] = new TFilter('uf', '=', $data->uf);// create the filter 
        }

        if (isset($data->cep) AND ( (is_scalar($data->cep) AND $data->cep !== '') OR (is_array($data->cep) AND (!empty($data->cep)) )) )
        {

            $filters[] = new TFilter('cep', 'like', "%{$data->cep}%");// create the filter 
        }

        if (isset($data->created_at) AND ( (is_scalar($data->created_at) AND $data->created_at !== '') OR (is_array($data->created_at) AND (!empty($data->created_at)) )) )
        {

            $filters[] = new TFilter('created_at', '=', $data->created_at);// create the filter 
        }

        if (isset($data->rg) AND ( (is_scalar($data->rg) AND $data->rg !== '') OR (is_array($data->rg) AND (!empty($data->rg)) )) )
        {

            $filters[] = new TFilter('rg', '=', $data->rg);// create the filter 
        }

        if (isset($data->column_19) AND ( (is_scalar($data->column_19) AND $data->column_19 !== '') OR (is_array($data->column_19) AND (!empty($data->column_19)) )) )
        {

            $filters[] = new TFilter('column_19', '=', $data->column_19);// create the filter 
        }

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

            // creates a repository for LeadsApi
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'id';    
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

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->id}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

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

        $object = new LeadsApi($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

