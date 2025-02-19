<?php

class importacao extends TPage
{
     public function __construct()
    {
        parent::__construct();
        
            TScript::create('window.open("https://solucao24horas.com/importacao/GeraDados.php","_blank")');
        
    }
    function onShow(){
  }     
}
