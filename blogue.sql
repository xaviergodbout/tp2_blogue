CREATE TABLE utilisateur 
(
    username VARCHAR(50) NOT NULL PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL
);

CREATE TABLE article
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    texte TEXT NOT NULL,
    idAuteur VARCHAR(50) NOT NULL,
    FOREIGN KEY(IdAuteur) REFERENCES utilisateur(username) 
);

CREATE TABLE motCle
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    mot VARCHAR(50) NOT NULL
);

CREATE TABLE motArticle
(
    idArticle INT UNSIGNED NOT NULL,
    idMotCle INT UNSIGNED NOT NULL,
    PRIMARY KEY(idArticle, idMotCle),
    FOREIGN KEY(IdArticle) REFERENCES article(id),
    FOREIGN KEY(IdMotCle) REFERENCES motCle(id)
);