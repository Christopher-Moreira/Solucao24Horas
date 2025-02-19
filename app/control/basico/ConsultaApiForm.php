<?php

class ConsultaApiForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'api';
    private static $activeRecord = 'ConsultaApi';
    private static $primaryKey = 'id';
    private static $formName = 'form_ConsultaApiForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de consulta api");


        $id = new TEntry('id');
        $id_lote_consulta = new TEntry('id_lote_consulta');
        $data_hora = new TDateTime('data_hora');
        $flag_utilizado = new TCombo('flag_utilizado');

        $id_lote_consulta->addValidation("Id lote consulta", new TRequiredValidator()); 
        $data_hora->addValidation("Data hora", new TRequiredValidator()); 
        $flag_utilizado->addValidation("Flag utilizado", new TRequiredValidator()); 

        $id_lote_consulta->setMaxLength(50);
        $data_hora->setMask('dd/mm/yyyy hh:ii');
        $data_hora->setValue('CURRENT_TIMESTAMP');
        $data_hora->setDatabaseMask('yyyy-mm-dd hh:ii');
        $flag_utilizado->addItems(["0"=>" Não","1"=>"Sim"]);
        $flag_utilizado->enableSearch();
        $id->setEditable(false);
        $data_hora->setEditable(false);
        $id_lote_consulta->setEditable(false);

        $id->setSize(100);
        $data_hora->setSize(150);
        $flag_utilizado->setSize('100%');
        $id_lote_consulta->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Id lote consulta:", '#ff0000', '14px', null)],[$id_lote_consulta]);
        $row3 = $this->form->addFields([new TLabel("Data hora:", '#ff0000', '14px', null)],[$data_hora]);
        $row4 = $this->form->addFields([new TLabel("Flag utilizado:", '#ff0000', '14px', null)],[$flag_utilizado]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ConsultaApiHeaderList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new ConsultaApi(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('ConsultaApiHeaderList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 
        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new ConsultaApi($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

