<?php
$tab_couleur = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f');
echo '<pre>'; var_dump($tab_couleur); echo '</pre>';

// piocher une valeur aléatoire du tableau
// $tab_couleur[rand(0, 15)] . $tab_couleur[rand(0, 15)] . $tab_couleur[rand(0, 15)] . $tab_couleur[rand(0, 15)] . $tab_couleur[rand(0, 15)] . $tab_couleur[rand(0, 15)];

// plus proprement on fait une boucle
$code_couleur = "";
for($i = 0; $i < 6; $i++)
{
	$code_couleur .= $tab_couleur[rand(0, 15)]; // ou $code_couleur = $code_couleur . $tab_couleur[rand(0, 15)];
}

// faites en sorte que la couleur de fond à chaque rafraichissement de page
// le code couleur doit pouvoir afficher tout le panel chromatique sans exception
// indice => on met les 16 valeurs disponibles dans un tableau ARRAY
// ne pas hésiter à l'afficher pour voir s'il contient toutes les informations (var_dump() par ex)
// ensuite trouver une façon d'extraire aléatoirement 6 valeurs du tableau pour les mettre dans le code couleur

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style>
		body { background-color: #<?php echo $code_couleur; ?> ;}
	</style>
	<title></title>
</head>
<body>
	<h1><?php echo '<pre>'; var_dump($code_couleur); echo '</pre>'; ?></h1>
</body>
</html>