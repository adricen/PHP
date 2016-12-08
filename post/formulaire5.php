<?php
// faire un formulaire avec les champs suivant: expéditeur, destinataire, sujet, message
function hr(){
	echo '<hr />';
}
function br(){
	echo '<br />';
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style>
		* { font-family: arial, sans-serif; }
		h1 { background-color: pink; color: white; padding: 10px; }
		label { display: inline-block; font-style: italic; color: #000033; width: 140px; }
		input { width: 280px; }
		textarea { width: 280px; line-height: 4; resize: none;}
		.bouton {width: inherit;}
	</style>
	<title></title>
</head>
<body>
	<h1>Formulaire 5 - Envoi email</h1>
	<?php
		echo '<pre>'; var_dump($_POST); echo '</pre>'; hr();

		if(isset($_POST['expediteur']) && isset($_POST['destinataire']) && isset($_POST['sujet']) && isset($_POST['message']))
		{
			extract($_POST); // extract() ne marche que sur des tableaus array. cette fonction crée une variable pour chaque indice du tableau et cette variable contient la valeur correspondante. Ici nous aurons donc les variables suivantes: $destinataire, $expediteur, $sujet et $message
			// ne marche que si les indices sont des chaines de caractère puisqu'une variable ne peut commencer par un chiffre !!

			echo "<label>Destinataire:</label>" . $destinataire . br();
			echo "<label>Expéditeur:</label>" . $expediteur . br();
			echo "<label>Sujet:</label>" . $sujet . br();
			echo "<label>Message:</label>" . $message . br();

			$expediteur = "From: " . $expediteur . "\n";
			$expediteur .= "MIME-version: 1.0 \r\n"; 
			// .= concaténation lors de l'affectation => rajoute sans écraser 
			// cette ligne contient des informations attendues par un serveur mail pour accepter le mail
			$expediteur .= "Content-type: text/html; charset-iso-8859-1 \r\n";

			mail($destinataire, $sujet, $message, $expediteur); 
			//mail'"lemailconcerne@mail.fr", $sujet, $message, $expediteur);

		}
		hr();
		// le message d'erreur, si le fichier xampp/php/php.ini ne contient pas le smtp du FAI correct  pour envoyer le mail, est le suivant :
		// Warning: mail(): Failed to connect to mailserver at "localhost" port 25, verify your "SMTP" and "smtp_port" setting in php.ini or use ini_set() in C:\xampp\htdocs\php\post\formulaire5.php on line 47 


	?>
	<h1>FORMULAIRE HTML</h1>
	<form method="POST" action="">
		<label for="expediteur">Expéditeur</label>
		<input type="text" id="expediteur" name="expediteur" value=""><br />

		<label for="destinataire">Destinataire</label>
		<input type="text" id="destinataire" name="destinataire" value=""><br />
		
		<label for="sujet">Sujet</label>
		<input type="text" id="sujet" name="sujet" value=""><br />

		<label for="message">Message</label>
		<textarea id="message" name="message"></textarea><br />

		<input type="submit" name="valider" value="Valider"><br />

	</form>

</body>
</html>