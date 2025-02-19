<?php

class ParentesForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'api';
    private static $activeRecord = 'Parentes';
    private static $primaryKey = 'id';
    private static $formName = 'form_ParentesForm';

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
        $this->form->setFormTitle("Cadastro de parentes");

        $criteria_leads_id = new TCriteria();

        $id = new TEntry('id');
        $leads_id = new TDBCombo('leads_id', 'api', 'Leads', 'id', '{id}','id asc' , $criteria_leads_id );
        $parentesco = new TEntry('parentesco');
        $parentesco_cpf = new TEntry('parentesco_cpf');
        $parentesco_nome = new TEntry('parentesco_nome');
        $cpf = new TEntry('cpf');

        $leads_id->addValidation("Leads id", new TRequiredValidator()); 
        $parentesco->addValidation("Parentesco", new TRequiredValidator()); 
        $parentesco_nome->addValidation("Parentesco nome", new TRequiredValidator()); 

        $id->setEditable(false);
        $leads_id->enableSearch();
        $cpf->setMaxLength(16);
        $parentesco->setMaxLength(50);
        $parentesco_cpf->setMaxLength(50);
        $parentesco_nome->setMaxLength(128);

        $id->setSize(100);
        $cpf->setSize('100%');
        $leads_id->setSize('100%');
        $parentesco->setSize('100%');
        $parentesco_cpf->setSize('100%');
        $parentesco_nome->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Leads id:", '#ff0000', '14px', null)],[$leads_id]);
        $row3 = $this->form->addFields([new TLabel("Parentesco:", '#ff0000', '14px', null)],[$parentesco]);
        $row4 = $this->form->addFields([new TLabel("Parentesco cpf:", null, '14px', null)],[$parentesco_cpf]);
        $row5 = $this->form->addFields([new TLabel("Parentesco nome:", '#ff0000', '14px', null)],[$parentesco_nome]);
        $row6 = $this->form->addFields([new TLabel("Cpf:", null, '14px', null)],[$cpf]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ParentesHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new Parentes(); // create an empty object 

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
            TApplication::loadPage('ParentesHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Parentes($key); // instantiates the Active Record 

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

