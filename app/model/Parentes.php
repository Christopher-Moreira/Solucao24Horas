<?php

class Parentes extends TRecord
{
    const TABLENAME  = 'parentes';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $leads;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('leads_id');
        parent::addAttribute('parentesco');
        parent::addAttribute('parentesco_cpf');
        parent::addAttribute('parentesco_nome');
        parent::addAttribute('cpf');
            
    }

    /**
     * Method set_leads
     * Sample of usage: $var->leads = $object;
     * @param $object Instance of Leads
     */
    public function set_leads(Leads $object)
    {
        $this->leads = $object;
        $this->leads_id = $object->id;
    }

    /**
     * Method get_leads
     * Sample of usage: $var->leads->attribute;
     * @returns Leads instance
     */
    public function get_leads()
    {
    
        // loads the associated object
        if (empty($this->leads))
            $this->leads = new Leads($this->leads_id);
    
        // returns the associated object
        return $this->leads;
    }

    
}

