CREATE TABLE carteira( 
      id number(10)    NOT NULL , 
      responsavel_id number(10)    NOT NULL , 
      flag_ativo number(10)    NOT NULL , 
      nome varchar  (128)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE contato_observacao( 
      id number(10)    NOT NULL , 
      data_do_contato timestamp(0)    NOT NULL , 
      observacoes varchar(3000)    NOT NULL , 
      proximo_contato timestamp(0)   , 
      gestao_de_carteira_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE email( 
      id number(10)    NOT NULL , 
      cpf varchar(3000)    NOT NULL , 
      email varchar  (50)    NOT NULL , 
      leads_api_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE gestao_de_carteira( 
      id number(10)    NOT NULL , 
      correspondencia_flag number(10)    NOT NULL , 
      participantes_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads( 
      id number(10)    NOT NULL , 
      leads_gov_id number(10)    NOT NULL , 
      leads_api_id number(10)    NOT NULL , 
      carteira_id number(10)    NOT NULL , 
      flag_descontinuar number(10)    DEFAULT 0  NOT NULL , 
      data_prox_contato timestamp(0)   , 
      cpf number(10)    NOT NULL , 
      cpf_gov varchar  (16)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads_api( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
      cpf varchar  (14)    NOT NULL , 
      idade number(10)  (11)    NOT NULL , 
      data_nasc varchar  (10)    NOT NULL , 
      celular varchar  (15)    DEFAULT NULL , 
      flg_whatsapp number(10)  (1)    DEFAULT NULL , 
      telefone_fixo varchar  (15)    DEFAULT NULL , 
      email varchar  (255)    DEFAULT NULL , 
      lgr_numero varchar  (10)    DEFAULT NULL , 
      lgr_nome varchar  (255)    DEFAULT NULL , 
      bairro varchar  (255)    DEFAULT NULL , 
      cidade varchar  (255)    DEFAULT NULL , 
      uf char  (2)    DEFAULT NULL , 
      cep varchar  (10)    DEFAULT NULL , 
      created_at timestamp(0)    DEFAULT current_timestamp()  NOT NULL , 
      rg number(10)  (11)    NOT NULL , 
      column_19 number(10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE leads_gov( 
      cpf varchar  (14)    NOT NULL , 
      ano_aposentadoria number(10)   , 
      ano_ingresso number(10)   , 
      descricao_cargo varchar  (128)   , 
      id_servidor_portal number(10)    NOT NULL , 
      nome varchar  (128)   , 
      jornada_de_trabalho varchar  (128)   , 
      cargo_id number(10)    NOT NULL , 
      matricula varchar  (10)    NOT NULL , 
      org_lotacao varchar  (128)   , 
      orgsup_lotacao varchar  (128)   , 
      regime_juridico varchar  (128)   , 
      situacao_vinculo varchar  (128)   , 
      tipo_aposentadoria varchar  (128)   , 
      tipo_vinculo varchar  (128)   , 
      uorg_lotacao varchar  (128)   , 
      ferias char(1)   , 
      fundo_de_saude binary_double   , 
      irrf binary_double   , 
      mes number(10)   , 
      pensao_militar binary_double   , 
      remuneracao_apos_deducoes binary_double   , 
      remuneracao_bruta binary_double   , 
      verbas_indenizatorias binary_double   , 
 PRIMARY KEY (id_servidor_portal)) ; 

CREATE TABLE parentes( 
      id number(10)    NOT NULL , 
      leads_id number(10)    NOT NULL , 
      parentesco varchar  (50)    NOT NULL , 
      parentesco_cpf varchar  (50)   , 
      parentesco_nome varchar  (128)    NOT NULL , 
      cpf varchar  (16)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE participantes( 
      id number(10)    NOT NULL , 
      carteira_id varchar  (256)    NOT NULL , 
      leads_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

 
 ALTER TABLE leads_api ADD UNIQUE (id);
  
 ALTER TABLE contato_observacao ADD CONSTRAINT fk_contatos_1 FOREIGN KEY (gestao_de_carteira_id) references gestao_de_carteira(id); 
ALTER TABLE gestao_de_carteira ADD CONSTRAINT fk_gestao_de_carteira_1 FOREIGN KEY (participantes_id) references participantes(id); 
ALTER TABLE leads ADD CONSTRAINT fk_leads_1 FOREIGN KEY (leads_gov_id) references leads_gov(id_servidor_portal); 
ALTER TABLE leads ADD CONSTRAINT fk_leads_3 FOREIGN KEY (leads_api_id) references leads_api(id); 
ALTER TABLE parentes ADD CONSTRAINT fk_parentes_1 FOREIGN KEY (leads_id) references leads(id); 
ALTER TABLE participantes ADD CONSTRAINT fk_contato_carteira_1 FOREIGN KEY (carteira_id) references carteira(id); 
ALTER TABLE participantes ADD CONSTRAINT fk_participantes_2 FOREIGN KEY (leads_id) references leads(id); 
 CREATE SEQUENCE carteira_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER carteira_id_seq_tr 

BEFORE INSERT ON carteira FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT carteira_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE contato_observacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER contato_observacao_id_seq_tr 

BEFORE INSERT ON contato_observacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT contato_observacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE email_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER email_id_seq_tr 

BEFORE INSERT ON email FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT email_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE gestao_de_carteira_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER gestao_de_carteira_id_seq_tr 

BEFORE INSERT ON gestao_de_carteira FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT gestao_de_carteira_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE leads_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER leads_id_seq_tr 

BEFORE INSERT ON leads FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT leads_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE leads_api_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER leads_api_id_seq_tr 

BEFORE INSERT ON leads_api FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT leads_api_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE leads_gov_id_servidor_portal_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER leads_gov_id_servidor_portal_seq_tr 

BEFORE INSERT ON leads_gov FOR EACH ROW 

    WHEN 

        (NEW.id_servidor_portal IS NULL) 

    BEGIN 

        SELECT leads_gov_id_servidor_portal_seq.NEXTVAL INTO :NEW.id_servidor_portal FROM DUAL; 

END;
CREATE SEQUENCE parentes_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER parentes_id_seq_tr 

BEFORE INSERT ON parentes FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT parentes_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE participantes_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER participantes_id_seq_tr 

BEFORE INSERT ON participantes FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT participantes_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 