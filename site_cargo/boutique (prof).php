<?php
require_once("inc/init.inc.php");

$contenu_article = execute_requete("SELECT * FROM article");


include("inc/header.inc.php");
include("inc/nav.inc.php");
?>

    <div class="container">

      <div class="starter-template">
        <h1><span class="blueviolet glyphicon glyphicon-shopping-cart"></span> Boutique</h1> 
		<?php echo $msg; // variable initialisée dans le fichier init.inc.php ?>		
      </div>
	  <div class="row">
		  <div class="col-sm-12">
			<p>TRI</p>
		  </div>
		  <div class="col-sm-12">
		  <?php 
			// afficher tous les produits de la BDD
			// une req qui recupere tous le contenu de la table article
			// dans une boucle while, transformer la ligne en cours et afficher les informations désirées.
			// ajouter un lien voir la fiche produit !
			while($article = $contenu_article->fetch_assoc())
			{
				echo '<div class="col-sm-4" style="text-align: center;">
						<div class=" panel panel-primary">
							<div class="panel-heading"><img src="img/logo.png" width="50%" /></div>';
				echo '<div class="panel-body" style="text-align: center;">';
				echo '<h4 class="boutique_titre">' . $article['titre'] . '</h4>';
				echo '<p><img width="50%"  src="' . $article['photo'] . '" /></p><hr />';
				echo '<p>Prix: ' . $article['prix'] . '</p>';
				echo '<p><a href="">Aller sur la fiche article</a></p>';
				echo '</div>';
				echo '</div></div>';
			}
		  ?>
		  
		  </div>
	  </div>
	  

    </div><!-- /.container -->

<?php
include("inc/footer.inc.php");