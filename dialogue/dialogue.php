<?php
/*
EXERCICE: espace de dialogue / commentaire / ...
1- création d'un formulaire html: champ pseudo, champ message + bouton de validation
2- mettre en place une connexion à la BDD (mysqli ou PDO au choix)
3- récupération et affichage des saisies du formulaire dans la page
4- faire une requete d'insertion en BDD des saisies (/!\ ne pas oublier de donner la valeur du champ date_enregistrement => NOW())
5- récupération de tous les commentaires provenant de la BDD
6- traitement et affichage des commentaires du plus récent au plus ancien
7- afficher le nombre de commentaures en haut de la liste
8- affichage de la date en fr (exemple: le 10/11/2016 à 15:08) - en SQL: indice => date_format()
9- mettre en forme la page
*/
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		* { font-family: arial, sans-serif; text-align: center; }
		h1 { background-color: turquoise; color: white; padding: 10px; }
		label { display: inline-block; font-style: italic; color: #000033; width: 140px; }
		input { width: 100%; background-color: }
		textarea { width: 100%; line-height: 6;}
		.bouton {width: inherit;}
		.container {width: 500px; margin: 0 auto;}
	</style>
</head>
<body>
	<div class="container">
	<h1>Chat room ;-)</h1>
<?php
// 2- connexion à la BDD via MYSQLI
	$mysqli = new mysqli("localhost", "root", "", "dialogue");

// 3- récupération et affichage des saisies du formulaire dans la page
	if(isset($_POST['pseudo']) && isset($_POST['message']))
	{
		$erreur = false;
		if(!empty($_POST['pseudo'])) // controle du pseudo
		{
			echo '<div style="background-color: green; color: white; padding: 10px;">Votre Pseudo: ' . $_POST['pseudo'] . '</div>';
		}	else {
			echo '<div style="background-color: mediumslateblue; color: white; padding: 10px;">Vous devez renseigner votre Pseudo !' . '</div>';
			$erreur = true;	
		}
		if(!empty($_POST['message'])) // controle du message
		{
			echo '<div style="background-color: green; color: white; padding: 10px;">Votre Message: ' . $_POST['message'] . '</div>';
		}	else {
			echo '<div style="background-color: mediumslateblue; color: white; padding: 10px;">Vous devez écrire un message !' . '</div>';
			$erreur = true;	
		}
// 4- faire une requete d'insertion en BDD des saisies (/!\ ne pas oublier de donner la valeur du champ date_enregistrement => NOW())
		if($erreur === false)
		{
			extract($_POST);
			/*echo '<pre>'; var_dump($pseudo); echo'</pre>';
			echo '<pre>'; var_dump($message); echo'</pre>';*/
//protection contre les injections de code
			$pseudo = htmlentities($pseudo, ENT_QUOTES);
			$message = htmlentities($message, ENT_QUOTES);
//requete mysqli - insertion dans la bdd
			$mysqli->query("INSERT INTO commentaire (pseudo, message, date_enregistrement) VALUES ('$pseudo', '$message', NOW())");
		}
		else {
			echo '<div style="background-color: darkred; color: white; padding: 10px;">ERREUR !' . '</div>';
		}
	}
	echo '<hr />';
?>
	
	<form method="POST" action="">
		<label for="pseudo">Pseudo</label>
		<input type="text" id="pseudo" name="pseudo" value="" /><br /><br />

		<label for="message">Message</label>
		<textarea id="message" name="message" value=""></textarea><br /><br />

		<input type="submit" name="envoyer" value="Envoyer" />
	</form><hr />


<?php

		
/*5- récupération de tous les commentaires provenant de la BDD*/
	$recupMessages = $mysqli->query("SELECT pseudo, message, 
		date_format(date_enregistrement, '%d/%m/%Y') as date_fr, 
		date_format(date_enregistrement, '%H:%i:%s') as heure_fr FROM commentaire ORDER BY date_enregistrement DESC");
	//echo '<pre>'; var_dump($recupMessages); echo '</pre>';

/*7- afficher le nombre de commentaires en haut de la liste*/
	echo '<div style="background-color: teal; color: white; padding: 10px;">' . $recupMessages->num_rows . ' Commentaires</div><br />';

/*6- traitement et affichage des commentaires du plus récent au plus ancien*/
// plusieurs lignes donc une boucle
	while ($affMessages = $recupMessages->fetch_assoc())
	{
		//echo '<pre>'; var_dump($affMessages); echo '</pre>';
		echo '<div style="background-color: steelblue; color: white; padding: 10px;">' . $affMessages['pseudo'] . ' a écrit le ' . $affMessages['date_fr'] . ' à ' . $affMessages['heure_fr'] . '</div>';
		echo '<div style="text-align: justify; border: 1px solid darkslategray; padding: 10px;" >Commentaire : ' . $affMessages['message'] . '</div><br />';
	}
	



/*8- affichage de la date en fr (exemple: le 10/11/2016 à 15:08) - en SQL: indice => date_format()*/

/*9- mettre en forme la page*/


?>
	</div> <!-- fermeture div class=container -->
</body>
</html>