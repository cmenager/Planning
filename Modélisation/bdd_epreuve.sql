/*==============================================================*/
/* Nom de SGBD :  ORACLE Version 10g                            */
/* Date de création :  05/01/2015 15:40:05                      */
/*==============================================================*/


alter table ELEVE
   drop constraint FK_ELEVE_DF2_CLASSE;

alter table EPREUVE
   drop constraint FK_EPREUVE_EPREUVE_ELEVE;

alter table EPREUVE
   drop constraint FK_EPREUVE_EPREUVE2_LANGUE;

alter table EPREUVE
   drop constraint FK_EPREUVE_EPREUVE3_HEUREPAS;

alter table EPREUVE
   drop constraint FK_EPREUVE_EPREUVE4_DATEPASS;

alter table EPREUVE
   drop constraint FK_EPREUVE_EPREUVE5_PROFESSE;

alter table EPREUVE
   drop constraint FK_EPREUVE_EPREUVE6_SALLE;

alter table LANGUE
   drop constraint FK_LANGUE_DF3_TYPE;

alter table PASSE
   drop constraint FK_PASSE_PASSE_ELEVE;

alter table PASSE
   drop constraint FK_PASSE_PASSE2_LANGUE;

alter table PASSE
   drop constraint FK_PASSE_PASSE3_PROFESSE;

alter table PROFESSEUR
   drop constraint FK_PROFESSE_DF1_ROLE;

alter table SE_PASSE
   drop constraint FK_SE_PASSE_SE_PASSE_DATEPASS;

alter table SE_PASSE
   drop constraint FK_SE_PASSE_SE_PASSE2_HEUREPAS;

alter table SE_PASSE
   drop constraint FK_SE_PASSE_SE_PASSE3_LANGUE;

alter table SE_PASSE
   drop constraint FK_SE_PASSE_SE_PASSE4_PROFESSE;

alter table SE_PASSE
   drop constraint FK_SE_PASSE_SE_PASSE5_SALLE;

drop table CLASSE cascade constraints;

drop table DATEPASSAGE cascade constraints;

drop index DF2_FK;

drop table ELEVE cascade constraints;

drop index EPREUVE6_FK;

drop index EPREUVE5_FK;

drop index EPREUVE4_FK;

drop index EPREUVE3_FK;

drop index EPREUVE2_FK;

drop index EPREUVE_FK;

drop table EPREUVE cascade constraints;

drop table HEUREPASSAGE cascade constraints;

drop index DF3_FK;

drop table LANGUE cascade constraints;

drop index PASSE3_FK;

drop index PASSE2_FK;

drop index PASSE_FK;

drop table PASSE cascade constraints;

drop index DF1_FK;

drop table PROFESSEUR cascade constraints;

drop table ROLE cascade constraints;

drop table SALLE cascade constraints;

drop index SE_PASSE5_FK;

drop index SE_PASSE4_FK;

drop index SE_PASSE3_FK;

drop index SE_PASSE2_FK;

drop index SE_PASSE_FK;

drop table SE_PASSE cascade constraints;

drop table TYPE cascade constraints;

/*==============================================================*/
/* Table : CLASSE                                               */
/*==============================================================*/
create table CLASSE  (
   ID_CLASSE            INTEGER                         not null,
   LIBELLE              VARCHAR2(100),
   constraint PK_CLASSE primary key (ID_CLASSE)
);

/*==============================================================*/
/* Table : DATEPASSAGE                                          */
/*==============================================================*/
create table DATEPASSAGE  (
   DATE_PASSAGE         DATE                            not null,
   constraint PK_DATEPASSAGE primary key (DATE_PASSAGE)
);

/*==============================================================*/
/* Table : ELEVE                                                */
/*==============================================================*/
create table ELEVE  (
   ID_ELEVE             INTEGER                         not null,
   ID_CLASSE            INTEGER                         not null,
   NOM                  VARCHAR2(100),
   PRENOM               VARCHAR2(100),
   TIERS_TEMPS          SMALLINT,
   constraint PK_ELEVE primary key (ID_ELEVE)
);

/*==============================================================*/
/* Index : DF2_FK                                               */
/*==============================================================*/
create index DF2_FK on ELEVE (
   ID_CLASSE ASC
);

/*==============================================================*/
/* Table : EPREUVE                                              */
/*==============================================================*/
create table EPREUVE  (
   ID_ELEVE             INTEGER                         not null,
   ID_LANGUE            INTEGER                         not null,
   ID_HEURE_PASSAGE     INTEGER                         not null,
   DATE_PASSAGE         DATE                            not null,
   ID_PROFESSEUR        INTEGER                         not null,
   ID_SALLE             INTEGER                         not null,
   constraint PK_EPREUVE primary key (ID_ELEVE, ID_LANGUE, ID_HEURE_PASSAGE, DATE_PASSAGE, ID_PROFESSEUR, ID_SALLE)
);

