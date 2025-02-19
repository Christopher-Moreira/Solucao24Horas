CREATE TABLE carteira( 
      id  INT IDENTITY    NOT NULL  , 
      responsavel_id int   NOT NULL  , 
      flag_ativo int   NOT NULL  , 
      nome varchar  (128)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE contato_observacao( 
      id  INT IDENTITY    NOT NULL  , 
      data_do_contato datetime2   NOT NULL  , 
      observacoes nvarchar(max)   NOT NULL  , 
      proximo_contato datetime2   , 
      gestao_de_carteira_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE email( 
      id  INT IDENTITY    NOT NULL  , 
      cpf nvarchar(max)   NOT NULL  , 
      email varchar  (50)   NOT NULL  , 
      leads_api_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE gestao_de_carteira( 
      id  INT IDENTITY    NOT NULL  , 
      correspondencia_flag int   NOT NULL  , 
      participantes_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads( 
      id  INT IDENTITY    NOT NULL  , 
      leads_gov_id int   NOT NULL  , 
      leads_api_id int   NOT NULL  , 
      carteira_id int   NOT NULL  , 
      flag_descontinuar int   NOT NULL    DEFAULT 0, 
      data_prox_contato datetime2   , 
      cpf int   NOT NULL  , 
      cpf_gov varchar  (16)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads_api( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      cpf varchar  (14)   NOT NULL  , 
      idade int  (11)   NOT NULL  , 
      data_nasc varchar  (10)   NOT NULL  , 
      celular varchar  (15)     DEFAULT NULL, 
      flg_whatsapp int  (1)     DEFAULT NULL, 
      telefone_fixo varchar  (15)     DEFAULT NULL, 
      email varchar  (255)     DEFAULT NULL, 
      lgr_numero varchar  (10)     DEFAULT NULL, 
      lgr_nome varchar  (255)     DEFAULT NULL, 
      bairro varchar  (255)     DEFAULT NULL, 
      cidade varchar  (255)     DEFAULT NULL, 
      uf char  (2)     DEFAULT NULL, 
      cep varchar  (10)     DEFAULT NULL, 
      created_at datetime2   NOT NULL    DEFAULT current_timestamp(), 
      rg int  (11)   NOT NULL  , 
      column_19 int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads_gov( 
      cpf varchar  (14)   NOT NULL  , 
      ano_aposentadoria int   , 
      ano_ingresso int   , 
      descricao_cargo varchar  (128)   , 
      id_servidor_portal  INT IDENTITY    NOT NULL  , 
      nome varchar  (128)   , 
      jornada_de_trabalho varchar  (128)   , 
      cargo_id int   NOT NULL  , 
      matricula varchar  (10)   NOT NULL  , 
      org_lotacao varchar  (128)   , 
      orgsup_lotacao varchar  (128)   , 
      regime_juridico varchar  (128)   , 
      situacao_vinculo varchar  (128)   , 
      tipo_aposentadoria varchar  (128)   , 
      tipo_vinculo varchar  (128)   , 
      uorg_lotacao varchar  (128)   , 
      ferias bit   , 
      fundo_de_saude float   , 
      irrf float   , 
      mes int   , 
      pensao_militar float   , 
      remuneracao_apos_deducoes float   , 
      remuneracao_bruta float   , 
      verbas_indenizatorias float   , 
 PRIMARY KEY (id_servidor_portal)) ; 

CREATE TABLE parentes( 
      id  INT IDENTITY    NOT NULL  , 
      leads_id int   NOT NULL  , 
      parentesco varchar  (50)   NOT NULL  , 
      parentesco_cpf varchar  (50)   , 
      parentesco_nome varchar  (128)   NOT NULL  , 
      cpf varchar  (16)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE participantes( 
      id  INT IDENTITY    NOT NULL  , 
      carteira_id varchar  (256)   NOT NULL  , 
      leads_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

 
 ALTER TABLE leads_api ADD UNIQUE (id);
  
 ALTER TABLE contato_observacao ADD CONSTRAINT fk_contatos_1 FOREIGN KEY (gestao_de_carteira_id) references gestao_de_carteira(id); 
ALTER TABLE gestao_de_carteira ADD CONSTRAINT fk_gestao_de_carteira_1 FOREIGN KEY (participantes_id) references participantes(id); 
ALTER TABLE leads ADD CONSTRAINT fk_leads_1 FOREIGN KEY (leads_gov_id) references leads_gov(id_servidor_portal); 
ALTER TABLE leads ADD CONSTRAINT fk_leads_3 FOREIGN KEY (leads_api_id) references leads_api(id); 
ALTER TABLE parentes ADD CONSTRAINT fk_parentes_1 FOREIGN KEY (leads_id) references leads(id); 
ALTER TABLE participantes ADD CONSTRAINT fk_contato_carteira_1 FOREIGN KEY (carteira_id) references carteira(id); 
ALTER TABLE participantes ADD CONSTRAINT fk_participantes_2 FOREIGN KEY (leads_id) references leads(id); 
