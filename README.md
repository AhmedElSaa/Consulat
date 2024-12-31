# Consulat

Site web fictif du consulat égyptien

<h1>Guide pour utiliser wamp et sa bdd</h1>

<h2>1-Installer WampServer et ses packages et le lancer</h2>
<p>Il faut en premier temps installer les packages et les lancer</p>
<p>Pour les packages il faut sélectionner le dossier : <i>All VC Redistribuable Packages (x86_x64) (32 & 64bits)</i> en bas de page</p>
<p>Lien des packages  : https://wampserver.aviatechno.net/</p>
<p>Lien de wampserver : https://www.wampserver.com/</p>
<p>Une fois installé vous pouvez lancer Wamp et ce dernier sera affiché en bas à droite dans les icônes cachées</p>
<p>Vous n'avez plus qu'à cliquer sur localhost</p>

<h2>2-Autoriser les liens sur les projets</h2>
<p>Faites un clic droit sur le logo wamp</p>
<p>Puis il faut aller sur "Paramètre Wamp"</p>
<p>Ensuite, "Attention: risqué"</p>
<p>Puis il faut cocher la ligne "Autoriser liens sur projet d'accueil</p>

<h2>3-Installer la bdd</h2>
<p>Repartez sur le logo Wamp en bas à droite et sélectionner phpMyAdmin</p>
<p>Renseignez l'identifiant "root" et ne mettez pas de mdp</p>
<p>Une fois connecté, allez sur "nouvelle base de données", puis dans nom mettez "db_consulat", et Créer</p>
<p>En haut il y aura une case "SQL" où vous mettrez tout le contenu du fichier database.sql présent dans le dossier puis exécutez</p>

<h2>4-Explorer le site web</h2>
<p>C'est bon vous pouvez lancer le site web avec localhost, puis sélectionner le nom du dossier contenant le code du site web</p>

## Environnement 

Ce projet concerne la création d’un site web fictif du consulat égyptien à Paris, ce projet vise à simuler les services d’un consulat pour la création de visa. Le client souhaite avoir une interface d’accueil avec des informations culturelles, d’actualités et de contact. Une interface de connexion et d’inscription avec les informations nécessaires à la création de visa. Et souhaite créer une loterie pour avoir la nationalité égyptienne.

## Interlocuteur(s) du projet

Chef de Projet : EL SAADAWY Ahmed<br>
Développeur : EL SAADAWY Ahmed<br>
Client : M.NANA Grégory (gnana@zenity.fr)<br>

## Contexte

Ce projet est un projet scolaire qui consiste à créer une application web évaluant la gestion de projet et le respect des règles de qualité de développement de l'élève.

## Technique

Language : - Php(Backend) - HTML/JS/CSS(FrontEnd)<br>
Base de données : - MySQL<br>
Serveur : - Apache<br>
Framework : - Bootstrap<br>
Tests : - Tests(try/catch) sur le fichier model.php<br>

## Arborescence du Projet

Content/ : Fichier .css et .js. <br>
Controller/ : Contient tous les controllers du site.<br>
fpdf/ : Dossier pour générer les fichier .pdf des visas.<br>
img/ : Contient toute les images du site web.<br>

## Jalon

08/11/2024 : Restitution du projet face au client.

## Retour du client

Le client est satisfait du projet et de sa facilité d'utilisation.
