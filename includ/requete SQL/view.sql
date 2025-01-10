
CREATE OR REPLACE VIEW `detailarticle` AS 
SELECT 
    `ar`.`id_article` AS `id_article`,
    `ar`.`title` AS `title`,
    `ar`.`content` AS `content`,
    `ar`.`id_user` AS `id_user`,
    `ar`.`id_theme` AS `id_theme`,
    `ar`.`statut` AS `statut`,
    `ar`.`created_at` AS `created_at`,
    `ar`.`archive` AS `archive`,
    `th`.`name` AS `title_theme`,
    `u`.`nom` AS `nom_user`,
    `u`.`prenom` AS `prenom_user`,
    `f`.`id_favorite` AS `id_favorite`,
    COUNT(`c`.`id_comment`) AS `total_comment`
FROM 
    `articles` `ar`
JOIN 
    `themes` `th` 
    ON `ar`.`id_theme` = `th`.`id_theme`
JOIN 
    `users` `u` 
    ON `ar`.`id_user` = `u`.`id_user`
LEFT JOIN 
    `favorites` `f` 
    ON `u`.`id_user` = `f`.`id_user` AND `ar`.`id_article` = `f`.`id_article`
LEFT JOIN 
    `comments` `c` 
    ON `ar`.`id_article` = `c`.`id_article`
GROUP BY 
    `ar`.`id_article`, `ar`.`title`, `ar`.`content`, `ar`.`id_user`, `ar`.`id_theme`, 
    `ar`.`statut`, `ar`.`created_at`, `ar`.`archive`, `th`.`name`, 
    `u`.`nom`, `u`.`prenom`, `f`.`id_favorite`;

