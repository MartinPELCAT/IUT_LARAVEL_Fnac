/*==============================================================*/
/* Nom de SGBD :  PostgreSQL 8                                  */
/* Date de création :  20/09/2015 17:47:22                      */
/*==============================================================*/


drop table if exists T_E_ACHAT_ACH cascade;

drop table if exists T_E_ACQUEREUR_ACQ cascade;

drop table if exists T_E_ADRESSE_ADR cascade;

drop table if exists T_E_AVIS_AVI cascade;

drop table if exists T_E_CARTEBLEUE_CAB cascade;

drop table if exists T_E_FABRICANT_FAB cascade;

drop table if exists T_E_ORDITABLETTE_ORT cascade;

drop table if exists T_E_PHOTO_PHO cascade;

drop table if exists T_E_RELAIS_REL cascade;

drop table if exists T_E_SYSTEMEEXPLOITATION_SYE cascade;

drop table if exists T_J_ALERTE_ALE cascade;

drop table if exists T_J_AVISABUSIF_AVA cascade;

drop table if exists T_J_FAVORI_FAV cascade;

drop table if exists T_J_LIGNEACHAT_LEA cascade;

drop table if exists T_J_RELAISACQUEREUR_REA cascade;

drop table if exists T_J_RUBRIQUEORDITAB_RUO cascade;

drop table if exists T_J_TYPEORDITAB_TOT cascade;

drop table if exists T_R_MAGASIN_MAG cascade;

drop table if exists T_R_PAYS_PAY cascade;

drop table if exists T_R_RUBRIQUE_RUB cascade;

drop table if exists T_R_TYPE_TYP cascade;

/*==============================================================*/
/* Table : T_E_ACHAT_ACH                                        */
/*==============================================================*/
create table T_E_ACHAT_ACH (
   ACH_ID               SERIAL               not null,
   ACQ_ID               INT4                 not null,
   REL_ID               INT4                 null,
   ADR_ID               INT4                 null,
   CAB_ID               INT4                 not null,
   MAG_ID               INT4                 null,
   ACH_DATE             DATE                 not null,
   constraint PK_T_E_ACHAT_ACH primary key (ACH_ID),
   constraint CK_ACH_REL_ADR_MAG check ((REL_ID is null and ADR_ID is not null and MAG_ID is null) OR (REL_ID is not null and ADR_ID is null and MAG_ID is null) OR (REL_ID is null and ADR_ID is null and MAG_ID is not null))
);

/*==============================================================*/
/* Table : T_E_ACQUEREUR_ACQ                                    */
/*==============================================================*/
create table T_E_ACQUEREUR_ACQ (
   ACQ_ID               SERIAL               not null,
   ACQ_MEL              VARCHAR(80)          not null
   	  constraint UQ_ACQ_MEL unique,
   ACQ_MOTPASSE         VARCHAR(128)         not null,
   ACQ_PSEUDO           VARCHAR(20)          not null,
   ACQ_CIVILITE         VARCHAR(4)           not null
      constraint CKC_ACQ_CIVILITE_T_E_ACQU check (ACQ_CIVILITE in ('M.','Mlle','Mme')),
   ACQ_NOM              VARCHAR(50)          not null,
   ACQ_PRENOM           VARCHAR(50)          not null,
   ACQ_TELFIXE          VARCHAR(15)          null,
   ACQ_TELPORTABLE      VARCHAR(15)          null,
   MAG_ID				INT4,
   constraint PK_T_E_ACQUEREUR_ACQ primary key (ACQ_ID),
   constraint  CK_ACQ_TEL_PORTABLE check ((ACQ_TELFIXE is null AND ACQ_TELPORTABLE is not null) OR (ACQ_TELFIXE is not null AND ACQ_TELPORTABLE is null) OR (ACQ_TELFIXE is not null AND ACQ_TELPORTABLE is not null))
);

/*==============================================================*/
/* Table : T_E_ADRESSE_ADR                                      */
/*==============================================================*/
create table T_E_ADRESSE_ADR (
   ADR_ID               SERIAL               not null,
   ACQ_ID               INT4                 not null,
   ADR_NOM              VARCHAR(50)          not null,
   ADR_TYPE             VARCHAR(15)          not null
      constraint CKC_ADR_TYPE_T_E_ADRE check (ADR_TYPE in ('Livraison','Facturation')),
   ADR_RUE              VARCHAR(200)         not null,
   ADR_COMPLEMENTRUE    VARCHAR(200)         null,
   ADR_CP               VARCHAR(10)          not null,
   ADR_VILLE            VARCHAR(100)         not null,
   PAY_ID               INT4                 not null,
   ADR_LATITUDE         FLOAT8               null,
   ADR_LONGITUDE        FLOAT8               null,
   constraint PK_T_E_ADRESSE_ADR primary key (ADR_ID)
);

