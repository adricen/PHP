<?php
// faire un formulaire avec les champs suivants: pseudo, email
// finir ce formulaire afin que lorsque l'on valide le formulaire l'utilisateur arrive sur la page formulaire 4 et afficher les saisies sur la formulaire page 4



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		* { font-family: arial, sans-serif; }
		h1 { background-color: fuchsia; color: white; padding: 10px; }
		label { display: inline-block; font-style: italic; color: #000033; width: 140px; }
		input { width: 280px; }
		textarea { width: 280px; line-height: 4;}
		.bouton {width: inherit;}
	</style>
</head>
<body>
	<h1>Formulaire 3</h1>
	
	<form method="POST" action="formulaire4.php">
		<label for="pseudo">Pseudo</label>
		<input type="text" id="pseudo" name="pseudo" value="" /><br />

		<label for="email">E-mail</label>
		<input type="text" id="email" name="email" value="" /><br />

		<input type="submit" name="envoyer" value="Envoyer" />
	</form>

</body>
</html>






