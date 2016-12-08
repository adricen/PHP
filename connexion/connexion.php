<?php
// générer une connexion à la bdd grace à la class mysqli
$mysqli = new Mysqli("localhost", "root", "", "connexion") or die ("Erreur lors de la connexion a la BDD");
// serveur - user - mdp - table

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		* { font-family: arial, sans-serif; }
		h1 { background-color: mediumslateblue; color: white; padding: 10px; }
		label { display: inline-block; font-style: italic; color: #000033; width: 140px; }
		input { width: 280px; }
		textarea { width: 280px; line-height: 4;}
		.bouton {width: inherit;}
		form {width: 280px; margin: 0 auto;}
	</style>
</head>
<body>
	<h1>Connexion</h1>
	<?php
	// afficher les entrées du formulaire
	if (isset($_POST['pseudo']) && isset($_POST['mdp']))
	{
		echo '<label>Votre pseudo est : </label>' . $_POST['pseudo'] . '<br />';
		echo '<label>Votre MdP est : </label>' . $_POST['mdp'] . '<hr />';
		//$req = "SELECT * FROM utilisateur WHERE pseudo='$_POST[pseudo]' AND mdp='$_POST[mdp]'";
		// sécurisation des saisies
		// htmlentities() est une fonction prédéfinie qui va transformer tous les caractères éligibles en entites html (https://alexandre.alapetite.fr/doc-alex/alx_special.html)
		// le mode ENT_QUOTES permet aussi la prise en charge des quotes et des guillemets
		$_POST['pseudo'] = htmlentities($_POST['pseudo'], ENT_QUOTES);
		$_POST['mdp'] = htmlentities($_POST['mdp'], ENT_QUOTES);

		extract($_POST); // génère les variables donc plus de pb d'écriture de quotes et doubles quotes
		$req = "SELECT * FROM utilisateur WHERE pseudo='$pseudo' AND mdp='$mdp'";
		echo $req . '<hr />'; // affichage de la requete
		// si on écrit => ' OR 1 ='1 <= dans les champs du formulaire on peut se connecter puisque le code n'est pas protégé

		$user = $mysqli->query($req); // variable de réception des infos de la requete à transformer pour la rendre exploitable

		$membre = $user->fetch_assoc(); // fetch_assoc() transforme l'objet $user en tableau array représenté par $membre - /!\ ici la boucle est inutile puisqu'en récupérant la saisie d'un formulaire on ne peut avoir qu'un pseudo et qu'un mdp

		if(!empty($membre)) // si $membre n'est pas vide alors nous avons récupéré les informations de l'utilisateur, donc ses identifiants sont corrects
		{
			echo '<h3 style="background-color: darkgreen; padding: 10px; color: white; text-align: center;">Connexion</h3>';
			echo '<span><b>Id:</b></span>' . $membre['id_utilisateur'] . '<br />';
			echo '<span><b>Pseudo:</b></span>' . $membre['pseudo'] . '<br />';
			echo '<span><b>MdP:</b></span>' . $membre['mdp'] . '<br />';
			echo '<span><b>Nom:</b></span>' . $membre['nom'] . '<br />';
			echo '<span><b>Prénom:</b></span>' . $membre['prenom'] . '<br />';
		}
		else // si $membre ne reconnait pas l'utilisateur
		{
			echo '<h3 style="background-color: darkred; padding: 10px; color: white; text-align: center;">Erreur d\'identification<h3>';
		}
	} 
	else
	{
		echo '<div style="background-color: mediumslateblue; color: white; padding: 10px; text-align: center; font-weight: bold;">Veuillez saisir vos informations :</div>';
	}


	?>
	<form method="POST" action="">
		<label for="pseudo">Pseudo</label>
		<input type="text" id="pseudo" name="pseudo" value="" /><br />

		<label for="mdp">Mot de passe</label>
		<input type="text" id="mdp" name="mdp" value="" /><br />

		<br /><input type="submit" name="envoyer" value="Envoyer" />
	</form>

</body>
</html>






