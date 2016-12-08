<?php
require_once("inc/init.inc.php");
if(isset($_GET['action']) && $_GET['action'] == 'vider')
{
	unset($_SESSION['panier']);
}

creation_panier(); // fonction creation_panier(); cf functions.inc.php


// EXERCICE
// Rajouter sur chaque ligne du tableau panier un bouton pour pouvoir retirer l'article de cette ligne du panier
if(isset($_GET['action']) && $_GET['action'] == 'retrait')
{
	if(isset($_GET['id']))
	{
		retirer_un_article_du_panier($_GET['id']);
	}
}

// fin EXERCICE retirer un article du panier

// --- PAIEMENT DU PANIER ---
if(isset($_GET['action']) && $_GET['action'] == 'payer')
{
	// avant de valider le paiement, il faut vérifier les stocks disponibles de chaque produit et modifier si nécessaire la commande du client
	for($i = 0; $i < count($_SESSION['panier']['quantite']) ; $i++) // on recalcule le nombre d'articles dans le panier à chaque tour de boucle pour que toute suppression d'article soit géréé sans trou ni dans le tableau ni dans la boucle
	{
		// à chaque tour de boucle on compare le stock en BDD avec la quantité demandée
		$resultat = execute_requete("SELECT * FROM article WHERE id_article=" . $_SESSION['panier']['id_article'][$i]);
		$article = $resultat->fetch_assoc();
		$stock_restant = $article['stock'];
		// TEST // $msg .= '<div>Stock restant de l\'article ' . $_SESSION['panier']['id_article'][$i] . ': ' . $stock_restant . '</div>';

		if($stock_restant < $_SESSION['panier']['quantite'][$i])
		{
			// si le stock restant est inférieur à la quantité demandée alors il y a un souci
			if($stock_restant > 0) 
			{
				// s'il reste du stock mais inférieur à la quantité demandée alors on affecte le stock restant directement au panier, mais on prévient l'utilisateur !
				$_SESSION['panier']['quantite'][$i] = $stock_restant;
				$msg .= '<div class="erreur">Erreur :<br />La quantité de l\'article ' . $_SESSION['panier']['id_article'][$i] . ' a été réduite car notre stock est insuffisant.<br />Veuillez vérifier votre panier.</div>';
			} else {
				// le stock restant est égal à zéro
				$msg .= '<div class="erreur">Erreur :<br />L\'article ' . $_SESSION['panier']['id_article'][$i] . ' a été retiré de votre panier car nous sommes en rupture de stock.<br />Veuillez vérifier votre panier.</div>';
				retirer_un_article_du_panier($_SESSION['panier']['id_article'][$i]); // on retire l'article de l'id en cours du panier
				$i--; // pour éviter les trous dans le tableau suite au retrait de la ligne de l'article supprimé
				//!\ attention, si l'on retire un article, les indices se réodonnent (voir la fonction dans function.inc.php => function retirer_un_article_du_panier($id_article)) du coup il est important d'enlever 1 à $i car cette variable nous sert pour parcourir l'ensemble du tableau array
			}
			$erreur = true; // si on passe par cette ligne, il y a obligatoirement au moins une erreur de stock avec au moins un des produits
		}
	}
	// a la sortie de la boucle FOR on valide les commandes
	if(!isset($erreur)) // si $erreur n'existe pas alors il n'y a pas eu d'erreur sur les stocks et nous pouvons valider la commande
	{
		execute_requete("INSERT INTO commande (id_membre, montant, date) VALUES ('" . $_SESSION['utilisateur']['id_membre'] . "', " . montant_total() .", NOW())"); // enregistrement de la commande

		$id_commande = $mysqli->insert_id; // la propriété insert_id de l'objet $mysqli contient le dernier id inseré, nous en avons besoin pour l'insertion dans détail_commande dans la BDD - METHODE => http://php.net/manual/fr/mysqli.insert-id.php

		$nombre_article = count($_SESSION['panier']['id_article']);

		for ($i = 0 ; $i < $nombre_article ; $i++) 
		{
			// une boucle pour insérer tous les articles du panier dans la table details_commande, chaque article étant une ligne de cette table
			execute_requete("INSERT INTO details_commande (id_commande, id_article, quantite, prix) VALUES ($id_commande, " . $_SESSION['panier']['id_article'][$i] . ", " . $_SESSION['panier']['quantite'][$i] . ", " . $_SESSION['panier']['prix'][$i] . ")");

			//mise à jour des stocks
			execute_requete("UPDATE article SET stock=stock-" . $_SESSION['panier']['quantite'][$i] . " WHERE id_article=" . $_SESSION['panier']['id_article'][$i]);
		}
		unset($_SESSION['panier']); // on vide le panier
		// MAIL A TESTER AVEC UN SERVEUR
		//mail($_SESSION['utilisateur']['email'], "Confirmation de votre commande", "Merci, votre n° de commande et le $id_commande", "From: vendeur@site.fr");
	}
}

// --- FIN PAIEMENT DU PANIER ---


