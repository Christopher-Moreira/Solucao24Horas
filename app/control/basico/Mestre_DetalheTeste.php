    <?php

    use Adianti\Database\TTransaction;
    use Adianti\Widget\Container\TNotebook;
    use Adianti\Widget\Datagrid\TDataGridColumn;
    use Adianti\Widget\Form\THtmlEditor;
    use Adianti\Widget\Wrapper\TDBRadioGroup;
    use Adianti\Wrapper\BootstrapFormBuilder;


    class Mestre_DetalheTeste extends TPage {

        private $form; // form de Dados Pessoais
        private $formVinculos; // form de Vínculos
        private $datagrid; // listing
        private $pageNavigation;
        private $loaded;
        private $filter_criteria;
        private static $database = 'api';
        private static $activeRecord = 'Leads';
        private static $primaryKey = 'id';
        private static $formName = 'Mestre_DetalheTeste';
        private $showMethods = ['onReload', 'onSearch'];
        private $limit = 20;

        public function __construct($param) {
            parent::__construct();
           
            TSession::setValue('responsavel_id', $param['responsavel_id']);

            $this->form = new BootstrapFormBuilder(self::$formName);
            $this->form->setFormTitle('Estados');
            
             // Cria o campo de seleção para UF
            $uf = new TCombo('uf');
            $uf->addItems([
                'AC' => 'Acre',
                'AL' => 'Alagoas',
                'AP' => 'Amapá',
                'AM' => 'Amazonas',
                'BA' => 'Bahia',
                'CE' => 'Ceará',
                'DF' => 'Distrito Federal',
                'ES' => 'Espírito Santo',
                'GO' => 'Goiás',
                'MA' => 'Maranhão',
                'MT' => 'Mato Grosso',
                'MS' => 'Mato Grosso do Sul',
                'MG' => 'Minas Gerais',
                'PA' => 'Pará',
                'PB' => 'Paraíba',
                'PR' => 'Paraná',
                'PE' => 'Pernambuco',
                'PI' => 'Piauí',
                'RJ' => 'Rio de Janeiro',
                'RN' => 'Rio Grande do Norte',
                'RS' => 'Rio Grande do Sul',
                'RO' => 'Rondônia',
                'RR' => 'Roraima',
                'SC' => 'Santa Catarina',
                'SP' => 'São Paulo',
                'SE' => 'Sergipe',
                'TO' => 'Tocantins'
            ]);
            $uf->setChangeAction(new TAction(['Mestre_DetalheTeste', 'onFilterChange']));
    
            $this->form->addFields([new TLabel('UF:')], [$uf]);

            $btn_clear = $this->form->addAction("Limpar Parâmetros", new TAction([$this, 'onLimparParametros']), 'fas:trash-alt');
            $btn_clear->addStyleClass('btn btn-danger');

            $this->datagrid = new TDataGrid;
            $this->datagrid->disableHtmlConversion();
        
            $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);

            $this->filter_criteria = new TCriteria;

            $this->datagrid->style = 'width: 100%';
            $this->datagrid->setHeight(320);

/*
*/
            $notebook = new TNotebook('Leads');
            
            $column_id = new TDataGridColumn('id', "ID", 'left');
            $column_uf = new TDataGridColumn('uf', "UF", 'left');
             $column_cidade = new TDataGridColumn('cidade', "cidade", 'left');
            $column_cpf = new TDataGridColumn('cpf', "Cpf", 'left');
            $column_nome = new TDataGridColumn('nome', "Nome", 'left');
            $column_carteira_id = new TDataGridColumn('carteira_id', 'Carteira ID', 'left');
            $column_flag_ativo = new TDataGridColumn('flag_ativo', "Ativo", 'left');
            $column_flag_ativo->setTransformer(function($value, $object) {
                return $object->flag_descontinuar == 0 ? 'Sim' : 'Não';
            });

            $order_id_servidor_portal = new TAction(array($this, 'onReload'));
            $order_id_servidor_portal->setParameter('order', 'id_servidor_portal');
            
              //  $this->datagrid->addcolumn($column_id);
                $this->datagrid->addcolumn($column_uf);
                 $this->datagrid->addcolumn($column_cidade);
                $this->datagrid->addColumn($column_cpf);
                $this->datagrid->addColumn($column_nome);
                $this->datagrid->addColumn($column_carteira_id);
                $this->datagrid->addColumn($column_flag_ativo);

                $this->datagrid->style = 'width: 100%;';
    $this->datagrid->setHeight(320);

    // Adiciona um contêiner para a barra de rolagem
    $scrollContainer = new TElement('div');
    $scrollContainer->style = 'height: 750px; overflow-y: auto;'; // Define a altura e a rolagem

    // Adiciona a datagrid ao contêiner
  
       $scrollContainer->add($this->form);
       $scrollContainer->add($this->datagrid);

    // Adiciona a datagrid com rolagem ao notebook
    $notebook->appendPage('Listagem da Carteira', $scrollContainer);

        

            $action_onEdit = new TDataGridAction(array('Mestre_DetalheTeste', 'onEdit'));
            $action_onEdit->setUseButton(false);
            $action_onEdit->setButtonClass('btn btn-default btn-sm');
            $action_onEdit->setLabel("Visualizar");
            $action_onEdit->setImage('far:eye #48c48c');
            $action_onEdit->setField('id');
            $action_onEdit->setParameter('responsavel_id', $param['responsavel_id']); 
            $action_onEdit->setParameter('cpf', '{cpf}');
            $action_onEdit->setParameter('uf', '{uf}');
            
            

            $this->datagrid->addAction($action_onEdit);

            $this->datagrid->createModel();

        

            $this->form = new BootstrapFormBuilder(self::$formName);
            $this->form->setFormTitle('Dados Pessoais');

            
                $notebook2 = new TNotebook('Leads');
                // Campos para dados pessoais
                    $nome = new TEntry('nome');
                        $nome->setEditable(false);
                        $nome->setMaxLength(14);
                        $nome->setSize('60%');


                    $cpf = new TEntry('cpf');
                        $cpf->setEditable(false);
                        $cpf->setMaxLength(14);
                        $cpf->setSize('60%');


                    $NOME_MAE = new TEntry('NOME_MAE');
                        $NOME_MAE->setEditable(false);
                        $NOME_MAE->setMaxLength(14);
                        $NOME_MAE->setSize('60%');
                        
                        $NOME_PAI = new TEntry('NOME_PAI');
                        $NOME_PAI->setEditable(false);
                        $NOME_PAI->setMaxLength(14);
                        $NOME_PAI->setSize('60%');

                    $SEXO = new TEntry('SEXO');
                        $SEXO->setEditable(false);
                        $SEXO->setMaxLength(14);
                        $SEXO->setSize('60%');
                    
                    $Escolaridade = new TEntry('Escolaridade');
                        $Escolaridade->setEditable(false);
                        $Escolaridade->setMaxLength(14);
                        $Escolaridade->setSize('60%');



                    $parentesco_nome = new TEntry ('parentesco_nome');
                        $parentesco_nome->setEditable(false);
                        $parentesco_nome->setMaxLength(14);
                        $parentesco_nome->setSize('60%');

                    $nasc = new TEntry('data_nasc');
                        $nasc->setEditable(false);
                        $nasc->setMaxLength(14);
                        $nasc->setSize('60%');
                        
                        $idade = new TEntry('idade');
                        $idade->setEditable(false);
                        $idade->setMaxLength(14);
                        $idade->setSize('60%');
                        
                        $signo = new TEntry('signo');
                        $signo->setEditable(false);
                        $signo->setMaxLength(14);
                        $signo->setSize('60%');

                        $rg = new TEntry('rg');
                            $rg->setEditable(false);
                            $rg->setMaxLength(100);
                            $rg->setSize('60%');

                    $telefone = new TEntry('telefone');
                        $telefone->setEditable(false);
                        $telefone->setMaxLength(14);
                        $telefone->setSize('60%');
                
                    // Adicionando campos ao formulário de Dados Pessoais
                    $this->form->addFields([new TLabel('Nome:')], [$nome]);
                    $this->form->addFields([new TLabel('CPF:')], [$cpf]);
                    $this->form->addFields([new TLabel('Nome Mãe:')], [$NOME_MAE]);
                    $this->form->addFields([new TLabel('Nome Pai:')], [$NOME_PAI]);
                    $this->form->addFields([new TLabel('Data de Nascimento:')], [$nasc]);
                    $this->form->addFields([new TLabel('Idade:')], [$idade]);
                    $this->form->addFields([new TLabel('Signo:')], [$signo]);
                    $this->form->addFields([new TLabel('Escolidade:')], [$Escolaridade]);
                    $this->form->addFields([new TLabel('Sexo:')], [$SEXO]);
                    $this->form->addFields([new TLabel('RG:')], [$rg]);

                    $cpfValue = isset($param['cpf']) ? $param['cpf'] : null;
            

                    $notebook2->appendPage('Dados Pessoais', $this->form);


            

        

   $this->formContato = new BootstrapFormBuilder('formContato');
                    $this->formContato->setFormTitle('Contato');
        
        

                    $id_contato = new THidden('id');
                        $id_contato->setEditable(false);
                      
                        $id_contato->setSize('60%');

        
                        $data_do_contato = new TEntry('data_do_contato');
                        $data_do_contato->setValue(date('Y-m-d')); // Atribui a data de hoje
                        $data_do_contato->setSize('60%');


                    $observacoes = new THtmlEditor('observacoes');
                        
                        $observacoes->setSize('60%', '200');
                        $observacoes->setSize('60%');
        
                        $proximo_contato = new TDate('proximo_contato');
                        $proximo_contato->setMask('dd/mm/yyyy'); // Define o formato de data
                        $proximo_contato->setDatabaseMask('yyyy-mm-dd'); // Define o formato para o banco de dados
                        $proximo_contato->setSize('60%');

                    $gestao_de_carteira_id = new THidden('gestao_de_carteira_id');
                        $gestao_de_carteira_id->setEditable(false);
                       
                        $gestao_de_carteira_id->setSize('60%');

        
                        
        
        
                        $this->formContato->addFields([new TLabel('')], [$id_contato]);
                        $this->formContato->addFields([new TLabel('Primeiro Contato')], [$data_do_contato]);
                        $this->formContato->addFields([new TLabel('Anotação')], [$observacoes]);
                        $this->formContato->addFields([new TLabel('Próximo Contato')], [$proximo_contato]);
                        $this->formContato->addFields([new TLabel('')], [ $gestao_de_carteira_id]);
        
                       
                        $btn_contato = $this->formContato->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
                        $btn_contato->addStyleClass('btn-success');
                        $btn_contato->style = 'background-color: #48c48c; color: white;';
                        
        
        
        
                $notebook2->appendPage('Contato', $this->formContato);
        
        
                    $this->formCargo = new BootstrapFormBuilder('formCargo');
                    $this->formCargo->setFormTitle('LeadsGov');
        
                        $cargo = new TEntry('descricao_cargo');
                            $cargo->setEditable(false);
                            $cargo->setMaxLength(14);
                            $cargo->setSize('60%');
        
        
                        $ano_ingresso = new TEntry('ano_ingresso');
                            $ano_ingresso->setEditable(false);
                            $ano_ingresso->setMaxLength(14);
                            $ano_ingresso->setSize('60%');
        
                        $ano_aposentadoria = new TEntry('ano_aposentadoria');
                            $ano_aposentadoria->setEditable(false);
                            $ano_aposentadoria->setMaxLength(14);
                            $ano_aposentadoria->setSize('60%');
        
                        $jornada_de_trabalho = new TEntry('jornada_de_trabalho');
                            $jornada_de_trabalho->setEditable(false);
                            $jornada_de_trabalho->setMaxLength(14);
                            $jornada_de_trabalho->setSize('60%');
        
                        $org_lotacao = new TEntry('org_lotacao');
                            $org_lotacao->setEditable(false);
                            $org_lotacao->setMaxLength(14);
                            $org_lotacao->setSize('60%');
        
                        
        
        
                        $this->formCargo->addFields([new TLabel('Cargo:')], [$cargo]);
                        $this->formCargo->addFields([new TLabel('Ano de Ingresso:')], [$ano_ingresso]);
                        $this->formCargo->addFields([new TLabel('Ano de Aposentadoria:')], [$ano_aposentadoria]);
                        $this->formCargo->addFields([new TLabel('Jornada de Trabalho:')], [$jornada_de_trabalho]);
                        $this->formCargo->addFields([new TLabel('Lotação:')], [$org_lotacao]);
        

                $notebook2->appendPage('Cargo', $this->formCargo);
        
        
                    $this->formRemuneracao = new BootstrapFormBuilder('formRemuneracao');
                    $this->formRemuneracao->setFormTitle('Remuneração');
        
                    $remuneracao_bruta = new TEntry('remuneracao_bruta');
                        $remuneracao_bruta->setEditable(false);
                        $remuneracao_bruta->setMaxLength(14);
                        $remuneracao_bruta->setSize('60%');
        
                    
        
                    $remuneracao_apos_deducoes = new TEntry('remuneracao_apos_deducoes');
                        $remuneracao_apos_deducoes->setEditable(false);
                        $remuneracao_apos_deducoes->setMaxLength(14);
                        $remuneracao_apos_deducoes->setSize('60%');
        
                        $this->formRemuneracao->addFields([new TLabel('Remuneração Bruta:')], [$remuneracao_bruta]);
                        $this->formRemuneracao->addFields([new TLabel('Remuneração Após Deduções:')], [$remuneracao_apos_deducoes]);
        
        
        
        
        
                $notebook2->appendPage('Remuneração', $this->formRemuneracao);
        
                    
        
                $this->formGov = new BootstrapFormBuilder('formGov');
                $this->formGov->setFormTitle('GOV');
        
                $orgsup_lotacao = new TEntry('orgsup_lotacao');
                    $orgsup_lotacao->setEditable(false);
                    $orgsup_lotacao->setMaxLength(14);
                    $orgsup_lotacao->setSize('60%');
        
                $regime_juridico = new TEntry('regime_juridico');
                    $regime_juridico->setEditable(false);
                    $regime_juridico->setMaxLength(14);
                    $regime_juridico->setSize('60%');
        
                $pensao_militar = new TEntry('pensao_militar');
                    $pensao_militar->setEditable(false);
                    $pensao_militar->setMaxLength(14);
                    $pensao_militar->setSize('60%');
        
                $irrf = new TEntry('irrf');
                    $irrf->setEditable(false);
                    $irrf->setMaxLength(14);
                    $irrf->setSize('60%');
        
                $fundo_de_saude = new TEntry('fundo_de_saude');
                    $fundo_de_saude->setEditable(false);
                    $fundo_de_saude->setMaxLength(14);
                    $fundo_de_saude->setSize('60%');
        
                $verbas_indenizatorias = new TEntry('verbas_indenizatorias');
                    $verbas_indenizatorias->setEditable(false);
                    $verbas_indenizatorias->setMaxLength(14);
                    $verbas_indenizatorias->setSize('60%');
        
                $situacao_vinculo = new TEntry('situacao_vinculo');
                    $situacao_vinculo->setEditable(false);
                    $situacao_vinculo->setMaxLength(14);
                    $situacao_vinculo->setSize('60%');
        
                $tipo_aposentadoria = new TEntry('tipo_aposentadoria');
                    $tipo_aposentadoria->setEditable(false);
                    $tipo_aposentadoria->setMaxLength(14);
                    $tipo_aposentadoria->setSize('60%');
        
                $tipo_vinculo = new TEntry('tipo_vinculo');
                    $tipo_vinculo->setEditable(false);
                    $tipo_vinculo->setMaxLength(14);
                    $tipo_vinculo->setSize('60%');
        
                $uorg_lotacao = new TEntry('uorg_lotacao');
                    $uorg_lotacao->setEditable(false);
                    $uorg_lotacao->setMaxLength(14);
                    $uorg_lotacao->setSize('60%');
                
                $ferias = new TEntry('ferias');
                    $ferias->setEditable(false);
                    $ferias->setMaxLength(14);
                    $ferias->setSize('60%');
        
                $mes = new TEntry('mes');
                    $mes ->setEditable(false);
                    $mes ->setMaxLength(14);
                    $mes ->setSize('60%');
        
                    $this->formGov->addFields([new TLabel('Orgão Suporte Lotação:')], [$orgsup_lotacao]);
                    $this->formGov->addFields([new TLabel('Regime Juridico:')], [$regime_juridico]);
                    $this->formGov->addFields([new TLabel('Vinculo:')], [$situacao_vinculo]);
                    $this->formGov->addFields([new TLabel('Tipo de Aposentadoria:')], [$tipo_aposentadoria]);
                    $this->formGov->addFields([new TLabel('Tipo de Vinculo:')], [$tipo_vinculo]);
                    $this->formGov->addFields([new TLabel('Uorg Lotação:')], [$uorg_lotacao]);
                    $this->formGov->addFields([new TLabel('Ferias:')], [$ferias]);
                    $this->formGov->addFields([new TLabel('Mês:')], [$mes]);
                    $this->formGov->addFields([new TLabel('Pensão Militar:')], [$pensao_militar]);
                    $this->formGov->addFields([new TLabel('IRRF:')], [$irrf]);
                    $this->formGov->addFields([new TLabel('Fundo de Saúde:')], [$fundo_de_saude]);
                    $this->formGov->addFields([new TLabel('Verbas indenizatorias:')], [$verbas_indenizatorias]);
        
            
                $notebook2->appendPage('GOV', $this->formGov);

                

                


                $this->formEnderecos = new BootstrapFormBuilder('formEnderecos');
                $this->formEnderecos->setFormTitle('Endereços');
                
                // Campos do primeiro endereço
                $end_num_1 = new TEntry('end_num_1');
                $end_num_1->setMaxLength(10);
                $end_num_1->setSize('100%');
                $end_num_1->setEditable(false);
                
                $end_logradouro_1 = new TEntry('end_logradouro_1');
                $end_logradouro_1->setMaxLength(50);
                $end_logradouro_1->setSize('100%');
                $end_logradouro_1->setEditable(false);
                
                $end_bairro_1 = new TEntry('end_bairro_1');
                $end_bairro_1->setMaxLength(50);
                $end_bairro_1->setSize('100%');
                $end_bairro_1->setEditable(false);
                
                $end_cidade_1 = new TEntry('end_cidade_1');
                $end_cidade_1->setMaxLength(50);
                $end_cidade_1->setSize('100%');
                $end_cidade_1->setEditable(false);
                
                $end_estado_1 = new TEntry('end_estado_1');
                $end_estado_1->setMaxLength(2);
                $end_estado_1->setSize('100%');
                $end_estado_1->setEditable(false);
                
                $end_cep_1 = new TEntry('end_cep_1');
                $end_cep_1->setMaxLength(10);
                $end_cep_1->setSize('100%');
                $end_cep_1->setEditable(false);
                
                // Campos do segundo endereço
                $end_num_2 = new TEntry('end_num_2');
                $end_num_2->setMaxLength(10);
                $end_num_2->setSize('100%');
                $end_num_2->setEditable(false);
                
                $end_logradouro_2 = new TEntry('end_logradouro_2');
                $end_logradouro_2->setMaxLength(50);
                $end_logradouro_2->setSize('100%');
                $end_logradouro_2->setEditable(false);
                
                $end_bairro_2 = new TEntry('end_bairro_2');
                $end_bairro_2->setMaxLength(50);
                $end_bairro_2->setSize('100%');
                $end_bairro_2->setEditable(false);
                
                $end_cidade_2 = new TEntry('end_cidade_2');
                $end_cidade_2->setMaxLength(50);
                $end_cidade_2->setSize('100%');
                $end_cidade_2->setEditable(false);
                
                $end_estado_2 = new TEntry('end_estado_2');
                $end_estado_2->setMaxLength(2);
                $end_estado_2->setSize('100%');
                $end_estado_2->setEditable(false);
                
                $end_cep_2 = new TEntry('end_cep_2');
                $end_cep_2->setMaxLength(10);
                $end_cep_2->setSize('100%');
                $end_cep_2->setEditable(false);

                //Campos do terceiro endereco
                $end_num_3 = new TEntry('end_num_3');
                $end_num_3->setMaxLength(10);
                $end_num_3->setSize('100%');
                $end_num_3->setEditable(false);

                $end_logradouro_3 = new TEntry('end_logradouro_3');
                $end_logradouro_3->setMaxLength(50);
                $end_logradouro_3->setSize('100%');
                $end_logradouro_3->setEditable(false);

                $end_bairro_3 = new TEntry('end_bairro_3');
                $end_bairro_3->setMaxLength(50);
                $end_bairro_3->setSize('100%');
                $end_bairro_3->setEditable(false);

                $end_cidade_3 = new TEntry('end_cidade_3');
                $end_cidade_3->setMaxLength(50);
                $end_cidade_3->setSize('100%');
                $end_cidade_3->setEditable(false);

                $end_estado_3 = new TEntry('end_estado_3');
                $end_estado_3->setMaxLength(2);
                $end_estado_3->setSize('100%');
                $end_estado_3->setEditable(false);

                $end_cep_3 = new TEntry('end_cep_3');
                $end_cep_3->setMaxLength(10);
                $end_cep_3->setSize('100%');
                $end_cep_3->setEditable(false);

                //Campos do quarto endereco
                $end_num_4 = new TEntry('end_num_4');
                $end_num_4->setMaxLength(10);
                $end_num_4->setSize('100%');
                $end_num_4->setEditable(false);

                $end_logradouro_4 = new TEntry('end_logradouro_4');
                $end_logradouro_4->setMaxLength(50);
                $end_logradouro_4->setSize('100%');
                $end_logradouro_4->setEditable(false);

                $end_bairro_4 = new TEntry('end_bairro_4');
                $end_bairro_4->setMaxLength(50);
                $end_bairro_4->setSize('100%');
                $end_bairro_4->setEditable(false);

                $end_cidade_4 = new TEntry('end_cidade_4');
                $end_cidade_4->setMaxLength(50);
                $end_cidade_4->setSize('100%');
                $end_cidade_4->setEditable(false);

                $end_estado_4 = new TEntry('end_estado_4');
                $end_estado_4->setMaxLength(2);
                $end_estado_4->setSize('100%');
                $end_estado_4->setEditable(false);

                $end_cep_4 = new TEntry('end_cep_4');
                $end_cep_4->setMaxLength(10);
                $end_cep_4->setSize('100%');
                $end_cep_4->setEditable(false);

                //Campos do quinto endereco
                $end_num_5 = new TEntry('end_num_5');
                $end_num_5->setMaxLength(10);
                $end_num_5->setSize('100%');
                $end_num_5->setEditable(false);

                $end_logradouro_5 = new TEntry('end_logradouro_5');
                $end_logradouro_5->setMaxLength(50);
                $end_logradouro_5->setSize('100%');
                $end_logradouro_5->setEditable(false);

                $end_bairro_5 = new TEntry('end_bairro_5');
                $end_bairro_5->setMaxLength(50);
                $end_bairro_5->setSize('100%');
                $end_bairro_5->setEditable(false);

                $end_cidade_5 = new TEntry('end_cidade_5');
                $end_cidade_5->setMaxLength(50);
                $end_cidade_5->setSize('100%');
                $end_cidade_5->setEditable(false);

                $end_estado_5 = new TEntry('end_estado_5');
                $end_estado_5->setMaxLength(2);
                $end_estado_5->setSize('100%');
                $end_estado_5->setEditable(false);

                $end_cep_5 = new TEntry('end_cep_5');
                $end_cep_5->setMaxLength(10);
                $end_cep_5->setSize('100%');
                $end_cep_5->setEditable(false);



                
                // Adicionando campos do primeiro e segundo endereço lado a lado
                $this->formEnderecos->addFields([new TLabel('Número 1')], [$end_num_1], [new TLabel('Número 2')], [$end_num_2]);
                $this->formEnderecos->addFields([new TLabel('Logradouro 1')], [$end_logradouro_1], [new TLabel('Logradouro 2')], [$end_logradouro_2]);
                $this->formEnderecos->addFields([new TLabel('Bairro 1')], [$end_bairro_1], [new TLabel('Bairro 2')], [$end_bairro_2]);
                $this->formEnderecos->addFields([new TLabel('Cidade 1')], [$end_cidade_1], [new TLabel('Cidade 2')], [$end_cidade_2]);
                $this->formEnderecos->addFields([new TLabel('UF 1')], [$end_estado_1], [new TLabel('UF 2')], [$end_estado_2]);
                $this->formEnderecos->addFields([new TLabel('CEP 1')], [$end_cep_1], [new TLabel('CEP 2')], [$end_cep_2]);

                $this->formEnderecos->addContent([new TElement('br')]);

                $this->formEnderecos->addFields([new TLabel('Número 3')], [$end_num_3], [new TLabel('Número 4')], [$end_num_4]);
                $this->formEnderecos->addFields([new TLabel('Logradouro 3')], [$end_logradouro_3], [new TLabel('Logradouro 4')], [$end_logradouro_4]);
                $this->formEnderecos->addFields([new TLabel('Bairro 3')], [$end_bairro_3], [new TLabel('Bairro 4')], [$end_bairro_4]);
                $this->formEnderecos->addFields([new TLabel('Cidade 3')], [$end_cidade_3], [new TLabel('Cidade 4')], [$end_cidade_4]);
                $this->formEnderecos->addFields([new TLabel('UF 3')], [$end_estado_3], [new TLabel('UF 4')], [$end_estado_4]);
                $this->formEnderecos->addFields([new TLabel('CEP 3')], [$end_cep_3], [new TLabel('CEP 4')], [$end_cep_4]);

                $this->formEnderecos->addContent([new TElement('br')]);

                $this->formEnderecos->addFields([new TLabel('Número 5')], [$end_num_5]);
                $this->formEnderecos->addFields([new TLabel('Logradouro 5')], [$end_logradouro_5]);
                $this->formEnderecos->addFields([new TLabel('Bairro 5')], [$end_bairro_5]);
                $this->formEnderecos->addFields([new TLabel('Cidade 5')], [$end_cidade_5]);
                $this->formEnderecos->addFields([new TLabel('UF 5')], [$end_estado_5]);
                $this->formEnderecos->addFields([new TLabel('CEP 5')], [$end_cep_5]);

    $notebook2->appendPage('Enderecos', $this->formEnderecos);


            $this->formEmails = new BootstrapFormBuilder('forEmails');
            $this->formEmails->setFormTitle('Emails');

            $Email_1 = new TEntry('Email_1');
            $Email_1->setMaxLength(50);
            $Email_1->setSize('100%');
            $Email_1->setEditable(false);

            $Email_2 = new TEntry('Email_2');
            $Email_2->setMaxLength(50);
            $Email_2->setSize('100%');
            $Email_2->setEditable(false);

            $Email_3 = new TEntry('Email_3');
            $Email_3->setMaxLength(50);
            $Email_3->setSize('100%');
            $Email_3->setEditable(false);

            $Email_4 = new TEntry('Email_4');
            $Email_4->setMaxLength(50);
            $Email_4->setSize('100%');
            $Email_4->setEditable(false);

            $Email_5 = new TEntry('Email_5');
            $Email_5->setMaxLength(50);
            $Email_5->setSize('100%');
            $Email_5->setEditable(false);

            $Email_6 = new TEntry('Email_6');
            $Email_6->setMaxLength(50);
            $Email_6->setSize('100%');
            $Email_6->setEditable(false);

            $Email_7 = new TEntry('Email_7');
            $Email_7->setMaxLength(50);
            $Email_7->setSize('100%');
            $Email_7->setEditable(false);

            $Email_8 = new TEntry('Email_8');
            $Email_8->setMaxLength(50);
            $Email_8->setSize('100%');
            $Email_8->setEditable(false);

            $Email_9 = new TEntry('Email_9');
            $Email_9->setMaxLength(50);
            $Email_9->setSize('100%');
            $Email_9->setEditable(false);

            $Email_10 = new TEntry('Email_10');
            $Email_10->setMaxLength(50);
            $Email_10->setSize('100%');
            $Email_10->setEditable(false);



            $this->formEmails->addFields([new TLabel('Email 1')], [$Email_1]);
            $this->formEmails->addFields([new TLabel('Email 2')], [$Email_2]);
            $this->formEmails->addFields([new TLabel('Email 3')], [$Email_3]);
            $this->formEmails->addFields([new TLabel('Email 4')], [$Email_4]);
            $this->formEmails->addFields([new TLabel('Email 5')], [$Email_5]);
            $this->formEmails->addFields([new TLabel('Email 6')], [$Email_6]);
            $this->formEmails->addFields([new TLabel('Email 7')], [$Email_7]);
            $this->formEmails->addFields([new TLabel('Email 8')], [$Email_8]);
            $this->formEmails->addFields([new TLabel('Email 9')], [$Email_9]);
            $this->formEmails->addFields([new TLabel('Email 10')], [$Email_10]);
            
            
            

    $notebook2->appendPage('Emails', $this->formEmails);

            $this->formCelular = new BootstrapFormBuilder('Celulares');
            $this->formCelular->setFormTitle('Celulares');
                
            $cel_1 = new TEntry('cel_1');
            $cel_1->setMaxLength(50);
            $cel_1->setSize('100%');
            $cel_1->setEditable(false);

            $cel_2 = new TEntry('cel_2');
            $cel_2->setMaxLength(50);
            $cel_2->setSize('100%');
            $cel_2->setEditable(false);

            $cel_3 = new TEntry('cel_3');
            $cel_3->setMaxLength(50);
            $cel_3->setSize('100%');
            $cel_3->setEditable(false);

            $cel_4 = new TEntry('cel_4');
            $cel_4->setMaxLength(50);
            $cel_4->setSize('100%');
            $cel_4->setEditable(false);

            $cel_5 = new TEntry('cel_5');
            $cel_5->setMaxLength(50);
            $cel_5->setSize('100%');
            $cel_5->setEditable(false);

            $cel_6 = new TEntry('cel_6');
            $cel_6->setMaxLength(50);
            $cel_6->setSize('100%');
            $cel_6->setEditable(false);

            $cel_7 = new TEntry('cel_7');
            $cel_7->setMaxLength(50);
            $cel_7->setSize('100%');
            $cel_7->setEditable(false);

            $cel_8 = new TEntry('cel_8');
            $cel_8->setMaxLength(50);
            $cel_8->setSize('100%');
            $cel_8->setEditable(false);

            $cel_9 = new TEntry('cel_9');
            $cel_9->setMaxLength(50);
            $cel_9->setSize('100%');
            $cel_9->setEditable(false);

            $cel_10 = new TEntry('cel_10');
            $cel_10->setMaxLength(50);
            $cel_10->setSize('100%');
            $cel_10->setEditable(false);




            $this->formCelular->addFields([new TLabel('Celular 1:')], [$cel_1]);
            $this->formCelular->addFields([new TLabel('Celular 2:')], [$cel_2]);
            $this->formCelular->addFields([new TLabel('Celular 3:')], [$cel_3]);
            $this->formCelular->addFields([new TLabel('Celular 4:')], [$cel_4]);
            $this->formCelular->addFields([new TLabel('Celular 5:')], [$cel_5]);
            $this->formCelular->addFields([new TLabel('Celular 6:')], [$cel_6]);
            $this->formCelular->addFields([new TLabel('Celular 7:')], [$cel_7]);
            $this->formCelular->addFields([new TLabel('Celular 8:')], [$cel_8]);
            $this->formCelular->addFields([new TLabel('Celular 9:')], [$cel_9]);
            $this->formCelular->addFields([new TLabel('Celular 10:')], [$cel_10]);
            
            


    $notebook2->appendPage('Celulares', $this->formCelular);

        $this->formTelefoneFixo = new BootstrapFormBuilder('Telefones Fixos');
        $this->formTelefoneFixo->setFormTitle('Telefones Fixos');

        $fixo_1 = new TEntry('fixo_1');
        $fixo_1->setMaxLength(50);
        $fixo_1->setSize('100%');
        $fixo_1->setEditable(false);
        
        $fixo_2 = new TEntry('fixo_2');
        $fixo_2->setMaxLength(50);
        $fixo_2->setSize('100%');
        $fixo_2->setEditable(false);
        
        $fixo_3 = new TEntry('fixo_3');
        $fixo_3->setMaxLength(50);
        $fixo_3->setSize('100%');
        $fixo_3->setEditable(false);
        
        $fixo_4 = new TEntry('fixo_4');
        $fixo_4->setMaxLength(50);
        $fixo_4->setSize('100%');
        $fixo_4->setEditable(false);
        
        $fixo_5 = new TEntry('fixo_5');
        $fixo_5->setMaxLength(50);
        $fixo_5->setSize('100%');
        $fixo_5->setEditable(false);
        
        $fixo_6 = new TEntry('fixo_6');
        $fixo_6->setMaxLength(50);
        $fixo_6->setSize('100%');
        $fixo_6->setEditable(false);
        
        $fixo_7 = new TEntry('fixo_7');
        $fixo_7->setMaxLength(50);
        $fixo_7->setSize('100%');
        $fixo_7->setEditable(false);
        
        $fixo_8 = new TEntry('fixo_8');
        $fixo_8->setMaxLength(50);
        $fixo_8->setSize('100%');
        $fixo_8->setEditable(false);
        
        $fixo_9 = new TEntry('fixo_9');
        $fixo_9->setMaxLength(50);
        $fixo_9->setSize('100%');
        $fixo_9->setEditable(false);
        
        $fixo_10 = new TEntry('fixo_10');
        $fixo_10->setMaxLength(50);
        $fixo_10->setSize('100%');
        $fixo_10->setEditable(false);
        



        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 1:')], [$fixo_1]);
        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 2:')], [$fixo_2]);
        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 3:')], [$fixo_3]);
        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 4:')], [$fixo_4]);
        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 5:')], [$fixo_5]);
        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 6:')], [$fixo_6]);
        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 7:')], [$fixo_7]);
        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 8:')], [$fixo_8]);
        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 9:')], [$fixo_9]);
        $this->formTelefoneFixo->addFields([new TLabel('Telefone Fixo 10:')], [$fixo_10]);
        

        
    $notebook2->appendPage('Telefones Fixos', $this->formTelefoneFixo);

          //  $notebook3 = new TNotebook('Leads');
                
            $this->formFlag = new BootstrapFormBuilder('formFlag');
            $this->formFlag->setFormTitle('Status de Contato');


            $id = new THidden('id');
            $id->setEditable(false);

            $leads_gov_id = new THidden('leads_gov_id');
            
            $leads_api_id = new THidden('leads_api_id');

            $carteira_id = new THidden('carteira_id');

            

            $flag_descontinuar = new TRadioGroup('flag_descontinuar');
                $flag_descontinuar->addItems(["1"=>"Sim","0"=>"Não"]);
                $flag_descontinuar->setBooleanMode();
            
                $this->formFlag->addFields([new TLabel("Parar contato?", null, '25px', 'center')]);
                $this->formFlag->addFields([new TLabel("", null, '14px', null)],[$flag_descontinuar]);
                $this->formFlag->addFields([new TLabel("Id:", 'white', '14px', null)],[$id]);
                $this->formFlag->addFields([new TLabel("leads_gov_id:", 'white', '14px', null)],[$leads_gov_id]);
                $this->formFlag->addFields([new TLabel("leads_api_id:", 'white', '14px', null)],[$leads_api_id]);
                $this->formFlag->addFields([new TLabel("carteira_id:", 'white', '14px', null)],[$carteira_id]);
              
                


                $btn_onsave = $this->formFlag->addAction("Salvar", new TAction([$this, 'onSaveContato']), 'fas:save #ffffff');
                    $this->btn_onsave = $btn_onsave;
                    $btn_onsave->addStyleClass('btn-primary'); 
                    $btn_onsave->addStyleClass('btn-success');
                    $btn_onsave->style = 'background-color: #48c48c; color: white;';


                    $notebook2->appendPage('Status Contato', $this->formFlag);
                     

                    

            
            $vbox = new TVBox;
            $vbox->style = 'width: 100%';
            
            // Cria um HBox para colocar formBaixo e formLado lado a lado
            $hbox = new TElement('div');
            $hbox->style = 'display: flex; width:100%; overflow-x: auto; white-space: nowrap;';
            
            // FormBaixo
            $formBaixoWrapper = new TElement('div');
            $formBaixoWrapper->style = 'flex: 0 0 15%; padding: 10px;'; 
            $formBaixoWrapper->add($notebook); 
            $hbox->add($formBaixoWrapper);

            $formLadoWrapper = new TElement('div');
            $formLadoWrapper->style = 'flex: 0 0 55%; padding: 10px;';
            $formLadoWrapper->add($notebook2); 
            $hbox->add($formLadoWrapper);


            $vbox->add($hbox);

        
            parent::add($vbox);
            }

            public function onSave($param) {
                
                try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->formContato->validate(); // validate form data

            $object = new ContatoObservacao(); // create an empty object 

            $data = $this->formContato->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->formContato->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
           // TApplication::loadPage('ContatoObservacaoHeaderList', 'onShow', $loadPageParam); 
              echo "<script>location.reload();</script>";
                 exit;

                        TScript::create("Template.closeRightPanel();"); 
        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
            
            }   
