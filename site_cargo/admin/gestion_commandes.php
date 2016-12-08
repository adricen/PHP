<?php
require_once("../inc/init.inc.php");

// bloquer l'accès à l'URL uniquement à l'admin
if(!utilisateur_est_connecte_et_est_admin())
{
	header("location:" . URL . "profil.php");
	exit(); // bloque l'exécution de la suite du site
}

// unlink(); pour supprimer un fichier on peut utiliser unlink.

$id_article = "";
$reference = "";
$categorie = "";
$titre = "";
$description = "";
$couleur = "";
$taille = "";
$sexe = "f";
$prix = "";
$stock = "";

/*===================================================*/
/* SUPPRESSION */
if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
	if(isset($_GET['id']))
	{
		$article_a_supprimer = execute_requete("SELECT photo FROM article WHERE id_article='$_GET[id]'");
		$photo_a_supprimer = $article_a_supprimer->fetch_assoc();
		if(!empty($photo_a_supprimer['photo']) && file_exists(RACINE_SERVER . URL . $photo_a_supprimer['photo']))
		{
			unlink(RACINE_SERVER . URL . $photo_a_supprimer['photo']); // pour supprimer la photo de cet article.
		}
		
		execute_requete("DELETE FROM article WHERE id_article='$_GET[id]'");
	}	
	$_GET['action'] = 'affichage';
}
/*===================================================*/

// modifications de la BDD depuis le formulaire
if(isset($_GET['action']) && $_GET['action'] == 'modification')
{
	if(isset($_GET['id']))
	{
		$resultat = execute_requete("SELECT * FROM article WHERE id_article='$_GET[id]'"); // dans le cas d'une modif, on récupère en BDD toutes les informations de l'article
		$article_actuel = $resultat->fetch_assoc();// on tranforme la ligne de l'objet $resultat en tableau array
		extract($article_actuel);
	}
}

