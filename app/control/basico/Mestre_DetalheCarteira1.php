<?php

use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Form\THtmlEditor;
use Adianti\Wrapper\BootstrapFormBuilder;

class Mestre_DetalheCarteira extends TPage {
    private $form;
    private static $database = 'api';
    private static $activeRecord = 'Carteira';
    private static $primaryKey = 'id';
    private static $formName = 'Mestre_DetalheCarteira';

    public function __construct($param) {
        parent::__construct();

        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setFormTitle('Seleção de Carteira');

        // Critério para carregar o dropdown com as carteiras ativas
        $criteria_carteira = new TCriteria();
        $criteria_carteira->add(new TFilter('flag_ativo', '=', 1));

        // Dropdown de Carteiras
        $dropdown = new TDBCombo('carteira', 'api', 'Carteira', 'id', '{nome}', 'nome', $criteria_carteira);
        $dropdown->setSize('70%');
        $dropdown->setChangeAction(new TAction([$this, 'onChangeDropDown']));

        $this->form->addFields([new TLabel("Carteira:", null, '14px', null)], [$dropdown]);
        $this->form->setData(TSession::getValue(__CLASS__ . '_filter_data'));

        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add($this->form);

        parent::add($container);
    }

    public static function onChangeDropDown($param) {
        if (isset($param['carteira'])) {
            // Passa o ID da carteira selecionada para carregar os leads correspondentes
            $action = new TAction(['Mestre_DetalheTDados', 'onReload']);
            $action->setParameter('responsavel_id', $param['carteira']);
            TApplication::loadPage('Mestre_DetalheTDados', 'onReload', $action->getParameters());
        }
    }
}
