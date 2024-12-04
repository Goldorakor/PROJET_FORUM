CREATE TABLE membre(
   id_membre INT AUTO_INCREMENT,
   pseudonyme VARCHAR(50) NOT NULL,
   email VARCHAR(255) NOT NULL,
   password VARCHAR(255) NOT NULL,
   dateInscription DATETIME DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(id_membre),
   UNIQUE(pseudonyme),
   UNIQUE(email)
);

CREATE TABLE categorie(
   id_categorie INT AUTO_INCREMENT,
   libelle VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_categorie),
   UNIQUE(libelle)
);

CREATE TABLE sujet(
   id_sujet INT AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
   statut BOOLEAN NOT NULL,
   categorie_id INT NOT NULL,
   membre_id INT NOT NULL,
   PRIMARY KEY(id_sujet),
   FOREIGN KEY(categorie_id) REFERENCES categorie(id_categorie),
   FOREIGN KEY(membre_id) REFERENCES membre(id_membre)
);

CREATE TABLE message(
   id_message INT AUTO_INCREMENT,
   texte TEXT NOT NULL,
   dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
   membre_id INT NOT NULL,
   sujet_id INT NOT NULL,
   PRIMARY KEY(id_message),
   FOREIGN KEY(membre_id) REFERENCES membre(id_membre),
   FOREIGN KEY(sujet_id) REFERENCES sujet(id_sujet)
);
