<?php

class LeadsGov extends TRecord
{
    const TABLENAME  = 'leads_gov';
    const PRIMARYKEY = 'id_servidor_portal';
    const IDPOLICY   =  'serial'; // {max, serial}

    const Veriano = '675971';
    const Celso = '3001956';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cpf');
        parent::addAttribute('ano_aposentadoria');
        parent::addAttribute('ano_ingresso');
        parent::addAttribute('descricao_cargo');
        parent::addAttribute('nome');
        parent::addAttribute('jornada_de_trabalho');
        parent::addAttribute('cargo_id');
        parent::addAttribute('matricula');
        parent::addAttribute('org_lotacao');
        parent::addAttribute('orgsup_lotacao');
        parent::addAttribute('regime_juridico');
        parent::addAttribute('situacao_vinculo');
        parent::addAttribute('tipo_aposentadoria');
        parent::addAttribute('tipo_vinculo');
        parent::addAttribute('uorg_lotacao');
        parent::addAttribute('ferias');
        parent::addAttribute('fundo_de_saude');
        parent::addAttribute('irrf');
        parent::addAttribute('mes');
        parent::addAttribute('pensao_militar');
        parent::addAttribute('remuneracao_apos_deducoes');
        parent::addAttribute('remuneracao_bruta');
        parent::addAttribute('verbas_indenizatorias');
        parent::addAttribute('flag_usado');
            
    }

    /**
     * Method getLeadss
     */
    public function getLeadss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('leads_gov_id', '=', $this->id_servidor_portal));
        return Leads::getObjects( $criteria );
    }

    public function set_leads_leads_gov_to_string($leads_leads_gov_to_string)
    {
        if(is_array($leads_leads_gov_to_string))
        {
            $values = LeadsGov::where('id_servidor_portal', 'in', $leads_leads_gov_to_string)->getIndexedArray('id_servidor_portal', 'id_servidor_portal');
            $this->leads_leads_gov_to_string = implode(', ', $values);
        }
        else
        {
            $this->leads_leads_gov_to_string = $leads_leads_gov_to_string;
        }

        $this->vdata['leads_leads_gov_to_string'] = $this->leads_leads_gov_to_string;
    }

    public function get_leads_leads_gov_to_string()
    {
        if(!empty($this->leads_leads_gov_to_string))
        {
            return $this->leads_leads_gov_to_string;
        }
    
        $values = Leads::where('leads_gov_id', '=', $this->id_servidor_portal)->getIndexedArray('leads_gov_id','{leads_gov->id_servidor_portal}');
        return implode(', ', $values);
    }

    public function set_leads_leads_api_to_string($leads_leads_api_to_string)
    {
        if(is_array($leads_leads_api_to_string))
        {
            $values = LeadsApi::where('id', 'in', $leads_leads_api_to_string)->getIndexedArray('id', 'id');
            $this->leads_leads_api_to_string = implode(', ', $values);
        }
        else
        {
            $this->leads_leads_api_to_string = $leads_leads_api_to_string;
        }

        $this->vdata['leads_leads_api_to_string'] = $this->leads_leads_api_to_string;
    }

    public function get_leads_leads_api_to_string()
    {
        if(!empty($this->leads_leads_api_to_string))
        {
            return $this->leads_leads_api_to_string;
        }
    
        $values = Leads::where('leads_gov_id', '=', $this->id_servidor_portal)->getIndexedArray('leads_api_id','{leads_api->id}');
        return implode(', ', $values);
    }

    
}

