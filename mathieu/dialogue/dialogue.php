<?php
/*
EXERCICE: espace de dialogue / commentaire / ...
1 - Création d'un formulaire html: champ pseudo, champ message + bouton de validation
2 - mettre en place une connexion à la BDD (Mysqli ou PDO au choix)
3 - Récupération et affichage des saisies du formulaire dans la page 
4 - Faire une requete d'insertion en BDD des saisies (/!\ ne pas oublier de donner la valeur du champ date_enregistrement => NOW())
5 - Récupération de tous les commentaires provenant de la BDD 
6 - Traitement et affichage des commentaires du plus récent au plus ancien
7 - Afficher le nombre de commentaires en haut de liste
8 - Affichage de la date en fr (exemple: Le 10/11/2016 à 15:08) en SQL: indice => date_format()
9 - mettre en forme la page.
*/

// 2 - connexion à la BDD
$mysqli = new Mysqli("localhost", 'root', '', 'dialogue');

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<style>
			* { font-family: arial, sans-serif; }
			h1 { background-color: Indigo; color: white; padding: 10px; text-align: center; font-size: 14px; }
			label { display: inline-block; font-style: italic; color: #000033; width: 140px;  font-size: 11px; }
			input { width: 100%; background-color: Lavender; border: 1px solid #c0c0c0; }
			textarea { width: 100%; resize: none; background-color: Lavender; border: 1px solid #c0c0c0; padding: 0; min-height: 70px; }
			.conteneur { width: 500px; margin: 0 auto; }
			.bouton { background-color: MediumPurple; color: white; height: 30px; }
			.bouton:hover { background-color: SlateBlue; color: white; cursor: pointer; }
			i { font-size: 11px; }
			/* affichage */
			.commentaire { border: 1px solid SlateBlue; margin-top: 20px; }
			.titre { padding: 5px; background-color: Indigo; color: white; text-align: center; font-size: 11px; }
			.message { padding: 5px; font-size: 11px; }
		</style>
	</head>
	
	<body>
		<div class="conteneur">
		<h1>Espace de dialogue</h1>
		
		<?php
			//echo '<pre>'; var_dump($_POST); echo '</pre>';
			
			echo '<hr />';
			// 3 - récupération & affichage des saisies
			if(isset($_POST['pseudo']) && isset($_POST['message']))
			{
				echo '<i>La valeur du champs pseudo est :</i> ' . $_POST['pseudo'] . '<br />';
				echo '<i>La valeur du champs message est :</i> ' . $_POST['message'] . '<br />';
				
				// 4 enregistrement des saisies en BDD
				extract($_POST);
				$pseudo = htmlentities($pseudo, ENT_QUOTES);
				$message = htmlentities($message, ENT_QUOTES);
				$mysqli->query("INSERT INTO commentaire(pseudo, message, date_enregistrement) VALUES ('$pseudo', '$message', NOW())");
			}
			
			echo '<hr />';
			
		?>
		<form method="POST" action=""> 
			<label for="pseudo">Pseudo</label>
			<input type="text" id="pseudo" name="pseudo" value="" /><br />
			
			<label for="message">Message</label>
			<textarea id="message" name="message"></textarea><br /><br />
			
			<input type="submit" name="valider" class="bouton" value="Valider" />		
		</form>
		<hr />
		<?php 
			// 5 - récupération de tous les commentaires de la BDD
			$commentaires = $mysqli->query("SELECT pseudo, message, date_format(date_enregistrement, '%d/%m/%Y') as date_fr, date_format(date_enregistrement, '%H:%i:%s') as heure_fr FROM commentaire ORDER BY date_enregistrement DESC");
		?>
		<h1><?php /* 7 - */ echo $commentaires->num_rows; ?> Commentaires</h1>
		
		<?php 
		 // 6 - affichage des commentaires
		 while($comment = $commentaires->fetch_assoc())
		 {
			 echo '<div class="commentaire">';
			 echo '<div class="titre">Par: ' . $comment['pseudo'] . ' le ' . $comment['date_fr'] . ' à ' . $comment['heure_fr'] . '</div>';
			 echo '<div class="message">' . $comment['message'] . '</div>';
			 
			 echo '</div>';
		 }
		?>
		</div>
	</body>
</html>
