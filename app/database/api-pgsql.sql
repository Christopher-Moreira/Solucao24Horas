CREATE TABLE carteira( 
      id  SERIAL    NOT NULL  , 
      responsavel_id integer   NOT NULL  , 
      flag_ativo integer   NOT NULL  , 
      nome varchar  (128)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE contato_observacao( 
      id  SERIAL    NOT NULL  , 
      data_do_contato timestamp   NOT NULL  , 
      observacoes text   NOT NULL  , 
      proximo_contato timestamp   , 
      gestao_de_carteira_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE email( 
      id  SERIAL    NOT NULL  , 
      cpf text   NOT NULL  , 
      email varchar  (50)   NOT NULL  , 
      leads_api_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE gestao_de_carteira( 
      id  SERIAL    NOT NULL  , 
      correspondencia_flag integer   NOT NULL  , 
      participantes_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads( 
      id  SERIAL    NOT NULL  , 
      leads_gov_id integer   NOT NULL  , 
      leads_api_id integer   NOT NULL  , 
      carteira_id integer   NOT NULL  , 
      flag_descontinuar integer   NOT NULL    DEFAULT 0, 
      data_prox_contato timestamp   , 
      cpf integer   NOT NULL  , 
      cpf_gov varchar  (16)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads_api( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      cpf varchar  (14)   NOT NULL  , 
      idade integer   NOT NULL  , 
      data_nasc varchar  (10)   NOT NULL  , 
      celular varchar  (15)     DEFAULT NULL, 
      flg_whatsapp integer     DEFAULT NULL, 
      telefone_fixo varchar  (15)     DEFAULT NULL, 
      email varchar  (255)     DEFAULT NULL, 
      lgr_numero varchar  (10)     DEFAULT NULL, 
      lgr_nome varchar  (255)     DEFAULT NULL, 
      bairro varchar  (255)     DEFAULT NULL, 
      cidade varchar  (255)     DEFAULT NULL, 
      uf char  (2)     DEFAULT NULL, 
      cep varchar  (10)     DEFAULT NULL, 
      created_at timestamp   NOT NULL    DEFAULT current_timestamp(), 
      rg integer   NOT NULL  , 
      column_19 integer   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads_gov( 
      cpf varchar  (14)   NOT NULL  , 
      ano_aposentadoria integer   , 
      ano_ingresso integer   , 
      descricao_cargo varchar  (128)   , 
      id_servidor_portal  SERIAL    NOT NULL  , 
      nome varchar  (128)   , 
      jornada_de_trabalho varchar  (128)   , 
      cargo_id integer   NOT NULL  , 
      matricula varchar  (10)   NOT NULL  , 
      org_lotacao varchar  (128)   , 
      orgsup_lotacao varchar  (128)   , 
      regime_juridico varchar  (128)   , 
      situacao_vinculo varchar  (128)   , 
      tipo_aposentadoria varchar  (128)   , 
      tipo_vinculo varchar  (128)   , 
      uorg_lotacao varchar  (128)   , 
      ferias boolean   , 
      fundo_de_saude float   , 
      irrf float   , 
      mes integer   , 
      pensao_militar float   , 
      remuneracao_apos_deducoes float   , 
      remuneracao_bruta float   , 
      verbas_indenizatorias float   , 
 PRIMARY KEY (id_servidor_portal)) ; 

CREATE TABLE parentes( 
      id  SERIAL    NOT NULL  , 
      leads_id integer   NOT NULL  , 
      parentesco varchar  (50)   NOT NULL  , 
      parentesco_cpf varchar  (50)   , 
      parentesco_nome varchar  (128)   NOT NULL  , 
      cpf varchar  (16)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE participantes( 
      id  SERIAL    NOT NULL  , 
      carteira_id varchar  (256)   NOT NULL  , 
      leads_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

 
 ALTER TABLE leads_api ADD UNIQUE (id);
  
 ALTER TABLE contato_observacao ADD CONSTRAINT fk_contatos_1 FOREIGN KEY (gestao_de_carteira_id) references gestao_de_carteira(id); 
ALTER TABLE gestao_de_carteira ADD CONSTRAINT fk_gestao_de_carteira_1 FOREIGN KEY (participantes_id) references participantes(id); 
ALTER TABLE leads ADD CONSTRAINT fk_leads_1 FOREIGN KEY (leads_gov_id) references leads_gov(id_servidor_portal); 
ALTER TABLE leads ADD CONSTRAINT fk_leads_3 FOREIGN KEY (leads_api_id) references leads_api(id); 
ALTER TABLE parentes ADD CONSTRAINT fk_parentes_1 FOREIGN KEY (leads_id) references leads(id); 
ALTER TABLE participantes ADD CONSTRAINT fk_contato_carteira_1 FOREIGN KEY (carteira_id) references carteira(id); 
ALTER TABLE participantes ADD CONSTRAINT fk_participantes_2 FOREIGN KEY (leads_id) references leads(id); 
 
 CREATE index idx_contato_observacao_gestao_de_carteira_id on contato_observacao(gestao_de_carteira_id); 
CREATE index idx_gestao_de_carteira_participantes_id on gestao_de_carteira(participantes_id); 
CREATE index idx_leads_leads_gov_id on leads(leads_gov_id); 
CREATE index idx_leads_leads_api_id on leads(leads_api_id); 
CREATE index idx_parentes_leads_id on parentes(leads_id); 
CREATE index idx_participantes_carteira_id on participantes(carteira_id); 
CREATE index idx_participantes_leads_id on participantes(leads_id); 
