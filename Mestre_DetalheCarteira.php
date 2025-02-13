<?php

use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Form\THtmlEditor;
use Adianti\Wrapper\BootstrapFormBuilder;


class Mestre_DetalheCarteira extends TPage {

    private $form; // form de Dados Pessoais
    private $formVinculos; // form de Vínculos
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'api';
    private static $activeRecord = 'Carteira';
    private static $primaryKey = 'id';
    private static $formName = 'Mestre_DetalheCarteira';
    private $showMethods = ['onReload', 'onSearch'];
    private $limit = 20;

    public function __construct($param) {
        parent::__construct();

        
        $this->form = new BootstrapFormBuilder(self::$formName);
        // Titulo
        $this->form->setFormTitle('Teste');
    
        $criteria_carteira = new TCriteria();
    
        $dropdown = new TDBCombo('carteira', 'api', 'Carteira', 'id', '{nome}', 'nome', $criteria_carteira);
        $dropdown->setSize('70%');
        $dropdown->setChangeAction(new TAction([$this, 'onChangeDropDown'])); // Adiciona ação de mudança
    
        $this->form->addFields([new TLabel("Carteira:", null, '14px', null)], [$dropdown]);
    
        $this->form->setData(TSession::getValue(__CLASS__ . '_filter_data'));
    
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add($this->form);
    
        parent::add($container);

    }

    public static function onChangeDropDown ($param) {
        if (isset($param['carteira'])) {
            // Passa o id selecionado no dropdown para a página Mestre_DetalheV3
            $action = new TAction(['Mestre_DetalheV3', 'onReload']);
            $action->setParameter('responsavel_id', $param['carteira']); // Envia o ID selecionado
            TApplication::loadPage('Mestre_DetalheV3', 'onReload', $action->getParameters());
        }
    }
}
    