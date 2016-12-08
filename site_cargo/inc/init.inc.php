<?php
// fichier le plus important du site => appelé en tout 1er (pas d'utf8)

// CONNEXION BDD
$mysqli = new Mysqli("localhost", "root", "", "site_cargo");
// gestion erreurs lors connexion bdd
if($mysqli->connect_error)
{
	die ("Une erreur est survenue lors de la connexion a la BDD: " . $mysqli->connect_error); // die bloque l'exécution mais permet d'afficher l'erreur
}
// $mysqli->set_charset("utf8"); permet de forcer la gestion de l'utf-8 avec la BDD si on rencontre un pb

// OUVERTURE SESSION (nouvelle ou existante)
session_start();

// AUTRES INCLUSIONS
require_once("functions.inc.php"); // appel du fichier de fonctions

// VARIABLES DEVANT ETRE DISPONIBLES SUR TOUTES LES PAGES
$msg = ""; // cette variable nous servira à afficher des messages pour l'utilisateur

// CONSTANTES
// racine serveur
define("URL", "/php/site_cargo/"); // nom, valeur
// racine serveur
define("RACINE_SERVER", $_SERVER['DOCUMENT_ROOT']); // information récupérée dynamiquement grac à la superglobale $_SERVER // information nécessaire pour l'enregistrement de fichier sur notre serveur (voir gestion_boutique.php ligne 54)


