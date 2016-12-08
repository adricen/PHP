<?php

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style>
		* { font-family: arial, sans-serif; }
		h1 { background-color: #000033; color: white; padding: 10px; }
		label { display: inline-block; font-style: italic; color: #000033; width: 140px; }
		input { width: 280px; }
		textarea { width: 280px; resize: none;}
		.bouton {width: inherit;}
	</style>
	<title></title>
</head>
<body>
	<h1>Formulaire 1</h1>
	<?php
		echo '<pre>'; var_dump($_POST); echo '</pre>';
		echo "<br />";
		echo '<hr />';	

	// afficher proprement les saisies du formulaire
		// avec le if on protège les saisies
		if(isset($_POST['prenom']) && isset($_POST['description']))
		{	
			echo $_POST['prenom'] . ' a écrit le commentaire suivant: ' . $_POST['description'] . '<br />';
		}
		echo '<hr />';



	?>
	<form method="POST" action=""> <!-- l'attribut action décide où on envoie les infos quand on valide le formulaire (url cible) et la méthode détermine par quelle méthode vont transiter les données : du $_GET (envoie infos dans la même url - par défaut) ou du $_POST -->
		<label for="prenom">Prénom</label> <!-- l'attribut for se réfère à l'id de l'input -->
		<input type="text" id="prenom" name="prenom" value="" /><br /> <!-- l'attribut name sur chaque champ est obligatoire ==> le name du champ est l'indice du tableau ARRAY qui sera généré pour récupérer l'information -->

		<label for="description">Description</label>
		<textarea id="description" name="description"></textarea><br />

		<input type="submit" name="valider" value="Valider" />
	</form>

</body>
</html>