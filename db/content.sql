--
-- Structure de la table `eleve`
--

CREATE TABLE IF NOT EXISTS `eleve` (
  `id_eleve` int(5) NOT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tiers_temps` varchar(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Contenu de la table `eleve`
--

INSERT INTO `eleve` (`id_eleve`, `nom`, `prenom`, `tiers_temps`) VALUES
(1, 'Durand', 'Daniel', 'Oui'),
(2, 'Dupont', 'Jennifer', 'Non'),
(3, 'Zerzar', 'Jennifer', 'Oui');