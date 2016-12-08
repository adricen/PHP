<?php
require_once("inc/init.inc.php");
$categories = execute_requete("SELECT DISTINCT categorie FROM article");
//requete qui récupère les catégories de la BDD
$mescategories = "";
while($categorie = $categories->fetch_assoc()) 
{
	$mescategories .= '<option>' . $categorie['categorie'] . '</option>';
}
$tri = "";
if(!empty($_GET['cat']))
{
	if($_GET['cat'] != 'tous')
	$tri = "WHERE categorie='$_GET[cat]'";
}

$contenu_article = execute_requete("SELECT * FROM article $tri");


include("inc/header.inc.php");
include("inc/nav.inc.php");
?>

    <div class="container">

      	<div class="starter-template">
        	<h1><span class="blueviolet glyphicon glyphicon-shopping-cart"></span> Boutique</h1> 
			<?php echo $msg; // variable initialis�e dans le fichier init.inc.php ?>		
      	</div>
	  	<div class="row">
		  	<div class="col-sm-12">
				<form method="get" action="">
					<select name="cat" class="form-control" style="width: 20%; display: inline-block;">
						<option value="tous">Tous les produits</option>
						<?php echo $mescategories; ?>
					</select>
					<input type="submit" class="btn btn-default" style="width: 20%;" value="Valider" name="">
				</form>
		  	</div>
		</div>
		<div class="row"><hr />
			<div class="col-sm-12">
			<?php 
				// afficher tous les produits de la BDD
				// une req qui recupere tous le contenu de la table article
				// dans une boucle while, transformer la ligne en cours et afficher les informations désirées.
				// ajouter un lien voir la fiche produit !
			while($article = $contenu_article->fetch_assoc())
			{
				echo '<div class="col-sm-3" style="text-align: center;">
						<div class="panel panel-warning">
							<div class="panel-heading"><img src="img/logo.png" width="50%" /></div>';
				echo '<div class="panel-body" style="text-align: center;">';
					echo '<h4 class="boutique_titre">' . $article['titre'] . '</h4>';
					echo '<p><img width="40%"  src="' . $article['photo'] . '" /></p><hr />';
					echo '<p>Prix: ' . $article['prix'] . '</p>';
					echo '</div>'; // fermeture panel-body
				echo '<div class="panel-footer panel-info"><p><a href="fiche_article.php?id=' . $article['id_article'] . '">Voir la fiche produit</a></p></div>';
				echo '</div></div>';
				}
				?>
		  
		  	</div>
		</div>
	  		
    </div><!-- /.container -->

<?php
include("inc/footer.inc.php");