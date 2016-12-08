<?php
require_once("inc/init.inc.php");

if(!preg_match('#^[0-9]+$#', $_GET['id']))
{// SECURITE on vérifie que l'id est un chiffre et rien d'autre
    /*
    les signes # indiquent le début et la fin de l'expression régulière
    le ^ indique le début de la chaine, sinon la chaine pourrait commencer par autre chose
    le $ indique la fin de la chaine, sinon la chaine pourrait finir par autre chose
    le + indique qu'on peut retrouver plusieurs fois le même caractère, sinon on ne pourrait le trouver qu'une seule fois

    preg_match() renvoie false si un caractère non autorisé par l'expression régulière se trouve dans la chaine testée (ici $pseudo)
    */
    header("location:boutique.php"); // sinon on renvoie sur la boutique
    exit(); //ne pas oublier le exit() ici sinon la requete ci-dessous s'exécutera quand même !!
}

$id = $_GET['id']; // variable de récupération de l'id dans l'url de la page
$info_article = execute_requete("SELECT * FROM article WHERE id_article='$id'"); // requete qui récupère les informations de l'article correspondant à l'id_article de la BDD

if($info_article->num_rows == 0)
{// s'il n'y a pas de ligne dans le BDD pour cet id il ne correspond à rien
	header("location:boutique.php");
	exit();
} else {
	extract($_POST);
	// echo 'TEST';
	// debug($info_article);
	$article = $info_article->fetch_assoc();
}


// affichages HTML (tout le reste du code doit venir avant)
include("inc/header.inc.php");
include("inc/nav.inc.php");

//EXERCICE
// Afficher sur la page un lien qui permet de revenir à sa sélection sur la page boutique (si l'utilisateur est sur un pantalon on le renvoie sur boutique.php avec par déaut la catégorie pantalon affichée)
// Dans les informations produit, afficher le stock ou le message "rupture de stock pour ce produit" si le stock est à 0
?>

    <div class="container">

      	<div class="starter-template">
        	<h1><span class="blueviolet glyphicon glyphicon-tag"></span> Fiche article</h1>
        	<?php echo $msg;  // variable initialisée dans le fichier init.inc.php
        	?> 
      	</div>

	      	<div class="col-sm-6 col-sm-offset-3">
	      		<div class="panel panel-warning">
	      			<div class="panel-heading" style="text-align: center;"><img src="img/logo.png" width="50%" /></div>
	      			<div class="panel-body">
	      				<h4 class="boutique-titre" style="text-align: center;"><?php echo $article['titre']; ?></h4>
						<p style="text-align: center;"><img width="50%" src="<?php echo $article['photo']; ?>" /></p>
		      			<div class="row">
		      				<div class="col-sm-4 blueviolet" style="font-weight: bold;">
		      					<p>Prix :</p>
		      					<p>Taille :</p>
		      					<p>Couleur :</p>
		      					<p>Sexe :</p>
		      					<p>Stock :</p>
		      				</div> <!-- fermeture div pour les titres des rubriques -->
		      				<div class="col-sm-6 col-sm-offset-2">
		      					<p><?php echo $article['prix'] ?> €</p>
		      					<p><?php echo $article['taille'] ?></p>
		      					<p><?php echo $article['couleur'] ?></p>
		      					<p><?php echo $article['sexe'] ?></p>
		      					<!-- <p><?php echo $article['stock'] ?></p> -->
		      					<p><?php 
		      					if ($article['stock'] > 0) {
		      							echo $article['stock']; 
		      						} else {
		      							echo 'Rupture de stock';
		      						} ?>
		      					</p>
		      				</div> <!-- fermeture div pour les contenus des rubriques -->
						</div>
						<div class="row">
							<div class="col-sm-8">
								<p class="blueviolet" style="font-weight: bold;">Description :</p>
								<p><?php echo $article['description'] ?></p>
							</div>
						</div>
						<hr />
						<?php 
						if ($article['stock'] > 0)
						{
							echo '<form method="post" action="panier.php">';
							echo '<input type="hidden" name="id_article" value="' . $article['id_article'] . '" />';
								echo '<select name="quantite" class="form-control">';
									for($i = 1 ; $i <= $article['stock'] && $i <= 5; $i++) {
										echo '<option>' . $i . '</option>';
									}
								echo '</select><br />';
								echo '<input type="submit" class="form-control btn btn-danger" name="ajout_panier" value="Ajouter au Panier" />';
							echo '</form>';						
						}	
						?>
							      				
	      			</div> <!-- fermeture div panel-body -->
	      			<div class="panel-footer panel-success" style="text-align: center;">
	      				<p><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><a href="boutique.php?cat=<?php echo $article['categorie']; ?>"> Retour vers votre sélection</a></p>
	      			</div>
	      		</div> <!-- fermeture div panel -->
	      	</div>

    </div><!-- /.container -->

<?php
include("inc/footer.inc.php");
