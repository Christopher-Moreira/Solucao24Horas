<?php

class Leads extends TRecord
{
    const TABLENAME  = 'leads';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $leads_gov;
    private $leads_api;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('leads_gov_id');
        parent::addAttribute('leads_api_id');
        parent::addAttribute('carteira_id');
        parent::addAttribute('flag_descontinuar');
        parent::addAttribute('data_prox_contato');
        parent::addAttribute('cpf');
        parent::addAttribute('cpf_gov');
            
    }

    /**
     * Method set_leads_gov
     * Sample of usage: $var->leads_gov = $object;
     * @param $object Instance of LeadsGov
     */
    public function set_leads_gov(LeadsGov $object)
    {
        $this->leads_gov = $object;
        $this->leads_gov_id = $object->id_servidor_portal;
    }

    /**
     * Method get_leads_gov
     * Sample of usage: $var->leads_gov->attribute;
     * @returns LeadsGov instance
     */
    public function get_leads_gov()
    {
    
        // loads the associated object
        if (empty($this->leads_gov))
            $this->leads_gov = new LeadsGov($this->leads_gov_id);
    
        // returns the associated object
        return $this->leads_gov;
    }
    /**
     * Method set_leads_api
     * Sample of usage: $var->leads_api = $object;
     * @param $object Instance of LeadsApi
     */
    public function set_leads_api(LeadsApi $object)
    {
        $this->leads_api = $object;
        $this->leads_api_id = $object->id;
    }

    /**
     * Method get_leads_api
     * Sample of usage: $var->leads_api->attribute;
     * @returns LeadsApi instance
     */
    public function get_leads_api()
    {
    
        // loads the associated object
        if (empty($this->leads_api))
            $this->leads_api = new LeadsApi($this->leads_api_id);
    
        // returns the associated object
        return $this->leads_api;
    }

    /**
     * Method getParentess
     */
    public function getParentess()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('leads_id', '=', $this->id));
        return Parentes::getObjects( $criteria );
    }
    /**
     * Method getParticipantess
     */
    public function getParticipantess()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('leads_id', '=', $this->id));
        return Participantes::getObjects( $criteria );
    }

    public function set_parentes_leads_to_string($parentes_leads_to_string)
    {
        if(is_array($parentes_leads_to_string))
        {
            $values = Leads::where('id', 'in', $parentes_leads_to_string)->getIndexedArray('id', 'id');
            $this->parentes_leads_to_string = implode(', ', $values);
        }
        else
        {
            $this->parentes_leads_to_string = $parentes_leads_to_string;
        }

        $this->vdata['parentes_leads_to_string'] = $this->parentes_leads_to_string;
    }

    public function get_parentes_leads_to_string()
    {
        if(!empty($this->parentes_leads_to_string))
        {
            return $this->parentes_leads_to_string;
        }
    
        $values = Parentes::where('leads_id', '=', $this->id)->getIndexedArray('leads_id','{leads->id}');
        return implode(', ', $values);
    }

    public function set_participantes_carteira_to_string($participantes_carteira_to_string)
    {
        if(is_array($participantes_carteira_to_string))
        {
            $values = Carteira::where('id', 'in', $participantes_carteira_to_string)->getIndexedArray('id', 'id');
            $this->participantes_carteira_to_string = implode(', ', $values);
        }
        else
        {
            $this->participantes_carteira_to_string = $participantes_carteira_to_string;
        }

        $this->vdata['participantes_carteira_to_string'] = $this->participantes_carteira_to_string;
    }

    public function get_participantes_carteira_to_string()
    {
        if(!empty($this->participantes_carteira_to_string))
        {
            return $this->participantes_carteira_to_string;
        }
    
        $values = Participantes::where('leads_id', '=', $this->id)->getIndexedArray('carteira_id','{carteira->id}');
        return implode(', ', $values);
    }

    public function set_participantes_leads_to_string($participantes_leads_to_string)
    {
        if(is_array($participantes_leads_to_string))
        {
            $values = Leads::where('id', 'in', $participantes_leads_to_string)->getIndexedArray('id', 'id');
            $this->participantes_leads_to_string = implode(', ', $values);
        }
        else
        {
            $this->participantes_leads_to_string = $participantes_leads_to_string;
        }

        $this->vdata['participantes_leads_to_string'] = $this->participantes_leads_to_string;
    }

    public function get_participantes_leads_to_string()
    {
        if(!empty($this->participantes_leads_to_string))
        {
            return $this->participantes_leads_to_string;
        }
    
        $values = Participantes::where('leads_id', '=', $this->id)->getIndexedArray('leads_id','{leads->id}');
        return implode(', ', $values);
    }

    
}