/*==============================================================*/
/* Table : T_E_AVIS_AVI                                         */
/*==============================================================*/
create table T_E_AVIS_AVI (
   AVI_ID               SERIAL               not null,
   ACQ_ID               INT4                 not null,
   ORT_ID               INT4                 not null,
   AVI_DATE             DATE                 not null default CURRENT_DATE,
   AVI_TITRE            VARCHAR(100)         not null,
   AVI_DETAIL           VARCHAR(2000)        not null,
   AVI_NOTE             INT2                 not null
      constraint CKC_AVI_NOTE_T_E_AVIS check (AVI_NOTE between 1 and 5),
   AVI_NBUTILEOUI       INT2                 not null
      constraint CK_AVI_NBUTILEOUI check (AVI_NBUTILEOUI >= 0),
   AVI_NBUTILENON       INT2                 not null
      constraint CK_AVI_NBUTILENON check (AVI_NBUTILENON >= 0),
   constraint PK_T_E_AVIS_AVI primary key (AVI_ID)
);

/*==============================================================*/
/* Table : T_E_CARTEBLEUE_CAB                                   */
/*==============================================================*/
create table T_E_CARTEBLEUE_CAB (
   CAB_ID               SERIAL               not null,
   ACQ_ID               INT4                 not null,
   CAB_TYPE             VARCHAR(30)          not null
      constraint CKC_CAB_TYPE_T_E_CART check (CAB_TYPE in ('Mastercard','Visa','American Express')),
   CAB_TITULAIRE        VARCHAR(80)          not null,
   CAB_NUMERO           NUMERIC(16)             not null,
   CAB_MOISEXPIRATION   INT2                 not null,
   CAB_ANNEEEXPIRATION  INT2                 not null,
   CAB_CVS              INT4                 not null,
   constraint PK_T_E_CARTEBLEUE_CAB primary key (CAB_ID)
);

/*==============================================================*/
/* Table : T_E_FABRICANT_FAB                                    */
/*==============================================================*/
create table T_E_FABRICANT_FAB (
   FAB_ID               SERIAL               not null,
   FAB_NOM              VARCHAR(80)          not null,
   constraint PK_T_E_FABRICANT_FAB primary key (FAB_ID)
);

/*==============================================================*/
/* Table : T_E_ORDITABLETTE_ORT                                 */
/*==============================================================*/
create table T_E_ORDITABLETTE_ORT (
   ORT_ID               SERIAL               not null,
   FAB_ID               INT4                 not null,
   SYE_ID               INT4                 null,
   ORT_NOMPDT           VARCHAR(100)         not null,
   ORT_PROCESSEUR       VARCHAR(80)          not null,
   ORT_RAMGO            NUMERIC(6,2)         not null,
   ORT_DISQUEDURGO      NUMERIC(10,2)        not null,
   ORT_TAILLEECRAN      NUMERIC(4,1)         null,
   ORT_PRIXTTC          NUMERIC(6,2)         not null,
   ORT_CODEBARRE        VARCHAR(13)          not null,
   ORT_STOCK            INT4                 not null
      constraint CKC_ORT_STOCK_T_E_ORDI check (ORT_STOCK >= 0),
   constraint PK_T_E_ORDITABLETTE_ORT primary key (ORT_ID)
);

/*==============================================================*/
/* Table : T_E_PHOTO_PHO                                        */
/*==============================================================*/
create table T_E_PHOTO_PHO (
   PHO_ID               SERIAL               not null,
   ORT_ID               INT4                 not null,
   PHO_URL              VARCHAR(200)         not null,
   constraint PK_T_E_PHOTO_PHO primary key (PHO_ID)
);

/*==============================================================*/
/* Table : T_E_RELAIS_REL                                       */
/*==============================================================*/
create table T_E_RELAIS_REL (
   REL_ID               SERIAL               not null,
   REL_NOM              VARCHAR(100)         not null,
   REL_RUE              VARCHAR(200)         not null,
   REL_CP               VARCHAR(10)          not null,
   REL_VILLE            VARCHAR(100)         not null,
   PAY_ID               INT4                 not null,
   REL_LATITUDE         FLOAT8               null,
   REL_LONGITUDE        FLOAT8               null,
   constraint PK_T_E_RELAIS_REL primary key (REL_ID)
);

