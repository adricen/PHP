<?php

$mysqli = new mysqli("localhost", "root", "", "repertoire");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="//code.jquery.com/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="i18n/datepicker-ar.js"></script>
	  	<script src="i18n/datepicker-fr.js"></script>
	  	<script src="i18n/datepicker-he.js"></script>
	  	<script src="i18n/datepicker-zh-TW.js"></script>
	  	<script>
	  		$( function() {
	    		$( "#datepicker" ).datepicker( $.datepicker.regional['fr'] );
	    		$( "#locale" ).on( "change", function() {
	      		$( "#datepicker" ).datepicker( "option",
	        	$.datepicker.regional[ $( this ).val() ] );
	    		});
	  		} );
	  </script> -->
	<style>
		* { font-family: 'Open Sans', sans-serif; }
		h1 { background-color: indigo; color: white; padding: 10px; font-size: 14px; text-align: center; margin-top: 0px; }
		label { display: inline-block; font-weight: bold; font-style: italic; color: midnightblue; width: 140px; font-size: 11px; }
		.sexe { display: inline-block; font-weight: bold; font-style: italic; color: midnightblue; width: 140px; font-size: 11px; }
		.input { width: 100%; background-color: lightcyan; border: 1px solid thistle; }
		textarea { width: 100%; background-color: lightcyan; border: 1px solid thistle; min-height: 60px; }
		form { padding: 0px 10px; }
		.container { width: 500px; margin: 0 auto; border: 1px solid indigo; }
		.bouton { width: 104%; background-color: slateblue; color: white; padding: 10px; font-size: 14px; margin-left: -10px;}
		.bouton:hover { background-color: indigo; color: white; cursor: pointer; font-weight: bold; }
		.obs { font-style: italic; font-size: 8px; }
		.datenaiss .jour .mois { display: inline-block; }
	</style>
	<title></title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>
<body>

<?php

//récupération et affichage des saisies du formulaire
	if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['profession']) && isset($_POST['ville']) && isset($_POST['cp']) && isset($_POST['adresse']) && isset($_POST['jour_naiss']) && isset($_POST['mois_naiss']) && isset($_POST['an_naiss']) && isset($_POST['sexe']) && isset($_POST['description']))
	{
		extract($_POST); //extraction avec les champs en variables
		// protection contre injections de code
		$nom = htmlentities($nom, ENT_QUOTES);
		$prenom = htmlentities($prenom, ENT_QUOTES);
		$telephone = htmlentities($telephone, ENT_QUOTES);
		$profession = htmlentities($profession, ENT_QUOTES);
		$ville = htmlentities($ville, ENT_QUOTES);
		$cp = htmlentities($cp, ENT_QUOTES);
		$date_naiss = $an_naiss . '-' . $mois_naiss . '-' . $jour_naiss;
		$description = htmlentities($description, ENT_QUOTES);

		// récupération des saisies dans la bdd
		$mysqli->query("INSERT INTO annuaire (nom, prenom, telephone, profession, ville, code_postal, adresse, date_de_naissance, sexe, description) VALUES ('$nom', '$prenom', '$telephone', '$profession', '$ville', '$cp', '$adresse', '$date_naiss', '$sexe', '$description')");	
		$req = "INSERT INTO annuaire (nom, prenom, telephone, profession, ville, code_postal, adresse, date_de_naissance, sexe, description) VALUES ('$nom', '$prenom', '$telephone', '$profession', '$ville', '$cp', '$adresse', '$date_naiss', '$sexe', '$description'";
		echo $req;

		//affichage des saisies en haut du formulaire
		echo '<hr /><pre>'; echo var_dump($nom); echo '</pre>';
		echo '<pre>'; echo var_dump($prenom); echo '</pre>';
		echo '<pre>'; echo var_dump($telephone); echo '</pre>';
		echo '<pre>'; echo var_dump($profession); echo '</pre>';
		echo '<pre>'; echo var_dump($ville); echo '</pre>';
		echo '<pre>'; echo var_dump($cp); echo '</pre>';
		echo '<pre>'; echo var_dump($adresse); echo '</pre>';
		echo '<pre>'; echo var_dump($date_naiss); echo '</pre>';
		echo '<pre>'; echo var_dump($sexe); echo '</pre>';
		echo '<pre>'; echo var_dump($description); echo '</pre><hr />';
	} else
	{
		echo '<div style="background-color: darkorchid; color: white; text-align: center; padding: 10px;"> Saisie incomplète !' . '</div>';
	}
	echo "<hr />";


?>
	<div class="container">
		<h1>Informations</h1>
		<form method="POST" action="" class="">
			<label for="nom">Nom</label>
			<input type="text" id="nom" name="nom" value="" class="input" /><br />

			<label for="prenom">Prénom</label>
			<input type="text" id="prenom" name="prenom" value="" class="input" /><br />

			<label for="telephone">Téléphone</label>
			<input type="text" id="telephone" name="telephone" value="" class="input" maxlength="10" /><br />

			<label for="profession">Profession</label>
			<input type="text" id="profession" name="profession" value="" class="input" /><br />

			<label for="ville">Ville</label>
			<input type="text" id="ville" name="ville" value="" class="input" /><br />

			<label for="cp">Code Postal <span class="obs">(5 chiffres)</span></label>
			<input type="text" id="cp" name="cp" value="" maxlength="5" class="input" /><br />

			<label for="adresse">Adresse</label>
			<input type="text" id="adresse" name="adresse" value="" class="input" /><br />

			<label for="datenaiss">Date de Naissance</label>
			<!-- <input type="text" id="datepicker" name="datenaiss" value="" class="input" />&nbsp; -->
			<?php 
			//création des listes pour la date de naissance
			echo '<select id="jour_naiss" name="jour_naiss" value="">';
			echo '<option value="" selected disabled>Jour</option>';
				$jour = date("d");
				for ($jour = 1; $jour <= 31 ; $jour++)
					{
						echo '<option name="jour" value="' . $jour . '">' . $jour . '</option>';
					}
			echo '<select>';
			//mois
			echo '<select id="mois_naiss" name="mois_naiss">'; 
			echo '<option value="" selected disabled>Mois</option>';	
				$mois = date("m");
				for ($mois = 1; $mois <= 12 ; $mois++)
					{
						echo '<option name="mois_naiss" value="' . $mois . '">' . $mois . '</option>';
					}	
			echo '<select>';
			//année
			echo '<select id="an_naiss" name="an_naiss">'; 
			echo '<option value="" selected disabled>Année</option>';	
				$annee_en_cours = date("Y");
				for ($annee = $annee_en_cours; $annee >= ($annee_en_cours - 100) ; $annee--)
					{
						echo '<option name="an_naiss" value="' . $annee . '">' . $annee . '</option>';
					}	
			echo '<select>';		
			?>	
				
			</select><br />

			<label for="sexe">Sexe</label>
			<p class="sexe">
				<input type="radio" id="sexe" name="sexe" value="m" checked />Homme
				<input type="radio" id="sexe" name="sexe" value="f" />Femme
			</p><br />

			<label for="description">Description</label>
			<textarea id="description" name="description" value="" class="input"></textarea><br /><br />

			<input type="submit" name="enregistrement" class="bouton" value="Enregistrement" class="input" /><br />
		</form>


	</div> <!-- fermeture div class=container -->
</body>
</html>