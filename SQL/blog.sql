-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 26 sep. 2021 à 18:51
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `contenu`, `created_at`, `published`, `id_post`, `id_membre`) VALUES
(1, 'C\'est un bon article.', '2021-09-24 11:24:06', 1, 1, 1),
(2, 'Oui nous avons trop d\'idées reçues!', '2021-09-24 11:43:22', 1, 6, 2),
(4, 'Merci, grâce à vous je suis devenu un développeur pro.', '2021-09-24 11:46:35', 1, 4, 2),
(5, 'C\'est un excellent article.', '2021-09-24 11:43:58', 1, 1, 2),
(6, 'Bravo, bon article.', '2021-09-24 11:42:57', 1, 6, 3),
(7, 'Un peu compliqué comme sujet.', '2021-09-24 11:47:34', 0, 5, 3),
(8, 'Plus de sujets comme celui là.', '2021-09-24 11:46:31', 1, 4, 3),
(10, 'Merci, j\'avais du mal à comprendre celà.', '2021-09-24 11:46:47', 1, 3, 3),
(11, 'Je ne suis pas fan de ce sujet.', '2021-09-24 11:44:21', 0, 1, 3),
(12, 'Merci Caroline!', '2021-09-24 11:48:02', 1, 5, 1),
(13, 'Très bon article sur un beau sujet.', '2021-09-24 11:53:11', 1, 5, 2),
(14, 'je débute justement sur ce sujet.', '2021-09-24 11:53:06', 1, 5, 2),
(16, '<script>alert(\"test\")<script>', '2021-09-24 11:57:06', 1, 5, 2),
(17, '<a href=\"https://www.google.com/search?client=opera&q=test&sourceid=opera&ie=UTF-8&oe=UTF-8\"></a>', '2021-09-24 11:56:52', 1, 5, 2),
(18, 'ceci est un test fait par paul', '2021-09-25 08:28:34', 0, 5, 2),
(19, 'BRAVO', '2021-09-25 08:32:02', 0, 5, 2),
(20, 'J\'aime beaucoup cet article', '2021-09-25 11:46:05', 0, 5, 2),
(22, 'Fantastique', '2021-09-26 08:13:56', 0, 6, 2),
(25, 'Je ne partage pas votre avis', '2021-09-26 08:40:17', 0, 5, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `login`, `password`, `type`) VALUES
(1, 'pierre', 'password', 'admin'),
(2, 'paul', 'password', 'subscriber'),
(3, 'jacques', 'password', 'subscriber'),
(4, 'henry', 'password', 'subscriber'),
(5, 'larry', 'password', 'subscriber'),
(6, 'harry', 'password', 'subscriber'),
(7, 'laura', 'password', 'subscriber'),
(8, 'lauraa', 'password', 'subscriber'),
(9, 'lauraaa', 'password', 'subscriber'),
(10, 'lauraaaa', 'password', 'subscriber'),
(11, 'lauraaaaa', 'password', 'subscriber'),
(12, 'lauraaaaaa', 'password', 'subscriber'),
(13, 'lauraaaaaaa', 'password', 'subscriber'),
(14, 'lauraaaaaaaa', 'password', 'subscriber'),
(15, 'lauraaaaaaaaa', 'password', 'subscriber'),
(16, 'lauraaaaaaaaaa', 'password', 'subscriber'),
(17, 'lauraaaaaaaaaaa', 'password', 'subscriber'),
(18, 'lauraaaaaaaaaaaa', 'password', 'subscriber'),
(19, 'lauraaaaaaaaaaaaa', 'password', 'subscriber'),
(20, 'lauren', 'password', 'subscriber');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `auteur`, `titre`, `chapo`, `contenu`, `created_at`, `slug`) VALUES
(1, 'Pierre Dupont', 'Générer des uuidv4 depuis mysql', 'ASTUCE', 'Introduction\nLes UUID sont de plus en plus utiliser pour identifier des resources dans une base de données. Ils sont généralement générer avec l\'insertion de vos données. Néanmoins, ils y a des cas où générer l\'UUID depuis MySQL peut être très utile. Je pense notamment à la migration de données ou à l\'import de données ne possédant pas d\'UUID. Pour des raisons de performance, ces scripts sont généralement écrit entièrement en SQL, il n\'est donc pas possible d\'utiliser une quelqu\'un lib d\'un autre langage pour générer nos UUID.\n\nUUIDv1 vs UUIDv4\nMySQL propose une function native UUID() qui malheureusement ne génère que des UUIDv1. Les UUIDv1 comporte une partie déterminé à partir de l\'adresse physique de la machine et de la date, puis une partie aléatoire. Ainsi, vos UUIDv1 sont garantie d\'être unique à moins d\'être générer du même ordinateur exactement au même moment.', '2021-09-26 19:12:47', 'generer-des-uuidv4-depuis-mysql'),
(3, 'Michel De La Marne', 'Découper une chaine de caractère mais avec plusieurs séparateur en php', 'PHP', 'La fonction explode est très connu en PHP. Elle permet de découper une chaine de caractère en fonction d\'un séparateur.\n\nLa fonction preg_split est moins connu, elle permet de découper une chaine de caractère non plus en fonction d\'un séparateur mais en fonction d\'une regex. Il est possible de cibler plusieurs séparateurs avec cette regex.\n\npreg_split permet donc l\'équivalent d\'un explode mais avec plusieurs séparateur.', '2021-09-26 19:11:44', 'decouper-une-chaine-de-caractere-mais-avec-plusieurs-separateur-en-php'),
(4, 'Michel De La Marne', 'Boucler sur les jours entre deux dates php', 'PHP', 'Il m\'arrive souvent de devoir boucler sur les jours entre deux dates en PHP pour par exemple créer des tableaux, construire des graphiques ou des statistiques.\n\nVoici une façon élégante de le faire en utilisant la classe \\DatePeriod.\n\nEn choisissant un interval d\'un jour, il est possible de boucler sur les jours avec un simple foreach.', '2021-09-26 19:10:29', 'boucler-sur-les-jours-entre-deux-dates-php'),
(5, 'Caroline Gaultier', 'Permettre un embeddable doctrine d\'être nullable', 'SYMFONY', 'Doctrine propose une fonctionnalité très utile pour créer des propriétés objets sur vos entité, il s\'agit des embeddable.\n\nSeulement il existe une limitation aux embeddable, il ne peux pas être nullable. Au mieux vous pouvez rendre toutes les propriétés de l\'embbedable nullable mais Doctrine vous hydratera toujours l\'objet embeddable même si toutes ses propriétés sont null.\n\nUn workaround à cela est d\'utiliser un event listener Doctrine en postLoad afin d\'assigner null à la place de embedable si toutes ses propriétés sont null.', '2021-09-26 19:08:02', 'permettre-un-embeddable-doctrine-d-etre-nullable'),
(6, 'Sophie Dubois', 'Créer une configuration sémantique dans symfony sans bundle', 'SYMFONY', 'Depuis quelque temps et avec l\'arrivé de Flex, le découpage applicatif en bundle ne fait plus partie des bonnes pratiques Symfony. Si cela amène plus de simplicité dans le code, un des avantages des bundles était leur capacité à étendre la configuration du framework grâce au répertoire DependencyInjection.\n\nVoici comment reproduire cela dans les versions récentes de Symfony et sans bundle.', '2021-09-26 19:09:12', 'creer-une-configuration-semantique-dans-symfony-sans-bundle'),
(9, 'Pierre Dupont', 'Modifier l\'auteur des commit sur un arbre git', 'GIT', 'commit-tree\nSi comme moi vous utilisez plusieurs identités différentes pour committer votre code sur vos repos git (par exemple votre nom et email professionnels pour le travail et un pseudo et votre email perso pour vos projets perso), il vous est surement déjà arrivé d\'avoir des commits avec le mauvais nom ou le mauvais email.\n\nHeureusement git vous permet de modifier ces informations en réécrivant l\'arbre de commit.', '2021-09-26 19:21:26', 'modifier-l-auteur-des-commit-sur-un-arbre-git'),
(10, 'Paul De LA Marne', 'Active l\'option case-sensitive sur phpstorm', 'PHPSTORM', 'Lorsque vous utilisez un système de fichier sensible avec PHPStorm, celui ci devrait vous montrer le message erreur suivant vous indiquant que le logiciel n\'est pas configurer pour gérer la casse.\n\nFilesystem Case-Sensitivity Mismatch The project seems to be located on a case-sensitive file system. This does not match the IDE setting (controlled by property \"idea.case.sensitive.fs\")\n\nPHPStorm ne fera alors pas la différence entre les noms de fichiers avec ou sans majuscule et vous permettra de créer plusieurs fichiers avec le même nom mais une casse différente, ce qui peut entrainer des nombreuses erreurs une fois le code déployé sur un système sensible à la casse.\n\nJe vous conseil donc d\'activer l\'option case-sensitive.\n\nLes exemples suivants sont sur macOS mais le principe est le même sur les autres OS.', '2021-09-26 19:19:34', 'active-l-option-case-sensitive-sur-phpstorm');

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