/*==============================================================*/
/* Table : T_E_SYSTEMEEXPLOITATION_SYE                          */
/*==============================================================*/
create table T_E_SYSTEMEEXPLOITATION_SYE (
   SYE_ID               SERIAL               not null,
   SYE_NOM              VARCHAR(80)          not null,
   constraint PK_T_E_SYSTEMEEXPLOITATION_SYE primary key (SYE_ID)
);

/*==============================================================*/
/* Table : T_J_ALERTE_ALE                                       */
/*==============================================================*/
create table T_J_ALERTE_ALE (
   ACQ_ID               INT4                 not null,
   ORT_ID               INT4                 not null,
   constraint PK_T_J_ALERTE_ALE primary key (ACQ_ID, ORT_ID)
);

/*==============================================================*/
/* Table : T_J_AVISABUSIF_AVA                                   */
/*==============================================================*/
create table T_J_AVISABUSIF_AVA (
   ACQ_ID               INT4                 not null,
   AVI_ID               INT4                 not null,
   constraint PK_T_J_AVISABUSIF_AVA primary key (ACQ_ID, AVI_ID)
);

/*==============================================================*/
/* Table : T_J_FAVORI_FAV                                       */
/*==============================================================*/
create table T_J_FAVORI_FAV (
   ACQ_ID               INT4                 not null,
   ORT_ID               INT4                 not null,
   constraint PK_T_J_FAVORI_FAV primary key (ACQ_ID, ORT_ID)
);

/*==============================================================*/
/* Table : T_J_LIGNEACHAT_LEA                                   */
/*==============================================================*/
create table T_J_LIGNEACHAT_LEA (
   ACH_ID               INT4                 not null,
   ORT_ID               INT4                 not null,
   LEA_QUANTITE         INT4                 not null
      constraint CKC_LEA_QUANTITE_T_J_LIGN check (LEA_QUANTITE >= 1),
   constraint PK_T_J_LIGNEACHAT_LEA primary key (ACH_ID, ORT_ID)
);

/*==============================================================*/
/* Table : T_J_RELAISACQUEREUR_REA                              */
/*==============================================================*/
create table T_J_RELAISACQUEREUR_REA (
   ACQ_ID               INT4                 not null,
   REL_ID               INT4                 not null,
   constraint PK_T_J_RELAISACQUEREUR_REA primary key (ACQ_ID, REL_ID)
);

/*==============================================================*/
/* Table : T_J_RUBRIQUEORDITAB_RUO                              */
/*==============================================================*/
create table T_J_RUBRIQUEORDITAB_RUO (
   ORT_ID               INT4                 not null,
   RUB_ID               INT4                 not null,
   constraint PK_T_J_RUBRIQUEORDITAB_RUO primary key (ORT_ID, RUB_ID)
);

/*==============================================================*/
/* Table : T_J_TYPEORDITAB_TOT                                  */
/*==============================================================*/
create table T_J_TYPEORDITAB_TOT (
   ORT_ID               INT4                 not null,
   TYP_ID               INT4                 not null,
   constraint PK_T_J_TYPEORDITAB_TOT primary key (ORT_ID, TYP_ID)
);

/*==============================================================*/
/* Table : T_R_MAGASIN_MAG                                      */
/*==============================================================*/
create table T_R_MAGASIN_MAG (
   MAG_ID               SERIAL               not null,
   MAG_NOM              VARCHAR(100)         not null,
   MAG_VILLE            VARCHAR(100)         not null,
   constraint PK_T_R_MAGASIN_MAG primary key (MAG_ID)
);

/*==============================================================*/
/* Table : T_R_PAYS_PAY                                         */
/*==============================================================*/
create table T_R_PAYS_PAY (
   PAY_ID               SERIAL               not null,
   PAY_NOM              VARCHAR(50)          not null,
   constraint PK_T_R_PAYS_PAY primary key (PAY_ID)
);

/*==============================================================*/
/* Table : T_R_RUBRIQUE_RUB                                     */
/*==============================================================*/
create table T_R_RUBRIQUE_RUB (
   RUB_ID               SERIAL               not null,
   RUB_NOM              VARCHAR(50)          not null,
   constraint PK_T_R_RUBRIQUE_RUB primary key (RUB_ID)
);

/*==============================================================*/
/* Table : T_R_TYPE_TYP                                         */
/*==============================================================*/
create table T_R_TYPE_TYP (
   TYP_ID               SERIAL               not null,
   TYP_LIBELLE          VARCHAR(50)          not null,
   constraint PK_T_R_TYPE_TYP primary key (TYP_ID)
);

