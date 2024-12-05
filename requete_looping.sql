CREATE TABLE User(
   id_user INT AUTO_INCREMENT,
   pseudonyme VARCHAR(50) NOT NULL,
   email VARCHAR(255) NOT NULL,
   password VARCHAR(255) NOT NULL,
   dateInscription DATETIME DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(id_user),
   UNIQUE(pseudonyme),
   UNIQUE(email)
);

CREATE TABLE Categorie(
   id_categorie INT AUTO_INCREMENT,
   libelle VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_categorie),
   UNIQUE(libelle)
);

CREATE TABLE Sujet(
   id_sujet INT AUTO_INCREMENT,
   titre VARCHAR(255) NOT NULL,
   dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
   statut BOOLEAN NOT NULL,
   id_categorie INT NOT NULL,
   id_user INT NOT NULL,
   PRIMARY KEY(id_sujet),
   FOREIGN KEY(id_categorie) REFERENCES Categorie(id_categorie),
   FOREIGN KEY(id_user) REFERENCES Users(id_user)
);

CREATE TABLE Message(
   id_message INT AUTO_INCREMENT,
   texte TEXT NOT NULL,
   dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
   id_user INT NOT NULL,
   id_sujet INT NOT NULL,
   PRIMARY KEY(id_message),
   FOREIGN KEY(id_user) REFERENCES Users(id_user),
   FOREIGN KEY(id_sujet) REFERENCES Sujet(id_sujet)
);
