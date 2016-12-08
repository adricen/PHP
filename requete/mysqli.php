<?php
//====================== MYSQLI =====================
/*
		>> >> QUERY() méthode
				SELECT: query() est utilisé pour la formulation de requetes retournant un ou plusieurs résultats
				Valeurs de retour:
					Echec: false (problème de syntaxe dans la requete)
					Succes: nouvel objet issu de la class Mysqli_result

				INSERT / UPDATE / DELETE via la méthode query()
				Valeurs de retour:
					Echec: false
					Succes: true

		>> >> PREPARE() puis EXECUTE()
				INSERT / UPDATE / DELETE / SELECT
					PREPARE permet de préparer la requete mais ne l'exécute pas
					EXECUTE permet d'exécuter une requete préparée

					Valeurs de retour:
						prepare() renvoie toujours un objet Mysqli_result
						execute() :
							Echec: false
							Succes: mysqli_result

Cycle des requetes = analyse - interprétation - exécution
PREPARE fait les 2 premiers cycles
EXECUTE ne fait que le dernier

*/

/*$mysqli->query("SELECT * FROM employes");
signifie :
BDD		via requete (...)*/

//_______________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">1 - Connexion avec Mysqli</h1>';

$mysqli = new mysqli("localhost", "root", "", "entreprise"); 
// sous MAC: $mysqli = new mysqli("localhost", "root", "root", "entreprise"); 
// 4 arguments(hôte(serveur) / identifiant BDD / mot de passe BDD / nom de la BDD)

// on vérifie la connexion :
//echo '<pre>'; var_dump($mysqli); echo '</pre>';
//echo '<pre>'; var_dump(get_class_methods($mysqli)); echo '</pre>';

//_______________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">2 - Erreur de REQUETE</h1>';

$mysqli->query("sdfghjk");
echo $mysqli->error . '<br />'; // pour voir la dernière erreur sql, si le code php est correct il faut demander à afficher l'erreur en mysql sinon elle ne s'affichera pas toute seule

//_______________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">3 - INSERT / UPDATE / DELETE</h1>';

//$mysqli->query("INSERT INTO employes (nom, prenom, salaire, sexe, service, date_embauche) VALUES ('Gauriau', 'Marie', 10000, 'f', 'informatique', '2016-11-09')"); // lors d'une requete de type insert / update / delete, nous n'avons pas besoin de prévoir la variable de réception sauf si l'on souhaite tester si on obtient true ou false.

//echo 'nombre de lignes affectées: ' . $mysqli->affected_rows . '<hr />';
// le nombre de lignes affectées par la dernière requete

//_______________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">4 - SELECT pour une seule ligne de résultat</h1>';

// /!\ un fetch_ efface la ligne dès qu'il a effectué le traitement sur la ligne 


$resultat = $mysqli->query("SELECT * FROM employes WHERE id_employes=350");
echo '<pre>'; var_dump($resultat); echo '</pre>';
// créé un nouvel objet 'resultat' qui résulte de la class 'mysqli_result'
// $resultat est le résultat inexploitable, nous devons le traiter avec une des méthodes fetch_... de l'objet mysqli_resultat afin de le rendre exploitable.

$employes = $resultat->fetch_assoc(); // pour obtenir un tableau ARRAY associatif (le nom des colonnes comme indices du tableau)

//$employes = $resultat->fetch_row(); // les indices du tableau sont des chiffres

//$employes = $resultat->fetch_array(); // mélange de fetch_assoc() et de fetch_row() il double les informations pour avoir un jeu avec des indices numériques et l'autre jeu avec le nom des colonnes en indices

//$employes = $resultat->fetch_object(); // pour un objet avec les noms des champs comme propriétés publiques


echo '<pre>'; var_dump($employes); echo '</pre>';
echo $employes['prenom'] . '<br />'; // avec fetch_assoc()
// echo $employes[1] . '<br />'; // avec fetch_row()
// echo $employes->prenom . '<br />'; // avec fetch_object()

