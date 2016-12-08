<?php
require_once("inc/init.inc.php");
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion')
{
	unset($_SESSION['utilisateur']); // effet immédiat
	
	if(isset($_SESSION['panier']))
	{
		unset($_SESSION['panier']);//permet de tester l'utilisation du panier
	}
	//session_destroy(); // à la fin de l'exécution du script
	// un session_destroy ici nous fait revenir sur connexion
}

if(utilisateur_est_connecte()) // je rentre dans cette condition si la fonction me renvoie true
  {
   /* header("location:profil.php");
    exit();*/ // bloque l'exécution du script puisque l'on redirige la page 
  }

if(isset($_POST['pseudo']) && isset($_POST['mdp'])) // vérif pseudo et mdp saisis
{
	// debug($_POST);
	foreach ($_POST AS $indice => $valeur) {
		$_POST[$indice] = htmlentities($valeur, ENT_QUOTES);
	}

	extract($_POST);
	//echo 'test';
	
	$selection_membre = execute_requete("SELECT * FROM membre WHERE pseudo = '$pseudo' AND mdp = '$mdp'");
	
	if ($selection_membre->num_rows >= 1) // s'il y a au moins une ligne alors le pseudo et le mdp sont corrects
	{
		//$msg .= '<div style="background-color: indigo; color: white; padding: 10px;">Pseudo :' . $pseudo . '<br />' . 'MDP :' . $mdp . '</div>';
		// nous nous servons de la session pour conserver les informations obtenues sachant que nous pouvons interroger la session partout dans notre projet (toutes les pages)
		$_SESSION['utilisateur'] = array();
		// pas de boucle car pseudo est unique
		$membre = $selection_membre->fetch_assoc(); // on transforme l'objet $selection_membre en tableau array avec la méthode fetch_assoc()
		foreach ($membre AS $indice => $valeur) 
		{
			if($indice != 'mdp') // tous les indices en cours sauf le mdp
			{
				$_SESSION['utilisateur'][$indice] = $valeur;
			}
			header("location:profil.php");
		}
		// boucle foreach ci-dessus correspond à ceci:
		/*$_SESSION['utilisateur'][$pseudo] = $membre['pseudo'];
		$_SESSION['utilisateur'][$nom] = $membre['nom'];
		$_SESSION['utilisateur'][$prenom] = $membre['prenom'];
		$_SESSION['utilisateur'][$email] = $membre['email'];*/

	}
	else {
		$msg .= '<div class="erreur">Erreur :<br />Le pseudo ou le mot de passe sont incorrects, veuillez vérifier vos saisies</div>';
	}
}


// affichages HTML (tout le reste du code doit venir avant)
include("inc/header.inc.php");
include("inc/nav.inc.php");

?>

    <div class="container">

      <div class="starter-template">
        <h1><span class="blueviolet glyphicon glyphicon-log-in"></span> Connexion</h1>
        <?php echo $msg;  // variable initialisée dans le fichier init.inc.php
          ?> 
      </div>

      <div class="row">
      	<div class="col-sm-4 col-sm-offset-4">
      		<form method="post" action="">
      			<!-- faire un formulaire avec les champs pseudo / mdp + bouton validation 
					 faire les controles: si le pseudo et le mdp sont ok affichez connexion ok sinon affichez connexion not OK	
      			-->
      			<div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" id="pseudo"  placeholder="Pseudo" name="pseudo" />
              </div>
              <div class="form-group">
                <label for="mdp">Mot de Passe</label>
                <input type="text" class="form-control" id="mdp"  placeholder="Mot de passe" name="mdp" />
              </div>

              <hr />

              <input type="submit" class="form-control btn btn-primary" id="inscription" name="validation" value="Validation" />
      		</form>
      	</div>
      </div>

    </div><!-- /.container -->

<?php
include("inc/footer.inc.php");
