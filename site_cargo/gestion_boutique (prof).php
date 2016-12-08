<?php
require_once("../inc/init.inc.php");

if(!utilisateur_est_connecte_et_est_admin()) 
{
	header("location:".URL."profil.php");
	exit(); // bloque l'exécution du script
}
// unlink();
$id_article = "";
$reference = "";
$categorie = "";
$titre = "";
$description = "";
$couleur = "";
$taille = "";
$sexe = "m";
$photo = "";
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


/* MODIFICATION */
if(isset($_GET['action']) && $_GET['action'] == 'modification')
{
	if(isset($_GET['id']))
	{
		$resultat = execute_requete("SELECT * FROM article WHERE id_article='$_GET[id]'"); // dans le cas d'une modif, on récupère en bdd toutes les informations de l'article.
		$article_actuel = $resultat->fetch_assoc(); // on transforme la ligne de l'objet resultat en tableau array
		extract($article_actuel);
	}
}

// faire des controles sur la validité des saisies du formulaire
// faire un script nous permettant de vérifier si la référence fournie est déjà présente dans la BDD
if(isset($_POST['reference']) && isset($_POST['categorie']) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['couleur']) && isset($_POST['taille']) && isset($_POST['sexe']) && isset($_POST['prix']) && isset($_POST['stock']))
{
	
	foreach($_POST as $indice => $valeur)
	{
		$_POST[$indice] = htmlentities($valeur, ENT_QUOTES);
	}
	extract($_POST);
	// controle sur la référence (unique en BDD)
	$controle_reference = execute_requete("SELECT * FROM article WHERE reference='$reference'");
	if($controle_reference->num_rows > 0 && isset($_GET['action']) && $_GET['action'] == 'ajout') // s'il y a au moins une ligne dans l'objet $controle_reference alors la référence existe déjà en BDD
	{
		$msg .= '<div class="erreur">Erreur: La référence: '. $reference . ' est indisponible</div>';
	}else {
		// $msg .= '<div class="succes">La référence: '. $reference . ' est valide</div>';
		
		/*===================================================*/
		$photo_bdd = ""; // pour éviter une erreur undefined si l'utilisateur ne charge pas de photo.
		
		if(isset($_GET['action']) && $_GET['action'] == 'modification')
		{
			$photo_bdd = $_POST['photo_actuelle']; // dans le cas d'une modif, on place le src de l'ancienne photo dans $photo_bdd avant de tester si une nouvelle photo a été posté qui écrasera la valeur de $photo_bdd
		}	
		/*===================================================*/	
		if(!empty($_FILES['photo']['name'])) // si une photo a été postée
		{
			// les fichiers chargés via un formulaire se trouvent dans la superglobale $_FILES
			if(verif_extension_photo())
			{
				// il faut vérifier le nom de la photo car si une photo possède le même nom, cela pourrait l'écraser.
				// on concatène donc la référence qui est unique avec le nom de la photo.
				$nom_photo = $reference . '_' . $_FILES['photo']['name'];
				$photo_bdd = 'img/' . $nom_photo; // $photo_bdd représente le src que nous allons enregistrer en BDD
				$chemin_dossier = RACINE_SERVER . URL . 'img/' . $nom_photo; // représente le chemin absolu pour enregistrer la photo.
				copy($_FILES['photo']['tmp_name'], $chemin_dossier); // copy() permet de copier un fichier d'un endroit vers un autre. ici tmp_name est l'emplacement temporaire ou la photo est conservée après l'avoir chargée dans un formulaire.
				
				
			}else { // l'extension de la photo n'est pas valide
				$msg .= '<div class="erreur">L\'extension de la photo n\'est pas valide<br />Extensions acceptées: jpg / jpeg / png /gif</div>';
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
//AJOUT et MODIFICATION ===================================================//	


include("../inc/header.inc.php");
include("../inc/nav.inc.php");
?>

    <div class="container">

      <div class="starter-template">
        <h1><span class="blueviolet glyphicon glyphicon-th"></span> Gestion boutique</h1> 
		<?php echo $msg;  //debug($_POST);//debug($_SERVER);  debug($_FILES);// variable initialisée dans le fichier init.inc.php ?>	
		
      </div>

    
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4" style="text-align: center;">
			<a href="?action=ajout" class="btn btn-primary">Ajouter un article</a>
			<a href="?action=affichage" class="btn btn-info">Afficher les articles</a>
		<hr />
		</div>
		<?php 
			if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
			{			
		?> 
		<div class="col-sm-6 col-sm-offset-3">		
			<form method="post" action="" enctype="multipart/form-data"><!-- l'attribut enctype avec la valeur "multipart/form-data" permet le chargement de fichier dans un formulaire -->		
			<legend>Ajout d'article</legend>
			  
			  <input type="hidden" id="id_article" name="id_article" value="<?php echo $id_article; ?>" />
			  
			  <div class="form-group">
			  
			  <?php
				$readonly = "";
				if(isset($_GET['action']) && $_GET['action'] == 'modification')
				{
					$readonly = "readonly";
				}
			  ?>
			  
				<label for="reference">Référence</label>
				<input type="text" class="form-control" id="reference" placeholder="Référence..." <?php echo $readonly; ?>  name="reference" value="<?php echo $reference; ?>" />
				
				
			  </div>
			  <div class="form-group">
				<label for="categorie">Catégorie</label>
				<input type="text" class="form-control" id="categorie" placeholder="Catégorie..." name="categorie" value="<?php echo $categorie; ?>" />
			  </div>
			  <div class="form-group">
				<label for="titre">Titre</label>
				<input type="text" class="form-control" id="titre" placeholder="Titre..." name="titre" value="<?php echo $titre; ?>" />
			  </div>
			  <div class="form-group">
				<label for="description">Description</label>
				<textarea class="form-control" id="description" placeholder="Description..." name="description"><?php echo $description; ?></textarea>
			  </div>
			  <div class="form-group">
				<label for="couleur">Couleur</label>
				<input type="text" class="form-control" id="couleur" placeholder="Couleur..." name="couleur" value="<?php echo $couleur; ?>" />
			  </div>
			  <div class="form-group">
				<label for="taille">Taille</label>
				<select name="taille" id="taille" class="form-control" >
					<option>S</option>
					<option <?php if($taille == "M") echo 'selected'; ?> >M</option>
					<option <?php if($taille == "L") echo 'selected'; ?> >L</option>
					<option <?php if($taille == "XL") echo 'selected'; ?> >XL</option>
				</select>
				
			  </div>			  
			  <div class="radio">
				<label>
				  <input type="radio" name="sexe" value="m" <?php if($sexe == 'm') { echo 'checked'; } ?> >Homme					
				</label>
			  </div>
			  <div class="radio">
				<label>
				  <input type="radio" name="sexe" value="f" <?php if($sexe == 'f') { echo 'checked'; } ?> >Femme
				</label>
			  </div>
			  
			  <div class="form-group">
				<label for="photo">Photo</label>
				<input type="file" class="form-control" id="photo" name="photo" />				
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
				<input type="text" class="form-control" id="prix" placeholder="Prix..." name="prix"  value="<?php echo $prix; ?>" />
			  </div>
			  <div class="form-group">
				<label for="stock">Stock</label>
				<input type="text" class="form-control" id="stock" placeholder="Stock..." name="stock"  value="<?php echo $stock; ?>" />
			  </div>		  
			  
			  <hr />
			
			  <input type="submit" class="form-control btn btn-info" id="enregistrer" name="enregistrer" value="Enregistrer" />
			
			</form>
			
		</div>
<?php 		}	

if(isset($_GET['action']) && $_GET['action'] == 'affichage')
{
	echo '<div class="col-sm-12">';
	// est-il possible d'accéder à cette page si l'on est pas administrateur ???
	$resultat = $mysqli->query("SELECT * FROM article");
	echo '<table border="1" class="table table-striped affichage_article" style="border-collapse: collapse; width: 100%;">';
	echo '<tr>';
	while($colonne = $resultat->fetch_field()) 
	{
		echo '<th>' . $colonne->name . '</th>';
	}
	echo '<th>Modif</th><th>Suppr</th>';
	echo '</tr>';

	while($article = $resultat->fetch_assoc())
	{
		echo '<tr>';
		foreach($article AS $indice => $valeur)
		{
			// afficher l'image dans un img src !
			if($indice == 'photo')
			{
				echo '<td><img src="' . URL . $valeur . '" alt="" width="100" /></td>';
			}elseif($indice == 'description')
			{
				echo '<td>' . substr($valeur, 0, 26) . ' <a href="">... lire la suite</a></td>';
			}
			else {
				echo '<td>' . $valeur . '</td>';
			}
			
		}
		echo '<td><a href="?action=modification&id=' . $article['id_article'] . '" class="btn btn-warning"><span class="glyphicon glyphicon-refresh"></span></a></td>';
		
		echo '<td><a onClick="return(confirm(\'Etes-vous sur ?\'));" href="?action=suppression&id=' . $article['id_article'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>';
		
		echo '</tr>';
	}
	echo '</table>';	
	echo '</div>';
	
}






echo '</div></div><!-- /.container -->'; // fermeture du row et du container
include("../inc/footer.inc.php");




/*
POUR TESTER L'EXTENSION DES PHOTOS SANS PASSER PAR LA FONCTION
if($_FILES)
{
	$extension = strrchr($_FILES['photo']['name'], '.');
	echo 'L\'extension récupérée : ' . $extension . '<hr />';
	$extension = strtolower(substr($extension, 1)); 
	echo 'L\'extension retravaillée : ' . $extension . '<hr />';
	$extension_valide = array('jpg', 'jpeg', 'png', 'gif');
	debug($extension_valide);
	
	$verif_extension = in_array($extension, $extension_valide); 
	if($verif_extension)
	{
		echo 'EXTENSION OK';
	}
	else {
		echo 'EXTENSION NOK';
	}
}
*/