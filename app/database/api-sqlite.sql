PRAGMA foreign_keys=OFF; 

CREATE TABLE carteira( 
      id  INTEGER    NOT NULL  , 
      responsavel_id int   NOT NULL  , 
      flag_ativo int   NOT NULL  , 
      nome varchar  (128)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE contato_observacao( 
      id  INTEGER    NOT NULL  , 
      data_do_contato datetime   NOT NULL  , 
      observacoes text   NOT NULL  , 
      proximo_contato datetime   , 
      gestao_de_carteira_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(gestao_de_carteira_id) REFERENCES gestao_de_carteira(id)) ; 

CREATE TABLE email( 
      id  INTEGER    NOT NULL  , 
      cpf text   NOT NULL  , 
      email varchar  (50)   NOT NULL  , 
      leads_api_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE gestao_de_carteira( 
      id  INTEGER    NOT NULL  , 
      correspondencia_flag int   NOT NULL  , 
      participantes_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(participantes_id) REFERENCES participantes(id)) ; 

CREATE TABLE leads( 
      id  INTEGER    NOT NULL  , 
      leads_gov_id int   NOT NULL  , 
      leads_api_id int   NOT NULL  , 
      carteira_id int   NOT NULL  , 
      flag_descontinuar int   NOT NULL    DEFAULT 0, 
      data_prox_contato datetime   , 
      cpf int   NOT NULL  , 
      cpf_gov varchar  (16)   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(leads_gov_id) REFERENCES leads_gov(id_servidor_portal),
FOREIGN KEY(leads_api_id) REFERENCES leads_api(id)) ; 

CREATE TABLE leads_api( 
      id  INTEGER    NOT NULL  , 
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
      created_at datetime   NOT NULL  , 
      rg int  (11)   NOT NULL  , 
      column_19 int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads_gov( 
      cpf varchar  (14)   NOT NULL  , 
      ano_aposentadoria int   , 
      ano_ingresso int   , 
      descricao_cargo varchar  (128)   , 
      id_servidor_portal  INTEGER    NOT NULL  , 
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
      ferias text   , 
      fundo_de_saude double   , 
      irrf double   , 
      mes int   , 
      pensao_militar double   , 
      remuneracao_apos_deducoes double   , 
      remuneracao_bruta double   , 
      verbas_indenizatorias double   , 
 PRIMARY KEY (id_servidor_portal)) ; 

CREATE TABLE parentes( 
      id  INTEGER    NOT NULL  , 
      leads_id int   NOT NULL  , 
      parentesco varchar  (50)   NOT NULL  , 
      parentesco_cpf varchar  (50)   , 
      parentesco_nome varchar  (128)   NOT NULL  , 
      cpf varchar  (16)   , 
 PRIMARY KEY (id),
FOREIGN KEY(leads_id) REFERENCES leads(id)) ; 

CREATE TABLE participantes( 
      id  INTEGER    NOT NULL  , 
      carteira_id varchar  (256)   NOT NULL  , 
      leads_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(carteira_id) REFERENCES carteira(id),
FOREIGN KEY(leads_id) REFERENCES leads(id)) ; 

 
 CREATE UNIQUE INDEX unique_idx_leads_api_id ON leads_api(id);
 