alter table T_E_ACHAT_ACH
   add constraint FK_ACH_REL foreign key (REL_ID)
      references T_E_RELAIS_REL (REL_ID)
      on delete restrict on update restrict;

alter table T_E_ACHAT_ACH
   add constraint FK_ACH_ADR foreign key (ADR_ID)
      references T_E_ADRESSE_ADR (ADR_ID)
      on delete restrict on update restrict;

alter table T_E_ACHAT_ACH
   add constraint FK_ACH_ACQ foreign key (ACQ_ID)
      references T_E_ACQUEREUR_ACQ (ACQ_ID)
      on delete restrict on update restrict;

alter table T_E_ACHAT_ACH
   add constraint FK_ACH_MAG foreign key (MAG_ID)
      references T_R_MAGASIN_MAG (MAG_ID)
      on delete restrict on update restrict;
      
alter table T_E_ACHAT_ACH
   add constraint FK_ACH_CAB foreign key (CAB_ID)
      references T_E_CARTEBLEUE_CAB (CAB_ID)
      on delete restrict on update restrict;

alter table T_E_ACQUEREUR_ACQ
   add constraint FK_ACQ_MAG foreign key (MAG_ID)
      references T_R_MAGASIN_MAG (MAG_ID)
      on delete restrict on update restrict;
      
alter table T_E_ADRESSE_ADR
   add constraint FK_ADR_ACQ foreign key (ACQ_ID)
      references T_E_ACQUEREUR_ACQ (ACQ_ID)
      on delete restrict on update restrict;

alter table T_E_ADRESSE_ADR
   add constraint FK_ADR_PAY foreign key (PAY_ID)
      references T_R_PAYS_PAY (PAY_ID)
      on delete restrict on update restrict;

alter table T_E_AVIS_AVI
   add constraint FK_AVI_ACQ foreign key (ACQ_ID)
      references T_E_ACQUEREUR_ACQ (ACQ_ID)
      on delete restrict on update restrict;

alter table T_E_AVIS_AVI
   add constraint FK_AVI_ORT foreign key (ORT_ID)
      references T_E_ORDITABLETTE_ORT (ORT_ID)
      on delete restrict on update restrict;

alter table T_E_CARTEBLEUE_CAB
   add constraint FK_CAB_ACQ foreign key (ACQ_ID)
      references T_E_ACQUEREUR_ACQ (ACQ_ID)
      on delete restrict on update restrict;

alter table T_E_ORDITABLETTE_ORT
   add constraint FK_ORT_SYE foreign key (SYE_ID)
      references T_E_SYSTEMEEXPLOITATION_SYE (SYE_ID)
      on delete restrict on update restrict;

alter table T_E_ORDITABLETTE_ORT
   add constraint FK_ORT_FAB foreign key (FAB_ID)
      references T_E_FABRICANT_FAB (FAB_ID)
      on delete restrict on update restrict;

alter table T_E_PHOTO_PHO
   add constraint FK_PHO_ORT foreign key (ORT_ID)
      references T_E_ORDITABLETTE_ORT (ORT_ID)
      on delete restrict on update restrict;

alter table T_E_RELAIS_REL
   add constraint FK_MEL_PAY foreign key (PAY_ID)
      references T_R_PAYS_PAY (PAY_ID)
      on delete restrict on update restrict;

alter table T_J_ALERTE_ALE
   add constraint FK_ALE_ACQ foreign key (ACQ_ID)
      references T_E_ACQUEREUR_ACQ (ACQ_ID)
      on delete restrict on update restrict;

alter table T_J_ALERTE_ALE
   add constraint FK_ALE_ORT foreign key (ORT_ID)
      references T_E_ORDITABLETTE_ORT (ORT_ID)
      on delete restrict on update restrict;

alter table T_J_AVISABUSIF_AVA
   add constraint FK_AVA_AVI foreign key (AVI_ID)
      references T_E_AVIS_AVI (AVI_ID)
      on delete restrict on update restrict;

alter table T_J_AVISABUSIF_AVA
   add constraint FK_AVA_ACQ foreign key (ACQ_ID)
      references T_E_ACQUEREUR_ACQ (ACQ_ID)
      on delete restrict on update restrict;

alter table T_J_FAVORI_FAV
   add constraint FK_FAV_ACQ foreign key (ACQ_ID)
      references T_E_ACQUEREUR_ACQ (ACQ_ID)
      on delete restrict on update restrict;

alter table T_J_FAVORI_FAV
   add constraint FK_FAV_ORT foreign key (ORT_ID)
      references T_E_ORDITABLETTE_ORT (ORT_ID)
      on delete restrict on update restrict;

