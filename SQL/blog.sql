-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 24 sep. 2021 à 10:14
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenu` text COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Comment_Membre0_FK` (`id_membre`),
  KEY `Comment_Post_FK` (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `contenu`, `created_at`, `published`, `id_post`, `id_membre`) VALUES
(1, 'C\'est un bon article.', '2021-09-24 11:24:06', 1, 1, 1),
(2, 'Oui nous avons trop d\'idées reçues!', '2021-09-24 11:43:22', 1, 6, 2),
(4, 'Merci, grâce à vous je suis devenu un pro de l\'astronomie amateur.', '2021-09-24 11:46:35', 1, 4, 2),
(5, 'C\'est un excellent télescope en effet.', '2021-09-24 11:43:58', 1, 1, 2),
(6, 'Bravo, bon article.', '2021-09-24 11:42:57', 1, 6, 3),
(7, 'Un peu compliqué comme sujet.', '2021-09-24 11:47:34', 0, 5, 3),
(8, 'Plus de sujets comme celui là.', '2021-09-24 11:46:31', 1, 4, 3),
(10, 'Merci, j\'avais du mal à comprendre celà.', '2021-09-24 11:46:47', 1, 3, 3),
(11, 'Je ne suis pas fan de ce télescope moi.', '2021-09-24 11:44:21', 0, 1, 3),
(12, 'Merci Caroline!', '2021-09-24 11:48:02', 1, 5, 1),
(13, 'Très bon article sur un beau sujet.', '2021-09-24 11:53:11', 1, 5, 2),
(14, 'je débute justement l\'astrophotographie, merci.', '2021-09-24 11:53:06', 1, 5, 2),
(16, '<script>alert(\"test\")<script>', '2021-09-24 11:57:06', 1, 5, 2),
(17, '<a href=\"https://www.google.com/search?client=opera&q=test&sourceid=opera&ie=UTF-8&oe=UTF-8\"></a>', '2021-09-24 11:56:52', 1, 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` text COLLATE utf8mb4_bin NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `login`, `password`, `type`) VALUES
(1, 'pierre', 'password', 'admin'),
(2, 'paul', 'password', 'subscriber'),
(3, 'jacques', 'password', 'subscriber'),
(4, 'henry', 'password', 'subscriber');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `chapo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `auteur`, `titre`, `chapo`, `contenu`, `created_at`, `slug`) VALUES
(1, 'Pierre Dupont', 'Le meilleur télescope pour débuter l’astrophotographie ', 'Ciel profond', 'Dans l’article 4 manières de débuter l’astrophotographie, nous avons vu qu’il n’y avait pas un télescope pour pratiquer l’astrophoto.\nEn effet, le télescope que vous allez choisir va dépendre des objets que vous voulez photographier.\n\nIl n’existe pas un télescope universel permettant de faire tout type de photographie.\n\nEnfin en tout cas, ce n’est pas l’idéal.\nIl vaut toujours mieux avoir un télescope spécialisé qui donne une bonne qualité d’images, plutôt qu’un télescope qui peut « tout faire », mais avec une qualité moyenne.\n\nIl est donc préférable de savoir dès le début ce que vous souhaitez photographier, pour choisir votre matériel en conséquence.', '2021-09-24 11:21:35', 'le-meilleur-telescope-pour-debuter-l-astrophotographie'),
(3, 'Michel De La Marne', 'Comprendre les différentes phases de la Lune', 'Notre satellite, la Lune', 'Certaines nuits elle est là.\nD’autres non.\nParfois, elle vient même nous faire coucou la journée.\n\nBref, la Lune fait partie de notre paysage quotidien (ou presque).\n\nMais la connaissez-vous vraiment ?\n\nConnaissez-vous les différents phases de la Lune ?\nEt savez-vous pourquoi elles existent ?\n\nC’est ce que nous allons voir ensemble maintenant !\n\nPourquoi la Lune possède différentes phases ?\nAvant de découvrir pourquoi la Lune nous montre différents visages suivant les jours, voyons déjà pourquoi nous pouvons si bien la contempler.\n\nPourquoi nous la voyons si bien ?\nLa Lune n’est pas une étoile (mais un satellite), elle n’émet donc pas de lumière. Ce que nous voyons ce sont donc les rayons du Soleil qui se reflètent sur elle et qui nous parviennent.\n\nEt si elle est si lumineuse, c’est simplement parce qu’elle se trouve (relativement) proche de nous.', '2021-09-24 11:27:12', 'comprendre-les-differentes-phases-de-la-lune'),
(4, 'Michel De La Marne', '12 étapes pour devenir un Pro de l’ASTRONOMIE AMATEUR', 'ASTRONOMIE AMATEUR', 'Peut-être que vous rêvez de photographier des nébuleuses ? Ou d’observer les anneaux de Saturne ? Ou les cratères de la Lune en gros plan ?\n\nBref : vous avez envie de vous lancer dans le merveilleux monde de l’astronomie amateur !\n\nLe problème c’est que vous ne savez peut-être pas par où commencer.\n\nPar quelle étape commencer ? Est-ce que vous devez tout de suite acheter un télescope (et lequel) ?\n\nJuste une petite précision avant de commencer :\n\nL’astronomie est un domaine assez complexe.\n\nLe but de cet article est donc de prendre un peu de recul. De vous donner une vue globale de ce qu’il est possible de faire dans cette pratique.\n\nEt surtout de vous faciliter la vie dans votre parcours d’astronome amateur.\n\nMême s’il n’existe pas vraiment de parcours type (il existe autant de chemins que d’astronomes), il existe une suite logique d’étapes / de connaissances à acquérir qui vous aideront à progresser sans trop d’embûches.', '2021-09-24 11:28:38', '12-etapes-pour-devenir-un-pro-de-l-astronomie-amateur'),
(5, 'Caroline Gaultier', 'Astrophotographie : tout ce que vous devez savoir pour bien débuter', 'Astrophotographie ', 'L’astrophotographie est un domaine passionnant et extrêmement riche. Mais il est aussi complexe. \n\nOui, pour bien débuter, vous devez connaître pas mal de choses. \n\nComme : \n\nCe qu’il est possible de photographier\nDes notions de photo, et d’astronomie\nLe choix et l’utilisation du matériel (APN, télescope (si besoin)…)\nPas de panique !\n\nLes différents types d’astrophotographie\nL’astrophotographie est vaste, il existe donc beaucoup de catégories.\n\nCela peut aller de la simple photo de la voûte céleste prise avec votre smartphone. Jusqu’à une superposition de clichés pris avec un télescope et une caméra (à plusieurs milliers d’euros).\n\nCe type d’astrophotographie est le plus simple. \n\nEn effet, il vous suffit simplement de viser le ciel avec votre appareil photo et d’appuyer sur le déclencheur. Et hop… vous pouvez voir les étoiles apparaître sur votre photo !\n\nBon, en réalité, c’est pas aussi simple que ça. \n\nEh oui, l’astrophotographie possède un gros défaut : le manque de lumière. \n\nSi vous faites déjà un peu de photo vous le savez : les clichés en basse luminosité sont les plus compliquées à prendre. \n\nAlors imaginez prendre des photos sans aucune autre source lumineuse que celles des objets célestes… (Voire celle de la Lune quand elle est présente.)\n\nL’autre ennemi des astrophotographes, c’est la pollution lumineuse.\n\n(En effet, vous ne voulez pas non plus avoir trop de luminosité. Enfin du moins pas la mauvaise : celle venant de nos villes.)', '2021-09-24 11:45:01', 'astrophotographie-tout-ce-que-vous-devez-savoir-pour-bien-debuter'),
(6, 'Sophie Dubois', '5 idées reçues sur l’astronomie', 'Idées reçues', 'Eh oui, en astronomie comme dans n’importe quel autre domaine, il existe des croyances erronées !\n\nQue ce soit sur le Soleil, la Lune, les planètes… ou bien sur l’histoire de l’astronomie, certaines idées reçues se sont installées.\n\nLes anneaux de Saturne n’ont pas toujours été là…\nJe suis sûre que vous connaissez la magnifique Saturne ! Et quand on parle de Saturne, tout de suite on pense à… ses anneaux ! Eh oui, parce que ce qui caractérise le plus Saturne, ce sont bien ses anneaux. Imaginer Saturne sans ses anneaux, c’est comme imaginer la Lune sans ses cratères !\n\nImpossible n’est-ce pas ?\n\nEt pourtant, Saturne n’a pas toujours eu des anneaux… Et elle n’en aura pas jusqu’à la fin des temps.\n\nEn effet, grâce aux informations fournies par Cassini, les chercheurs estiment désormais l’âge des anneaux entre 10 et 100 millions d’années.\n\nLa formation de notre Système solaire remonte quant à elle à 4,6 milliards d’années. Ainsi, Saturne a vécu pendant longtemps sans ses anneaux.\n\nEt d’ailleurs, elle devra réapprendre à vivre sans !\n\n', '2021-09-24 11:32:25', '5-idees-recues-sur-l-astronomie');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `Comment_Membre0_FK` FOREIGN KEY (`id_membre`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Comment_Post_FK` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
