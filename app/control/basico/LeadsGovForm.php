<?php

class LeadsGovForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'api';
    private static $activeRecord = 'LeadsGov';
    private static $primaryKey = 'id_servidor_portal';
    private static $formName = 'form_LeadsGovForm';

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
        $this->form->setFormTitle("Cadastro de Lead GOV");


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
        $ferias = new TRadioGroup('ferias');
        $fundo_de_saude = new TNumeric('fundo_de_saude', '2', ',', '.' );
        $irrf = new TNumeric('irrf', '2', ',', '.' );
        $mes = new TEntry('mes');
        $pensao_militar = new TNumeric('pensao_militar', '2', ',', '.' );
        $remuneracao_apos_deducoes = new TNumeric('remuneracao_apos_deducoes', '2', ',', '.' );
        $remuneracao_bruta = new TNumeric('remuneracao_bruta', '2', ',', '.' );
        $verbas_indenizatorias = new TNumeric('verbas_indenizatorias', '2', ',', '.' );

        $cpf->addValidation("Cpf", new TRequiredValidator()); 
        $cargo_id->addValidation("Cargo id", new TRequiredValidator()); 
        $matricula->addValidation("Matricula", new TRequiredValidator()); 

        $id_servidor_portal->setEditable(false);
        $ferias->addItems(["1"=>"Sim","2"=>"Não"]);
        $ferias->setLayout('vertical');
        $ferias->setBooleanMode();
        $cpf->setMaxLength(14);
        $nome->setMaxLength(128);
        $matricula->setMaxLength(10);
        $org_lotacao->setMaxLength(128);
        $tipo_vinculo->setMaxLength(128);
        $uorg_lotacao->setMaxLength(128);
        $orgsup_lotacao->setMaxLength(128);
        $descricao_cargo->setMaxLength(128);
        $regime_juridico->setMaxLength(128);
        $situacao_vinculo->setMaxLength(128);
        $tipo_aposentadoria->setMaxLength(128);
        $jornada_de_trabalho->setMaxLength(128);

        $ferias->setSize(80);
        $cpf->setSize('100%');
        $mes->setSize('100%');
        $nome->setSize('100%');
        $irrf->setSize('100%');
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
        $id_servidor_portal->setSize(100);
        $regime_juridico->setSize('100%');
        $situacao_vinculo->setSize('100%');
        $ano_aposentadoria->setSize('100%');
        $remuneracao_bruta->setSize('100%');
        $tipo_aposentadoria->setSize('100%');
        $jornada_de_trabalho->setSize('100%');
        $verbas_indenizatorias->setSize('100%');
        $remuneracao_apos_deducoes->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Cpf:", '#ff0000', '14px', null)],[$cpf]);
        $row2 = $this->form->addFields([new TLabel("Ano aposentadoria:", null, '14px', null)],[$ano_aposentadoria]);
        $row3 = $this->form->addFields([new TLabel("Ano ingresso:", null, '14px', null)],[$ano_ingresso]);
        $row4 = $this->form->addFields([new TLabel("Descricao cargo:", null, '14px', null)],[$descricao_cargo]);
        $row5 = $this->form->addFields([new TLabel("Id servidor portal:", null, '14px', null)],[$id_servidor_portal]);
        $row6 = $this->form->addFields([new TLabel("Nome:", null, '14px', null)],[$nome]);
        $row7 = $this->form->addFields([new TLabel("Jornada de trabalho:", null, '14px', null)],[$jornada_de_trabalho]);
        $row8 = $this->form->addFields([new TLabel("Cargo id:", '#ff0000', '14px', null)],[$cargo_id]);
        $row9 = $this->form->addFields([new TLabel("Matricula:", '#ff0000', '14px', null)],[$matricula]);
        $row10 = $this->form->addFields([new TLabel("Org lotacao:", null, '14px', null)],[$org_lotacao]);
        $row11 = $this->form->addFields([new TLabel("Orgsup lotacao:", null, '14px', null)],[$orgsup_lotacao]);
        $row12 = $this->form->addFields([new TLabel("Regime juridico:", null, '14px', null)],[$regime_juridico]);
        $row13 = $this->form->addFields([new TLabel("Situacao vinculo:", null, '14px', null)],[$situacao_vinculo]);
        $row14 = $this->form->addFields([new TLabel("Tipo aposentadoria:", null, '14px', null)],[$tipo_aposentadoria]);
        $row15 = $this->form->addFields([new TLabel("Tipo vinculo:", null, '14px', null)],[$tipo_vinculo]);
        $row16 = $this->form->addFields([new TLabel("Uorg lotacao:", null, '14px', null)],[$uorg_lotacao]);
        $row17 = $this->form->addFields([new TLabel("Ferias:", null, '14px', null)],[$ferias]);
        $row18 = $this->form->addFields([new TLabel("Fundo de saude:", null, '14px', null)],[$fundo_de_saude]);
        $row19 = $this->form->addFields([new TLabel("Irrf:", null, '14px', null)],[$irrf]);
        $row20 = $this->form->addFields([new TLabel("Mes:", null, '14px', null)],[$mes]);
        $row21 = $this->form->addFields([new TLabel("Pensao militar:", null, '14px', null)],[$pensao_militar]);
        $row22 = $this->form->addFields([new TLabel("Remuneracao apos deducoes:", null, '14px', null)],[$remuneracao_apos_deducoes]);
        $row23 = $this->form->addFields([new TLabel("Remuneracao bruta:", null, '14px', null)],[$remuneracao_bruta]);
        $row24 = $this->form->addFields([new TLabel("Verbas indenizatorias:", null, '14px', null)],[$verbas_indenizatorias]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['LeadsGovHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new LeadsGov(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id_servidor_portal = $object->id_servidor_portal; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('LeadsGovHeaderList', 'onShow', $loadPageParam); 

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

                $object = new LeadsGov($key); // instantiates the Active Record 

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

