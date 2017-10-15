-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 14 Octobre 2017 à 19:10
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `ecv_jo2024`
--

-- --------------------------------------------------------

--
-- Structure de la table `athlete`
--

CREATE TABLE IF NOT EXISTS `athlete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pays_id` int(11) DEFAULT NULL,
  `discipline_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C03B8321A6E44244` (`pays_id`),
  KEY `IDX_C03B8321A5522701` (`discipline_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Contenu de la table `athlete`
--

INSERT INTO `athlete` (`id`, `nom`, `prenom`, `date_naissance`, `photo`, `pays_id`, `discipline_id`) VALUES
(3, 'Lamoche', 'Gertrude', '2012-01-01', 'eee1dc7f3d01228f036f7b20e69a1767.png', 1, 1),
(6, 'ij', 'ji', '1902-02-01', 'a2bc234edd7814fd8bd723d01fcb3ccd.jpeg', 2, 1),
(10, 'nunun', 'nununu', '1902-01-01', '61c6a5863454f52b0491316647167671.png', 1, 1),
(11, 'Fred', 'Haller', '1902-01-01', 'e32c24808a601d4769c1f007fdfa4f46.png', 6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `discipline`
--

CREATE TABLE IF NOT EXISTS `discipline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `discipline`
--

INSERT INTO `discipline` (`id`, `nom`) VALUES
(1, '200m'),
(4, '100m'),
(6, '400m relais'),
(7, 'Saut en hauteur');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drapeau` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `pays`
--

INSERT INTO `pays` (`id`, `nom`, `drapeau`) VALUES
(1, 'France', '7973ef35945515bc57305ea842f187bf.png'),
(2, 'Angleterre', 'b2c60206bcaae369af1d70386dab45e6.png'),
(6, 'Allemagne', 'c7718d5cb601b56634074f75434a66d4.png');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `athlete`
--
ALTER TABLE `athlete`
  ADD CONSTRAINT `FK_C03B8321A5522701` FOREIGN KEY (`discipline_id`) REFERENCES `discipline` (`id`),
  ADD CONSTRAINT `FK_C03B8321A6E44244` FOREIGN KEY (`pays_id`) REFERENCES `pays` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