/*mudei aqui*/
public function onEdit($param) {
    
                // Verifica se o ID do lead foi passado
                if (isset($param['id'])) {
                    $lead_id = $param['id'];

                    try {
                        TTransaction::open(self::$database);

                        // Busca o lead na tabela leads
                        $lead = Leads::find($lead_id);
                        if ($lead) {
                            if ($lead->flag_descontinuar == 0) {
                            // Busca os dados do lead na tabela leads_api
                            $leads_api = LeadsApi::where('id', '=', $lead->leads_api_id)->first();
                            
                            // Busca os dados do servidor na tabela leads_gov
                            $leads_gov = LeadsGov::where('id_servidor_portal', '=', $lead->leads_gov_id)->first();


                        //    $contato = ContatoObservacao::where('id', '=', $lead->id)->first();
                            $contato = ContatoObservacao::where('id', '=', $lead->id)->first();

                           

                            $participantes = Participantes::where('leads_id', '=', $lead->id)->first();

                            $contato2 = GestaoDeCarteira::where('id', '=', $participantes->id)->first();
                                
                            
                    //     $endereco = Enderecos::where('id', '=', $lead->id)->first();
                            
                            // Preenche o formulário com os dados do lead
                            $this->formFlag->setData((object) [
                                'id' => $lead->id,
                                'leads_gov_id' => $lead->leads_gov_id,
                                'leads_api_id' => $lead->leads_api_id,
                                'carteira_id' => $lead->carteira_id,
                                'flag_descontinuar' => $lead->flag_descontinuar,
                            ]);

                                if($contato2){
                                    $this->formContato->setData((object) [
                                        'gestao_de_carteira_id'=>$contato2->id-1,
                                    ]);
                }

       

                            if ($contato) {
                                $this->formContato->setData((object) [
                                'id' => $contato->id,
                                'data_do_contato' => $contato->data_do_contato,
                                'proximo_contato' => $contato->proximo_contato,
                                
                                'observacoes' =>$contato->observacoes,

                                ]);
                                
                            }
                            
           
                            
                            // Preenche o formulário com os dados do lead
                            $this->formFlag->setData((object) [
                                'id' => $lead->id,
                                'leads_gov_id' => $lead->leads_gov_id,
                                'leads_api_id' => $lead->leads_api_id,
                                'carteira_id' => $lead->carteira_id,
                                'flag_descontinuar' => $lead->flag_descontinuar,
                            ]);

                            if ($contato) {
                                $this->formContato->setData((object) [
                                'id' => $contato->id,
                                'data_do_contato' => $contato->data_do_contato,
                                'proximo_contato' => $contato->proximo_contato,
                                'gestao_de_carteira_id' =>$contato->gestao_de_carteira_id,
                                'observacoes' =>$contato->observacoes,

                                ]);
                            }
                            if ($leads_api) {
                                $this->form->setData((object) [
                                    'nome' => $leads_api->nome,
                                    'cpf' => $leads_api->cpf,
                                    'data_nasc' => $leads_api->data_nasc,
                                    'idade' => $leads_api->idade,
                                    'signo' => $leads_api->signo,
                                    'rg' => $leads_api->rg,  
                                    'NOME_MAE' => $leads_api->NOME_MAE,  
                                    'NOME_PAI' => $leads_api->NOME_PAI,  
                                    'SEXO' => $leads_api->SEXO,
                                    'Escolaridade' =>$leads_api->Escolaridade,
                                     'uf' => $leads_api->end_estado_1,
                                    'cidade' =>$leads_api->end_cidade_1,
                                ]);
                            }

                        


                        if($leads_api){
                                $this->formEnderecos->setData((object)[
                                    'end_num_1' => $leads_api->end_num_1,  
                                    'end_logradouro_1' => $leads_api->end_logradouro_1, 
                                    'end_bairro_1' => $leads_api->end_bairro_1,  
                                    'end_cidade_1' => $leads_api->end_cidade_1, 
                                    'end_estado_1' => $leads_api->end_estado_1,  
                                    'end_cep_1' => $leads_api->end_cep_1, 

                                    'end_num_2' => $leads_api->end_num_2,
                                    'end_logradouro_2' => $leads_api->end_logradouro_2,
                                    'end_bairro_2' => $leads_api->end_bairro_2,
                                    'end_cidade_2' => $leads_api->end_cidade_2,
                                    'end_estado_2' => $leads_api->end_estado_2,
                                    'end_cep_2' => $leads_api->end_cep_2,

                                    'end_num_3' => $leads_api->end_num_3,
                                    'end_logradouro_3' => $leads_api->end_logradouro_3,
                                    'end_bairro_3' => $leads_api->end_bairro_3,
                                    'end_cidade_3' => $leads_api->end_cidade_3,
                                    'end_estado_3' => $leads_api->end_estado_3,
                                    'end_cep_3' => $leads_api->end_cep_3,

                                    'end_num_4' => $leads_api->end_num_4,
                                    'end_logradouro_4' => $leads_api->end_logradouro_4,
                                    'end_bairro_4' => $leads_api->end_bairro_4,
                                    'end_cidade_4' => $leads_api->end_cidade_4,
                                    'end_estado_4' => $leads_api->end_estado_4,
                                    'end_cep_4' => $leads_api->end_cep_4,

                                    'end_num_5' => $leads_api->end_num_5,
                                    'end_logradouro_5' => $leads_api->end_logradouro_5,
                                    'end_bairro_5' => $leads_api->end_bairro_5,
                                    'end_cidade_5' => $leads_api->end_cidade_5,
                                    'end_estado_5' => $leads_api->end_estado_5,
                                    'end_cep_5' => $leads_api->end_cep_5,




                                ]);
                            } 

                            if($leads_api){
                                $this->formEmails->setData((object)[
                                    'Email_1' => $leads_api->Email_1,
                                    'Email_2' => $leads_api->Email_2,
                                    'Email_3' => $leads_api->Email_3,
                                    'Email_4' => $leads_api->Email_4,
                                    'Email_5' => $leads_api->Email_5,
                                    'Email_6' => $leads_api->Email_6,
                                    'Email_7' => $leads_api->Email_7,
                                    'Email_8' => $leads_api->Email_8,
                                    'Email_9' => $leads_api->Email_9,
                                    'Email_10' => $leads_api->Email_10,
    


                                ]);
                            } 

                            if($leads_api){
                                $this->formCelular->setData((object)[

                                    'cel_1' => $leads_api->cel_1,
                                    'cel_2' => $leads_api->cel_2,
                                    'cel_3' => $leads_api->cel_3,
                                    'cel_4' => $leads_api->cel_4,
                                    'cel_5' => $leads_api->cel_5,
                                    'cel_6' => $leads_api->cel_6,
                                    'cel_7' => $leads_api->cel_7,
                                    'cel_8' => $leads_api->cel_8,
                                    'cel_9' => $leads_api->cel_9,
                                    'cel_10' => $leads_api->cel_10,

                                ]);
                            } 
                            if($leads_api){
                                $this->formTelefoneFixo->setData((object)[
                                    'fixo_1' => $leads_api->fixo_1,
                                    'fixo_2' => $leads_api->fixo_2,
                                    'fixo_3' => $leads_api->fixo_3,
                                    'fixo_4' => $leads_api->fixo_4,
                                    'fixo_5' => $leads_api->fixo_5,
                                    'fixo_6' => $leads_api->fixo_6,
                                    'fixo_7' => $leads_api->fixo_7,
                                    'fixo_8' => $leads_api->fixo_8,
                                    'fixo_9' => $leads_api->fixo_9,
                                    'fixo_10' => $leads_api->fixo_10,


                                ]);
                            } 

                            if ($leads_gov) {
                                $this->formCargo->setData((object) [
                                    'descricao_cargo' => $leads_gov->descricao_cargo,
                                    'ano_ingresso' => $leads_gov->ano_ingresso,
                                    'ano_aposentadoria' => $leads_gov->ano_aposentadoria,
                                    'jornada_de_trabalho' => $leads_gov->jornada_de_trabalho,
                                    'org_lotacao' => $leads_gov->org_lotacao,
                                ]);
                            }
                            
                            if($leads_gov){
                                $this->formRemuneracao->setData((object) [
                                    
                                    'remuneracao_bruta' => $leads_gov->remuneracao_bruta,
                                    'remuneracao_apos_deducoes' => $leads_gov->remuneracao_apos_deducoes,


                                ]);
                            
                            }
                            if ($leads_gov) {
                                $this->formGov->setData((object) [
                                    'orgsup_lotacao' => $leads_gov->orgsup_lotacao,
                                    'regime_juridico' => $leads_gov->regime_juridico,
                                    'pensao_militar' => $leads_gov->pensao_militar,
                                    'irrf' => $leads_gov->irrf,
                                    'fundo_de_saude' => $leads_gov->fundo_de_saude,
                                    'verbas_indenizatorias' => $leads_gov->verbas_indenizatorias,
                                    'situacao_vinculo' => $leads_gov->situacao_vinculo,
                                    'tipo_aposentadoria' => $leads_gov->tipo_aposentadoria,
                                    'tipo_vinculo' => $leads_gov->tipo_vinculo,
                                    'uorg_lotacao' => $leads_gov->uorg_lotacao,
                                    'ferias' => $leads_gov->ferias,
                                    'mes' => $leads_gov->mes,
                                ]);
                            }
                        
                    
                            
                        } else {
                            new TMessage('error', 'Este registro está desativado e não pode ser editado.');
                        }
                    } else {
                        new TMessage('error', 'Lead não encontrado.');
                    }
                    
                    TTransaction::close();
                } catch (Exception $e) {
                    TTransaction::rollback();
                    new TMessage('error', $e->getMessage());
                    }
                }

            
            }
            