//faire des controles sur la validité des saisies du formulaire
//faire un script nous permettant de vérifier si la référence fournie est déjà présente dans la BDD
if(isset($_POST['reference']) && isset($_POST['categorie']) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['couleur']) && isset($_POST['taille']) && isset($_POST['sexe']) && isset($_POST['prix']) && isset($_POST['stock']))
{
	foreach ($_POST as $indice => $valeur) 
	{
		$_POST[$indice] = htmlentities($valeur, ENT_QUOTES);
	}
	//echo 'TEST';
	extract($_POST);

	// expression régulière - on défini les caractères qu'on n'accepte pas
  	if(!preg_match('#^[0-9._-]+$#', $reference))
  	{
    /*
    les signes # indiquent le début et la fin de l'expression régulière
    le ^ indique le début de la chaine, sinon la chaine pourrait commencer par autre chose
    le $ indique la fin de la chaine, sinon la chaine pourrait finir par autre chose
    le + indique qu'on peyt retrouver plusieurs fois le même caractère, sinon on ne pourrait le trouver qu'une seule fois

    preg_match() renvoie false si un caractère non autorisé par l'expression régulière se trouve dans la chaine testée (ici $pseudo)
    */
    $msg .= '<div class="erreur">Erreur sur la référence:<br />Caractères autorisés: de 0 - 9.</div>';
  	}

	$controle_reference = execute_requete("SELECT * FROM article WHERE reference = '$reference'");// controle sur la référence (unique dans la BDD)

	// on rajoute des conditions si l'admin veut ajouter un produit sur la page de modification
	if ($controle_reference->num_rows > 0 && isset($_GET['action']) && $_GET['action'] == 'ajout') 
	{ // s'il y a au moins une ligne dans l'objet $controle_reference alors la référence existe déjà en BDD)
		$msg .= '<div class="erreur">ERREUR, la référence saisie existe déjà. </div>';
	} else {
		//$msg .= '<div class="succes">La référence : ' . $reference . ' est valide.</div>';

		/*===================================================*/
		$photo_bdd = ""; // pour éviter une erreur undefined si l'utilisateur ne charge pas de photo.
		
		if(isset($_GET['action']) && $_GET['action'] == 'modification')
		{
			$photo_bdd = $_POST['photo_actuelle']; // dans le cas d'une modif, on place le src de l'ancienne photo dans $photo_bdd avant de tester si une nouvelle photo a été posté qui écrasera la valeur de $photo_bdd
		}	
		//fin MODIF PHOTO ACTUELLE
		if (!empty($_FILES['photo']['name'])) // une photo a été postée
		{
			// les fichiers chargés via un formulaire se trouvent dans la superglobale $_FILES
			if (verif_extension_photo()) 
			{
				//il faut vérifier le nom de la photo car si une photo possède le même nom, cela pourrait l'écraser
				//on concatène donc la référence qui est unique dans la BDD avec le nom de la photo
				$nom_photo = $reference . '_' . $_FILES['photo']['name'];
				$photo_bdd = 'img/' . $nom_photo; // $photo_bdd représente le src que nous allons enregistrer en BDD
				$chemin_dossier = RACINE_SERVER . URL . 'img/' . $nom_photo; // représente le chemin absolu pour enregistrer la photo
				copy($_FILES['photo']['tmp_name'], $chemin_dossier); // copy() permet de copier un fichier d'un endroit vers un autre. Ici tmp_name est l'emplacement temporaire ou la photo est conservée après l'avoir chargée dans un formulaire.

			} else {//l'extension de la photo n'est pas valide
				$msg .= '<div class="erreur">L\'extension de la photo n\'est pas valide.<br />Extensions acceptées: jpg / jpeg / png / gif.</div>';
			}
		}
		//AJOUT et MODIFICATION ===================================================//	
		if(empty($msg)) // s'il n'y a pas d'erreur au préalable, alors on lance l'enregistrement en BDD
		{
			
			if(isset($_GET['action']) && $_GET['action'] == 'ajout')
			{
				execute_requete("INSERT INTO article (reference, categorie, titre, description, couleur, taille, sexe, prix, stock, photo) VALUES ('$reference', '$categorie', '$titre', '$description', '$couleur', '$taille', '$sexe', '$prix', '$stock', '$photo_bdd')");
			}elseif (isset($_GET['action']) && $_GET['action'] == 'modification')
			{
				execute_requete("UPDATE article SET categorie='$categorie', titre='$titre', description='$description', couleur='$couleur', taille='$taille', sexe='$sexe', prix='$prix', stock='$stock', photo='$photo_bdd' WHERE id_article='$id_article'");
			}
			$msg .= '<div class="succes">' . ucfirst($_GET['action']) . ' OK !</div>';
			$_GET['action'] = 'affichage'; // on bascule sur l'affichage du tableau pour voir l'enregsitrement ou la modification qui vient d'être exécutée.			 
		}
	}
}	
		// insertion dans la BDD
		/*if (empty($msg)) {
			$ajout_article = execute_requete("INSERT INTO article (reference, categorie, titre, description, couleur, taille, sexe, photo, prix, stock) VALUES ('$reference', '$categorie', '$titre', '$description', '$couleur', '$taille', '$sexe', '$photo_bdd', '$prix', '$stock')");
			$msg .= '<div class="succes">Insertion OK.</div>';
		}
	}
}*/
//AJOUT et MODIFICATION ===================================================//	

// affichages HTML (tout le reste du code doit venir avant)
include("../inc/header.inc.php");
include("../inc/nav.inc.php");

