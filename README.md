# Blog

Application PHP en architecture MVC sans framework, utilisant des packages.

# Packages utilisés

* AltoRouter
* Cocur
* SwiftMailer
* Twig

Ces packages dépendent des packages suivants, qui seront automatiquement téléchargés.
*Doctrine
*Elogus
*Symfony

# Requis pour lancer le projet

* PHP7
* PHPMyAdmin
* Composer
* Serveur Mail
* Serveur Web avec SGBD

# Installation
Cloner le repository:
git clone https://github.com/soutenance14/blog.git

## Installer les packages
Dans un terminal lancer la commande
composer install

# Configuration

## Mail
Dans le dossier Config, copier le fichier __configMailExample.php__, le renommé en __configMailLocal.php__, y renseigner les identifiants de votre serveur mail.
*Suivre l'exemple dans le fichier*

## Database
Créer une base de données sur votre serveur (dans PhpMyAdmin).
Dans le dossier Config, copier le fichier __configDBExample.php__, le renommé en __configDBLocal.php__, y renseigner les identifiants de votre base de données.
*Suivre l'exemple dans le fichier*

* Créer la base de données
*Copier le fichier __blog.sql__, executer le code sql dans votre base de données dans PhpMyAdmin afin d'y créer les données.

## Racine (root)
Dans le fichier configRoot, renseigner l'url de la racine de votre projet, exemple: 127.0.0.1/blog/.
*Suivre l'exemple dans le fichier*

## Shéma

Voir diagrammes dans le dossier UML.


