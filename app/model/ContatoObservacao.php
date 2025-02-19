<?php

class ContatoObservacao extends TRecord
{
    const TABLENAME  = 'contato_observacao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $gestao_de_carteira;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('data_do_contato');
        parent::addAttribute('observacoes');
        parent::addAttribute('proximo_contato');
        parent::addAttribute('gestao_de_carteira_id');
            
    }

    /**
     * Method set_gestao_de_carteira
     * Sample of usage: $var->gestao_de_carteira = $object;
     * @param $object Instance of GestaoDeCarteira
     */
    public function set_gestao_de_carteira(GestaoDeCarteira $object)
    {
        $this->gestao_de_carteira = $object;
        $this->gestao_de_carteira_id = $object->id;
    }

    /**
     * Method get_gestao_de_carteira
     * Sample of usage: $var->gestao_de_carteira->attribute;
     * @returns GestaoDeCarteira instance
     */
    public function get_gestao_de_carteira()
    {
    
        // loads the associated object
        if (empty($this->gestao_de_carteira))
            $this->gestao_de_carteira = new GestaoDeCarteira($this->gestao_de_carteira_id);
    
        // returns the associated object
        return $this->gestao_de_carteira;
    }

    
}

