<?php
// la superglobale $_GET représente l'url - /!\ case sensitive
// toutes les superglobales sont des tableaux ARRAY
// par défaut une superglobale est accessible de partout (contrairement à global/local)
echo '<pre>'; var_dump($_GET); echo '</pre>';
echo '<br />';

if(!empty($_GET))// si $_GET n'est pas vide équivaut en raccourci à ==> if($_GET){}
{
	echo '<b>La valeur de l\'ID est:</b> ' . $_GET['id'] . '<br />';
	echo '<b>La valeur de la catégorie est:</b> ' . $_GET['categorie'] . '<br />';
	echo '<b>La valeur de la couleur est:</b> ' . $_GET['couleur'] . '<br />';
	echo '<b>La valeur du prix est:</b> ' . $_GET['prix'] . '<br />';
}
// ce 1er contrôle permet de n'afficher que si le détail de l'url n'est pas vide (et donc d'éviter d'obtenir des erreurs si on conserve l'affichage alors que les informations complémentaires de l'url n'existent pas)

// TRES IMPORTANT
// $_GET existe toujours, il est donc inutile de la déclarer
// En outre l'url étant manipulable par l'utilisateur il n'est pas sécurisé, ne pas mettre de données confidentielles ou sensibles dans une url

// ?indice1=valeur1&indice2=valeur2&indice3=valeur3...
// /!\ étant des protocoles http, $_GET et $_POST sont toujours existants !!!

// $_post ne fonctionne que sur un formulaire mais il est sécurisé car il passe par le serveur avant de renvoyer les informations
echo '<hr />';






?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<h1 style="background-color: navy; padding: 10px; color: white;" >PAGE 2</h1>
	<hr /><a href="page1.php">Aller sur la page 1</a><hr />
</body>
</html>