alter table T_J_LIGNEACHAT_LEA
   add constraint FK_LEA_ACH foreign key (ACH_ID)
      references T_E_ACHAT_ACH (ACH_ID)
      on delete restrict on update restrict;

alter table T_J_LIGNEACHAT_LEA
   add constraint FK_LEA_ORT foreign key (ORT_ID)
      references T_E_ORDITABLETTE_ORT (ORT_ID)
      on delete restrict on update restrict;

alter table T_J_RELAISACQUEREUR_REA
   add constraint FK_REA_REL foreign key (REL_ID)
      references T_E_RELAIS_REL (REL_ID)
      on delete restrict on update restrict;

alter table T_J_RELAISACQUEREUR_REA
   add constraint FK_REA_ACQ foreign key (ACQ_ID)
      references T_E_ACQUEREUR_ACQ (ACQ_ID)
      on delete restrict on update restrict;

alter table T_J_RUBRIQUEORDITAB_RUO
   add constraint FK_RUO_ORT foreign key (ORT_ID)
      references T_E_ORDITABLETTE_ORT (ORT_ID)
      on delete restrict on update restrict;

alter table T_J_RUBRIQUEORDITAB_RUO
   add constraint FK_RUP_RUB foreign key (RUB_ID)
      references T_R_RUBRIQUE_RUB (RUB_ID)
      on delete restrict on update restrict;

alter table T_J_TYPEORDITAB_TOT
   add constraint FK_TOT_ORT foreign key (ORT_ID)
      references T_E_ORDITABLETTE_ORT (ORT_ID)
      on delete restrict on update restrict;

alter table T_J_TYPEORDITAB_TOT
   add constraint FK_TOT_TYP foreign key (TYP_ID)
      references T_R_TYPE_TYP (TYP_ID)
      on delete restrict on update restrict;

-- INSERT
INSERT INTO T_R_PAYS_PAY (PAY_NOM) VALUES ('France');
INSERT INTO T_R_PAYS_PAY (PAY_NOM) VALUES ('Suisse');
INSERT INTO T_R_PAYS_PAY (PAY_NOM) VALUES ('Italie');
INSERT INTO T_R_PAYS_PAY (PAY_NOM) VALUES ('Espagne');
INSERT INTO T_R_PAYS_PAY (PAY_NOM) VALUES ('UK');

INSERT INTO T_R_MAGASIN_MAG (MAG_NOM, MAG_VILLE) VALUES ('Annecy','Annecy');
INSERT INTO T_R_MAGASIN_MAG (MAG_NOM, MAG_VILLE) VALUES ('Chambéry','Chambéry');
INSERT INTO T_R_MAGASIN_MAG (MAG_NOM, MAG_VILLE) VALUES ('Lyon Bellecour','Lyon');
INSERT INTO T_R_MAGASIN_MAG (MAG_NOM, MAG_VILLE) VALUES ('Lyon Part-Dieu','Lyon');

INSERT INTO T_E_ACQUEREUR_ACQ (ACQ_MEL, ACQ_MOTPASSE, ACQ_PSEUDO, ACQ_CIVILITE, ACQ_NOM, ACQ_PRENOM, ACQ_TELFIXE, ACQ_TELPORTABLE, MAG_ID) VALUES ('paul.durand@gmail.com', '123', 'paulo', 'M.', 'DURAND', 'Paul', '0450505050', null, 1);
INSERT INTO T_E_ACQUEREUR_ACQ (ACQ_MEL, ACQ_MOTPASSE, ACQ_PSEUDO, ACQ_CIVILITE, ACQ_NOM, ACQ_PRENOM, ACQ_TELFIXE, ACQ_TELPORTABLE, MAG_ID) VALUES ('marc.dupond@gmail.com', '123', 'marco', 'M.', 'DUPOND', 'Marc', '0450505051', '0601010101', 4);
INSERT INTO T_E_ACQUEREUR_ACQ (ACQ_MEL, ACQ_MOTPASSE, ACQ_PSEUDO, ACQ_CIVILITE, ACQ_NOM, ACQ_PRENOM, ACQ_TELFIXE, ACQ_TELPORTABLE, MAG_ID) VALUES ('pascal.poison@gmail.com', '123', 'curare', 'M.', 'POISON', 'Pascal', '0450505052', '0601010102', 3);
INSERT INTO T_E_ACQUEREUR_ACQ (ACQ_MEL, ACQ_MOTPASSE, ACQ_PSEUDO, ACQ_CIVILITE, ACQ_NOM, ACQ_PRENOM, ACQ_TELFIXE, ACQ_TELPORTABLE, MAG_ID) VALUES ('vincent.vivant@gmail.com', '123', 'vince', 'M.', 'VIVANT', 'Vincent', '0450505051', '0601010101', 1);

