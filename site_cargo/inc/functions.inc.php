<?php

// FONCTIONS DIVERSES

function active($url)
{
	if($_SERVER['PHP_SELF'] == $url)
	{
		return ' class="active" ';
	}
	// $_SERVER['PHP_SELF'] nous renvoie l'url du script en cours
	// pour l'utilisation voir sur menu.inc.php
}


// exécuter requetes sql
function execute_requete($req)
{
	global $mysqli; // on réupère la variable représentant la connexion BDD depuis le script global
	$resultat = $mysqli->query($req); // on exécute la requete reçue en argument
	if(!$resultat) // si cela renvoie false, c'est qu'il y a une erreur sur la requete // équivalent de if($resultat == false)
	{
		die ("Erreur sur la requete: " . $req . "<br />Message : " . $mysqli->error . '<hr />'); // die créé une erreur fatale et entre () on lui demande le détail de l'erreur // si la requete échoue, die + affichage de l'erreur
	}
	return $resultat; // on retourne le résultat de la requete
}

function debug($var, $mode = 1) // si je ne fournit que le 1er argument par défaut à l'exécution il prendra la valeur de la 2nd variable déclarée en argument
{
	echo '<div style="background-color: orange; padding: 10px;">';
	$trace = debug_backtrace(); // la fonction debug_backtrace retourne un tableau ARRAY contenant des informations telles que la ligne et le fichier où est exécutée cette fonction
	// echo '<hr />'; var_dump($trace); echo '<hr />';
	$trace = array_shift($trace); // retire le 1er élément du tableau et réodonne tous les éléments pour qu'il n'y ait pas de vide
	echo '<p>Debug demandé dans le fichier: ' . $trace['file'] . ' à la ligne: ' . $trace['line'] . '</p>';
	if($mode === 1)
	{
		echo '<pre>'; var_dump($var); echo '</pre>';
	} 
	else
	{
		echo '<pre>'; print_r($var); echo '</pre>';
	}

	echo '</div>';
}
// si on passe un seul argument  debug($arg); => var_dump
// si on passe deux arguments et que le 2nd argument n'est pas 1  debug($arg, $arg2); => print_r


// FONCTIONS UTILISATEUR
function utilisateur_est_connecte()
{// cette fonction m'indique si l'utilisateur est connecté
	if(isset($_SESSION['utilisateur']))// indice 'utilisateur' créé dans la page connexion si pseudo et mdp sont bien dans la BDD
	{
		return true;
	}
	else
	{
		return false;
	}
}

//---
function utilisateur_est_connecte_et_est_admin()
{// cette fonction m'indique si l'utilisateur est connecté mais aussi admin
	if(utilisateur_est_connecte() && $_SESSION['utilisateur']['statut'] == 1)
	{
		return true;
	}
	else {
		return false;
	}
}

// FONCTIONS GESTION BOUTIQUE
function verif_extension_photo()
{
	$extension = strrchr($_FILES['photo']['name'], '.'); // permet de retourner la chaine de caractères contenue après le . fourni en 2eme argument. Cette fonction part de la fin de la chaine puis remonte pour couper la chaine lorsqu'elle tombe sur la première occurence du caractère fourni en 2eme argument. Par exemple on récupère .jpg ou .png
	$extension = strtolower(substr($extension, 1)); // ici on transforme la chaine en minuscules (strtolower) au cas où et on coupe le point du début de la chaine (substr) au final le .jpg ou .JPEG deviennent => .jpg ou .jpeg
	// echo $extension;

	// définition dans un tableau array toutes les extensions valides/acceptées
	$extension_valide = array('jpg', 'jpeg', 'png', 'gif');

	// vérification si l'extension chargée est valide
	$verif_extension = in_array($extension, $extension_valide); // renvoie true ou false - in_array teste si le 1er argument correspond à une des valeurs contenues dans le tableau array fourni en 2ème argument - Cette fonction native nous évite de faire une boucle

	return $verif_extension; // on renvoie donc true ou false
}


// FONCTIONS PANIER
//---- création du panier
function creation_panier()
{
	if(!isset($_SESSION['panier'])) //s'il existe on le reprend si il n'existe pas on le créé => on n'écrase pas le panier existant
	{
		$_SESSION['panier'] = array();
		$_SESSION['panier']['titre'] = array();
		$_SESSION['panier']['id_article'] = array();
		$_SESSION['panier']['quantite'] = array();
		$_SESSION['panier']['prix'] = array();
	}
	return true; // permet de controler d'autant qu'une fonction sans return retournera par défaut false
}

//----- ajout au panier
function ajouter_article_au_panier($titre, $id_article, $quantite, $prix)
{// 4 arguments à fournir depuis la page panier.php
	// 1- on vérifie si le produit n'est pas déjà présent dans le panier afin de ne changer que sa quantité si c'est le cas
	$position_article = array_search($id_article, $_SESSION['panier']['id_article']); // la fonction array_search cherche une valeur dans un tableau array et nous renvoie l'indice correspondant s'il existe
	// si la valeur de l'indice n'est pas trouvée, on récupère false

	// on vérifie qu'on ne récupère pas false
	if($position_article !== false) // !== comparaison stricte sur la valeur mais aussi le type (!== au lieu de !=) car si l'on récupère 0 cela aurait été interprété comme false
	{ // si l'on rentre dans cette condition, le produit est déjà présent dans le panier. Nous ne changeons donc que sa quantité
		$_SESSION['panier']['quantite'][$position_article] += $quantite;
	} else {
		// si on rentre dans le else alors l'article n'est pas déjà dans le panier et nous le rajoutons. des crochets vides crééent un nouveau champ
		$_SESSION['panier']['quantite'][] = $quantite;
		$_SESSION['panier']['titre'][] = $titre;
		$_SESSION['panier']['prix'][] = $prix;
		$_SESSION['panier']['id_article'][] = $id_article;
	}

}

//------ Montant total du panier
function montant_total()
{
	$total = 0;
	$nb_articles = count($_SESSION['panier']['titre']); //on récupère le nombre d'articles dans le panier (n'importe lequel des 4: quantite, titre, prix, id_article)
	for($i = 0; $i < $nb_articles ; $i++)
	{
		$total += $_SESSION['panier']['prix'][$i]*$_SESSION['panier']['quantite'][$i]; // on multiplie le prix par la quantité de l'indice en cours => chaque article présent dans le panier et on ajoute ces valeurs dans la variable $total
	}
	return round($total, 2); // round() permet d'arrondir la valeur, le deuxième argument précise le nombre de décimales
}

// -------- pour retirer un article du panier 
function retirer_un_article_du_panier($id_article)
{
	$position_article = array_search($id_article, $_SESSION['panier']['id_article']); // retourne un chiffre correspondant à l'indice ou se trouve cette valeur
	if($position_article !== false) // si le produit est présent dans le panier => on le retire
	{
		array_splice($_SESSION['panier']['id_article'], $position_article, 1);
		array_splice($_SESSION['panier']['prix'], $position_article, 1);
		array_splice($_SESSION['panier']['titre'], $position_article, 1);
		array_splice($_SESSION['panier']['quantite'], $position_article, 1);
		// array_splice() permet de retirer un élément du tableau array mais aussi de réordonner les indices afin qu'il n'y ai pas un trou dans notre tableau (pas de décalage dans les indices)
		// http://php.net/manual/fr/function.array-splice.php
	}
}