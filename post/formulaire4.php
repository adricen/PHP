

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	
</head>
<body>
	<h1 style="background-color: fuchsia; color: white; padding: 10px; font-family: arial, sans-serif;">Formulaire 4</h1>
	<hr><a href="formulaire3.php">Retour au formulaire</a></hr>

	<?php
// faire un formulaire avec les champs suivants: pseudo, email
// finir ce formulaire afin que lorsque l'on valide le formulaire l'utilisateur arrive sur la page formulaire 4 et afficher les saisies sur la formulaire page 4

// faire des contrôles des saisies obtenues depuis formulaire3.php
// Vérifier la taille du pseudo : le pseudo doit avoir entre 4 et 14 caractères inclus
// le mail ne doit pas être vide
// si les deux contrôles sont ok on les affiche (le pseudo est...)
// sinon on affiche un message d'erreur sur le pseudo ou l'email

		echo '<pre>'; var_dump($_POST); echo '</pre>';
		echo '<br />';

		echo '<hr />';

		$pseudo = isset($_POST['pseudo']);
		$pseudo_len = strlen($_POST['pseudo']);
		$email = isset($_POST['email']);
		$email_nul = empty($_POST['email']);

		if(($pseudo) && ($email)) // controle pseudo
		{
			if(($pseudo_len < 4) || ($pseudo_len > 14))
			{// si je prends le && il faut >=4 && <= 14 (>&&< // <||>)
				echo 'Veuillez renseigner un pseudo entre 4 et 14 caractères.<br />';
			}
			else
			{
				echo 'Votre Pseudo est: ' . $_POST['pseudo'] . '. <br />';
			}
			if($email_nul) // controle email renseigné ou vide
			{
				echo 'Vous devez renseigner une adresse email.<br />';
			}
			else
			{
				echo 'Votre adresse email est :' . $_POST['email'] . '. <br />';
			}
		}
		echo '<hr />';

		//CORRIGE
		if(isset($_POST['pseudo']) && isset($_POST['email']))
		{// si le formulaire a été validé
			$erreur = false; // création d'une variable qui nous permet de contrôler s'il y a eu une erreur
			if(strlen($_POST['pseudo']) >= 4 && strlen($_POST['pseudo']) <=14) // controle pseudo
			{
				echo '<div style="padding: 10px; background-color: darkgreen; color: white;">Votre pseudo est: ' . $_POST['pseudo'] . '</div>';
			}
			else
			{
				echo '<div style="padding: 10px; background-color: darkred; color: white;">Attention, le pseudo doit avoir entre 4 et 14 caractères inclus !</div>';
					$erreur = true;
			}
			if(!empty($_POST['email'])) // controle de l'email
			{
				echo '<div style="margin-top: 10px; padding: 10px; background-color: darkgreen; color: white;">Votre email est: ' . $_POST['email'] . '</div>';
			}
			else
			{
				echo '<div style="margin-top: 10px; padding: 10px; background-color: darkred; color: white;">Attention l\'email est obligatoire !</div>';	
					$erreur = true;
			}
			if($erreur === false)
			{
				// echo '<hr>OK</hr>'; // cas où il n'y a pas d'erreur
				// écriture dans un fichier crée dynamiquement (l'ouvrir avec un éditeur de texte)
				$f = fopen("liste.txt", "a"); // variable $f qui représentera le fichier // fopen() en mode "a" permet de créer un fichier ou de l'ouvrir s'il est déjà existant et place le curseur à la dernière ligne ("a" ouvre le fichier à l'écriture)
				fwrite($f, $_POST['pseudo'] . ' - '); // fwrite() permet d'écrire dans un fichier. 1er argument => le fichier concerné, 2ème argument => l'information à écrire
				fwrite($f, $_POST['email'] . "\n"); // "\n" représente un retour à la ligne dans un fichier. /!\ entre "" obligatoire.

				$f = fclose($f); // fclose() permet de fermer le fichier afin de ne pas surcharger de la ressource sur le serveur. Mettre la fonction dans une variable permet de le contoler, c'est tout.
			}
			else
			{
				echo '<hr>ERREUR</hr>';
			}
		}



?>

</body>
</html>






