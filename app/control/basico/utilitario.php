<?php

class utilitario extends TPage
{
     public function __construct()
    {
        parent::__construct();
        
            TScript::create('window.open("https://solucao24horas.com/utilitario/utilitario.php","_blank")');
        
    }
    function onShow(){
  }     
}
