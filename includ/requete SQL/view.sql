
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
    `f`.`id_favorite` AS `id_favorite`
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
    ON `u`.`id_user` = `f`.`id_user`  AND  `ar`.`id_article` = `f`.`id_article` ;







##article on plus de 2 tags 
SELECT ar.*
FROM articles ar
INNER JOIN themes th ON ar.id_theme = th.id_theme 
INNER JOIN article_tags artg ON ar.id_article = artg.id_article
INNER	JOIN	tags tg ON	artg.id_tag = tg.id_tag
GROUP BY title 
HAVING COUNT(tg.name) > 2  ; 


SELECT * FROM articles ; 
 select t.id_tag ,name from tags t 
                 inner join article_tags  a on a.id_tag = t.id_tag
                 where id_article = 1
                 
                 
select c.*  , nom , prenom from comments c
        inner join users  u on u.id_user = c.id_user
        where id_article = 5
        
SELECT * FROM tags WHERE id_tag=2

SELECT * FROM article_tags WHERE id_=2


SELECT DISTINCT viewArticle.*
FROM detailArticle AS viewArticle
INNER JOIN articles ar ON ar.id_article = viewArticle.id_article
INNER JOIN themes th ON ar.id_theme = th.id_theme
LEFT JOIN article_tags artg ON ar.id_article = artg.id_article
LEFT JOIN tags tg ON artg.id_tag = tg.id_tag
WHERE 
    ar.title LIKE "%SUV%" OR 
    ar.content LIKE "%SUV%" OR 
    tg.name LIKE "%SUV%" OR 
    th.name LIKE "%SUV%"
LIMIT 10 OFFSET 0
