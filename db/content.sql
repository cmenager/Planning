--
-- Contenu de la table `classe`
--

INSERT INTO `classe` (`ID_CLASSE`, `LIBELLE_CLASSE`) VALUES
(1, 'Terminale S'),
(2, 'Terminale ES'),
(3, 'Terminale L'),
(4, 'Terminale STG'),
(5, 'Terminale ST2S'),
(6, 'Terminale ST2A');

--
-- Contenu de la table `eleve`
--

INSERT INTO `eleve` (`ID_ELEVE`, `ID_CLASSE`, `NOM_ELEVE`, `PRENOM_ELEVE`, `TIERS_TEMPS`) VALUES
(1, 1, 'Dupont', 'Daniel', 1),
(2, 2, 'Raja', 'Pascal', 0),
(3, 1, 'Zerzar', 'Jennifer', 1),
(4, 3, 'Menager', 'Sophie', 1),
(5, 5, 'Gomes', 'Dimitri', 0),
(6, 2, 'Vuillot', 'Genevieve', NULL);


--
-- Contenu de la table `enseigne`
--

INSERT INTO `enseigne` (`ID_ELEVE`, `ID_LANGUE`, `ID_PROFESSEUR`) VALUES
(1, 1, 2),
(3, 3, 2);


--
-- Contenu de la table `epreuve`
--

INSERT INTO `epreuve` (`ID_ELEVE`, `DATE_PASSAGE`, `ID_HEURE_PASSAGE`, `ID_LANGUE`, `ID_PROFESSEUR`, `ID_SALLE`) VALUES
(1, '2015-01-13 00:00:00', 1, 1, 2, 2),
(2, '2015-01-19 00:00:00', 2, 3, 2, 3);


--
-- Contenu de la table `heurepassage`
--

INSERT INTO `heurepassage` (`ID_HEURE_PASSAGE`, `HEURE_DEBUT`, `HEURE_FIN`) VALUES
(1, '2015-01-07 14:00:00', '2015-01-07 14:40:00'),
(2, '2015-01-07 10:00:00', '2015-01-07 10:40:00');

--
-- Contenu de la table `langue`
--

INSERT INTO `langue` (`ID_LANGUE`, `ID_TYPE`, `LIBELLE_LANGUE`) VALUES
(1, 1, 'Espagnol'),
(2, 2, 'Anglais'),
(3, 3, 'Italien'),
(4, 4, 'Allemand');



--
-- Contenu de la table `professeur`
--

INSERT INTO `professeur` (`ID_PROFESSEUR`, `ID_ROLE`, `NOM_PROFESSEUR`, `PRENOM_PROFESSEUR`, `LOGIN_PROFESSEUR`, `PWD_PROFESSEUR`, `SALT_PROFESSEUR`) VALUES
(1, 2, 'Pluchot', 'Daniel', 'p.dan@me.fr', 'secret', NULL),
(2, 1, 'Admin', 'adm', 'adm', 'adm', NULL);


--
-- Contenu de la table `role`
--

INSERT INTO `role` (`ID_ROLE`, `LIBELLE_ROLE`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_PROFESSEUR');


--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`ID_SALLE`, `LIBELLE_SALLE`) VALUES
(1, 'B206'),
(2, 'B201'),
(3, 'B216'),
(4, 'B101');

--
-- Contenu de la table `type`
--

INSERT INTO `type` (`ID_TYPE`, `LIBELLE_TYPE`) VALUES
(1, 'LV1'),
(2, 'LV2'),
(3, 'LV3'),
(4, 'LV4');