INSERT INTO T_E_ADRESSE_ADR (ACQ_ID, ADR_NOM, ADR_TYPE, ADR_RUE, ADR_CP, ADR_VILLE, PAY_ID, ADR_LATITUDE, ADR_LONGITUDE) VALUES (1, 'Chez moi', 'Facturation', 'Chemin de Bellevue', '74940', 'Annecy-le-Vieux', 1, 45.921154, 6.153794);
INSERT INTO T_E_ADRESSE_ADR (ACQ_ID, ADR_NOM, ADR_TYPE, ADR_RUE, ADR_CP, ADR_VILLE, PAY_ID, ADR_LATITUDE, ADR_LONGITUDE) VALUES (1, 'Chez moi', 'Livraison', '9 rue de l''Arc en Ciel', '74940', 'Annecy-le-Vieux', 1, 45.919787, 6.160215 );
INSERT INTO T_E_ADRESSE_ADR (ACQ_ID, ADR_NOM, ADR_TYPE, ADR_RUE, ADR_CP, ADR_VILLE, PAY_ID, ADR_LATITUDE, ADR_LONGITUDE) VALUES (2, 'Lyon', 'Facturation', '10 rue des 3 Rois', '69007', 'Lyon', 1, 45.753979, 4.842775);
INSERT INTO T_E_ADRESSE_ADR (ACQ_ID, ADR_NOM, ADR_TYPE, ADR_RUE, ADR_CP, ADR_VILLE, PAY_ID, ADR_LATITUDE, ADR_LONGITUDE) VALUES (3, 'Villeurbanne', 'Facturation', '43 Boulevard du 11 Novembre 1918', '69100', 'Villeurbanne', 1, 45.779122, 4.864483);
INSERT INTO T_E_ADRESSE_ADR (ACQ_ID, ADR_NOM, ADR_TYPE, ADR_RUE, ADR_CP, ADR_VILLE, PAY_ID, ADR_LATITUDE, ADR_LONGITUDE) VALUES (4, 'Annecy', 'Facturation', 'Rue de la gare', '74000', 'Annecy', 1, 45.900870, 6.121609);

INSERT INTO T_E_RELAIS_REL (REL_NOM, REL_RUE, REL_CP, REL_VILLE, PAY_ID, REL_LATITUDE, REL_LONGITUDE) VALUES ('Tabac presse des pommaries', '12 Rue des Pommaries', '74940', 'Annecy-le-Vieux', 1, 45.910793, 6.145592);
INSERT INTO T_E_RELAIS_REL (REL_NOM, REL_RUE, REL_CP, REL_VILLE, PAY_ID, REL_LATITUDE, REL_LONGITUDE) VALUES ('Casino', '7 Place du 18 Juin', '74940', 'Annecy-le-Vieux', 1, 45.915350, 6.145780);
INSERT INTO T_E_RELAIS_REL (REL_NOM, REL_RUE, REL_CP, REL_VILLE, PAY_ID, REL_LATITUDE, REL_LONGITUDE) VALUES ('Casino', '119 Rue Sébastien Gryphe', '69007', 'Lyon', 1, 45.748600, 4.839746);
INSERT INTO T_E_RELAIS_REL (REL_NOM, REL_RUE, REL_CP, REL_VILLE, PAY_ID, REL_LATITUDE, REL_LONGITUDE) VALUES ('Torrefaction des 3 Rois', '13 rue des 3 Rois', '69007', 'Lyon', 1, 45.753979, 4.842775);

INSERT INTO T_J_RELAISACQUEREUR_REA (ACQ_ID, REL_ID) VALUES (1,1);
INSERT INTO T_J_RELAISACQUEREUR_REA (ACQ_ID, REL_ID) VALUES (1,2);

INSERT INTO T_R_RUBRIQUE_RUB (RUB_NOM) VALUES ('Ventes flash');
INSERT INTO T_R_RUBRIQUE_RUB (RUB_NOM) VALUES ('Gaming');
INSERT INTO T_R_RUBRIQUE_RUB (RUB_NOM) VALUES ('Rentrée');
INSERT INTO T_R_RUBRIQUE_RUB (RUB_NOM) VALUES ('Offres remboursement');

