<?php
// 1 - récupérer 5 images sur le web (pixabay)
// 2 - les renommer sous cette forme: image1.jpg image2.jpg...
// 3 - afficher une image avec un <img src ="" /> en HTML
// 4 - afficher 5 fois le même image toujours avec un seul <img src ="" /> (indice => afficher une boucle)
// 5 - afficher les 5 images toujours avec un seul <img src ="" /> (indice => une boucle + ...)

echo 'Exo 3 <br /> . <img src="../img/image1.jpg" width="480" height="320" />';
echo '<hr />';

echo 'Exo 4 <br />';
for($i = 0; $i < 5; $i++)
{
	echo '<img src="../img/image1.jpg" width="480" height="320" />';
}


echo '<hr />';
echo 'Exo 5 <br />';
for($i = 1; $i < 6; $i++)
{
	echo '<img src="../img/image' . $i . '.jpg" width="480" height="320" />';
}

// sans connaitre le nom des images
echo '<hr />';
echo 'Exo 6 <br />';
// fonction scandir() qui récupère tous les noms des fichiers se trouvant dans un dossier pour les placer dans un tableau ARRAY
$chemin = '../img/';
$tab = scandir($chemin);
echo '<pre>'; var_dump($tab); echo '</pre>';

foreach($tab AS $val) // on récupère le tableau plus les valeurs sans les indices 
{
	if(strlen($val) >= 5)
	{
		echo '<img src ="' . $chemin . $val . '" width="480" height="320" />';
	}
}

// voir aussi fonction prédéfinie glob();
// /!\ avec la fonction glob() l'extension des fichiers doit être définie, à l'inverse du tableau précédent
echo '<hr />';
$tab2 = glob("../img/*.jpg");
echo '<pre>'; var_dump($tab2); echo '</pre>';


foreach (glob("../img/*.jpg") as $filename) {
    echo "$filename occupe " . filesize($filename) . "<br />";
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>


</body>
</html>