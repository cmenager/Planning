-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 08 Janvier 2015 à 18:26
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `planning`
--

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE IF NOT EXISTS `classe` (
  `ID_CLASSE` int(11) NOT NULL,
  `LIBELLE_CLASSE` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE IF NOT EXISTS `eleve` (
  `ID_ELEVE` int(11) NOT NULL,
  `ID_CLASSE` int(11) NOT NULL,
  `NOM_ELEVE` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRENOM_ELEVE` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TIERS_TEMPS` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `enseigne`
--

CREATE TABLE IF NOT EXISTS `enseigne` (
  `ID_ELEVE` int(11) NOT NULL,
  `ID_LANGUE` int(11) NOT NULL,
  `ID_PROFESSEUR` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `enseigne`
--

INSERT INTO `enseigne` (`ID_ELEVE`, `ID_LANGUE`, `ID_PROFESSEUR`) VALUES
(1, 1, 2),
(3, 3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `epreuve`
--

CREATE TABLE IF NOT EXISTS `epreuve` (
  `ID_ELEVE` int(11) NOT NULL,
  `DATE_PASSAGE` date NOT NULL,
  `ID_HEURE_PASSAGE` int(11) NOT NULL,
  `ID_LANGUE` int(11) NOT NULL,
  `ID_PROFESSEUR` int(11) NOT NULL,
  `ID_SALLE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `epreuve`
--

INSERT INTO `epreuve` (`ID_ELEVE`, `DATE_PASSAGE`, `ID_HEURE_PASSAGE`, `ID_LANGUE`, `ID_PROFESSEUR`, `ID_SALLE`) VALUES
(1, '2015-01-18', 1, 1, 3, 2),
(2, '2015-01-26', 2, 4, 3, 4),
(3, '2015-01-11', 4, 2, 3, 2),
(3, '2015-01-18', 4, 2, 2, 2),
(4, '2015-01-19', 1, 4, 4, 2),
(5, '2015-01-12', 2, 1, 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `heurepassage`
--

CREATE TABLE IF NOT EXISTS `heurepassage` (
  `ID_HEURE_PASSAGE` int(11) NOT NULL,
  `HEURE_DEBUT` time DEFAULT NULL,
  `HEURE_FIN` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `heurepassage`
--

INSERT INTO `heurepassage` (`ID_HEURE_PASSAGE`, `HEURE_DEBUT`, `HEURE_FIN`) VALUES
(1, '10:00:00', '10:40:00'),
(2, '11:00:00', '11:40:00'),
(3, '12:00:00', '12:40:00'),
(4, '13:00:00', '13:40:00');

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

CREATE TABLE IF NOT EXISTS `langue` (
  `ID_LANGUE` int(11) NOT NULL,
  `LIBELLE_LANGUE` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `langue`
--

INSERT INTO `langue` (`ID_LANGUE`, `LIBELLE_LANGUE`) VALUES
(1, 'Espagnol LV1'),
(4, 'Espagnol LV2'),
(5, 'Espagnol LV3'),
(2, 'Anglais LV1'),
(6, 'Anglais LV2'),
(7, 'Anglais LV3'),
(3, 'Allemand LV1'),
(8, 'Allemand LV2'),
(9, 'Allemand LV3');

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE IF NOT EXISTS `professeur` (
  `ID_PROFESSEUR` int(11) NOT NULL,
  `ID_ROLE` int(11) NOT NULL,
  `NOM_PROFESSEUR` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRENOM_PROFESSEUR` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LOGIN_PROFESSEUR` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PWD_PROFESSEUR` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SALT_PROFESSEUR` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `professeur`
--

INSERT INTO `professeur` (`ID_PROFESSEUR`, `ID_ROLE`, `NOM_PROFESSEUR`, `PRENOM_PROFESSEUR`, `LOGIN_PROFESSEUR`, `PWD_PROFESSEUR`, `SALT_PROFESSEUR`) VALUES
(1, 2, 'Pluchot', 'Daniel', 'p.dan@me.fr', 'secret', NULL),
(2, 1, 'Boissel', 'Alain', 'boissel.alain@me.fr', 'adm', NULL),
(3, 2, 'Riamon', 'Clemence', 'r.clem@me.fr', 'rclem', NULL),
(4, 2, 'Pitois', 'Remy', 'p.remy@me.fr', 'pr', NULL),
(5, 2, 'Gomena', 'Dimitri', 'g.d@me.fr', 'gd', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `ID_ROLE` int(11) NOT NULL,
  `LIBELLE_ROLE` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`ID_ROLE`, `LIBELLE_ROLE`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_PROFESSEUR');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `ID_SALLE` int(11) NOT NULL,
  `LIBELLE_SALLE` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`ID_SALLE`, `LIBELLE_SALLE`) VALUES
(1, 'B206'),
(2, 'B201'),
(3, 'B216'),
(4, 'B101');

-- --------------------------------------------------------

--
-- Index pour les tables exportées
--

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
 ADD PRIMARY KEY (`ID_CLASSE`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
 ADD PRIMARY KEY (`ID_ELEVE`), ADD KEY `FK_ELEVE_CLASSE` (`ID_CLASSE`);

--
-- Index pour la table `enseigne`
--
ALTER TABLE `enseigne`
 ADD PRIMARY KEY (`ID_ELEVE`,`ID_LANGUE`), ADD KEY `FK_ENSEIGNE_LANGUE` (`ID_LANGUE`), ADD KEY `FK_ENSEIGNE_PROFESSEUR` (`ID_PROFESSEUR`);

--
-- Index pour la table `epreuve`
--
ALTER TABLE `epreuve`
 ADD PRIMARY KEY (`ID_ELEVE`,`ID_HEURE_PASSAGE`,`DATE_PASSAGE`), ADD KEY `FK_EPREUVE_LANGUE` (`ID_LANGUE`), ADD KEY `FK_EPREUVE_HEUREPASSAGE` (`ID_HEURE_PASSAGE`), ADD KEY `FK_EPREUVE_PROFESSEUR` (`ID_PROFESSEUR`), ADD KEY `FK_EPREUVE_SALLE` (`ID_SALLE`);

--
-- Index pour la table `heurepassage`
--
ALTER TABLE `heurepassage`
 ADD PRIMARY KEY (`ID_HEURE_PASSAGE`);

--
-- Index pour la table `professeur`
--
ALTER TABLE `professeur`
 ADD PRIMARY KEY (`ID_PROFESSEUR`), ADD KEY `FK_PROFESSEUR_ROLE` (`ID_ROLE`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
 ADD PRIMARY KEY (`ID_ROLE`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
 ADD PRIMARY KEY (`ID_SALLE`);


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
ADD CONSTRAINT `FK_ELEVE_CLASSE` FOREIGN KEY (`ID_CLASSE`) REFERENCES `classe` (`ID_CLASSE`);

--
-- Contraintes pour la table `enseigne`
--
ALTER TABLE `enseigne`
ADD CONSTRAINT `FK_ENSEIGNE_ELEVE` FOREIGN KEY (`ID_ELEVE`) REFERENCES `eleve` (`ID_ELEVE`),
ADD CONSTRAINT `FK_ENSEIGNE_LANGUE` FOREIGN KEY (`ID_LANGUE`) REFERENCES `langue` (`ID_LANGUE`),
ADD CONSTRAINT `FK_ENSEIGNE_PROFESSEUR` FOREIGN KEY (`ID_PROFESSEUR`) REFERENCES `professeur` (`ID_PROFESSEUR`);

--
-- Contraintes pour la table `epreuve`
--
ALTER TABLE `epreuve`
ADD CONSTRAINT `FK_EPREUVE_ELEVE` FOREIGN KEY (`ID_ELEVE`) REFERENCES `eleve` (`ID_ELEVE`),
ADD CONSTRAINT `FK_EPREUVE_HEUREPASSAGE` FOREIGN KEY (`ID_HEURE_PASSAGE`) REFERENCES `heurepassage` (`ID_HEURE_PASSAGE`),
ADD CONSTRAINT `FK_EPREUVE_LANGUE` FOREIGN KEY (`ID_LANGUE`) REFERENCES `langue` (`ID_LANGUE`),
ADD CONSTRAINT `FK_EPREUVE_PROFESSEUR` FOREIGN KEY (`ID_PROFESSEUR`) REFERENCES `professeur` (`ID_PROFESSEUR`),
ADD CONSTRAINT `FK_EPREUVE_SALLE` FOREIGN KEY (`ID_SALLE`) REFERENCES `salle` (`ID_SALLE`);


--
-- Contraintes pour la table `professeur`
--
ALTER TABLE `professeur`
ADD CONSTRAINT `FK_PROFESSEUR_ROLE` FOREIGN KEY (`ID_ROLE`) REFERENCES `role` (`ID_ROLE`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
