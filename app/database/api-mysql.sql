CREATE TABLE carteira( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `responsavel_id` int   NOT NULL  , 
      `flag_ativo` int   NOT NULL  , 
      `nome` varchar  (128)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE contato_observacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `data_do_contato` datetime   NOT NULL  , 
      `observacoes` text   NOT NULL  , 
      `proximo_contato` datetime   , 
      `gestao_de_carteira_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE email( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `cpf` text   NOT NULL  , 
      `email` varchar  (50)   NOT NULL  , 
      `leads_api_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE gestao_de_carteira( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `correspondencia_flag` int   NOT NULL  , 
      `participantes_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE leads( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `leads_gov_id` int   NOT NULL  , 
      `leads_api_id` int   NOT NULL  , 
      `carteira_id` int   NOT NULL  , 
      `flag_descontinuar` int   NOT NULL    DEFAULT 0, 
      `data_prox_contato` datetime   , 
      `cpf` int   NOT NULL  , 
      `cpf_gov` varchar  (16)   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE leads_api( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` varchar  (255)   NOT NULL  , 
      `cpf` varchar  (14)   NOT NULL  , 
      `idade` int   NOT NULL  , 
      `data_nasc` varchar  (10)   NOT NULL  , 
      `celular` varchar  (15)     DEFAULT NULL, 
      `flg_whatsapp` int     DEFAULT NULL, 
      `telefone_fixo` varchar  (15)     DEFAULT NULL, 
      `email` varchar  (255)     DEFAULT NULL, 
      `lgr_numero` varchar  (10)     DEFAULT NULL, 
      `lgr_nome` varchar  (255)     DEFAULT NULL, 
      `bairro` varchar  (255)     DEFAULT NULL, 
      `cidade` varchar  (255)     DEFAULT NULL, 
      `uf` char  (2)     DEFAULT NULL, 
      `cep` varchar  (10)     DEFAULT NULL, 
      `created_at` datetime   NOT NULL    DEFAULT current_timestamp(), 
      `rg` int   NOT NULL  , 
      `column_19` int   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE leads_gov( 
      `cpf` varchar  (14)   NOT NULL  , 
      `ano_aposentadoria` int   , 
      `ano_ingresso` int   , 
      `descricao_cargo` varchar  (128)   , 
      `id_servidor_portal`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` varchar  (128)   , 
      `jornada_de_trabalho` varchar  (128)   , 
      `cargo_id` int   NOT NULL  , 
      `matricula` varchar  (10)   NOT NULL  , 
      `org_lotacao` varchar  (128)   , 
      `orgsup_lotacao` varchar  (128)   , 
      `regime_juridico` varchar  (128)   , 
      `situacao_vinculo` varchar  (128)   , 
      `tipo_aposentadoria` varchar  (128)   , 
      `tipo_vinculo` varchar  (128)   , 
      `uorg_lotacao` varchar  (128)   , 
      `ferias` boolean   , 
      `fundo_de_saude` double   , 
      `irrf` double   , 
      `mes` int   , 
      `pensao_militar` double   , 
      `remuneracao_apos_deducoes` double   , 
      `remuneracao_bruta` double   , 
      `verbas_indenizatorias` double   , 
 PRIMARY KEY (id_servidor_portal)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE parentes( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `leads_id` int   NOT NULL  , 
      `parentesco` varchar  (50)   NOT NULL  , 
      `parentesco_cpf` varchar  (50)   , 
      `parentesco_nome` varchar  (128)   NOT NULL  , 
      `cpf` varchar  (16)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE participantes( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `carteira_id` varchar  (256)   NOT NULL  , 
      `leads_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

 
 ALTER TABLE leads_api ADD UNIQUE (id);
  
 ALTER TABLE contato_observacao ADD CONSTRAINT fk_contatos_1 FOREIGN KEY (gestao_de_carteira_id) references gestao_de_carteira(id); 
ALTER TABLE gestao_de_carteira ADD CONSTRAINT fk_gestao_de_carteira_1 FOREIGN KEY (participantes_id) references participantes(id); 
ALTER TABLE leads ADD CONSTRAINT fk_leads_1 FOREIGN KEY (leads_gov_id) references leads_gov(id_servidor_portal); 
ALTER TABLE leads ADD CONSTRAINT fk_leads_3 FOREIGN KEY (leads_api_id) references leads_api(id); 
ALTER TABLE parentes ADD CONSTRAINT fk_parentes_1 FOREIGN KEY (leads_id) references leads(id); 
ALTER TABLE participantes ADD CONSTRAINT fk_contato_carteira_1 FOREIGN KEY (carteira_id) references carteira(id); 
ALTER TABLE participantes ADD CONSTRAINT fk_participantes_2 FOREIGN KEY (leads_id) references leads(id); 
