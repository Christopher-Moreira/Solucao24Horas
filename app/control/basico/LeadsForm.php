<?php

class LeadsForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'api';
    private static $activeRecord = 'Leads';
    private static $primaryKey = 'id';
    private static $formName = 'form_LeadsForm';

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
        $this->form->setFormTitle("Cadastro de leads");

        $criteria_leads_gov_id = new TCriteria();
        $criteria_leads_api_id = new TCriteria();

        $id = new TEntry('id');
        $leads_gov_id = new TDBCombo('leads_gov_id', 'api', 'LeadsGov', 'id_servidor_portal', '{id_servidor_portal}','id_servidor_portal asc' , $criteria_leads_gov_id );
        $leads_api_id = new TDBCombo('leads_api_id', 'api', 'LeadsApi', 'id', '{id}','id asc' , $criteria_leads_api_id );
        $carteira_id = new TEntry('carteira_id');
        $flag_descontinuar = new TEntry('flag_descontinuar');
        $data_prox_contato = new TDateTime('data_prox_contato');
        $cpf = new TEntry('cpf');
        $cpf_gov = new TEntry('cpf_gov');

        $leads_gov_id->addValidation("Leads gov id", new TRequiredValidator()); 
        $leads_api_id->addValidation("Leads api id", new TRequiredValidator()); 
        $carteira_id->addValidation("Carteira id", new TRequiredValidator()); 
        $flag_descontinuar->addValidation("Flag descontinuar", new TRequiredValidator()); 
        $cpf->addValidation("Cpf", new TRequiredValidator()); 
        $cpf_gov->addValidation("Cpf gov", new TRequiredValidator()); 

        $id->setEditable(false);
        $data_prox_contato->setMask('dd/mm/yyyy hh:ii');
        $data_prox_contato->setDatabaseMask('yyyy-mm-dd hh:ii');
        $cpf_gov->setMaxLength(16);
        $leads_gov_id->enableSearch();
        $leads_api_id->enableSearch();

        $id->setSize(100);
        $cpf->setSize('100%');
        $cpf_gov->setSize('100%');
        $carteira_id->setSize('100%');
        $leads_gov_id->setSize('100%');
        $leads_api_id->setSize('100%');
        $data_prox_contato->setSize(150);
        $flag_descontinuar->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Leads gov id:", '#ff0000', '14px', null)],[$leads_gov_id]);
        $row3 = $this->form->addFields([new TLabel("Leads api id:", '#ff0000', '14px', null)],[$leads_api_id]);
        $row4 = $this->form->addFields([new TLabel("Carteira id:", '#ff0000', '14px', null)],[$carteira_id]);
        $row5 = $this->form->addFields([new TLabel("Flag descontinuar:", '#ff0000', '14px', null)],[$flag_descontinuar]);
        $row6 = $this->form->addFields([new TLabel("Data prox contato:", null, '14px', null)],[$data_prox_contato]);
        $row7 = $this->form->addFields([new TLabel("Cpf:", '#ff0000', '14px', null)],[$cpf]);
        $row8 = $this->form->addFields([new TLabel("Cpf gov:", '#ff0000', '14px', null)],[$cpf_gov]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['LeadsHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new Leads(); // create an empty object 

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
            TApplication::loadPage('LeadsHeaderList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 
        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

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

                $object = new Leads($key); // instantiates the Active Record 

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

