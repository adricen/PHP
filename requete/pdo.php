<?php
// ========== PDO : Php Data Object =========
// avec PDO on a le choix du SGBD contrairement à mysqli

/*
	>> >> EXEC()
		INSERT / UPDATE / DELETE
			exec() est utilisé pour la formulation de requetes ne renvoyant pas de résultat
			exec() re,voie le nombre de lignes affectées par la requete

			Valeur de retour:
				Echec: false
				Succes: int (le nombre de lignes affectées)

	>> >> QUERY()
		SELECT, query() est utilisé pour des requetes renvoyant un ou plusieurs résultats.
			Echec: false
			Succes: PDOStatement (object)

	>> >> PREPARE() & EXECUTE()
		SELECT / INSERT / UPDATE / DELETE
		prepare() permet de préparer la requete mais ne l'exécute pas
		execute() permet d'exécuter la requete préparée

		Valeurs de retour:
			prepare() renvoie toujours un objet PDOStatement
			execute():
				Echec: false
				Succes: PDOStatement
*/
//________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">1 - Connexion avec PDO</h1>';

//variable de réception
$pdo = new PDO('mysql:host=localhost;dbname=entreprise', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
// arguments
//1- serveur et nom BDD 
//2- identifiant de connexion à la BDD 
//3- mdp 
//4- options: toujours dans un tableau array (ici gestion des erreurs en 1er argument et en 2 prise en charge UTF-8)
// erreurs => http://php.net/manual/fr/pdo.error-handling.php

// équivalent de mysqli :
// $mysqli = new mysqli("localhost", "root", "", "entreprise"); 

echo '<pre>'; var_dump($pdo); echo '</pre>';

//________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">2 - EXEC() - INSERT UPDATE DELETE</h1>';

//$resultat = $pdo->exec("INSERT INTO employes (nom, prenom, salaire, sexe, service, date_embauche) VALUES ('Quittard', 'Mathieu', 10000, 'm', 'informatique', '2016-11-09')");
//echo 'Nombre d\'enregistrements affectés: ' . $resultat . '<br />';
//echo 'Dernier id généré: ' . $pdo->lastInsertId() . '<br />'; // le dernier id inséré dans la bdd

//________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">3 - QUERY() - UN SEUL RESULTAT</h1>';

$resultat = $pdo->query("SELECT * FROM employes WHERE id_employes=350");
echo '<pre>'; var_dump($resultat); echo '</pre>';
echo '<pre>'; var_dump(get_class_methods($resultat)); echo '</pre><hr />'; // affiche toutes les méthodes de l'objet (que l'on peut donc utiliser dessus)

$employe = $resultat->fetch(PDO::FETCH_ASSOC);
//depuis $resultat on utilise la méthode FETCH
// PDO::FETCH_ASSOC on passe directement sur la class et non pas l'objet. Les :: pour appeler un élément static de la class
echo '<pre>'; var_dump($employe); echo '</pre>';
echo $employe['prenom'] . '<br />';
echo 'Bonjour je suis ' . $employe['nom'] . ' ' . $employe['prenom'] . ' du service ' . $employe['service'] . '.' . '<hr />';

/*
fetch(PDO::FETCH_ASSOC) => pour un tableau array associatif
fetch(PDO::FETCH_NUM) => pour un tableau array indexé numériquement
fetch() => pour un tableau array qui mélange les 2 premiers FETCH_ASSOC et FETCH_NUM - c'est le cas par défaut si on ne renseigne rien (PDO::FETCH_BOTH)
fetch(PDO::FETCH_OBJ) => pour un tableau array avec les colonnes comme propriétés publiques (que l'on peut appeler de l'extérieur)
*/

//________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">4 - QUERY() - UN ENSEMBLE DE RESULTATS</h1>';

$resultat = $pdo->query("SELECT * FROM employes");
echo 'Nombre d\'employes: ' . $resultat->rowCount() . '<br />'; // l'équivalent de num_rows sqli qui est une propriété est avec pdo une méthode

while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) // à chaque tour de boucle je traite la ligne en cours avec un fetch
{
	echo '<div style="display: inline-block; width: 21%; margin: 1%; padding: 1%; background-color: darkslategray; color: white;">';
	echo 'Nom: ' . $employe['nom'] . '<br />';
	echo 'Prénom: ' . $employe['prenom'] . '<br />';
	echo 'Salaire: ' . $employe['salaire'] . '<br />';
	echo 'Service: ' . $employe['service'] . '<br />';
	echo 'Sexe: ' . $employe['sexe'] . '<br />';
	echo 'Date d\'embauche: ' . $employe['date_embauche'] . '<br />';
	echo '</div>';
}

//________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">5 - QUERY FETCHALL + FETCH_ASSOC</h1>';

$resultat = $pdo->query("SELECT * FROM employes");

$donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);
//$donnees = $resultat->fetchAll(); // équivalent à fetchAll(PDO::FETCH_BOTH)
echo '<pre>'; var_dump($donnees); echo '</pre><hr />';


// copie pour BEN
//________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">6 - PREPARE - BINDPARAM - BINDVALUE - EXECUTE</h1>';

$nom = 'laborde';
$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom"); // le : ici est un marqueur nominatif pour viser le champ concerné de la bdd ici le champ nom, c'est comme une variable

$resultat->bindParam(':nom', $nom, PDO::PARAM_STR); //bindParam reçoit exclusivement une variable en 2ème argument
//$resultat->bindValue(':nom', $nom, PDO::PARAM_STR); // ':abc' marqueur qu'on remplace - variable ou la valeur définitive directement - controle des informations que l'on reçoit ici cela ne pourra être qu'une chaine de caractères

$resultat->execute();
$employe = $resultat->fetch();
echo '<pre>'; var_dump($employe); echo '</pre><hr />';

//Avec 2 arguments
$nom = 'laborde';
$service = 'direction';
$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom AND service = :service");
$resultat->bindParam(':nom', $nom, PDO::PARAM_STR);
$resultat->bindParam(':service', $service, PDO::PARAM_STR);
$resultat->execute();
$employe = $resultat->fetch();
echo '<pre>'; var_dump($employe); echo '</pre><hr />';

//Avec 2 arguments, en exécutant sans passer per bindparam (ou bindvalue)
$nom = 'laborde';
$service = 'direction';
$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom AND service = :service");
// même résultat que précédemment mais sans bindparam ou bindvalue les données ne sont pas sécurisées
$resultat->execute(array(':nom' => 'laborde',
						 ':service' => $service));
$employe = $resultat->fetch();
echo '<pre>'; var_dump($employe); echo '</pre><hr />';

