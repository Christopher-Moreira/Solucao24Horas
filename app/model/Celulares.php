<?php

class Celulares extends TRecord
{
    const TABLENAME  = 'celulares';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('celular');
        parent::addAttribute('cpf');
        parent::addAttribute('flag_whatsapp');
            
    }

    
}

