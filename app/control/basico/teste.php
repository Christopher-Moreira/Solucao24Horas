<?php

use Adianti\Widget\Wrapper\TDBCombo;

class teste extends TPage{

    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'leads';
    private static $activeRecord = 'email';
    private static $primaryKey = 'id';
    private static $formName = 'Mestre_DetalheForm';
    private $showMethods = ['onReload', 'onSearch'];
    private $limit = 20;
    public $dropdown;
    
    
    public function __construct( $param ){
        parent::__construct();
        
        $notebook1 = new TNotebook;
        $notebook2 = new TNotebook;
        
        $notebook1->appendPage('page1', new TLabel('Page 1'));
        $notebook1->appendPage('page2', new TLabel('Page 2'));
        
        $notebook2->appendPage('page1', new TLabel('Page 1'));
        $notebook2->appendPage('page2', new TLabel('Page 2'));
        
        $notebook1->setSize(null,100);
        $notebook2->setSize(null,100);
        
        // creates the vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add($notebook1);
        $vbox->add($notebook2);
        parent::add($vbox);
        }
    }