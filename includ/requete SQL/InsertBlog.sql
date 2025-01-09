INSERT INTO themes (name, description)
VALUES 
('Voitures de luxe', 'Découvrez les derniers modèles de voitures de luxe, leurs performances et caractéristiques.'),
('Voitures électriques', 'Tout savoir sur les voitures électriques : avantages, inconvénients et nouveautés.'),
('Location de voitures', 'Conseils pour louer une voiture, comparer les prix et choisir les meilleures offres.'),
('Entretien automobile', 'Astuces et conseils pour bien entretenir votre voiture et prolonger sa durée de vie.'),
('Essais de conduite', 'Retrouvez des avis et tests complets sur les différents modèles de voitures.'),
('Voitures classiques', 'Un voyage dans le temps avec des articles sur les voitures classiques et vintage.'),
('Meilleurs itinéraires', 'Idées d’itinéraires pour les road trips et voyages en voiture.'),
('Accessoires automobiles', 'Les meilleurs accessoires pour améliorer votre expérience en voiture.'),
('Location longue durée', 'Tout sur la location de voitures à long terme : avantages et conseils.'),
('Comparatif de modèles', 'Analyse et comparatif des modèles récents pour vous aider à choisir.'),
('Voitures sportives', 'Zoom sur les voitures sportives et leurs performances exceptionnelles.');



INSERT INTO articles (title, content, id_user, id_theme, statut, archive)
VALUES
    ('Top 10 des voitures électriques de 2025', 'Découvrez les meilleures voitures électriques qui dominent le marché en 2025, avec des performances incroyables et une autonomie impressionnante.', 1, 2, 'confirmé', 0),
    ('Les SUV les plus fiables', 'Analyse des SUV qui offrent fiabilité, confort et performances, basés sur les avis des conducteurs et les tests experts.', 2, 3, 'annulé', 0),
    ('Comparatif : Essence vs Électrique', 'Un comparatif détaillé entre les voitures à essence et les voitures électriques, incluant coûts, impact environnemental et plaisir de conduite.', 3, 4, 'en attente', 0),
    ('Entretien des voitures anciennes', 'Conseils pratiques pour entretenir et restaurer les voitures anciennes, afin de préserver leur valeur et leur charme.', 4, 5, 'confirmé', 1),
    ('Les meilleures sportives abordables', 'Découvrez les voitures sportives qui allient performances et prix abordable, parfaites pour les amateurs de sensations fortes.', 5, 6, 'en attente', 0),
    ('Technologies embarquées innovantes', 'Un aperçu des dernières innovations technologiques dans les voitures modernes, des systèmes d\'aide à la conduite aux tableaux de bord connectés.', 6, 7, 'annulé', 0),
    ('Voitures hybrides : le meilleur des deux mondes', 'Analyse des voitures hybrides qui combinent moteur thermique et électrique pour une conduite économique et écologique.', 7, 8, 'confirmé', 0),
    ('Préparer sa voiture pour l\'hiver', 'Conseils pour préparer votre voiture aux conditions hivernales et rouler en toute sécurité, même sur routes verglacées.', 8, 9, 'en attente', 1),
    ('Top 5 des citadines économiques', 'Une sélection des meilleures voitures citadines qui allient faible consommation, praticité et design compact.', 9, 10, 'confirmé', 0),
    ('Avenir de l\'automobile : que nous réserve 2030 ?', 'Exploration des tendances et des innovations qui façonneront l\'industrie automobile d\'ici 2030.', 10, 1, 'annulé', 0);
  -- Commentaires pour l'article 'Top 10 des voitures électriques de 2025' (id_article = 1)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('Super article, j\'ai hâte de voir ces voitures sur la route!', 1, 2, 0),
('Les performances de ces voitures sont impressionnantes!', 1, 3, 0),
('Un comparatif intéressant, mais j\'aurais aimé plus de détails sur les prix.', 1, 4, 0);

-- Commentaires pour l'article 'Les SUV les plus fiables' (id_article = 2)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('Très bon article, je vais définitivement regarder ces SUV.', 2, 5, 0),
('Je suis étonné par la fiabilité de certains modèles mentionnés.', 2, 6, 0),
('Un peu déçu par le manque de diversité dans les marques.', 2, 7, 0);

-- Commentaires pour l'article 'Comparatif : Essence vs Électrique' (id_article = 3)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('L\'article est intéressant, mais j\'aurais aimé plus de données concrètes.', 3, 8, 0),
('L\'impact environnemental de l\'électrique est souvent sous-estimé.', 3, 9, 0),
('Un bon comparatif, mais je préfère encore les voitures à essence.', 3, 10, 0);

-- Commentaires pour l'article 'Entretien des voitures anciennes' (id_article = 4)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('Très utile pour les passionnés de voitures anciennes comme moi.', 4, 11, 0),
('Le conseil sur les pièces détachées est très pertinent.', 4, 12, 0),
('J\'aimerais voir un article sur la restauration des moteurs!', 4, 13, 0);

-- Commentaires pour l'article 'Les meilleures sportives abordables' (id_article = 5)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('Enfin une liste de sportives abordables! Merci pour cet article.', 5, 4, 0),
('Les prix sont vraiment attractifs, je vais chercher ces modèles.', 5, 1, 0),
('Peut-être inclure des véhicules d\'autres marques, comme Audi ou BMW?', 5, 6, 0);

-- Commentaires pour l'article 'Technologies embarquées innovantes' (id_article = 6)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('L\'avancée technologique dans l\'automobile est fascinante.', 6, 7, 0),
('Les nouvelles technologies de conduite sont un vrai plus!', 6, 8, 0),
('Je suis curieux de savoir comment ces technologies vont évoluer.', 6, 9, 0);

-- Commentaires pour l'article 'Voitures hybrides : le meilleur des deux mondes' (id_article = 7)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('Les hybrides sont définitivement l\'avenir de l\'automobile.', 7, 2, 0),
('Un bon compromis entre performance et écologie.', 7, 8, 0),
('Mais je trouve que les hybrides sont encore trop chers.', 7, 2, 0);

-- Commentaires pour l'article 'Préparer sa voiture pour l\'hiver' (id_article = 8)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('Très utile, surtout pour les conducteurs qui vivent dans le froid!', 8, 3, 0),
('Je ne savais pas qu\'il fallait vérifier les liquides avant l\'hiver.', 8, 4, 0),
('Un article à lire avant chaque hiver!', 8, 25, 0);

-- Commentaires pour l'article 'Top 5 des citadines économiques' (id_article = 9)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('Des voitures parfaites pour la ville, merci pour ce comparatif.', 9, 6, 0),
('Les critères de sélection sont bien expliqués, mais un test sur route serait top.', 9, 7, 0),
('J\'aime beaucoup la Toyota Yaris, mais elle est un peu chère.', 9, 8, 0);

-- Commentaires pour l'article 'Avenir de l\'automobile : que nous réserve 2030 ?' (id_article = 10)
INSERT INTO comments (content, id_article, id_user, archive) 
VALUES 
('L\'avenir semble prometteur, mais il reste encore beaucoup à faire pour l\'écologie.', 10, 9, 0),
('Intéressant, mais je me demande si les technologies seront accessibles à tous.', 10, 3, 0),
('J\'espère que les voitures autonomes seront sûres!', 10, 3, 0);
