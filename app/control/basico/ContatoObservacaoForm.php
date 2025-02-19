<?php

class ContatoObservacaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'api';
    private static $activeRecord = 'ContatoObservacao';
    private static $primaryKey = 'id';
    private static $formName = 'form_ContatoObservacaoForm';

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
        $this->form->setFormTitle("Cadastro observações");

        $criteria_gestao_de_carteira_id = new TCriteria();

        $id = new TEntry('id');
        $data_do_contato = new TDateTime('data_do_contato');
        $observacoes = new TEntry('observacoes');
        $proximo_contato = new TDateTime('proximo_contato');
        $gestao_de_carteira_id = new TDBCombo('gestao_de_carteira_id', 'api', 'GestaoDeCarteira', 'id', '{id}','id asc' , $criteria_gestao_de_carteira_id );

        $data_do_contato->addValidation("Data do contato", new TRequiredValidator()); 
        $observacoes->addValidation("Observacoes", new TRequiredValidator()); 
        $gestao_de_carteira_id->addValidation("Gestao de carteira id", new TRequiredValidator()); 

        $id->setEditable(false);
        $gestao_de_carteira_id->enableSearch();
        $data_do_contato->setMask('dd/mm/yyyy hh:ii');
        $proximo_contato->setMask('dd/mm/yyyy hh:ii');

        $data_do_contato->setDatabaseMask('yyyy-mm-dd hh:ii');
        $proximo_contato->setDatabaseMask('yyyy-mm-dd hh:ii');

        $id->setSize(100);
        $observacoes->setSize('100%');
        $data_do_contato->setSize(150);
        $proximo_contato->setSize(150);
        $gestao_de_carteira_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Data do contato:", '#ff0000', '14px', null)],[$data_do_contato]);
        $row3 = $this->form->addFields([new TLabel("Observacoes:", '#ff0000', '14px', null)],[$observacoes]);
        $row4 = $this->form->addFields([new TLabel("Proximo contato:", null, '14px', null)],[$proximo_contato]);
        $row5 = $this->form->addFields([new TLabel("Gestao de carteira id:", '#ff0000', '14px', null)],[$gestao_de_carteira_id]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ContatoObservacaoHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new ContatoObservacao(); // create an empty object 

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
            TApplication::loadPage('ContatoObservacaoHeaderList', 'onShow', $loadPageParam); 

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

                $object = new ContatoObservacao($key); // instantiates the Active Record 

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

