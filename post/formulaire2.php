<?php
// faire un formulaire avec les champs suivants: ville, code postal, adresse
// vérifier les saisies avec un var_dump ou un priny_r
// afficher proprement les saisies via des echo
// avez-vous pensé à protéger la page des erreurs "undefined index..." ? => pour tester: clic dans l'url + entrée (pas F5)




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
	<h1>Formulaire 2</h1>
	<?php
		echo '<pre>'; var_dump($_POST); echo '</pre>';
		echo '<br />';

		echo '<hr />';
		if(isset($_POST['ville']) && isset($_POST['cp']) && isset($_POST['adresse']))
		{
			echo 'Vous habitez à: ' . $_POST['ville'] . ', au ' . $_POST['adresse'] . ' (CP: ' . $_POST['cp'] . ').';
		}
		echo '<hr />'
?>
	<form method="POST" action="">
		<label for="ville">Ville</label>
		<input type="text" id="ville" name="ville" value="" /><br />

		<label for="cp">Code Postal</label>
		<input type="text" id="cp" name="cp" value=""><br />

		<label for="adresse">Adresse</label>
		<textarea id="adresse" name="adresse" value=""></textarea><br />

		<input type="submit" name="envoyer" value="Envoyer">
	</form>

</body>
</html>






