<?php

class Carteira extends TRecord
{
    const TABLENAME  = 'carteira';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('responsavel_id');
        parent::addAttribute('flag_ativo');
        parent::addAttribute('nome');
            
    }

    /**
     * Method getParticipantess
     */
    public function getParticipantess()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('carteira_id', '=', $this->id));
        return Participantes::getObjects( $criteria );
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
    
        $values = Participantes::where('carteira_id', '=', $this->id)->getIndexedArray('carteira_id','{carteira->id}');
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
    
        $values = Participantes::where('carteira_id', '=', $this->id)->getIndexedArray('leads_id','{leads->id}');
        return implode(', ', $values);
    }

    
}

