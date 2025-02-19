<?php

class Email extends TRecord
{
    const TABLENAME  = 'email';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cpf');
        parent::addAttribute('email');
        parent::addAttribute('leads_api_id');
            
    }

    
}

