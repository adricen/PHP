<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style>
		* { font-family: arial, sans-serif; }
		h1 { background-color: fuchsia; color: white; padding: 10px; }
		label { display: inline-block; font-style: italic; color: #000033; width: 140px; }
		input { width: 280px; }
		textarea { width: 280px; line-height: 4;}
		.bouton {width: inherit;}
	</style>
	<title></title>
</head>
<body>
	<h1>Exercices: 1 - Formulaires POST</h1>
	<?php
		echo 'Exercice 1.1';

		echo '<pre>'; var_dump($_POST); echo '</pre>'; echo '<hr />';

		$nom = isset($_POST['nom']);
		$nom_nul = empty($_POST['nom']);
		$prenom = isset($_POST['prenom']);
		$prenom_nul = empty($_POST['prenom']);
		$adresse = isset($_POST['adresse']);
		$adresse_nul = empty($_POST['adresse']);
		$ville = isset($_POST['ville']);
		$ville_nul = empty($_POST['ville']);
		$cp = isset($_POST['cp']);
		$cp_nul = empty($_POST['cp']);
		$sexe = isset($_POST['sexe']);
		$sexe_nul = empty($_POST['sexe']);
		$description = isset($_POST['description']);
		$description_nul = empty($_POST['description']);

		if (($nom) && ($prenom) && ($adresse) && ($ville) && ($cp) && ($sexe) && ($description)) //controle que le formulaire a été validé
		{
			extract($_POST);
			echo '<label>Nom</label> ' . $nom . '<br />';
		}


		if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['adresse']) && isset($_POST['ville']) && isset($_POST['cp']) && isset($_POST['sexe']) && isset($_POST['description']))
		{
			if ($nom_nul) {
				echo '<div style="padding: 10px; background-color: #DC7575; color: white;">Attention, vous devez indiquer votre Nom !</div>';
			}
			else 
			{
				echo '<div style="padding: 10px; background-color: #B5E655; color: white;">Votre Nom est : ' . $_POST['nom'] . '</div>';
			}
			if ($prenom_nul) {
				echo '<div style="padding: 10px; background-color: #DC7575; color: white;">Attention, vous devez indiquer votre Prénom !</div>';
			}
			else 
			{
				echo '<div style="padding: 10px; background-color: #B5E655; color: white;">Votre Prénom est : ' . $_POST['prenom'] . '</div>';
			}
		}

		echo '<hr />';
	?>
	<form method="POST" action="">
		<label for="nom">Nom</label>
		<input type="text" id="nom" name="nom" value="" /><br />

		<label for="prenom">Prénom</label>
		<input type="text" id="prenom" name="prenom" value="" /><br />

		<label for="adresse">Adresse</label>
		<textarea id="adresse" name="adresse" value=""></textarea><br />

		<label for="ville">Ville</label>
		<input type="text" id="ville" name="ville" value="" /><br />

		<label for="cp">Code postal</label>
		<input type="text" id="cp" name="cp" value="" /><br />

		<label for="sexe">Sexe</label>
		<select name="sexe" required="true">
			<option value="homme">Homme</option>
			<option value="femme">Femme</option>
		</select><br />

		<label for="description">Description</label>
		<textarea id="description" name="description" value=""></textarea><br />

		<input type="submit" name="envoi" value="Envoi" /><br />


	</form>


	<h1>Exercices: 2 - Liens GET</h1>
	
	<ul>
		<li><a href="exo1.php?id=Français&">France</a></li>
		<li><a href="exo1.php?id=Italien">Italie</a></li>
		<li><a href="exo1.php?id=Espagnol">Espagne</a></li>
		<li><a href="exo1.php?id=Anglais">Angleterre</a></li>
	</ul>

	<?php
	echo 'Exercice 1.2';
	echo '<hr />';
	if(!empty($_GET))
	{
	echo 'Vous êtes ' . $_GET['id'] . ' ?' . '<br />';
	}

	echo '<hr />';
	echo '<pre>'; var_dump($_GET); echo '<pre>';
	echo '<hr />';
	?>	

	<h1>Exercices: 3 - Liens GET</h1>
	<?php
	
	echo 'Exercice 3.2' . '<br />';	
	
	for ($i = 1; $i <=  100 ; $i++) { 
		if ($i == 50) {
			echo '<div style="color: fuchsia;">' . $i . '</div>';
		}
			elseif ($i == 25) 
			{
				echo '<div style="color: aquamarine;">' . $i . '</div>';
			}
			else
			{
				echo $i . '<br />';
			}
	}
	

	?>

	<h1>Exercices: 4 - Calculatrice</h1>

	<form method="POST" action="">
		<input type="text" id="nb1" name="nb1" value="" />
		
		<select name="operateur" required="true">
			<option value="+">+</option>
			<option value="-">-</option>
			<option value="*">*</option>
			<option value="/">/</option>
			<option value="%">%</option>
		</select><br />

		<input type="text" id="nb2" name="nb2" value="" /><br />

		<input type="submit" name="calculer" value="Calculer" /><br />
	</form>
	<?php
	if(isset($_POST['nb1']) &&  isset($_POST['operateur']) && isset($_POST['nb2']))
	{
		extract($_POST);
		$operation = "$nb1 $operateur $nb2";
		switch ($operateur) {
			case '+':
				$resultat = $nb1 + $nb2;
				break;
			case '-':
				$resultat = $nb1 - $nb2;
				break;
			case '*':
				$resultat = $nb1 * $nb2;
				break;
			case '/':
				$resultat = $nb1 / $nb2;
				break;
			case '%':
				$resultat = $nb1 % $nb2;
				break;
			default:
				echo '<div style="background-color: indigo; color: white; padding: 10px;">Erreur d\'opération, recommencer.</div>';
				break;
		}
		echo '<div style="background-color: mediumpurple; color: white; padding: 10px;">Opération saisie : ' . $operation . '<br />' . 'Votre résultat est : ' . $resultat . '</div>';
	}
	





	?>
	

</body>
</html>