//a funcao ta conseguindo atualizar a URL mas ela nao consegue rodar a onReload
public static function onFilterChange($param)
{
    // Verifica se o parâmetro 'uf' foi passado
    if (isset($param['uf'])) {
        // Obtém o valor da UF selecionada
        $uf = $param['uf'];

        // Obtém o responsavel_id da sessão
        $responsavel_id = TSession::getValue('responsavel_id');

        // Monta a URL base
        $baseUrl = "https://solucao24horas.com/index.php?class=Mestre_DetalheTeste&method=onReload&responsavel_id=" . $responsavel_id;

        // Adiciona o parâmetro 'uf' à URL
        $newUrl = $baseUrl . "&uf=" . $uf;

        // Redireciona para a nova URL
        echo "<script>window.location.href = '{$newUrl}';</script>";
        exit;
    }
}

public static function onLimparParametros($param) {
    // Obtém o responsavel_id da sessão
    $responsavel_id = TSession::getValue('responsavel_id');

    // Monta a URL base
    $baseUrl = "https://solucao24horas.com/index.php?class=Mestre_DetalheTeste&method=onReload&responsavel_id=" . $responsavel_id;

    // Redireciona para a nova URL sem o parâmetro 'uf'
    echo "<script>window.location.href = '{$baseUrl}';</script>";
    exit;
}
                
                    
            public function onSaveContato($param) {
                try {
                    TTransaction::open(self::$database); // Abre uma transação
            
                    // Cria um novo objeto Leads ou carrega um existente
                    if (!empty($param['id'])) { 
                        $object = Leads::find($param['id']); // Carrega o objeto existente
                    } else {
                        $object = new Leads(); // Cria um novo objeto
                    }
            
                    // Preenche o objeto com os dados do formulário
                    $data = $this->formFlag->getData(); // Obtém os dados do formulário
                    $object->fromArray((array) $data); // Carrega o objeto com os dados
            
                    // Salva o objeto
                    $object->store();
            
                    // Prepara a mensagem de sucesso
                    TToast::show('success', "Registro salvo com sucesso", 'topRight', 'far:check-circle');
            
                    // Atualiza os dados do formulário
                    $this->formFlag->setData($data);
            
                    TTransaction::close(); // Fecha a transação
                    $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
                     "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
                    // header("Location: $currentUrl");
                  //  echo "<script>window.location.href = '{$currentUrl}';</script>";
                    echo "<script>location.reload();</script>";
                 exit;

                  //  AdiantiCoreApplication::gotoPage('Mestre_DetalheCarteira'); 

                } catch (Exception $e) {
                    TTransaction::rollback(); // Desfaz as operações em caso de erro
                    new TMessage('error', $e->getMessage()); // Exibe a mensagem de erro
                }
            }
            public function onShowListContato($param){

            }
        

            public function onReload($param = null) {
                
                // Verifica se o parâmetro 'responsavel_id' foi passado
                if (isset($param['responsavel_id'])) {
                    $carteira_id = $param['responsavel_id'];
                    
                    // Cria um critério para buscar os leads com a carteira_id correspondente
                    $this->filter_criteria->add(new TFilter('carteira_id', '=', $carteira_id));
                    
                    // Verifica se o filtro por UF foi passado
                    if (isset($param['uf']) && $param['uf']) {
                        $this->filter_criteria->add(new TFilter('uf', '=', $param['uf']));
                    }
                    
                    // Limpa o datagrid
                    $this->datagrid->clear();
                    
                    // Busca os leads com base no critério
                    try {
                        TTransaction::open(self::$database);
                        // Consulta os leads com base no carteira_id
                        $leads = Leads::where('carteira_id', '=', $carteira_id)->load();
                        $leads_list = [];
                        
                        // Preenche os dados dos leads
                        foreach ($leads as $lead) {
                            // Busca apenas um resultado correspondente na tabela leads_api
                            $leads_api = LeadsApi::where('id', '=', $lead->leads_api_id)->first();
                            
                            // Se encontrar um leads_api, preenche os campos
                            if ($leads_api) {
                                // Adiciona a verificação da UF
                                if (!isset($param['uf']) || ($param['uf'] === $leads_api->end_estado_1)) {
                                    // Preenche os campos do lead
                                    $lead->nome = $leads_api->nome;            // Preenche o nome
                                    $lead->cpf = $leads_api->cpf;              // Preenche o CPF
                                    $lead->uf = $leads_api->end_estado_1;      // Preenche o estado
                                    $lead->cidade = $leads_api->end_cidade_1;  // Preenche a cidade
                                    
                                    // Adiciona o lead ao array sem duplicação
                                    $leads_list[$lead->id] = $lead; // Usa o ID como chave para evitar duplicados
                                }
                            }
                        }
                        
                        // Ordena o array de leads pelo campo 'uf'
                        usort($leads_list, function($a, $b) {
                            return strcmp($a->uf, $b->uf);
                        });
                        
                        // Adiciona os itens ordenados ao datagrid
                        foreach ($leads_list as $lead) {
                            $this->datagrid->addItem($lead);
                        }
                    } catch (Exception $e) {
                        // Trate exceções conforme necessário
                        echo 'Erro: ' . $e->getMessage();
                    } finally {
                        TTransaction::close(); // Garante que a transação seja fechada
                    }
                }
            }  
            

    
        public function show()
        {
            // check if the datagrid is already loaded
            if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
            {
                if (func_num_args() > 0)
                {
                    $this->onReload( func_get_arg(0) );
                }
                else
                {
                    $this->onReload();
                }
            }
            parent::show();
        }

        public static function manageRow($id)
        {
            $list = new self([]);

            $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

            if($openTransaction)
            {
                TTransaction::open(self::$database);    
            }

            $object = new LeadsGov($id);

            $row = $list->datagrid->addItem($object);
            $row->id = "row_{$object->id_servidor_portal}";

            if($openTransaction)
            {
                TTransaction::close();    
            }

            TDataGrid::replaceRowById(_CLASS_.'_datagrid', $row->id, $row);
        }
        public function onShow($param = null)
        {

        }
        

    }