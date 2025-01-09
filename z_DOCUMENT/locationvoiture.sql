-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 06 jan. 2025 à 01:33
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `locationvoiture`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AjouterReservation` (IN `v_id_vehicule` INT, IN `v_id_user` INT, IN `v_date_reservation` DATETIME, IN `v_date_debut` DATE, IN `v_date_fin` DATE, IN `v_statut` VARCHAR(50), OUT `v_etat_request` VARCHAR(50))   BEGIN
    DECLARE vehicule_disponible INT;
    DECLARE v_total_prix DECIMAL(10, 2);

    -- Vérifier la disponibilité du véhicule
    SELECT 
        (SELECT COUNT(*) 
         FROM reservation
         WHERE v_date_debut BETWEEN date_debut AND date_fin 
           AND id_vehicule = v_id_vehicule)
        +
        (SELECT COUNT(*) 
         FROM reservation
         WHERE v_date_fin BETWEEN date_debut AND date_fin 
           AND id_vehicule = v_id_vehicule)
        +
        (SELECT COUNT(*) 
         FROM reservation
         WHERE date_debut BETWEEN v_date_debut AND v_date_fin 
           AND id_vehicule = v_id_vehicule)
        INTO vehicule_disponible;

    -- Si le véhicule est disponible, ajouter la réservation
    IF vehicule_disponible = 0 THEN
        -- Calcul du prix total
          SET v_total_prix = DATEDIFF(v_date_fin, v_date_debut) * (SELECT prix FROM vehicule WHERE id_vehicule = v_id_vehicule);


        -- Insérer la réservation
        INSERT INTO reservation (
            id_vehicule, 
            id_user, 
            date_reservation, 
            date_debut, 
            date_fin, 
            prix, 
            statut,
            archive
        ) 
        VALUES (
            v_id_vehicule, 
            v_id_user, 
            v_date_reservation, 
            v_date_debut, 
            v_date_fin, 
            v_total_prix, 
            v_statut,
            '0'
        );
         set  v_etat_request = "disponible" ; 
      ELSE 
          set  v_etat_request = "non_disponible" ; 
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

CREATE TABLE `agence` (
  `id_agence` int(11) NOT NULL,
  `lieu` varchar(50) DEFAULT NULL,
  `nom_agence` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`id_agence`, `lieu`, `nom_agence`) VALUES
(1, 'Paris', 'Agence Parisienne'),
(2, 'Lyon', 'Agence Lyonnaise'),
(3, 'Marseille', 'Agence Méditerranéenne'),
(4, 'Toulouse', 'Agence Toulousaine'),
(5, 'Nice', 'Agence de la Côte d\'Azur');

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_avis` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `etoiles` int(11) DEFAULT NULL CHECK (`etoiles` between 0 and 5),
  `date_avis` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_reservation`, `description`, `etoiles`, `date_avis`) VALUES
(17, 101, ' Service impeccable et voiture en excellent état, une expérience de location sans souci !', 4, '2025-01-05 23:24:17'),
(18, 102, ' Rapidité, efficacité et voiture parfaite pour mon séjour, je recommande vivement ', 5, '2025-01-05 23:58:17'),
(19, 103, ' Processus simple, voiture impeccable et personnel très professionnel ', 4, '2025-01-05 23:58:31'),
(20, 105, ' Un service de qualité, une voiture récente et bien entretenue, rien à redire', 3, '2025-01-05 23:59:05');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `archive` enum('0','1') DEFAULT '0',
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`, `archive`, `description`) VALUES
(1, 'SUV', '0', 'Véhicules utilitaires sportifs pour tous les terrains.'),
(2, 'Berline', '0', 'Voitures confortables et polyvalentes pour la ville.'),
(3, 'Coupé', '0', 'Voitures compactes au design sportif.'),
(4, '4x4', '0', 'Véhicules tout-terrain robustes.'),
(5, 'Voiture Électriques', '0', 'Véhicules propulsés par une énergie propre.'),
(6, 'Voiture Hybride', '0', 'Véhicules combinant moteur thermique et électrique.'),
(7, 'Compacte', '1', 'Voitures petites et économiques pour la conduite urbaine.'),
(8, 'Cabriolet', '0', 'Voitures avec toit ouvrant pour une conduite en plein air.'),
(9, 'Pick-up', '0', 'Véhicules avec grande capacité de chargement.'),
(10, 'Sportive', '0', 'Voitures de performance avec une puissance accrue.'),
(50, 'Hic ut ducimus exer', '1', 'Nesciunt deleniti s'),
(56, 'sport spid', '1', ' des\r\n                '),
(57, 'VSU', '1', 'USY\r\n                '),
(59, 'VSU', '1', 'USY\r\n                '),
(61, 'Sport luxe', '1', ' Sport luxe de luxe\r\n                '),
(64, 'Monospaces', '0', ' Voitures familiales avec beaucoup de places et des sièges supplémentaires.\r\n                ');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `listavisbyvehicule`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `listavisbyvehicule` (
`id_avis` int(11)
,`id_reservation` int(11)
,`description` text
,`etoiles` int(11)
,`date_avis` datetime
,`id_vehicule` int(11)
,`id_user` int(11)
,`nom` varchar(100)
,`prenom` varchar(100)
,`email` varchar(150)
,`pwd` varchar(150)
,`archive` enum('0','1')
,`id_role` int(11)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `listeresevation`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `listeresevation` (
`id_reservation` int(11)
,`id_vehicule` int(11)
,`id_user` int(11)
,`id_agence` int(11)
,`date_reservation` datetime
,`date_debut` date
,`date_fin` date
,`prix` decimal(10,2)
,`statut` enum('confirmée','en attente','annulée')
,`archive` enum('0','1')
,`nom_user` varchar(100)
,`nom_categorie` varchar(50)
,`nom_vehicule` varchar(50)
,`marque` varchar(50)
,`model` varchar(50)
,`photo` varchar(255)
,`id_avis` int(11)
,`description` text
,`etoiles` int(11)
,`date_avis` datetime
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `listevehicule`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `listevehicule` (
`nom_categorie` varchar(50)
,`id_vehicule` int(11)
,`nom` varchar(50)
,`marque` varchar(50)
,`model` varchar(50)
,`disponibilite` enum('1','0')
,`archive` enum('0','1')
,`id_categorie` int(11)
,`photo` varchar(255)
,`prix` float
,`totalAvis` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `id_vehicule` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_agence` int(11) DEFAULT NULL,
  `date_reservation` datetime DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `statut` enum('confirmée','en attente','annulée') DEFAULT 'en attente',
  `archive` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `id_vehicule`, `id_user`, `id_agence`, `date_reservation`, `date_debut`, `date_fin`, `prix`, `statut`, `archive`) VALUES
(61, 1, 11, 1, '2024-12-30 10:00:00', '2025-01-01', '2025-01-10', 0.00, 'confirmée', '1'),
(67, 5, 12, 5, '2024-12-26 11:15:00', '2025-01-15', '2025-01-25', 0.00, 'en attente', '0'),
(73, 8, 12, 1, '2024-12-23 17:35:00', '2025-02-05', '2025-02-15', 0.00, 'confirmée', '0'),
(76, 1, 11, 1, '2024-12-30 10:00:00', '2025-01-16', '2025-01-20', 0.00, 'confirmée', '0'),
(77, 1, 12, 1, '2024-12-29 14:30:00', '2025-01-03', '2025-01-06', 0.00, 'confirmée', '0'),
(78, 1, 13, 1, '2024-12-28 09:45:00', '2025-01-21', '2025-01-30', 0.00, 'confirmée', '1'),
(81, 1, 11, NULL, '2025-01-02 10:30:00', '2025-05-11', '2025-05-15', 3000.00, 'en attente', '0'),
(101, 4, 13, NULL, '2025-01-05 23:13:39', '2025-01-18', '2025-01-21', 2100.00, 'confirmée', '0'),
(102, 23, 13, NULL, '2025-01-05 23:16:09', '2025-01-27', '2025-01-30', 1500.00, 'en attente', '0'),
(103, 6, 13, NULL, '2025-01-05 23:56:18', '2025-01-18', '2025-01-17', -840.00, 'en attente', '0'),
(104, 23, 13, NULL, '2025-01-05 23:56:51', '2025-01-17', '2025-01-19', 1000.00, 'en attente', '1'),
(105, 9, 13, NULL, '2025-01-05 23:57:30', '2025-01-02', '2025-01-07', 1500.00, 'confirmée', '0'),
(106, 1, 14, NULL, '2025-01-06 00:16:17', '1991-08-03', '1990-05-04', -182400.00, 'en attente', '0');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `role` enum('admin','client') DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'admin'),
(2, 'client');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pwd` varchar(150) NOT NULL,
  `archive` enum('0','1') DEFAULT '0',
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `nom`, `prenom`, `email`, `pwd`, `archive`, `id_role`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@example.com', 'password123', '0', 2),
(2, 'Martin', 'Marie', 'marie.martin@example.com', 'password456', '0', 2),
(3, 'Lemoine', 'Pierre', 'pierre.lemoine@example.com', 'password789', '0', 2),
(4, 'Durand', 'Sophie', 'sophie.durand@example.com', 'password101', '0', 2),
(5, 'Leclerc', 'David', 'david.leclerc@example.com', 'password102', '0', 2),
(6, 'Garnier', 'Julie', 'julie.garnier@example.com', 'password103', '0', 2),
(7, 'Bernard', 'Luc', 'luc.bernard@example.com', 'password104', '0', 2),
(8, 'Robert', 'Catherine', 'catherine.robert@example.com', 'password105', '0', 2),
(9, 'Fournier', 'Paul', 'paul.fournier@example.com', 'password106', '0', 2),
(10, 'Tanguy', 'Emilie', 'emilie.tanguy@example.com', 'password107', '0', 2),
(11, 'ines', 'ouss', 'ines@gmail.com', '$2y$10$QtK3zyRc/SeTtoIakDgSqenI9ACElQztMF4dGUAZrTqYmxedW9k8m', '0', 2),
(12, 'sara', 'rasa', 'sara@gmail.com', '$2y$10$/tlvRs37LElv46XICHbBXOwRo4JdpaMhQh2dPCz/343Ct09zL0zNC', '0', 2),
(13, 'lika', 'lika', 'lika@gmail.com', '$2y$10$6/nL/JBPEQ6jDpZbbHSYm.cTaCxrNmFBL8Ji7qFugXuTq.Pt44gIG', '0', 2),
(14, 'mina', 'kho', 'mina@gmail.com', '$2y$10$bgPknVVHlEa7RN1aus62ceI9pGMV6yhm5YK12wxDSEvIBdUw1lsCS', '0', 1);

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `id_vehicule` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `disponibilite` enum('1','0') DEFAULT '1',
  `archive` enum('0','1') DEFAULT '0',
  `id_categorie` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `prix` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id_vehicule`, `nom`, `marque`, `model`, `disponibilite`, `archive`, `id_categorie`, `photo`, `prix`) VALUES
(1, 'Qashqai', 'Nissan', '2023', '1', '', NULL, '0', 1),
(2, 'Corolla', 'Toyota', '2022', '1', '0', 2, 'uploads/2.jpg', 600),
(3, 'Mustang', 'Ford', '2021', '0', '0', 3, 'uploads/3.jpg', 300),
(4, 'Defender', 'Land Rover', '2023', '1', '0', 4, 'uploads/4.jpg', 700),
(5, 'Model S', 'Tesla', '2022', '1', '0', 5, 'uploads/5.jpg', 500),
(6, 'Prius', 'Toyota', '2022', '1', '0', 6, 'uploads/6.jpg', 840),
(7, 'Clio', 'Renault', '2021', '0', '0', 7, 'uploads/7.jpg', 900),
(8, '911 Carrera', 'Porsche', '2023', '0', '0', 8, 'uploads/8.jpg', 800),
(9, 'F-150', 'Ford', '2022', '1', '0', 9, 'uploads/9.jpg', 300),
(10, 'Aventador', 'Lamborghini', '2023', '0', '1', 10, 'uploads/10.jpg', 500),
(17, 'range', 'rover', '2025', '1', '0', 56, 'uploads/101.jpg', 399),
(23, 'BMW ', 'M3', '2025', '1', '0', 61, 'uploads/67765bdaa95c4-11.jpg', 500),
(25, 'Duster', 'diesel', '2024', '1', '0', 9, 'uploads/677b1994225e7-10.jpg', 500),
(26, 'Renault', ' Espace', '2020', '1', '0', 64, 'uploads/677b1c61026a4-45.jpg', 300),
(27, 'Citroën', 'E', '0', '1', '0', 64, 'uploads/677b1c6104856-70.jpg', 250);

-- --------------------------------------------------------

--
-- Structure de la vue `listavisbyvehicule`
--
DROP TABLE IF EXISTS `listavisbyvehicule`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `listavisbyvehicule`  AS SELECT `av`.`id_avis` AS `id_avis`, `av`.`id_reservation` AS `id_reservation`, `av`.`description` AS `description`, `av`.`etoiles` AS `etoiles`, `av`.`date_avis` AS `date_avis`, `v`.`id_vehicule` AS `id_vehicule`, `u`.`id_user` AS `id_user`, `u`.`nom` AS `nom`, `u`.`prenom` AS `prenom`, `u`.`email` AS `email`, `u`.`pwd` AS `pwd`, `u`.`archive` AS `archive`, `u`.`id_role` AS `id_role` FROM (((`avis` `av` join `reservation` `r` on(`r`.`id_reservation` = `av`.`id_reservation`)) join `vehicule` `v` on(`v`.`id_vehicule` = `r`.`id_vehicule`)) join `users` `u` on(`u`.`id_user` = `r`.`id_user`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `listeresevation`
--
DROP TABLE IF EXISTS `listeresevation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `listeresevation`  AS SELECT `r`.`id_reservation` AS `id_reservation`, `r`.`id_vehicule` AS `id_vehicule`, `r`.`id_user` AS `id_user`, `r`.`id_agence` AS `id_agence`, `r`.`date_reservation` AS `date_reservation`, `r`.`date_debut` AS `date_debut`, `r`.`date_fin` AS `date_fin`, `r`.`prix` AS `prix`, `r`.`statut` AS `statut`, `r`.`archive` AS `archive`, `u`.`nom` AS `nom_user`, `c`.`nom` AS `nom_categorie`, `v`.`nom` AS `nom_vehicule`, `v`.`marque` AS `marque`, `v`.`model` AS `model`, `v`.`photo` AS `photo`, `av`.`id_avis` AS `id_avis`, `av`.`description` AS `description`, `av`.`etoiles` AS `etoiles`, `av`.`date_avis` AS `date_avis` FROM ((((`reservation` `r` join `users` `u` on(`u`.`id_user` = `r`.`id_user`)) join `vehicule` `v` on(`v`.`id_vehicule` = `r`.`id_vehicule`)) join `categorie` `c` on(`c`.`id_categorie` = `v`.`id_categorie`)) left join `avis` `av` on(`r`.`id_reservation` = `av`.`id_reservation`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `listevehicule`
--
DROP TABLE IF EXISTS `listevehicule`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `listevehicule`  AS SELECT `c`.`nom` AS `nom_categorie`, `v`.`id_vehicule` AS `id_vehicule`, `v`.`nom` AS `nom`, `v`.`marque` AS `marque`, `v`.`model` AS `model`, `v`.`disponibilite` AS `disponibilite`, `v`.`archive` AS `archive`, `v`.`id_categorie` AS `id_categorie`, `v`.`photo` AS `photo`, `v`.`prix` AS `prix`, count(`av`.`id_avis`) AS `totalAvis` FROM (((`vehicule` `v` join `categorie` `c` on(`c`.`id_categorie` = `v`.`id_categorie`)) left join `reservation` `r` on(`v`.`id_vehicule` = `r`.`id_vehicule`)) left join `avis` `av` on(`av`.`id_reservation` = `r`.`id_reservation`)) GROUP BY `v`.`id_vehicule`, `c`.`nom`, `v`.`nom`, `v`.`marque`, `v`.`model`, `v`.`disponibilite`, `v`.`archive`, `v`.`id_categorie`, `v`.`photo`, `v`.`prix` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agence`
--
ALTER TABLE `agence`
  ADD PRIMARY KEY (`id_agence`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`),
  ADD KEY `id_reservation` (`id_reservation`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_vehicule` (`id_vehicule`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_agence` (`id_agence`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id_vehicule`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agence`
--
ALTER TABLE `agence`
  MODIFY `id_agence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id_avis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id_vehicule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id_reservation`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id_vehicule`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`id_agence`) REFERENCES `agence` (`id_agence`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `vehicule_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
