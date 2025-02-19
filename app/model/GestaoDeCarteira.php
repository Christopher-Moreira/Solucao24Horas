<?php

class GestaoDeCarteira extends TRecord
{
    const TABLENAME  = 'gestao_de_carteira';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $participantes;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('correspondencia_flag');
        parent::addAttribute('participantes_id');
            
    }

    /**
     * Method set_participantes
     * Sample of usage: $var->participantes = $object;
     * @param $object Instance of Participantes
     */
    public function set_participantes(Participantes $object)
    {
        $this->participantes = $object;
        $this->participantes_id = $object->id;
    }

    /**
     * Method get_participantes
     * Sample of usage: $var->participantes->attribute;
     * @returns Participantes instance
     */
    public function get_participantes()
    {
    
        // loads the associated object
        if (empty($this->participantes))
            $this->participantes = new Participantes($this->participantes_id);
    
        // returns the associated object
        return $this->participantes;
    }

    /**
     * Method getContatoObservacaos
     */
    public function getContatoObservacaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('gestao_de_carteira_id', '=', $this->id));
        return ContatoObservacao::getObjects( $criteria );
    }

    public function set_contato_observacao_gestao_de_carteira_to_string($contato_observacao_gestao_de_carteira_to_string)
    {
        if(is_array($contato_observacao_gestao_de_carteira_to_string))
        {
            $values = GestaoDeCarteira::where('id', 'in', $contato_observacao_gestao_de_carteira_to_string)->getIndexedArray('id', 'id');
            $this->contato_observacao_gestao_de_carteira_to_string = implode(', ', $values);
        }
        else
        {
            $this->contato_observacao_gestao_de_carteira_to_string = $contato_observacao_gestao_de_carteira_to_string;
        }

        $this->vdata['contato_observacao_gestao_de_carteira_to_string'] = $this->contato_observacao_gestao_de_carteira_to_string;
    }

    public function get_contato_observacao_gestao_de_carteira_to_string()
    {
        if(!empty($this->contato_observacao_gestao_de_carteira_to_string))
        {
            return $this->contato_observacao_gestao_de_carteira_to_string;
        }
    
        $values = ContatoObservacao::where('gestao_de_carteira_id', '=', $this->id)->getIndexedArray('gestao_de_carteira_id','{gestao_de_carteira->id}');
        return implode(', ', $values);
    }

    
}

