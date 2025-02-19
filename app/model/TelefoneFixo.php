<?php

class TelefoneFixo extends TRecord
{
    const TABLENAME  = 'telefone_fixo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('telefone_fixo');
        parent::addAttribute('cpf');
            
    }

    
}