?>

    <div class="container">

      <div class="starter-template">
        <h1><span class="blueviolet glyphicon glyphicon-list-alt"></span> Gestion des Commandes</h1>
        <?php echo $msg;  // variable initialisée dans le fichier init.inc.php
        ?> 
      </div>

    <div class="row">
    	<div class="col-sm-4 col-sm-offset-4" style="text-align: center;">
    		<a href="gestion_boutique.php?action=ajouter" class="btn btn-primary">Ajouter un article</a>
    		<a href="gestion_boutique.php?action=afficher" class="btn btn-info">Afficher les articles</a><hr />
    	</div>
		<?php 
		if(isset($_GET['action']) && ($_GET['action'] == 'ajouter' || $_GET['action'] == 'modification'))
		{
			//echo 'OK';
		?>
		
    	<div class="col-sm-6 col-sm-offset-3">
	<!-- 	<?php debug($_POST); debug ($_FILES); ?> -->

    		<form method="post" action="" enctype="multipart/form-data">
    		<!-- l'attribut enctype avec la valeur "multipart/form-data" permet le chargement de fichier dans un formulaire	 -->
    		<?php 
    		// faire un formulaire avec les champs suivants
    		// référence / catégorie / titre / description (textarea) / couleur / taille (liste déroulante S - M - L - XL) / sexe (radio) / photo (type="file") / prix / stock
    		// vérifier le formulaire avec un debug($_POST) par exemple
    		// faire en sorte de garder la dernière saisie de l'utilisateur par défaut dans le champs
    		?>
    		<legend>Ajout d'article</legend>

				<input type="hidden" id="id_article" name="id_article" value="<?php echo $id_article ?>" />
				<!-- input caché qui contiendra l'information pour nous permettre de faire des modifications sur l'article -->

    			<div class="form-group">

				<?php  
					$readonly = "";
					if(isset($_GET['action']) && $_GET['action'] == 'modification')
					{
						$readonly = "readonly";
					}
				?>

    				<label for="reference">Référence</label>
    				<input type="text" class="form-control" id="reference" <?php echo $readonly; ?> name="reference" placeholder="Référence" value="<?php echo $reference ?>" />
  				</div>
  				<div class="form-group">
    				<label for="categorie">Catégorie</label>
    				<input type="text" class="form-control" id="categorie" name="categorie" placeholder="Catégorie" value="<?php echo $categorie ?>" />
  				</div>
  				<div class="form-group">
    				<label for="titre">Titre</label>
    				<input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" value="<?php echo $titre ?>" />
  				</div>
  				<div class="form-group">
    				<label for="description">Description</label>
    				<textarea class="form-control" id="description" name="description" placeholder="Description" value="" ><?php echo $description ?></textarea>
  				</div>
  				<div class="form-group">
    				<label for="couleur">Couleur</label>
    				<input type="text" class="form-control" id="couleur" name="couleur" placeholder="Couleur" value="<?php echo $couleur ?>" />
  				</div>
  				<div class="form-group">
    				<label for="taille">Taille</label>
    				<select class="form-control" id="taille" name="taille">
    					<option value="s" <?php if ($taille == 's') { echo 'selected'; } ?> >S</option>
    					<option value="m" <?php if ($taille == 'm') {
    						echo 'selected';
    					} ?> >M</option>
    					<option value="l" <?php if ($taille == 'l') {
    						echo 'selected';
    					} ?> >L</option>
    					<option value="xl" <?php if ($taille == 'xl') {
    						echo 'selected';
    					} ?> >XL</option>
    				</select>
  				</div>
  				<div class="form-group">
    				<label class="radio-inline">Sexe 
					  <input type="radio" name="sexe" id="sexe" value="f" 
						<?php 
		                if ($sexe == 'f') 
		                {
		                  echo 'checked';
		                }  
		                ?>
					   /> <i class="fa fa-female fa-3x"></i>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="sexe" id="sexe" value="m"
						<?php 
		                if ($sexe == 'm') 
		                {
		                  echo 'checked';
		                }  
		                ?>
					   /> <i class="fa fa-male fa-3x"></i>
					</label>
  				</div>
  				<div class="form-group">
				    <label for="photo">Joindre une photo</label>
				    <input class="form-control" name="photo" type="file" id="photo" />
				    <p class="help-block">Sélectionnez le fichier à joindre.</p>
				</div>
				<!-- //============================ -->
			  	<?php if(isset($_GET['action']) && $_GET['action'] == 'modification') {
				/* ou: if(isset($article_actuel)) */
			  	?>
			  	<div >
					<label for="photo_actuelle">Photo actuelle</label>
					<img src="<?php echo URL . $photo ?>" alt="" width="140" />
					<input type="hidden" name="photo_actuelle" value="<?php echo $photo ?>" />
			  	</div>
			  	<?php } ?>
			  	<!-- //============================ -->
  				<div class="form-group">
				    <label for="prix">Prix</label>
				    <div class="input-group">
				      <div class="input-group-addon">€</div>
				      <input type="text" class="form-control" id="prix" name="prix" placeholder="Prix" value="<?php echo $prix ?>" />
				    </div>
				  </div>
  				<div class="form-group">
    				<label for="stock">Stock</label>
    				<input type="text" class="form-control" id="stock" name="stock" placeholder="Stock" value="<?php echo $stock ?>" />
  				</div>
				<input type="submit" class="form-control btn btn-success" id="enregistrer" name="enregistrer" value="Enregistrer" />
    		</form>
    	</div>

<?php 	} //fermeture du if(isset($_GET['action']) && $_GET['action'] == 'ajouter')	{ 

