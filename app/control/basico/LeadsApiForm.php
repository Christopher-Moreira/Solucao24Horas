<?php

class LeadsApiForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'api';
    private static $activeRecord = 'LeadsApi';
    private static $primaryKey = 'id';
    private static $formName = 'form_LeadsApiForm';

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
        $this->form->setFormTitle("Cadastro de leads api");


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
        $created_at = new TDateTime('created_at');
        $rg = new TEntry('rg');
        $column_19 = new TEntry('column_19');

        $nome->addValidation("Nome", new TRequiredValidator()); 
        $cpf->addValidation("Cpf", new TRequiredValidator()); 
        $idade->addValidation("Idade", new TRequiredValidator()); 
        $data_nasc->addValidation("Data nasc", new TRequiredValidator()); 
        $created_at->addValidation("Created at", new TRequiredValidator()); 
        $rg->addValidation("Rg", new TRequiredValidator()); 

        $id->setEditable(false);
        $created_at->setMask('dd/mm/yyyy hh:ii');
        $created_at->setDatabaseMask('yyyy-mm-dd hh:ii');
        $uf->setValue('NULL');
        $cep->setValue('NULL');
        $email->setValue('NULL');
        $bairro->setValue('NULL');
        $cidade->setValue('NULL');
        $celular->setValue('NULL');
        $lgr_nome->setValue('NULL');
        $lgr_numero->setValue('NULL');
        $flg_whatsapp->setValue('NULL');
        $telefone_fixo->setValue('NULL');
        $created_at->setValue('current_timestamp()');

        $uf->setMaxLength(2);
        $cpf->setMaxLength(14);
        $cep->setMaxLength(10);
        $nome->setMaxLength(255);
        $email->setMaxLength(255);
        $celular->setMaxLength(15);
        $bairro->setMaxLength(255);
        $cidade->setMaxLength(255);
        $data_nasc->setMaxLength(10);
        $lgr_nome->setMaxLength(255);
        $lgr_numero->setMaxLength(10);
        $telefone_fixo->setMaxLength(15);

        $id->setSize(100);
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
        $created_at->setSize(150);
        $lgr_nome->setSize('100%');
        $data_nasc->setSize('100%');
        $column_19->setSize('100%');
        $lgr_numero->setSize('100%');
        $flg_whatsapp->setSize('100%');
        $telefone_fixo->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Nome:", '#ff0000', '14px', null)],[$nome]);
        $row3 = $this->form->addFields([new TLabel("Cpf:", '#ff0000', '14px', null)],[$cpf]);
        $row4 = $this->form->addFields([new TLabel("Idade:", '#ff0000', '14px', null)],[$idade]);
        $row5 = $this->form->addFields([new TLabel("Data nasc:", '#ff0000', '14px', null)],[$data_nasc]);
        $row6 = $this->form->addFields([new TLabel("Celular:", null, '14px', null)],[$celular]);
        $row7 = $this->form->addFields([new TLabel("Flg whatsapp:", null, '14px', null)],[$flg_whatsapp]);
        $row8 = $this->form->addFields([new TLabel("Telefone fixo:", null, '14px', null)],[$telefone_fixo]);
        $row9 = $this->form->addFields([new TLabel("Email:", null, '14px', null)],[$email]);
        $row10 = $this->form->addFields([new TLabel("Lgr numero:", null, '14px', null)],[$lgr_numero]);
        $row11 = $this->form->addFields([new TLabel("Lgr nome:", null, '14px', null)],[$lgr_nome]);
        $row12 = $this->form->addFields([new TLabel("Bairro:", null, '14px', null)],[$bairro]);
        $row13 = $this->form->addFields([new TLabel("Cidade:", null, '14px', null)],[$cidade]);
        $row14 = $this->form->addFields([new TLabel("Uf:", null, '14px', null)],[$uf]);
        $row15 = $this->form->addFields([new TLabel("Cep:", null, '14px', null)],[$cep]);
        $row16 = $this->form->addFields([new TLabel("Created at:", '#ff0000', '14px', null)],[$created_at]);
        $row17 = $this->form->addFields([new TLabel("Rg:", '#ff0000', '14px', null)],[$rg]);
        $row18 = $this->form->addFields([new TLabel("Column 19:", null, '14px', null)],[$column_19]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['LeadsApiHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new LeadsApi(); // create an empty object 

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
            TApplication::loadPage('LeadsApiHeaderList', 'onShow', $loadPageParam); 

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

                $object = new LeadsApi($key); // instantiates the Active Record 

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