INSERT INTO T_E_FABRICANT_FAB (FAB_NOM) VALUES ('Microsoft');
INSERT INTO T_E_FABRICANT_FAB (FAB_NOM) VALUES ('Apple');
INSERT INTO T_E_FABRICANT_FAB (FAB_NOM) VALUES ('Lenovo');
INSERT INTO T_E_FABRICANT_FAB (FAB_NOM) VALUES ('Asus');
INSERT INTO T_E_FABRICANT_FAB (FAB_NOM) VALUES ('Acer');
INSERT INTO T_E_FABRICANT_FAB (FAB_NOM) VALUES ('Samsung');

INSERT INTO T_R_TYPE_TYP (TYP_LIBELLE) VALUES ('Ordinateur portable');
INSERT INTO T_R_TYPE_TYP (TYP_LIBELLE) VALUES ('Ordinateur de bureau');
INSERT INTO T_R_TYPE_TYP (TYP_LIBELLE) VALUES ('Tablette');

INSERT INTO T_E_SYSTEMEEXPLOITATION_SYE (SYE_NOM) VALUES ('iOS');
INSERT INTO T_E_SYSTEMEEXPLOITATION_SYE (SYE_NOM) VALUES ('Windows 8');
INSERT INTO T_E_SYSTEMEEXPLOITATION_SYE (SYE_NOM) VALUES ('Windows 8.1');
INSERT INTO T_E_SYSTEMEEXPLOITATION_SYE (SYE_NOM) VALUES ('Windows 10');
INSERT INTO T_E_SYSTEMEEXPLOITATION_SYE (SYE_NOM) VALUES ('Android 5.0');
INSERT INTO T_E_SYSTEMEEXPLOITATION_SYE (SYE_NOM) VALUES ('MacOS X');

INSERT INTO T_E_ORDITABLETTE_ORT (FAB_ID, SYE_ID, ORT_NOMPDT, ORT_PROCESSEUR, ORT_RAMGO, ORT_DISQUEDURGO, ORT_TAILLEECRAN      , ORT_PRIXTTC, ORT_CODEBARRE, ORT_STOCK) VALUES (1, 3, 'Tablette PC Microsoft Surface 3 10.8" 64 Go', '1.6 GHz', 2, 64, 10.8, 599.90, '1234567891011', 10);
INSERT INTO T_E_ORDITABLETTE_ORT (FAB_ID, SYE_ID, ORT_NOMPDT, ORT_PROCESSEUR, ORT_RAMGO, ORT_DISQUEDURGO, ORT_TAILLEECRAN      , ORT_PRIXTTC, ORT_CODEBARRE, ORT_STOCK) VALUES (3, 3, 'Tablette Lenovo Miix 3 10.1" Tactile', 'Intel Atom Z3745', 2, 64, 10.1, 351.19, '1234567891012', 20);
INSERT INTO T_E_ORDITABLETTE_ORT (FAB_ID, SYE_ID, ORT_NOMPDT, ORT_PROCESSEUR, ORT_RAMGO, ORT_DISQUEDURGO, ORT_TAILLEECRAN      , ORT_PRIXTTC, ORT_CODEBARRE, ORT_STOCK) VALUES (2, 6, 'Apple iMac 21,5" LED 1 To 8 Go RAM Intel Quad Core i5 à 2,7 GHz ME086', 'Intel Quad Core i5 ', 8, 1000, 21.5, 1349.90, '1234567891013', 15);
INSERT INTO T_E_ORDITABLETTE_ORT (FAB_ID, SYE_ID, ORT_NOMPDT, ORT_PROCESSEUR, ORT_RAMGO, ORT_DISQUEDURGO, ORT_TAILLEECRAN      , ORT_PRIXTTC, ORT_CODEBARRE, ORT_STOCK) VALUES (6, 5, 'Tablette Samsung Galaxy Tab S2 9.7" 32 Go Blanc', 'Octacore 1.9 GHz ', 3, 32, 9.7, 499.90, '1234567891014', 0);

INSERT INTO T_J_RUBRIQUEORDITAB_RUO (ORT_ID, RUB_ID) VALUES (1, 1);
INSERT INTO T_J_RUBRIQUEORDITAB_RUO (ORT_ID, RUB_ID) VALUES (1, 3);
INSERT INTO T_J_RUBRIQUEORDITAB_RUO (ORT_ID, RUB_ID) VALUES (1, 4);
INSERT INTO T_J_RUBRIQUEORDITAB_RUO (ORT_ID, RUB_ID) VALUES (2, 4);
INSERT INTO T_J_RUBRIQUEORDITAB_RUO (ORT_ID, RUB_ID) VALUES (3, 2);

