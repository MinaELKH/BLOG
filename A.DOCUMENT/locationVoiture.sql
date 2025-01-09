create database locationVoiture ; 
use locationVoiture ; 

CREATE TABLE `role` (
  `id_role` int(11) PRIMARY KEY AUTO_INCREMENT,
  `role` enum('admin','client') DEFAULT 'client'
) ; 

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'admin'),
(2, 'client');


CREATE TABLE `users` (
  `id_user` int(11) PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pwd` varchar(150) NOT NULL,
  `archive` enum('0','1') DEFAULT '0',
  `id_role` int(11) NOT NULL ,
   FOREIGN key(id_role) REFERENCES role(id_role)
) ; 

CREATE table agence(
id_agence int(11) PRIMARY KEY AUTO_INCREMENT, 
lieu varchar(50) , 
nom_agence varchar(50)
) ; 


CREATE table categorie(
id_categorie int(11) PRIMARY KEY AUTO_INCREMENT, 
nom varchar(50),
archive enum('0' , '1') DEFAULT '0'
) ;
alter table categorie 
add COLUMN description varchar(255) ; 



CREATE table vehicule(
id_vehicule int(11) PRIMARY KEY AUTO_INCREMENT, 
nom varchar(50),
marque varchar(50),
model varchar(50), 
disponibilte enum('0' , '1') DEFAULT '0', 
archive enum('0' , '1') DEFAULT '0', 
id_categorie int(11) ,
FOREIGN key(id_categorie) REFERENCES categorie(id_categorie)    
); 
alter table vehicule
add COLUMN photo varchar(255) ; 
alter table vehicule 
add COLUMN prix float ; 

create table reservation(
id_reservation int(11) AUTO_INCREMENT PRIMARY KEY,
id_vehicule int(11) ,
id_user int(11) , 
id_agence int(11)  ,
date_reservation datetime , 
date_debut date , 
date_fin date ,
FOREIGN key(id_vehicule) REFERENCES vehicule(id_vehicule)  ,
FOREIGN key(id_user) REFERENCES users(id_user)  ,
FOREIGN key(id_agence) REFERENCES agence(id_agence)  
);
 alter table vehicule
change  disponibilte disponibilite  enum('1' , '0') DEFAULT '1' ; 
alter table reservation 
add COLUMN statut enum ('annulée' ,'confirmée','en attente') DEFAULT 'en attente' ; 
alter table reservation 
add COLUMN archive enum('0' , '1') DEFAULT'1' ; 
ALTER TABLE reservation
ADD COLUMN prix DECIMAL(10, 2) NOT NULL AFTER date_fin; 



CREATE TABLE avis ( id_avis INT AUTO_INCREMENT PRIMARY KEY, id_reservation INT NOT NULL, description TEXT, etoiles TINYINT CHECK (etoiles BETWEEN  0 AND 5), date_avis DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (id_reservation) REFERENCES reservation(id_reservation) ON DELETE CASCADE );




INSERT INTO categorie (id_categorie, nom, description) VALUES
(1, 'SUV', 'Véhicules utilitaires sportifs pour tous les terrains.'),
(2, 'Berline', 'Voitures confortables et polyvalentes pour la ville.'),
(3, 'Coupé', 'Voitures compactes au design sportif.'),
(4, '4x4', 'Véhicules tout-terrain robustes.'),
(5, 'Voiture Électrique', 'Véhicules propulsés par une énergie propre.'),
(6, 'Voiture Hybride', 'Véhicules combinant moteur thermique et électrique.'),
(7, 'Compacte', 'Voitures petites et économiques pour la conduite urbaine.'),
(8, 'Cabriolet', 'Voitures avec toit ouvrant pour une conduite en plein air.'),
(9, 'Pick-up', 'Véhicules avec grande capacité de chargement.'),
(10, 'Sportive', 'Voitures de performance avec une puissance accrue.');



INSERT INTO vehicule (nom, marque, model, disponibilte, archive, id_categorie, photo) VALUES
('Qashqai', 'Nissan', '2023', '1', '0', 1, 'uploads/qashqai.jpg'),
('Corolla', 'Toyota', '2022', '1', '0', 2, 'uploads/corolla.jpg'),
('Mustang', 'Ford', '2021', '0', '0', 3, 'uploads/mustang.jpg'),
('Defender', 'Land Rover', '2023', '1', '0', 4, 'uploads/defender.jpg'),
('Model S', 'Tesla', '2022', '1', '0', 5, 'uploads/model_s.jpg'),
('Prius', 'Toyota', '2022', '1', '0', 6, 'uploads/prius.jpg'),
('Clio', 'Renault', '2021', '0', '0', 7, 'uploads/clio.jpg'),
('911 Carrera', 'Porsche', '2023', '0', '0', 8, 'uploads/911_carrera.jpg'),
('F-150', 'Ford', '2022', '1', '0', 9, 'uploads/f150.jpg'),
('Aventador', 'Lamborghini', '2023', '0', '1', 10, 'uploads/aventador.jpg');


INSERT INTO `users` (`nom`, `prenom`, `email`, `pwd`, `archive`, `id_role`)
VALUES
  ('Dupont', 'Jean', 'jean.dupont@example.com', 'password123', '0', 2),
  ('Martin', 'Marie', 'marie.martin@example.com', 'password456', '0', 2),
  ('Lemoine', 'Pierre', 'pierre.lemoine@example.com', 'password789', '0', 2),
  ('Durand', 'Sophie', 'sophie.durand@example.com', 'password101', '0', 2),
  ('Leclerc', 'David', 'david.leclerc@example.com', 'password102', '0', 2),
  ('Garnier', 'Julie', 'julie.garnier@example.com', 'password103', '0', 2),
  ('Bernard', 'Luc', 'luc.bernard@example.com', 'password104', '0', 2),
  ('Robert', 'Catherine', 'catherine.robert@example.com', 'password105', '0', 2),
  ('Fournier', 'Paul', 'paul.fournier@example.com', 'password106', '0', 2),
  ('Tanguy', 'Emilie', 'emilie.tanguy@example.com', 'password107', '0', 2);



  INSERT INTO `agence` (`lieu`, `nom_agence`)
VALUES
  ('Paris', 'Agence Parisienne'),
  ('Lyon', 'Agence Lyonnaise'),
  ('Marseille', 'Agence Méditerranéenne'),
  ('Toulouse', 'Agence Toulousaine'),
  ('Nice', 'Agence de la Côte d\'Azur');





  INSERT INTO reservation (id_vehicule, id_user, id_agence, date_reservation, date_debut, date_fin, STATUT) VALUES
(1, 11, 1, '2024-12-30 10:00:00', '2025-01-01', '2025-01-10', 'confirmée'),
(2, 12, 2, '2024-12-29 14:30:00', '2025-01-05', '2025-01-15', 'en attente'),
(3, 13, 3, '2024-12-28 09:45:00', '2025-01-03', '2025-01-08', 'annulée'),
(4, 14, 4, '2024-12-27 16:20:00', '2025-01-10', '2025-01-20', 'confirmée'),
(5, 12, 5, '2024-12-26 11:15:00', '2025-01-15', '2025-01-25', 'en attente'),
(6, 13, 6, '2024-12-25 08:00:00', '2025-01-20', '2025-01-30', 'confirmée'),
(7, 15, 7, '2024-12-24 13:50:00', '2025-02-01', '2025-02-10', 'annulée'),
(8, 12, 8, '2024-12-23 17:35:00', '2025-02-05', '2025-02-15', 'confirmée'),
(9, 15, 9, '2024-12-22 12:25:00', '2025-02-10', '2025-02-20', 'en attente'),
(10, 15, 10, '2024-12-21 10:40:00', '2025-02-15', '2025-02-25', 'confirmée');

-- create table disponibilite (
-- id_vehicule int(11) ,
-- date_debut date() , 
-- date_fin date()
-- PRIMARY key (id_vehicule ,date_debut , date_fin )
-- )


## requette verfier la disponiblite 
INSERT INTO reservation (id_vehicule, id_user, id_agence, date_reservation, date_debut, date_fin, STATUT) VALUES
(1, 11, '2024-12-30 10:00:00', '2025-01-03', '2025-01-10', 'confirmée'),
(1, 12,  '2024-12-29 14:30:00', '2025-01-06', '2025-01-15', 'confirmée'),
(1, 13, '2024-12-28 09:45:00', '2025-01-16', '2025-01-31', 'confirmée'),
(1, 13, '2024-12-28 09:45:00', '2025-02-02', '2025-02-20', 'confirmée') ;

## requete de verfification de disponiblite 
SELECT 
  (SELECT COUNT() 
   FROM reservation 
   WHERE '2025-01-11' BETWEEN date_debut AND date_fin 
     AND id_vehicule = 1)
+
  (SELECT COUNT() 
   FROM reservation 
   WHERE '2025-01-14' BETWEEN date_debut AND date_fin 
     AND id_vehicule = 1) 
AS total;




// $query = "SELECT * 
//             FROM reservation 
//             WHERE :date_debut BETWEEN date_debut AND date_fin 
//                 AND id_vehicule = :id
//         union
//            SELECT *
//             FROM reservation 
//             WHERE :date_fin  BETWEEN date_debut AND date_fin 
//                 AND id_vehicule = :id
//             ";




-- les views
-- pour afficher les reservations en detailles 
drop view listeresevation ; 
select `r`.`id_reservation` AS `id_reservation`,`r`.`id_vehicule` AS `id_vehicule`,`r`.`id_user` AS `id_user`,`r`.`id_agence` AS `id_agence`,`r`.`date_reservation` AS `date_reservation`,`r`.`date_debut` AS `date_debut`,`r`.`date_fin` AS `date_fin`,`r`.`prix` AS `prix`,`r`.`statut` AS `statut`,`r`.`archive` AS `archive`,`u`.`nom` AS `nom_user`,`c`.`nom` AS `nom_categorie`,`v`.`nom` AS `nom_vehicule`,`v`.`marque` AS `marque`,`v`.`model` AS `model`,`v`.`photo` AS `photo`,`av`.`id_avis` AS `id_avis`,`av`.`description` AS `description`,`av`.`etoiles` AS `etoiles`,`av`.`date_avis` AS `date_avis` from ((((`locationvoiture`.`reservation` `r` join `locationvoiture`.`users` `u` on(`u`.`id_user` = `r`.`id_user`)) join `locationvoiture`.`vehicule` `v` on(`v`.`id_vehicule` = `r`.`id_vehicule`)) join `locationvoiture`.`categorie` `c` on(`c`.`id_categorie` = `v`.`id_categorie`)) left join `locationvoiture`.`avis` `av` on(`r`.`id_reservation` = `av`.`id_reservation`))


-- pour afficher la liste des vehicule 
DROP VIEW IF EXISTS ListeVehicule;
create view ListeVehicule as
SELECT 
    c.nom AS nom_categorie,
    v.id_vehicule AS id_vehicule,
    v.nom AS nom,
    v.marque AS marque,
    v.model AS model,
    v.disponibilite AS disponibilite,
    v.archive AS archive,
    v.id_categorie AS id_categorie,
    v.photo AS photo,
    v.prix AS prix,
    COUNT(av.id_avis) AS totalAvis
FROM 
    locationvoiture.vehicule v
JOIN 
    locationvoiture.categorie c ON c.id_categorie = v.id_categorie
LEFT JOIN 
    locationvoiture.reservation r ON v.id_vehicule = r.id_vehicule
LEFT JOIN 
    locationvoiture.avis av ON av.id_reservation = r.id_reservation
GROUP BY 
    v.id_vehicule, c.nom, v.nom, v.marque, v.model, v.disponibilite, v.archive, v.id_categorie, v.photo, v.prix;


-- procedure stockee 
--DROP PROCEDURE IF EXISTS  AjouterReservation ;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AjouterReservation`(
    IN v_id_vehicule INT,
    IN v_id_user INT,
    IN v_date_reservation DATETIME,
    IN v_date_debut DATE,
    IN v_date_fin DATE,
    IN v_statut VARCHAR(50),
    OUT v_etat_request VARCHAR(50)
)
BEGIN
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
            statut
        ) 
        VALUES (
            v_id_vehicule, 
            v_id_user, 
            v_date_reservation, 
            v_date_debut, 
            v_date_fin, 
            v_total_prix, 
            v_statut
        );
         set  v_etat_request = "disponible" ; 
      ELSE 
          set  v_etat_request = "non_disponible" ; 
    END IF;
END$$
DELIMITER ;

--callprocedure 
CALL AjouterReservation(
    1, -- id_vehicule
    5, -- id_user
    '2025-01-02 10:30:00', -- date_reservation
    '2025-01-05', -- date_debut
    '2025-01-10', -- date_fin
    'En attente' -- statut
);





-- view liste des avis par voiture
DROP VIEW IF EXISTS listavisbyvehicule;

CREATE VIEW listavisbyvehicule AS
SELECT 
    av.id_avis AS id_avis,
    av.id_reservation AS id_reservation,
    av.description AS description,
    av.etoiles AS etoiles,
    av.date_avis AS date_avis,
    v.id_vehicule AS id_vehicule,
    u.*
FROM 
    locationvoiture.avis av
    INNER JOIN locationvoiture.reservation r ON r.id_reservation = av.id_reservation
    INNER JOIN locationvoiture.vehicule v ON v.id_vehicule = r.id_vehicule
    INNER JOIN locationvoiture.users u ON u.id_user = r.id_user;