//Affichage de la BDD en tableau HTML
		if(isset($_GET['action']) && $_GET['action'] == 'afficher')
		{
			echo '<div class="col-sm-12">';
			// récupérer la bdd article et l'afficher en tableau html 
			// essayer d'afficher l'image
			// bloquer l'accès à l'URL si pas administrateur

			$recuperation_bdd_article = execute_requete("SELECT * FROM article");
			echo '<table class="table table-striped affichage_article">';
			echo '<tr>';
			while($colonne = $recuperation_bdd_article->fetch_field())
			{
				echo '<th style="background-color: indigo; color: white; padding: 10px; text-align: center;">' . $colonne->name . '</th>'; // titres colonnes
			}
			echo '<th style="background-color: indigo; color: white; padding: 10px; text-align: center;">Modif</th><th style="background-color: indigo; color: white; padding: 10px; text-align: center;">Suppr</th>';
			echo '</tr>';

			while($article_bdd = $recuperation_bdd_article->fetch_assoc())
			{
				echo '<tr>';
				foreach ($article_bdd AS $champ => $valeur) {
					//afficher l'image dans un img src
					if($champ == 'photo')
					{
						echo '<td><img width="50" src="' . URL . $valeur . '" alt="' . $article_bdd['titre'] . '" /></td>';
					} elseif($champ == 'description') {
						echo '<td style="text-align: center;" >' . substr($valeur, 0, 26) . '<a href="">... lire la suite</a>' . '</td>';
					} else {
						echo '<td style="text-align: center;" >' . $valeur . '</td>';
					}
				}
				echo '<td><a href="?action=modification&id=' . $article_bdd['id_article'] . '"class="btn btn-warning"><span class="glyphicon glyphicon-refresh"></span></td>';
				echo '<td><a onClick="return(confirm(\'Etes-vous sur ?\'));" href="?action=suppression&id=' . $article_bdd['id_article'] . '"class="btn btn-success"><span class="glyphicon glyphicon-trash"></span></td>';
				echo '</tr>';
			}
			echo '</div>'; // div fermeture <div class="col-sm-12"> du tableau d'affichage des articles
			echo '</table>';
			echo $mysqli->error;
		}	

    echo '</div></div>'; //fermeture ROW puis container -->
 
include("../inc/footer.inc.php");

/*<!-- //========================================
//POUR TESTER L'EXTENSION DES PHOTOS SANS PASSER PAR LA FONCTION
//if($_FILES)
//{
//	$extension = strrchr($_FILES['photo']['name'], '.');
//	echo 'L\'extension récupérée : ' . $extension . '<hr />';
//	$extension = strtolower(substr($extension, 1)); 
//	echo 'L\'extension retravaillée : ' . $extension . '<hr />';
//	$extension_valide = array('jpg', 'jpeg', 'png', 'gif');
//	debug($extension_valide);
	
//	$verif_extension = in_array($extension, $extension_valide); 
//	if($verif_extension)
//	{
//		echo 'EXTENSION OK';
//	}
//	else {
//		echo 'EXTENSION NOK';
//	}
//} -->*/