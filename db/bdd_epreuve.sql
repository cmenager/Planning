/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  07/01/2015 15:25:23                      */
/*==============================================================*/


drop table if exists CLASSE;

drop table if exists ELEVE;

drop table if exists ENSEIGNE;

drop table if exists EPREUVE;

drop table if exists HEUREPASSAGE;

drop table if exists LANGUE;

drop table if exists PROFESSEUR;

drop table if exists ROLE;

drop table if exists SALLE;

drop table if exists TYPE;

/*==============================================================*/
/* Table : CLASSE                                               */
/*==============================================================*/
create table CLASSE
(
   ID_CLASSE            int not null,
   LIBELLE_CLASSE       varchar(80),
   primary key (ID_CLASSE)
);

/*==============================================================*/
/* Table : ELEVE                                                */
/*==============================================================*/
create table ELEVE
(
   ID_ELEVE             int not null,
   ID_CLASSE            int not null,
   NOM_ELEVE            varchar(80),
   PRENOM_ELEVE         varchar(80),
   TIERS_TEMPS          smallint,
   primary key (ID_ELEVE)
);

/*==============================================================*/
/* Table : ENSEIGNE                                             */
/*==============================================================*/
create table ENSEIGNE
(
   ID_ELEVE             int not null,
   ID_LANGUE            int not null,
   ID_PROFESSEUR        int not null,
   primary key (ID_ELEVE, ID_LANGUE)
);

/*==============================================================*/
/* Table : EPREUVE                                              */
/*==============================================================*/
create table EPREUVE
(
   ID_ELEVE             int not null,
   DATE_PASSAGE         datetime not null,
   ID_HEURE_PASSAGE     int not null,
   ID_LANGUE            int not null,
   ID_PROFESSEUR        int not null,
   ID_SALLE             int not null,
   primary key (ID_ELEVE, ID_HEURE_PASSAGE, DATE_PASSAGE)
);

/*==============================================================*/
/* Table : HEUREPASSAGE                                         */
/*==============================================================*/
create table HEUREPASSAGE
(
   ID_HEURE_PASSAGE     int not null,
   HEURE_DEBUT          datetime,
   HEURE_FIN            datetime,
   primary key (ID_HEURE_PASSAGE)
);

/*==============================================================*/
/* Table : LANGUE                                               */
/*==============================================================*/
create table LANGUE
(
   ID_LANGUE            int not null,
   ID_TYPE              int not null,
   LIBELLE_LANGUE       varchar(80),
   primary key (ID_LANGUE)
);

/*==============================================================*/
/* Table : PROFESSEUR                                           */
/*==============================================================*/
create table PROFESSEUR
(
   ID_PROFESSEUR        int not null,
   ID_ROLE              int not null,
   NOM_PROFESSEUR       varchar(100),
   PRENOM_PROFESSEUR    varchar(100),
   LOGIN_PROFESSEUR     varchar(40),
   PWD_PROFESSEUR       varchar(40),
   SALT_PROFESSEUR      varchar(40),
   primary key (ID_PROFESSEUR)
);

/*==============================================================*/
/* Table : ROLE                                                 */
/*==============================================================*/
create table ROLE
(
   ID_ROLE              int not null,
   LIBELLE_ROLE         varchar(80),
   primary key (ID_ROLE)
);

/*==============================================================*/
/* Table : SALLE                                                */
/*==============================================================*/
create table SALLE
(
   ID_SALLE             int not null,
   LIBELLE_SALLE        varchar(100),
   primary key (ID_SALLE)
);

/*==============================================================*/
/* Table : TYPE                                                 */
/*==============================================================*/
create table TYPE
(
   ID_TYPE              int not null,
   LIBELLE_TYPE         varchar(80),
   primary key (ID_TYPE)
);

alter table ELEVE add constraint FK_ELEVE_CLASSE foreign key (ID_CLASSE)
      references CLASSE (ID_CLASSE);

alter table ENSEIGNE add constraint FK_ENSEIGNE_ELEVE foreign key (ID_ELEVE)
      references ELEVE (ID_ELEVE);

alter table ENSEIGNE add constraint FK_ENSEIGNE_LANGUE foreign key (ID_LANGUE)
      references LANGUE (ID_LANGUE);

alter table ENSEIGNE add constraint FK_ENSEIGNE_PROFESSEUR foreign key (ID_PROFESSEUR)
      references PROFESSEUR (ID_PROFESSEUR);

alter table EPREUVE add constraint FK_EPREUVE_ELEVE foreign key (ID_ELEVE)
      references ELEVE (ID_ELEVE);

alter table EPREUVE add constraint FK_EPREUVE_LANGUE foreign key (ID_LANGUE)
      references LANGUE (ID_LANGUE);

alter table EPREUVE add constraint FK_EPREUVE_HEUREPASSAGE foreign key (ID_HEURE_PASSAGE)
      references HEUREPASSAGE (ID_HEURE_PASSAGE);

alter table EPREUVE add constraint FK_EPREUVE_PROFESSEUR foreign key (ID_PROFESSEUR)
      references PROFESSEUR (ID_PROFESSEUR);

alter table EPREUVE add constraint FK_EPREUVE_SALLE foreign key (ID_SALLE)
      references SALLE (ID_SALLE);

alter table LANGUE add constraint FK_LANGUE_TYPE foreign key (ID_TYPE)
      references TYPE (ID_TYPE);

alter table PROFESSEUR add constraint FK_PROFESSEUR_ROLE foreign key (ID_ROLE)
      references ROLE (ID_ROLE);

