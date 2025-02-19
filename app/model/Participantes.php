<?php

class Participantes extends TRecord
{
    const TABLENAME  = 'participantes';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $carteira;
    private $leads;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('carteira_id');
        parent::addAttribute('leads_id');
            
    }

    /**
     * Method set_carteira
     * Sample of usage: $var->carteira = $object;
     * @param $object Instance of Carteira
     */
    public function set_carteira(Carteira $object)
    {
        $this->carteira = $object;
        $this->carteira_id = $object->id;
    }

    /**
     * Method get_carteira
     * Sample of usage: $var->carteira->attribute;
     * @returns Carteira instance
     */
    public function get_carteira()
    {
    
        // loads the associated object
        if (empty($this->carteira))
            $this->carteira = new Carteira($this->carteira_id);
    
        // returns the associated object
        return $this->carteira;
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

    /**
     * Method getGestaoDeCarteiras
     */
    public function getGestaoDeCarteiras()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('participantes_id', '=', $this->id));
        return GestaoDeCarteira::getObjects( $criteria );
    }

    public function set_gestao_de_carteira_participantes_to_string($gestao_de_carteira_participantes_to_string)
    {
        if(is_array($gestao_de_carteira_participantes_to_string))
        {
            $values = Participantes::where('id', 'in', $gestao_de_carteira_participantes_to_string)->getIndexedArray('id', 'id');
            $this->gestao_de_carteira_participantes_to_string = implode(', ', $values);
        }
        else
        {
            $this->gestao_de_carteira_participantes_to_string = $gestao_de_carteira_participantes_to_string;
        }

        $this->vdata['gestao_de_carteira_participantes_to_string'] = $this->gestao_de_carteira_participantes_to_string;
    }

    public function get_gestao_de_carteira_participantes_to_string()
    {
        if(!empty($this->gestao_de_carteira_participantes_to_string))
        {
            return $this->gestao_de_carteira_participantes_to_string;
        }
    
        $values = GestaoDeCarteira::where('participantes_id', '=', $this->id)->getIndexedArray('participantes_id','{participantes->id}');
        return implode(', ', $values);
    }

    
}

