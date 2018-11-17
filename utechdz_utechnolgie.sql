-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  sam. 17 nov. 2018 à 15:16
-- Version du serveur :  10.1.32-MariaDB
-- Version de PHP :  7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `utechdz_utechnolgie`
--

-- --------------------------------------------------------

--
-- Structure de la table `config`
--

CREATE TABLE `config` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone1` varchar(30) NOT NULL,
  `phone2` varchar(30) NOT NULL,
  `adresse` text NOT NULL,
  `longitude` varchar(25) NOT NULL,
  `lattitude` varchar(25) NOT NULL,
  `fax` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE `menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(120) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id`, `title`, `description`, `parent_id`, `active`) VALUES
(1, 'menu1', 'slhslhl', 0, 1),
(2, 'menu2', 'sdsdmkjl', 0, 1),
(3, 'test', 'test test ', 1, 1),
(4, 'menu3', 'TEst test test tes', 0, 1),
(5, 'menu4', ',l ll l', 0, 0),
(6, 'menu7', 'sqdsdsds', 1, 1),
(7, 'menu8', 'sdqdsq qsd qsd', 4, 1),
(8, 'test', 'd qd qdqs dqd q', 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` varchar(20) NOT NULL,
  `priority` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `todo`
--

INSERT INTO `todo` (`id`, `title`, `description`, `date`, `priority`) VALUES
(1, 'tada', 'dsqghjdqs', '01-01-2018', '');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'utech-admin', '$2y$10$ve79kacw3r0/XUOtW/tfyuTZppFvoHt/Cvuu8p4tG0ucxIzR4w522'),
(16, 'youcef.bourahla@outlook.f', '$2y$10$x0DPdCHJOySw1uCefVsyzecqy4a7Vn8usXKFQKub62WI6F9IgvZpG'),
(17, 'youcef@outlook.fr', '$2y$10$vFlzHPP0mYF1OM1.tNgNquaRzcbp2oVmzebRLdfYj.eSAnlhcOh1K'),
(18, 'youcef1@outlook.fr', '$2y$10$o5HNkS2H9s6M4QTWt.EECOkhC7tEEK.RiRvH60GOvqOqKDXQdVwv2'),
(19, 'youcef2@outlook.fr', '$2y$10$2tj8xT9NdDGxPqTn1WEafeuSih9eVWJ6sf/s8YFP6.afDD78eStpu'),
(20, 'youcef1@outlook.fr', '$2y$10$0hCYNUEv503oB8txcAjS9uKSfAU5uzrptaySLYlbFCbHJqIX1/LRe');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `config`
--
ALTER TABLE `config`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