//_______________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">5 - SELECT pour plusieurs lignes de résultat</h1>';

$resultat = $mysqli->query("SELECT * FROM employes");
echo 'Nombre d\'employés: ' . $resultat->num_rows . '<hr />'; //propriété nom_rows => le nombre de lignes de résultat

// plusieurs lignes => une boucle pour traiter une par une les lignes avec une méthode fetch_...

while ($employe = $resultat->fetch_assoc()) 
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

// une seule ligne de résultat = un traitement fetch tout seul
// potentiellement plusieurs lignes de résultat = un boucle !!!

// maintenant on a traité toutes les lignes, $resultat est vide

//_______________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">6 - SELECT pour une seule ligne de résultat avec FETCH_ALL()</h1>';

$resultat = $mysqli->query("SELECT * FROM employes");
// nous permet de tout traiter sans passer par une boucle et l'on récupère un tableau array multidimensionnel
$donnees = $resultat->fetch_all();
echo '<pre>'; var_dump($donnees); echo '</pre>';

echo $donnees[7][1] . '<hr />';// indice tableau + indice sous tableau

//_______________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">7 - EXERCICE</h1>';
// Affichez la liste des BDD dans une liste ul/li
// attention à l'indice (sensible à la casse)

$recupbdd = $mysqli->query("SHOW DATABASES");
echo '<pre>'; var_dump($recupbdd); echo '</pre>';
//$eltrecup = $recupbdd->fetch_assoc();
//$eltrecup = $recupbdd->fetch_all();
//echo '<pre>'; var_dump($eltrecup); echo '</pre>';
/*Affichage : 
array(1) {
  ["Database"]=>
  string(12) "bibliotheque"
}
*/
echo '<ul>';
while ($eltrecup = $recupbdd->fetch_assoc()) {
	//echo '<pre>'; var_dump($eltrecup); echo '</pre>';
	echo '<li>' . $eltrecup['Database'] . '</li>';
}
echo '</ul>';

//_______________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">8 - SELECT pour plusieurs lignes de résultat affichées dans un tableau html créé dynamiquement</h1>';

// récupérer les informations
$resultat = $mysqli->query("SELECT * FROM employes");
// on obtient $resultat qui est un objet contenant tout le contenu de la table employes. En l'état => inexploitable.

echo '<table border="1" style="border-collapse: collapse; width: 100%;">';
echo '<tr>'; // première ligne du tableau pour l'affichage des champs
while($colonne = $resultat->fetch_field()) //fetch_field traite les champs de la table et nous renvoie un objet à cahque tour de boucle. Nous demanderons le name du champ mais il est possible d'appeler d'autres informations (var_dump())
{
	echo '<th style="background-color: darkslategray; color: white; padding: 10px; font-size: 18px;">' . $colonne->name . '</th>'; //titres des colonnes
}
echo '</tr>';

while($employe = $resultat->fetch_assoc())
{
	echo '<tr>';
	foreach ($employe AS $valeur) {
		echo '<td>' . $valeur . '</td>';
	}
	echo '</tr>';
}

echo '</table>';

//_______________________________________________________________________
echo '<h1 style="background-color: mediumslateblue; color: white; padding: 10px;">9 - PREPARE + BINDPARAM + EXECUTE</h1>';

$service = 'commercial';

$mysqli_stmt = $mysqli->prepare("SELECT * FROM employes WHERE service=?");//stmt abr. de statement
// on prépare la requete
$mysqli_stmt->bind_param ("s", $service); // s pour string et $service va remplacer le ? dans la requete

//on exécute la requete
$mysqli_stmt->execute();

$resultat = $mysqli_stmt->get_result(); // la methode get_result() nous renvoie un objet issu de la class Mysqli_result

while($ligne = $resultat->fetch_assoc())
{
	echo '<pre>'; var_dump($ligne); echo '</pre><hr />';
}

echo phpinfo();





