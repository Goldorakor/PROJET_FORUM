-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum_michael
CREATE DATABASE IF NOT EXISTS `forum_michael` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum_michael`;

-- Listage de la structure de table forum_michael. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_categorie`),
  UNIQUE KEY `libelle` (`libelle`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_michael.categorie : ~4 rows (environ)
INSERT INTO `categorie` (`id_categorie`, `libelle`) VALUES
	(1, 'Art'),
	(2, 'Cuisine'),
	(3, 'Sport'),
	(4, 'Voyages');

-- Listage de la structure de table forum_michael. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudonyme` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `dateInscription` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `pseudonyme` (`pseudonyme`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_michael.user : ~5 rows (environ)
INSERT INTO `user` (`id_user`, `pseudonyme`, `email`, `password`, `dateInscription`) VALUES
	(1, 'Alain', 'alain123@hotmail.com', 'alain123456', '2024-12-04 14:37:20'),
	(2, 'Bruno', 'bruno123@hotmail.com', 'bruno123456', '2024-12-04 14:37:43'),
	(3, 'Claire', 'claire123@hotmail.com', 'claire123456', '2024-12-04 14:38:02'),
	(4, 'Denis', 'denis123@hotmail.com', 'denis123456', '2024-12-04 14:38:23'),
	(5, 'Eric', 'eric123@hotmail.com', 'eric1234566', '2024-12-04 14:38:55');

-- Listage de la structure de table forum_michael. message
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `texte` text COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `sujet_id` int NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `membre_id` (`user_id`),
  KEY `sujet_id` (`sujet_id`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `membre` (`id_user`),
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`sujet_id`) REFERENCES `sujet` (`id_sujet`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_michael.message : ~9 rows (environ)
INSERT INTO `message` (`id_message`, `texte`, `dateCreation`, `user_id`, `sujet_id`) VALUES
	(1, 'recette s\'il vous plait ! ', '2024-12-04 14:46:25', 4, 1),
	(2, 'cuis des pates dans l\'eau ! ', '2024-12-04 14:46:57', 3, 1),
	(3, 'recette avec tomate please ! ', '2024-12-04 14:47:51', 1, 2),
	(4, 'le foot italien, c\'est bien ?', '2024-12-04 14:48:36', 2, 4),
	(5, 'et aussi, c\'est les mêmes règles ?', '2024-12-04 14:49:08', 2, 4),
	(6, 'non, ils jouent autrement ... ', '2024-12-04 14:49:55', 5, 4),
	(7, 'le rouge, c\'\'est joli ?', '2024-12-04 14:50:51', 3, 3),
	(8, 'le noir, c\'est plus sombre ! ', '2024-12-04 14:55:48', 2, 3),
	(9, 'pense à râper du parmesan ! ', '2024-12-04 14:56:38', 5, 1);

-- Listage de la structure de table forum_michael. sujet
CREATE TABLE IF NOT EXISTS `sujet` (
  `id_sujet` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `dateCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` tinyint(1) NOT NULL,
  `categorie_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_sujet`),
  KEY `categorie_id` (`categorie_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sujet_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`),
  CONSTRAINT `sujet_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_michael.sujet : ~4 rows (environ)
INSERT INTO `sujet` (`id_sujet`, `titre`, `dateCreation`, `statut`, `categorie_id`, `user_id`) VALUES
	(1, 'pâtes au parmesan', '2024-12-04 14:41:29', 1, 2, 4),
	(2, 'pâtes à la tomate', '2024-12-04 14:41:58', 1, 2, 1),
	(3, 'le rouge dans l\'art abstrait', '2024-12-04 14:42:35', 1, 1, 3),
	(4, 'le foot en Italie', '2024-12-04 14:43:24', 1, 3, 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
