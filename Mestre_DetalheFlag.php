<?php

use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Form\THtmlEditor;
use Adianti\Wrapper\BootstrapFormBuilder;


class Mestre_DetalheFlag extends TPage {

    private $form; // form de Dados Pessoais
    private $formVinculos; // form de Vínculos
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'api';
    private static $activeRecord = 'Leads';
    private static $primaryKey = 'id';
    private static $formName = 'Mestre_DetalheFlag';
    private $showMethods = ['onReload', 'onSearch'];
    private $limit = 20;

    public function __construct( $param )
    {
        parent::__construct();

            if(!empty($param['target_container']))
            {
                $this->adianti_target_container = $param['target_container'];
            }
        
            $this->form = new BootstrapFormBuilder(self::$formName);
            // define the form title
            $this->form->setFormTitle("Gostaria de continuar o contato?");



            $id = new TEntry('id');
            $id->setEditable(false);

            $leads_gov_id = new TEntry('leads_gov_id');
            
            $leads_api_id = new TEntry('leads_api_id');

            $carteira_id = new TEntry('carteira_id');

            

            $flag_ativo = new TRadioGroup('flag_descontinuar');
                $flag_ativo->addItems(["0"=>"Sim","1"=>"Não"]);
                $flag_ativo->setBooleanMode();

                $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
                $this->form->addFields([new TLabel("leads_gov_id:", null, '14px', null)],[$leads_gov_id]);
                $this->form->addFields([new TLabel("leads_api_id:", null, '14px', null)],[$leads_api_id]);
                $this->form->addFields([new TLabel("carteira_id:", null, '14px', null)],[$carteira_id]);
                $this->form->addFields([new TLabel("Continuar contato?:", null, '14px', null)],[$flag_ativo]);
                


                $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
                    $this->btn_onsave = $btn_onsave;
                    $btn_onsave->addStyleClass('btn-primary'); 

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



    public function onShow($param){

    }
}