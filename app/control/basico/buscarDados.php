<?php

class buscarDados extends TPage
{
     public function __construct()
    {
        parent::__construct();
        
            TScript::create('window.open("https://solucao24horas.com/importacao/BuscarDados.php","_blank")');
        
    }
    function onShow(){
  }     
}