if(isset($_POST['ajout_panier'])) // cet indice dans POST provient du formulaire d'ajout de fiche_article.php
{
	$article = execute_requete("SELECT * FROM article WHERE id_article='$_POST[id_article]'"); // on récupère toutes les informations de l'article à ajouter au panier
	// un seul article donc pas de boucle => un seul fetch
	$art = $article->fetch_assoc(); // on transforme la ligne en tableau array
	// $art['prix'] = $art['prix']*1.2; // si les prix en BDD sont hors taxe on rajoute la TVA ici
	ajouter_article_au_panier($art['titre'], $_POST['id_article'], $_POST['quantite'], $art['prix']);
	// ajout de l'article dans le panier // POST renvoie les infos du formulaire alors que $art va chercher dans la BDD (les infos devraint etre les memes)
	// header("location:panier.php"); // pour éviter de rajouter le même article en rafraichissant la page (F5)
}


// affichages HTML (tout le reste du code doit venir avant)
include("inc/header.inc.php");
include("inc/nav.inc.php");

?>

    <div class="container">

      <div class="starter-template">
        <h1><span class="blueviolet glyphicon glyphicon-eur"></span> Panier</h1>
        <?php echo $msg;  // variable initialisée dans le fichier init.inc.php
        ?> 
      </div>

      <div class="row">
      	<div class="col-sm-8 col-sm-offset-2">
      		<!-- <?php debug($_POST); echo '<hr />'; debug($_SESSION['panier']); ?> -->
      		<table class="table table-striped table-bordered">
      			<tr>
      				<th colspan="5" class="panier">PANIER</th> <!-- colspan fusionne cellules sous Boostrap -->
      			</tr>
      			<tr>
      				<th class="panier">Article</th>
      				<th class="panier">Titre</th>
      				<th class="panier">Quantité</th>
      				<th class="panier">Prix</th>
      				<th class="panier">Retirer</th>
      			</tr>
      			<?php
      				if(empty($_SESSION['panier']['prix']))
      				{// si un des indices enfants de panier est vide alors le panier est vide !
      					echo '<tr><td colspan="5" style="text-align: center;">Votre panier est vide</td></tr>';
      				} else {
      					$lignes_de_commande = count($_SESSION['panier']['id_article']);//on récupère le nombre d'articles dans le panier
      				//echo $lignes_de_commande;
      				for($i = 0; $i < $lignes_de_commande; $i++)
      				{
      					echo '<tr>';
      						echo '<td>' . $_SESSION['panier']['id_article'][$i] . '</td>';
      						echo '<td>' . $_SESSION['panier']['titre'][$i] . '</td>';
      						echo '<td>' . $_SESSION['panier']['quantite'][$i] . '</td>';
      						echo '<td>' . $_SESSION['panier']['prix'][$i] . '</td>';
      						echo '<td><a onClick="return(confirm(\'Etes-vous sur ?\'));" href ="?action=retrait&id=' . $_SESSION['panier']['id_article'][$i] . '" class="btn btn-warning form-control" style="text-align: center;"><span class="glyphicon glyphicon-trash"></span></a></td>';
      					echo '</tr>';
      				}

      				// echo '<tr><td colspan="4">';
      				// // afficher le bouton payer, uniquement si l'utilisateur est connecté sinon un message du type "Veuillez vous connecter ou vous inscrire pour payer votre panier" avec liens vers connction ou inscription
      				// if(utilisateur_est_connecte())
      				// {
      				// 	echo '<a href="?action=payer" class="btn btn-success">PAYER LE PANIER</a>';
      				// } else 
      				// {
      				// 	echo 'Veuillez vous connecter ou vous inscrire pour payer votre panier <br />';
      				// 	echo '<a href="' . URL . 'inscription.php" class="btn btn-info">INSCRIPTION</a>&nbsp';
      				// 	echo '<a href="' . URL . 'connexion.php" class="btn btn-danger">CONNEXION</a>';
      				// }
      				
      				// echo '</td><td  class="panier">Montant total : ' . montant_total() . ' € TTC</td>';
      				// echo '</tr>'; /*<!-- colspan fusionne cellules sous Boostrap -->*/

      				// echo '<tr>
      				// 	<td colspan="5"><a href="?action=vider" class="btn btn-danger">VIDER LE PANIER</a></td>
      				// 	</tr>'; /*<!-- colspan fusionne cellules sous Boostrap -->*/
      				// }

      				
      				echo '<tr><td colspan="4" class="panier">Montant total : ' . montant_total() . ' € TTC</td>';
      				//afficher le bouton payer, uniquement si l'utilisateur est connecté sinon un message du type "Veuillez vous connecter ou vous inscrire pour payer votre panier" avec liens vers connction ou inscription
      				echo '<td><a href="?action=vider" class="btn btn-danger form-control">VIDER LE PANIER</a></td>
      					</tr>';

      				echo '<tr>
      					<td colspan="5">';
      				if(utilisateur_est_connecte())
      				{
      					echo '<a href="?action=payer" class="btn btn-success form-control">PAYER LE PANIER</a>';
      				} else 
      				{
      					echo 'Veuillez vous connecter ou vous inscrire pour payer votre panier <br />';
      					echo '<a href="' . URL . 'inscription.php" class="btn btn-info" width="40%">INSCRIPTION</a>&nbsp';
      					echo '<a href="' . URL . 'connexion.php" class="btn btn-danger" width="40%">CONNEXION</a>';
      				}
      				
      					echo '</td></tr>'; /*<!-- colspan fusionne cellules sous Boostrap -->*/
      				}

      			?>
      				

      				
      			<!-- bouton vider le panier + traitement -->
      			
      		</table>
      	</div>
      </div>

    </div><!-- /.container -->

<?php
include("inc/footer.inc.php");
