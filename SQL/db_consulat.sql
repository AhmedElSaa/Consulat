-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 07 nov. 2024 à 21:07
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_consulat`
--

-- --------------------------------------------------------

--
-- Structure de la table `banned_nationalities`
--

DROP TABLE IF EXISTS `banned_nationalities`;
CREATE TABLE IF NOT EXISTS `banned_nationalities` (
  `id_nation` bigint NOT NULL,
  PRIMARY KEY (`id_nation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `banned_nationalities`
--

INSERT INTO `banned_nationalities` (`id_nation`) VALUES
(1),
(45),
(79),
(80),
(83),
(98),
(163),
(164),
(170),
(189);

-- --------------------------------------------------------

--
-- Structure de la table `nationalite`
--

DROP TABLE IF EXISTS `nationalite`;
CREATE TABLE IF NOT EXISTS `nationalite` (
  `id_nation` bigint NOT NULL,
  `nation` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_nation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `nationalite`
--

INSERT INTO `nationalite` (`id_nation`, `nation`) VALUES
(1, 'Afghanistan'),
(2, 'Afrique du Sud'),
(3, 'Albanie'),
(4, 'Algérie'),
(5, 'Allemagne'),
(6, 'Andorre'),
(7, 'Angola'),
(8, 'Antigua-et-Barbuda'),
(9, 'Arabie Saoudite'),
(10, 'Argentine'),
(11, 'Arménie'),
(12, 'Australie'),
(13, 'Autriche'),
(14, 'Azerbaïdjan'),
(15, 'Bahamas'),
(16, 'Bahreïn'),
(17, 'Bangladesh'),
(18, 'Barbade'),
(19, 'Belgique'),
(20, 'Belize'),
(21, 'Bénin'),
(22, 'Bhoutan'),
(23, 'Biélorussie'),
(24, 'Birmanie'),
(25, 'Bolivie'),
(26, 'Bosnie-Herzégovine'),
(27, 'Botswana'),
(28, 'Brésil'),
(29, 'Brunei'),
(30, 'Bulgarie'),
(31, 'Burkina Faso'),
(32, 'Burundi'),
(33, 'Cambodge'),
(34, 'Cameroun'),
(35, 'Canada'),
(36, 'Cap-Vert'),
(37, 'Centrafrique'),
(38, 'Chili'),
(39, 'Chine'),
(40, 'Chypre'),
(41, 'Colombie'),
(42, 'Comores'),
(43, 'Congo (Brazzaville)'),
(44, 'Congo (Kinshasa)'),
(45, 'Corée du Nord'),
(46, 'Corée du Sud'),
(47, 'Costa Rica'),
(48, 'Côte d’Ivoire'),
(49, 'Croatie'),
(50, 'Cuba'),
(51, 'Danemark'),
(52, 'Djibouti'),
(53, 'Dominique'),
(54, 'Égypte'),
(55, 'Émirats arabes unis'),
(56, 'Équateur'),
(57, 'Érythrée'),
(58, 'États-Unis'),
(59, 'Éthiopie'),
(60, 'Fidji'),
(61, 'Finlande'),
(62, 'France'),
(63, 'Gabon'),
(64, 'Gambie'),
(65, 'Géorgie'),
(66, 'Ghana'),
(67, 'Grèce'),
(68, 'Grenade'),
(69, 'Guatemala'),
(70, 'Guinée'),
(71, 'Guinée-Bissau'),
(72, 'Guinée Équatoriale'),
(73, 'Guyana'),
(74, 'Haïti'),
(75, 'Honduras'),
(76, 'Hongrie'),
(77, 'Inde'),
(78, 'Indonésie'),
(79, 'Irak'),
(80, 'Iran'),
(81, 'Irlande'),
(82, 'Islande'),
(83, 'Israël'),
(84, 'Italie'),
(85, 'Jamaïque'),
(86, 'Japon'),
(87, 'Jordanie'),
(88, 'Kazakhstan'),
(89, 'Kenya'),
(90, 'Kirghizistan'),
(91, 'Kiribati'),
(92, 'Koweït'),
(93, 'Laos'),
(94, 'Lesotho'),
(95, 'Lettonie'),
(96, 'Liban'),
(97, 'Liberia'),
(98, 'Libye'),
(99, 'Liechtenstein'),
(100, 'Lituanie'),
(101, 'Luxembourg'),
(102, 'Macédoine du Nord'),
(103, 'Madagascar'),
(104, 'Malaisie'),
(105, 'Malawi'),
(106, 'Maldives'),
(107, 'Mali'),
(108, 'Malte'),
(109, 'Maroc'),
(110, 'Marshall'),
(111, 'Maurice'),
(112, 'Mauritanie'),
(113, 'Mexique'),
(114, 'Micronésie'),
(115, 'Moldavie'),
(116, 'Monaco'),
(117, 'Mongolie'),
(118, 'Monténégro'),
(119, 'Mozambique'),
(120, 'Namibie'),
(121, 'Nauru'),
(122, 'Népal'),
(123, 'Nicaragua'),
(124, 'Niger'),
(125, 'Nigéria'),
(126, 'Norvège'),
(127, 'Nouvelle-Zélande'),
(128, 'Oman'),
(129, 'Ouganda'),
(130, 'Ouzbékistan'),
(131, 'Pakistan'),
(132, 'Palaos'),
(133, 'Panama'),
(134, 'Papouasie-Nouvelle-Guinée'),
(135, 'Paraguay'),
(136, 'Pays-Bas'),
(137, 'Pérou'),
(138, 'Philippines'),
(139, 'Pologne'),
(140, 'Portugal'),
(141, 'Qatar'),
(142, 'République dominicaine'),
(143, 'République tchèque'),
(144, 'Roumanie'),
(145, 'Royaume-Uni'),
(146, 'Russie'),
(147, 'Rwanda'),
(148, 'Saint-Kitts-et-Nevis'),
(149, 'Saint-Marin'),
(150, 'Saint-Vincent-et-les-Gren'),
(151, 'Sainte-Lucie'),
(152, 'Salomon'),
(153, 'Salvador'),
(154, 'Samoa'),
(155, 'Sao Tomé-et-Principe'),
(156, 'Sénégal'),
(157, 'Serbie'),
(158, 'Seychelles'),
(159, 'Sierra Leone'),
(160, 'Singapour'),
(161, 'Slovaquie'),
(162, 'Slovénie'),
(163, 'Somalie'),
(164, 'Soudan'),
(165, 'Soudan du Sud'),
(166, 'Sri Lanka'),
(167, 'Suède'),
(168, 'Suisse'),
(169, 'Suriname'),
(170, 'Syrie'),
(171, 'Tadjikistan'),
(172, 'Tanzanie'),
(173, 'Tchad'),
(174, 'Thaïlande'),
(175, 'Timor oriental'),
(176, 'Togo'),
(177, 'Tonga'),
(178, 'Trinité-et-Tobago'),
(179, 'Tunisie'),
(180, 'Turkménistan'),
(181, 'Turquie'),
(182, 'Tuvalu'),
(183, 'Ukraine'),
(184, 'Uruguay'),
(185, 'Vanuatu'),
(186, 'Vatican'),
(187, 'Venezuela'),
(188, 'Vietnam'),
(189, 'Yémen'),
(190, 'Zambie'),
(191, 'Zimbabwe'),
(192, 'Palestine'),
(193, 'Taïwan'),
(194, 'Kosovo'),
(195, 'Sahara occidental');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_nation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `numPass` varchar(255) NOT NULL,
  `dateExpPass` date NOT NULL,
  `dateNaissance` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `loterie` tinyint(1) DEFAULT '0',
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `id_nation`, `numPass`, `dateExpPass`, `dateNaissance`, `password`, `loterie`, `role`) VALUES
(1, 'ROOT', 'Admin', 'root@admin.com', '62', '12345678', '2030-03-08', '2003-03-08', '12345678', 0, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `visa`
--

DROP TABLE IF EXISTS `visa`;
CREATE TABLE IF NOT EXISTS `visa` (
  `id_visa` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'visa',
  `date` date DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `pays_residence` varchar(100) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `code_postal` varchar(20) NOT NULL,
  `ville` varchar(100) NOT NULL,
  PRIMARY KEY (`id_visa`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Déclencheurs `visa`
--
DROP TRIGGER IF EXISTS `set_visa_type`;
DELIMITER $$
CREATE TRIGGER `set_visa_type` BEFORE INSERT ON `visa` FOR EACH ROW BEGIN
    SET NEW.type = 'visa';
END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
