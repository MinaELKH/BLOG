CREATE TABLE themes (
    id_theme INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archive TINYINT(1) DEFAULT 0 
);

-- Table: articles
CREATE TABLE articles (
    id_article INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    id_user INT NOT NULL,
    id_theme INT NOT NULL,
    statut ENUM('confirmé', 'annulé', 'en attente') DEFAULT 'en attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archive TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_theme) REFERENCES themes(id_theme)
);

-- Table: tags
CREATE TABLE tags (
    id_tag INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archive TINYINT(1) DEFAULT 0
);

-- Table: article_tags
CREATE TABLE article_tags (
    id_article INT NOT NULL,
    id_tag INT NOT NULL,
    archive TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id_article, id_tag),
    FOREIGN KEY (id_article) REFERENCES articles(id_article),
    FOREIGN KEY (id_tag) REFERENCES tags(id_tag)
);

-- Table: comments
CREATE TABLE comments (
    id_comment INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    id_article INT NOT NULL,
    id_user INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archive TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_article) REFERENCES articles(id_article),
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

-- Table: favorites
CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_article INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    archive TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_article) REFERENCES articles(id_article)
);


