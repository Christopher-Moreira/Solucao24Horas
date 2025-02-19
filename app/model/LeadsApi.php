<?php

class LeadsApi extends TRecord
{
    const TABLENAME  = 'leads_api';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('cpf');
        parent::addAttribute('idade');
        parent::addAttribute('data_nasc');
        parent::addAttribute('signo');
        parent::addAttribute('flg_whatsapp');
        parent::addAttribute('telefone_fixo');
        parent::addAttribute('email');
        parent::addAttribute('lgr_numero');
        parent::addAttribute('lgr_nome');
        parent::addAttribute('bairro');
        parent::addAttribute('cidade');
        parent::addAttribute('uf');
        parent::addAttribute('cep');
        parent::addAttribute('created_at');
        parent::addAttribute('rg');
        parent::addAttribute('column_19');
        parent::addAttribute('Escolaridade');
        parent::addAttribute('NOME_MAE');
        parent::addAttribute('NOME_PAI');
        parent::addAttribute('SEXO');
        parent::addAttribute('cel_1');
        parent::addAttribute('cel_2');
        parent::addAttribute('cel_3');
        parent::addAttribute('cel_4');
        parent::addAttribute('cel_5');
        parent::addAttribute('cel_6');
        parent::addAttribute('cel_7');
        parent::addAttribute('cel_8');
        parent::addAttribute('cel_9');
        parent::addAttribute('cel_10');
        parent::addAttribute('fixo_1');
        parent::addAttribute('fixo_2');
        parent::addAttribute('fixo_3');
        parent::addAttribute('fixo_4');
        parent::addAttribute('fixo_5');
        parent::addAttribute('fixo_6');
        parent::addAttribute('fixo_7');
        parent::addAttribute('fixo_8');
        parent::addAttribute('fixo_9');
        parent::addAttribute('fixo_10');
        parent::addAttribute('Email_1');
        parent::addAttribute('Email_2');
        parent::addAttribute('Email_3');
        parent::addAttribute('Email_4');
        parent::addAttribute('Email_5');
        parent::addAttribute('Email_6');
        parent::addAttribute('Email_7');
        parent::addAttribute('Email_8');
        parent::addAttribute('Email_9');
        parent::addAttribute('Email_10');
        parent::addAttribute('end_tipo_logradouro_1');
        parent::addAttribute('end_logradouro_1');
        parent::addAttribute('end_num_1');
        parent::addAttribute('end_complemento_1');
        parent::addAttribute('end_bairro_1');
        parent::addAttribute('end_cidade_1');
        parent::addAttribute('end_estado_1');
        parent::addAttribute('end_cep_1');
         parent::addAttribute('end_tipo_logradouro_2');
        parent::addAttribute('end_logradouro_2');
        parent::addAttribute('end_num_2');
        parent::addAttribute('end_complemento_2');
        parent::addAttribute('end_bairro_2');
        parent::addAttribute('end_cidade_2');
        parent::addAttribute('end_estado_2');
        parent::addAttribute('end_cep_2');
          parent::addAttribute('end_tipo_logradouro_3');
        parent::addAttribute('end_logradouro_3');
        parent::addAttribute('end_num_3');
        parent::addAttribute('end_complemento_3');
        parent::addAttribute('end_bairro_3');
        parent::addAttribute('end_cidade_3');
        parent::addAttribute('end_estado_3');
        parent::addAttribute('end_cep_3');
          parent::addAttribute('end_tipo_logradouro_4');
        parent::addAttribute('end_logradouro_4');
        parent::addAttribute('end_num_4');
        parent::addAttribute('end_complemento_4');
        parent::addAttribute('end_bairro_4');
        parent::addAttribute('end_cidade_4');
        parent::addAttribute('end_estado_4');
        parent::addAttribute('end_cep_4');
          parent::addAttribute('end_tipo_logradouro_5');
        parent::addAttribute('end_logradouro_5');
        parent::addAttribute('end_num_5');
        parent::addAttribute('end_complemento_5');
        parent::addAttribute('end_bairro_5');
        parent::addAttribute('end_cidade_5');
        parent::addAttribute('end_estado_5');
        parent::addAttribute('end_cep_5');
            
    }

    /**
     * Method getLeadss
     */
    public function getLeadss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('leads_api_id', '=', $this->id));
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
    
        $values = Leads::where('leads_api_id', '=', $this->id)->getIndexedArray('leads_gov_id','{leads_gov->id_servidor_portal}');
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
    
        $values = Leads::where('leads_api_id', '=', $this->id)->getIndexedArray('leads_api_id','{leads_api->id}');
        return implode(', ', $values);
    }

    
}

