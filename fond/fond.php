<?php
$code_couleur = rand(100000, 999999); // rand() <=> random()
// rand() est une focntion prédéfinie permettant de récupérer une valeur aléatoire contenue entre deux entiers


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		body {background-color: #<?php echo $code_couleur; ?>;} /* // /!\ pas d'espace entre le # de la couleur et l'encodage PHP */
	</style>
</head>

<body>

</body>
</html>