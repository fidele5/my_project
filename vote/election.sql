-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 22 déc. 2018 à 07:18
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `election`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidat`
--

DROP TABLE IF EXISTS `candidat`;
CREATE TABLE IF NOT EXISTS `candidat` (
  `id_candidat` int(4) NOT NULL AUTO_INCREMENT,
  `nom_candidat` varchar(80) NOT NULL,
  `cat_cand` enum('1','2','3','4') NOT NULL,
  `poste_candidat` varchar(80) NOT NULL,
  `id_cellule` int(11) NOT NULL,
  `id_electeur` int(4) NOT NULL DEFAULT '0',
  `nb_oui_pres` int(4) NOT NULL DEFAULT '0',
  `nb_oui_vice` int(4) NOT NULL DEFAULT '0',
  `nb_oui_coord` int(4) NOT NULL DEFAULT '0',
  `nb_oui_vcoor` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_candidat`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `candidat`
--

INSERT INTO `candidat` (`id_candidat`, `nom_candidat`, `cat_cand`, `poste_candidat`, `id_cellule`, `id_electeur`, `nb_oui_pres`, `nb_oui_vice`, `nb_oui_coord`, `nb_oui_vcoor`) VALUES
(1, 'Franck-Cherif NTUMBA', '1', 'president', 0, 11, 15, 0, 0, 0),
(2, 'KAYOMBO YAV Dav', '2', 'v-president', 0, 11, 1, 11, 0, 0),
(3, 'ILUNGA WA ILUNGA Daniel', '3', 'coordonateur', 1, 6, 0, 0, 2, 0),
(4, 'MASEKO Jean-Luc', '3', 'coorndinateur', 1, 3, 0, 0, 1, 0),
(5, 'NUMBI MAKANDA Arcel', '4', 'v-coordonateur', 1, 6, 0, 0, 0, 2),
(6, 'FUNGA FUNGA CHABU Joséphine', '4', 'v-coordinateur', 2, 0, 0, 0, 0, 0),
(7, 'ISMAEL MULOLUM', '4', 'v-coordonateur', 3, 2, 0, 0, 0, 1),
(8, 'MBELU THIANI Naomie', '3', 'corrdinateur', 4, 10, 0, 0, 3, 0),
(9, 'ALVINE MFUAMBA', '3', 'coordonateur', 4, 0, 0, 0, 0, 0),
(10, 'KANKU TSHAMALA', '3', 'coordonateur', 4, 11, 0, 0, 1, 0),
(11, 'FUMBA ASEKEMBE Florette', '3', 'coordonateur', 5, 9, 0, 0, 2, 0),
(12, 'Hergé TWITE', '3', 'coodonateur', 5, 0, 0, 0, 0, 0),
(13, 'SUNGU MUTEBA Arielle', '4', 'v-coordonateur', 5, 9, 0, 0, 0, 2),
(14, 'NDAY KABONDO Hapiness', '4', 'v-coordination', 6, 0, 0, 0, 0, 0),
(21, 'LUKULA NUMBI Paul', '3', 'coordonateur', 7, 0, 0, 0, 0, 0),
(22, 'ALE MWAMBA Christoph', '3', 'coordonateur', 8, 4, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `cellules`
--

DROP TABLE IF EXISTS `cellules`;
CREATE TABLE IF NOT EXISTS `cellules` (
  `id_cellule` int(4) NOT NULL AUTO_INCREMENT,
  `nom_cellule` varchar(255) NOT NULL,
  PRIMARY KEY (`id_cellule`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cellules`
--

INSERT INTO `cellules` (`id_cellule`, `nom_cellule`) VALUES
(1, 'CONFERENCE'),
(2, 'LECTURE'),
(3, 'SPORT ET LOISIR'),
(4, 'FILM'),
(5, 'VIE ET ANIMATION CHRETIENNE'),
(6, 'ACCUEIL'),
(7, 'NATURE ET ECOLOGIE'),
(8, 'RENDEZ-VOUS DES ELEVES'),
(9, 'SPECTACLE'),
(10, 'DEVELOPPEMENT');

-- --------------------------------------------------------

--
-- Structure de la table `electeur`
--

DROP TABLE IF EXISTS `electeur`;
CREATE TABLE IF NOT EXISTS `electeur` (
  `id_electeur` int(4) NOT NULL AUTO_INCREMENT,
  `nom_electeur` varchar(80) NOT NULL,
  `mdp_electeur` varchar(40) NOT NULL,
  `id_cellule` int(2) NOT NULL,
  `vote_electeur` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_electeur`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `electeur`
--

INSERT INTO `electeur` (`id_electeur`, `nom_electeur`, `mdp_electeur`, `id_cellule`, `vote_electeur`) VALUES
(1, 'fidele', '1880852', 1, '1'),
(2, 'maestro', '18808528', 3, '1'),
(3, 'Delion', '188085296', 1, '1'),
(4, 'Maximilien', '188085245', 8, '0'),
(5, 'huguette', '123456', 4, '0'),
(6, 'plkah', '456789', 1, '0'),
(7, 'fplk', '456789', 5, '0'),
(8, 'kahumba', '4512', 4, '0'),
(9, 'paluku', '4512', 5, '0'),
(10, 'gaetan', '789456', 4, '0'),
(11, 'bruno', '789456', 4, '0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
