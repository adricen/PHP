<?php
// après avoir enregistré des informations dans le fichier liste.txt via le script sur formulaire4.php nous allons récupérer les informations pour les traiter.

$f = fopen('liste.txt', 'a'); // permet d'éviter une erreur si le fichier n'existe pas (n'écrasera pas son contenu - voir sur formulaire4.php)

$fichier = "liste.txt"; 

$contenu = file($fichier); // file() est une fonction prédéfinie qui fait tout le travail pour nous. Cette fonction retourne chaque ligne d'un fichier dans un tableau Array !

echo '<pre>'; var_dump($contenu); echo '</pre>';

echo '<hr />';
echo 'FOREACH' . '<ul>';
foreach($contenu AS $ind => $val)
{
	echo '<li>' . 'Pseudo et email indice : ' . $ind . ' est ' . $val . '</li>';
}
echo '</ul><hr />';

fclose($f);
// unlink(liste.txt');

echo 'IMPLODE' . '<br />';
echo implode($contenu, '<br />'); // implode retourne chaque élément d'un tableau array avec un séparateur fourni en 2ème argument.

// inverse de implode => explode permet de couper une chaine de caractère avec un séparateur
echo 'EXPLODE' . '<br />';
$texte = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis egestas lorem et sapien dignissim pellentesque. Nullam varius tortor eu massa dignissim fermentum. In ut felis et lacus egestas hendrerit id et diam. Cras vulputate, tortor vitae aliquet vehicula, ante tellus dictum arcu, at aliquet erat mi non urna. Donec commodo quis enim ac faucibus. Duis euismod imperdiet metus at rhoncus. Nulla ipsum urna, pulvinar nec commodo in, ultricies nec urna. Vestibulum nibh diam, blandit ut ante non, cursus efficitur purus. Vivamus sapien nulla, vestibulum a mattis vitae, feugiat ac nisi. Integer porta porttitor lacus et rhoncus. Nam bibendum sollicitudin magna tristique sodales. Duis at justo nulla. Nunc mollis diam eget placerat tempus";

$montableau = explode('.', $texte);

echo '<pre>'; var_dump($montableau); echo '<pre>';






?>