/*==============================================================*/
/* Index : EPREUVE_FK                                           */
/*==============================================================*/
create index EPREUVE_FK on EPREUVE (
   ID_ELEVE ASC
);

/*==============================================================*/
/* Index : EPREUVE2_FK                                          */
/*==============================================================*/
create index EPREUVE2_FK on EPREUVE (
   ID_LANGUE ASC
);

/*==============================================================*/
/* Index : EPREUVE3_FK                                          */
/*==============================================================*/
create index EPREUVE3_FK on EPREUVE (
   ID_HEURE_PASSAGE ASC
);

/*==============================================================*/
/* Index : EPREUVE4_FK                                          */
/*==============================================================*/
create index EPREUVE4_FK on EPREUVE (
   DATE_PASSAGE ASC
);

/*==============================================================*/
/* Index : EPREUVE5_FK                                          */
/*==============================================================*/
create index EPREUVE5_FK on EPREUVE (
   ID_PROFESSEUR ASC
);

/*==============================================================*/
/* Index : EPREUVE6_FK                                          */
/*==============================================================*/
create index EPREUVE6_FK on EPREUVE (
   ID_SALLE ASC
);

/*==============================================================*/
/* Table : HEUREPASSAGE                                         */
/*==============================================================*/
create table HEUREPASSAGE  (
   ID_HEURE_PASSAGE     INTEGER                         not null,
   HEURE_DEBUT          DATE,
   HEURE_FIN            DATE,
   constraint PK_HEUREPASSAGE primary key (ID_HEURE_PASSAGE)
);

/*==============================================================*/
/* Table : LANGUE                                               */
/*==============================================================*/
create table LANGUE  (
   ID_LANGUE            INTEGER                         not null,
   ID_TYPE              INTEGER                         not null,
   LIBELLE              VARCHAR2(100),
   constraint PK_LANGUE primary key (ID_LANGUE)
);

/*==============================================================*/
/* Index : DF3_FK                                               */
/*==============================================================*/
create index DF3_FK on LANGUE (
   ID_TYPE ASC
);

/*==============================================================*/
/* Table : PASSE                                                */
/*==============================================================*/
create table PASSE  (
   ID_ELEVE             INTEGER                         not null,
   ID_LANGUE            INTEGER                         not null,
   ID_PROFESSEUR        INTEGER                         not null,
   constraint PK_PASSE primary key (ID_ELEVE, ID_LANGUE, ID_PROFESSEUR)
);

/*==============================================================*/
/* Index : PASSE_FK                                             */
/*==============================================================*/
create index PASSE_FK on PASSE (
   ID_ELEVE ASC
);

/*==============================================================*/
/* Index : PASSE2_FK                                            */
/*==============================================================*/
create index PASSE2_FK on PASSE (
   ID_LANGUE ASC
);

/*==============================================================*/
/* Index : PASSE3_FK                                            */
/*==============================================================*/
create index PASSE3_FK on PASSE (
   ID_PROFESSEUR ASC
);

/*==============================================================*/
/* Table : PROFESSEUR                                           */
/*==============================================================*/
create table PROFESSEUR  (
   ID_PROFESSEUR        INTEGER                         not null,
   ID_ROLE              CHAR(10)                        not null,
   NOM                  VARCHAR2(100),
   PRENOM               VARCHAR2(100),
   constraint PK_PROFESSEUR primary key (ID_PROFESSEUR)
);

/*==============================================================*/
/* Index : DF1_FK                                               */
/*==============================================================*/
create index DF1_FK on PROFESSEUR (
   ID_ROLE ASC
);

/*==============================================================*/
/* Table : ROLE                                                 */
/*==============================================================*/
create table ROLE  (
   ID_ROLE              CHAR(10)                        not null,
   LIBELLE_ROLE         VARCHAR2(80),
   constraint PK_ROLE primary key (ID_ROLE)
);

/*==============================================================*/
/* Table : SALLE                                                */
/*==============================================================*/
create table SALLE  (
   ID_SALLE             INTEGER                         not null,
   LIBELLE              VARCHAR2(100),
   constraint PK_SALLE primary key (ID_SALLE)
);

/*==============================================================*/
/* Table : SE_PASSE                                             */
/*==============================================================*/
create table SE_PASSE  (
   DATE_PASSAGE         DATE                            not null,
   ID_HEURE_PASSAGE     INTEGER                         not null,
   ID_LANGUE            INTEGER                         not null,
   ID_PROFESSEUR        INTEGER                         not null,
   ID_SALLE             INTEGER                         not null,
   constraint PK_SE_PASSE primary key (DATE_PASSAGE, ID_HEURE_PASSAGE, ID_LANGUE, ID_PROFESSEUR, ID_SALLE)
);