INSERT INTO T_J_TYPEORDITAB_TOT (ORT_ID, TYP_ID) VALUES (1, 1);
INSERT INTO T_J_TYPEORDITAB_TOT (ORT_ID, TYP_ID) VALUES (1, 3);
INSERT INTO T_J_TYPEORDITAB_TOT (ORT_ID, TYP_ID) VALUES (2, 1);
INSERT INTO T_J_TYPEORDITAB_TOT (ORT_ID, TYP_ID) VALUES (2, 3);
INSERT INTO T_J_TYPEORDITAB_TOT (ORT_ID, TYP_ID) VALUES (3, 2);
INSERT INTO T_J_TYPEORDITAB_TOT (ORT_ID, TYP_ID) VALUES (4, 3);

INSERT INTO T_E_AVIS_AVI (ACQ_ID, ORT_ID, AVI_TITRE, AVI_DETAIL, AVI_NOTE, AVI_NBUTILEOUI, AVI_NBUTILENON) VALUES (1, 1, 'Super', 'J''adore. Je recommande vivement son achat', 5, 0, 4);
INSERT INTO T_E_AVIS_AVI (ACQ_ID, ORT_ID, AVI_TITRE, AVI_DETAIL, AVI_NOTE, AVI_NBUTILEOUI, AVI_NBUTILENON) VALUES (2, 1, 'Un peu cher', 'Super, mais un peu cher quand même', 3, 3, 0);
INSERT INTO T_E_AVIS_AVI (ACQ_ID, ORT_ID, AVI_TITRE, AVI_DETAIL, AVI_NOTE, AVI_NBUTILEOUI, AVI_NBUTILENON) VALUES (3, 1, 'Moyen', 'Pas mal, mais je préférais la version précédente', 2, 1, 1);

INSERT INTO T_E_CARTEBLEUE_CAB (ACQ_ID, CAB_TYPE, CAB_TITULAIRE, CAB_NUMERO, CAB_MOISEXPIRATION, CAB_ANNEEEXPIRATION, CAB_CVS) VALUES (1, 'Mastercard', 'Paul DURAND', 1234567890123456, 10, 20, 250);
INSERT INTO T_E_CARTEBLEUE_CAB (ACQ_ID, CAB_TYPE, CAB_TITULAIRE, CAB_NUMERO, CAB_MOISEXPIRATION, CAB_ANNEEEXPIRATION, CAB_CVS) VALUES (1, 'Visa', 'Paul DURAND', 1234567890123457, 10, 22, 230);
INSERT INTO T_E_CARTEBLEUE_CAB (ACQ_ID, CAB_TYPE, CAB_TITULAIRE, CAB_NUMERO, CAB_MOISEXPIRATION, CAB_ANNEEEXPIRATION, CAB_CVS) VALUES (2, 'Visa', 'Marc DUPOND', 1234567890123458, 9, 14, 310);

INSERT INTO T_E_ACHAT_ACH (REL_ID, ADR_ID, MAG_ID, ACQ_ID, ACH_DATE, CAB_ID) VALUES (1, null, null, 1, current_date-20, 1);
INSERT INTO T_E_ACHAT_ACH (REL_ID, ADR_ID, MAG_ID, ACQ_ID, ACH_DATE, CAB_ID) VALUES (null, 2, null, 1, current_date-10, 1);
INSERT INTO T_E_ACHAT_ACH (REL_ID, ADR_ID, MAG_ID, ACQ_ID, ACH_DATE, CAB_ID) VALUES (null, null, 1, 1, current_date, 2);

INSERT INTO T_J_LIGNEACHAT_LEA (ACH_ID, ORT_ID, LEA_QUANTITE) VALUES (1, 1, 1);
INSERT INTO T_J_LIGNEACHAT_LEA (ACH_ID, ORT_ID, LEA_QUANTITE) VALUES (1, 2, 3);
INSERT INTO T_J_LIGNEACHAT_LEA (ACH_ID, ORT_ID, LEA_QUANTITE) VALUES (1, 3, 1);
INSERT INTO T_J_LIGNEACHAT_LEA (ACH_ID, ORT_ID, LEA_QUANTITE) VALUES (2, 1, 1);
INSERT INTO T_J_LIGNEACHAT_LEA (ACH_ID, ORT_ID, LEA_QUANTITE) VALUES (2, 2, 1);
INSERT INTO T_J_LIGNEACHAT_LEA (ACH_ID, ORT_ID, LEA_QUANTITE) VALUES (2, 3, 1);
INSERT INTO T_J_LIGNEACHAT_LEA (ACH_ID, ORT_ID, LEA_QUANTITE) VALUES (2, 4, 1);
INSERT INTO T_J_LIGNEACHAT_LEA (ACH_ID, ORT_ID, LEA_QUANTITE) VALUES (3, 3, 10);

