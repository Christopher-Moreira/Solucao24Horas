<?php

class ConsultaApi extends TRecord
{
    const TABLENAME  = 'consulta_api';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id_lote_consulta');
        parent::addAttribute('data_hora');
        parent::addAttribute('flag_utilizado');
            
    }

    
}