/*==============================================================*/
/* Index : SE_PASSE_FK                                          */
/*==============================================================*/
create index SE_PASSE_FK on SE_PASSE (
   DATE_PASSAGE ASC
);

/*==============================================================*/
/* Index : SE_PASSE2_FK                                         */
/*==============================================================*/
create index SE_PASSE2_FK on SE_PASSE (
   ID_HEURE_PASSAGE ASC
);

/*==============================================================*/
/* Index : SE_PASSE3_FK                                         */
/*==============================================================*/
create index SE_PASSE3_FK on SE_PASSE (
   ID_LANGUE ASC
);

/*==============================================================*/
/* Index : SE_PASSE4_FK                                         */
/*==============================================================*/
create index SE_PASSE4_FK on SE_PASSE (
   ID_PROFESSEUR ASC
);

/*==============================================================*/
/* Index : SE_PASSE5_FK                                         */
/*==============================================================*/
create index SE_PASSE5_FK on SE_PASSE (
   ID_SALLE ASC
);

/*==============================================================*/
/* Table : TYPE                                                 */
/*==============================================================*/
create table TYPE  (
   ID_TYPE              INTEGER                         not null,
   LIBELLE              VARCHAR2(100),
   constraint PK_TYPE primary key (ID_TYPE)
);

alter table ELEVE
   add constraint FK_ELEVE_DF2_CLASSE foreign key (ID_CLASSE)
      references CLASSE (ID_CLASSE);

alter table EPREUVE
   add constraint FK_EPREUVE_EPREUVE_ELEVE foreign key (ID_ELEVE)
      references ELEVE (ID_ELEVE);

alter table EPREUVE
   add constraint FK_EPREUVE_EPREUVE2_LANGUE foreign key (ID_LANGUE)
      references LANGUE (ID_LANGUE);

alter table EPREUVE
   add constraint FK_EPREUVE_EPREUVE3_HEUREPAS foreign key (ID_HEURE_PASSAGE)
      references HEUREPASSAGE (ID_HEURE_PASSAGE);

alter table EPREUVE
   add constraint FK_EPREUVE_EPREUVE4_DATEPASS foreign key (DATE_PASSAGE)
      references DATEPASSAGE (DATE_PASSAGE);

alter table EPREUVE
   add constraint FK_EPREUVE_EPREUVE5_PROFESSE foreign key (ID_PROFESSEUR)
      references PROFESSEUR (ID_PROFESSEUR);

alter table EPREUVE
   add constraint FK_EPREUVE_EPREUVE6_SALLE foreign key (ID_SALLE)
      references SALLE (ID_SALLE);

alter table LANGUE
   add constraint FK_LANGUE_DF3_TYPE foreign key (ID_TYPE)
      references TYPE (ID_TYPE);

alter table PASSE
   add constraint FK_PASSE_PASSE_ELEVE foreign key (ID_ELEVE)
      references ELEVE (ID_ELEVE);

alter table PASSE
   add constraint FK_PASSE_PASSE2_LANGUE foreign key (ID_LANGUE)
      references LANGUE (ID_LANGUE);

alter table PASSE
   add constraint FK_PASSE_PASSE3_PROFESSE foreign key (ID_PROFESSEUR)
      references PROFESSEUR (ID_PROFESSEUR);

alter table PROFESSEUR
   add constraint FK_PROFESSE_DF1_ROLE foreign key (ID_ROLE)
      references ROLE (ID_ROLE);

alter table SE_PASSE
   add constraint FK_SE_PASSE_SE_PASSE_DATEPASS foreign key (DATE_PASSAGE)
      references DATEPASSAGE (DATE_PASSAGE);

alter table SE_PASSE
   add constraint FK_SE_PASSE_SE_PASSE2_HEUREPAS foreign key (ID_HEURE_PASSAGE)
      references HEUREPASSAGE (ID_HEURE_PASSAGE);

alter table SE_PASSE
   add constraint FK_SE_PASSE_SE_PASSE3_LANGUE foreign key (ID_LANGUE)
      references LANGUE (ID_LANGUE);

alter table SE_PASSE
   add constraint FK_SE_PASSE_SE_PASSE4_PROFESSE foreign key (ID_PROFESSEUR)
      references PROFESSEUR (ID_PROFESSEUR);

alter table SE_PASSE
   add constraint FK_SE_PASSE_SE_PASSE5_SALLE foreign key (ID_SALLE)
      references SALLE (ID_SALLE);

