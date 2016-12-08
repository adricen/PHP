
<meta charset="utf-8">
<style>
	* { font-family: arial, sans-serif; }
	h2 { color: white; padding: 10px; background-color: darkslategray; }
	h4 { color: white; padding: 5px; background-color: navy; }
	h5 { color: white; padding: 5px; background-color: darkred; }
</style>

<h2>I- Ecriture et Affichage</h2>
<!-- 161103 -->
<!-- Il est tout à fait possible d'écrire du html dans un fichier .php / L'inverse n'est pas possible : le html ne passe pas par l'interpréteur php-->

<!-- Balise PHP
ouverture et fermeture -->
<?php //écriture PHP ?>
<!-- quand on écrit QUE du PHP on conseille de ne pas fermer la balise PHP -->
<!-- pas de retour à la ligne ni de prise en charge des espaces dans PHP -->
<!-- php est sensible à la casse -->
<!-- sql est sensible à la casse pour les noms des champs MAIS PAS POUR LES VALEURS -->

<?php
// Instructions d'affichage
// Variables ; type - déclaration -affectation de valeur
// Concaténation avec le .
// Guillemets & apostrophes (double quotes & quotes)
// Constantes
//! Conditions & opérateurs
// Fonctions prédéfinies (éléments du langage déjà existants)
// Fonctions utilisateurs (fonctions déclarées par l'utilisateur et exécutées par l'utilisateur)
//! Boucles
// Inclusions
//! Array (tableaux)
// Classes & objets

echo 'Bonjour';
// quotes ou guillemets obligatoires pour les chaines de caractères
// echo est une instruction du langage permettant de faire un affichage.
echo '<br />'; // il est possible d'écrire du html
// chaque instruction se termine par un ;
// quand on a un message d'erreur dans le navigateur c'est dans 99% du temps un "unexpected" qui renvoie à la ligne x pour signaler que la ligne précédente ne contient pas de ; ce qui est une erreur fatale en PHP
echo "My gwenyff dypinn o kill a drews<br />";

print 'Bienvenue'; // print est une autre instruction d'affichage similaire à echo
// il y a cpdt des différences => print a plus une approche de fonction on lui fait afficher un argument et il ne peut en avoir qu'un seul
// http://www.zpmag.com/articles/echo.html pour se faire une idée

echo '<h2>II- Commentaires</h2>';
// ceci est un commentaire sur une seule ligne
# ceci est un commentaire sur une seule ligne
/* ceci est un commentaire sur plusieurs lignes 
comme en CSS
pour débugger très pratique */

echo '<h2>III- Variables : Types, déclaration et affectation</h2>';
//une variable est un espace mémoire nommé permettant de conserver une valeur
// en PHP déclaration d'une variable avec le signe $ (en JS il faut utiliser var)
// il est possible d'utiliser les lettres, les chiffres et l'underscore 
// en revanche il n'est pas possible de commencer par un chiffre
// sensible à la casse

$a = 123; // affectation de la valeur 123 dans la variable "a"
echo gettype($a); //une fonction aura tjs des parenthèses car elle peut accepter un ou plusieurs arguments
// gettype() est une fonction prédéfinie nous renvoyant le type d'une valeur fournie en argument // ici => integer (valeur numérique entière)

$b = 1.5;
echo '<br />';
echo gettype($b); // en PHP un chiffre à virgule son type est "double"

$a = 'Une chaîne';
echo '<br />';
echo gettype($a); // chaine de caractères => "string"
// ici on a écrasé en ligne 63 le contenu de la variable "a" déclaré en ligne 55 comme un int/integer

$c = '123';
echo '<br />';
echo gettype($c);  // une valeur entre quotes ou guillemets reste une chaine de caractères => "string"

$d = true; // ou 'false'
echo '<br />';
echo gettype($d); // ici "boolean"
// valeur de true = 1 et false = 0


echo '<h2>IV- Concaténation</h2>'; // assembler des chaines de caractères
$prenom1 = "Marie";
$prenom1 = "Olivier";
echo $prenom1; // la 2nde variable écrase la 1ère
echo '<br />';

$prenom2 = "Marie "; //mettre l'espace dans la string
$prenom3 = "Olivier";
echo $prenom2 . $prenom3 . '<br />';
// ici le point de concaténation peut se traduire par "suivi de"
echo $prenom2 , $prenom3 , '<br />'; // il est possible d'utiliser la virgule au lien du point mais UNIQUEMENT avec echo ! ne fonctionne pas avec print !
// ==> rester sur le point

$prenom1 = "Marie ";
$prenom1 .= 'Olivier'; // équivaut à: $prenom1 = $prenom1 . 'Olivier';
// c'est une concaténation lors de l'affectation
echo $prenom1 . '<br />';

echo '<h2>V- Les guillemets & les quotes</h2>';
echo 'Aujourd\'hui<br />'; //l'anti-slash permet de ne pas tenir compte de l'apostrophe qui est sinon considéré comme une quote => caractère d'échappement
echo "Aujourd'hui<br />";

$text = "Bonjour";

echo $text . ' tout le monde<br />'; // concaténation
echo "$text tout le monde<br />"; // dans des guillemets une variable et est reconnue et interprétée en PHP
echo '$text tout le monde<br />'; // entre apostrophes, une variable n'est pas reconnue !!! le PHP n'y verra que du texte
// ==>> préférer le concaténation qui permet de lire facilement le code et d'éviter certaines erreurs

echo '<h2>VI- Constantes & constantes magiques</h2>';

// Une constante tout comme une variable permet de conserver une valeur. Sauf que comme son nom l'indique cette valeur restera constante et ne sera pas amenée à changer durant l'exécution du script.

echo "<h4>Constantes</h4>";
define("CAPITALE", "Paris"); // define() permet de déclarer des constantes : 1er argument: son nom - 2ème argument: sa valeur.
//par convention une constante s'écrit en majuscules pour le repérer dans le code - ATT c'est sensible à la casse !
// une constante ne peut pas changer pendant l'exécution du script

echo CAPITALE . '<br />'; // affichage du contenu de la constante

// ex d'erreur :
// $cap = "Paris";
// echo cap; //ici on aura une erreur car sans le $ PHP cherchera une constante

echo '<hr />';

echo "<h4>Constantes magiques</h4>";
// Constante magique:
echo __FILE__ . '<br />'; // Affiche le chemin d'accès depuis le serveur (ici local) jusqu'au fichier sur lequel on travaille
echo __LINE__ .'<br />'; // Affiche le numéro de la ligne

echo '<h2>EX1 - Exercice sur les variables</h2>';
// afficher la chaine: Bleu - Blanc - Rouge en mettant chaque couleur une variable et en l'affichant via un seul echo.
echo "<h5>EXERCICE</h5>";
$couleur1 = "Bleu";
$couleur2 = "Blanc";
$couleur3 = "Rouge";
echo $couleur1 . ' - ' . $couleur2 . ' - ' . $couleur3 . '<br />';

echo '<h2>opérateurs arithmétiques</h2>';
$x = 10; $y = 2; $z = 3;

echo $x + $y . '<br />'; // affiche 12
echo $x - $y . '<br />'; // affiche 8
echo $x * $y . '<br />'; // affiche 20
echo $x / $y . '<br />'; // affiche 5
echo $x % $z . '<br />'; // affiche 1 => % est le signe du modulo (le restant de l'opération: 10/3 il reste 1)

// opération lors de l'affectation
$x += $y; // équivaut à $x = $x + $y;
// on peut utiliser ce raccourci pour tous les opérateurs

echo '<h2>VII- Les structures conditionnelles (if/elseif/else) & opérateurs de comparaisons</h2>';
//ATT pas d'espace entre 'else' et 'if' dans 'elseif' en PHP

// empty & isset
echo "<h4>Empty & Isset</h4>";
// empty permet de vérifier si l'élément est vide - un espace n'est pas vide mais "" est vide de même que 0 et false (car false = 0)
// isset permet de vérifier si l'élément existe (est défini)

$var1 = 0; // ou "" ou false
$var2 = ""; // chaîne de caractères vide MAIS elle existe

if (empty($var1)) //si la variable $var1 est vide
{
	echo 'La variable var1 est vide<br />'; // empty va tester si c'est vide, si c'est = à 0, si c'est false ou non définie
}

if(isset($var2))
{
	echo 'La variable var2 existe !<br />'; // isset va tester si la variable est existante
}

echo '<hr />';
// opérateurs de comparaisons
echo "<h4>Opérateurs de comparaisons - If/else</h4>";
$a = 10; $b = 5; $c = 2;

if($a > $b) // si la valeur de a est strictement supérieure à la valeur de b
{
	echo 'a est bien supérieur à b<br />';
}
else { // sinon => on ne met JAMAIS de condition car c'est le cas pas défaut
	echo "a n\'est pas supérieur à b<br />";
}

// AND ensemble de conditions
echo "<h4>AND ensemble de conditions</h4>";
echo "<h4>Opérateurs de comparaisons - AND ensemble de conditions</h4>";
if($a > $b && $b > $c)
{
	echo "OK pour les deux conditions !<br />";
}
else {
	echo "L\'une ou l\'autre ou les deux conditions sont fausses <br />";
}

// OR
echo "<h4>OR</h4>";
if($a == 9 || $b > $c)
{
	echo 'OK pour au moins une des deux conditions<br />';
}


// XOR
echo "<h4>XOR</h4>";
if($a == 10 XOR $b == 6)
{
	echo "OK condition exclusive: une seule des deux conditions est correcte<br />";
}

if($a == 8)
{
	echo "1 - a est égal à 8<br />";
}
elseif($a != 10)
{
	echo "2 - a est différent de 10<br />";
}
else {
	echo "3 - Les deux premières conditions sont fausses ! <br />";
}

/* 
==		est égal à
!=		est différent de
>=		supérieur ou égal
<=		inférieur ou égal
>		strictement supérieur
<		strictement inférieur
*/

$m = 1; // valeur 1 type integer
$n = '1'; // valeur 1 type string

if($m == $n) // == vérifie la valeur pas le type
{
	echo "OK c\'est la méme chose <br />";
}
// dans une condition on ne peut rentrer que dans un des cas de figures
// une fois qu'une des conditions est remplie on sort des accolades sans rentrer dans les cas suivants

if($m === $n) // === vérifie la valeur et le type
{
	echo "NON ce n\'est PAS la méme chose <br />";
}

/*
=	affectation
==	comparaison des valeurs
===	comparaison des valeurs et du type
*/

// autre façon d'écrire les conditions - façon dite ternaire
echo ($a == 10) ? 'a est égal à 10 <br />' : 'a n\'est pas égal à 10 <br />';
// le ? représente le if, les : représentent le else

echo '<h2>Conditions switch</h2>';
//if et switch sont identiques - le switch est plus rapide mais il faut connaître les cas à examiner à l'avance
// les 'case' représentent des cas différents dans lesquels nous pouvons potentiellement tomber.
$couleur = 'jaune';

switch ($couleur) { //teste la variable couleur
	case 'bleu':
		echo 'Vous aimez le bleu<br />';
		break;
	case 'rouge':
		echo 'Vous aimez le rouge<br />';
		break;
	case 'vert':
		echo "Vous aimez le vert<br />";
		break;
	default:
		echo "Vous n'aimez ni le bleu, ni le rouge, ni le vert<br \>";
		break;
}
// un seul cas possible => on ne rentrera jamais dans plus d'un seul cas

echo "<h5>EXERCICE</h5>";
//la même chose avec IF/ELSEIF/ELSE
if ($couleur == 'bleu') {
	echo "Vous aimez le bleu<br />";
}	elseif ($couleur == 'rouge') {
		echo "Vous aimez le rouge<br />";
}	elseif ($couleur == 'vert') {
		echo "Vous aimez le vert<br />";
}	else {
		echo "Vous n'aimez ni le bleu, ni le rouge, ni le vert<br />";
}

echo '<h2>VIII- Fonctions prédéfinies</h2>';
// une fonction prédéfinie permet de réaliser un traitement spécifique
// inscrite au langage, le développeur ne fait que l'exécuter
// une fonction prédéfinie ou non permet d'appliquer un traitement à partir du moment ou on va s'en servir plusieurs fois

echo "<b>Date du jour</b> <br />";
//echo date
echo time() . '<br />'; //nbre de secondes depuis 01/01/1970 (création de l'heure UNIX)
echo date("d/m/Y - H:i:s") . '<br />'; // voir la doc pour les différents token disponibles http://php.net/manual/fr/function.date.php


// convertir une date us en fr
$newDate = date("d-m-Y", strtotime('2020-01-15'));
echo $newDate . '<br />';

echo '<h2>VIII bis- Fonctions prédéfinies: traitement des chaines strpos / strlen / substr</h2>';


// strpos
echo "<h4>strpos</h4>";
// va chercher une occurence/position dans une chaine de caractères
// str => string - pos => position
// /!\ dans la position le 1er caractère à la position 0
$email = "mathieuquittard@evogue.fr";
echo strpos($email, "@") . '<br />';
// strpos() permet de chercher un caractère ou une chaine de caractères dans une autre chaine de caractères
// 1er argument: la chaine ou on doit chercher
// 2eme argument: ce que l'on chercher
// Valeurs de retour: 
//			succès => integer 
//			échec => false
//(si chaine de caractère c'est la position du 1er caractère de la chaine - si le caractère recherché existe à plusieurs endroits cest le 1er trouvé qui est retourné)

$email2 = "dfghjkl";
echo strpos($email2, "@") . '<br />'; // ici on n'affiche pas le false à l'écran
// pour voir le false, nous allons utiliser une instruction d'affichage amliorée: var_dump()
var_dump(strpos($email2, "@"));
echo '<br />';
// var_dump() est une fonction d'affichage => le echo est INUTILE !
// très utile pour le debuggage => il nous affiche la valeur de retour et son type - ici: 'bool(false)'


// strlen
echo "<h4>strlen</h4>";
$phrase = 'Lorem ipsum dolor sit amet';
echo strlen ($phrase) . '<br />';
$z = "€";
echo strlen ($z) . '<br />';
// strlen nous renvoie le nombre d'octets dans une chaine
// /:\ en UTF-8 un caractère peut valoir jusqu'à 6 octets

// pour l'UTF-8 et la prise en charge des caractères spéciaux, d'autres alternatives sont possibles:
$phrase2 = "là";
echo strlen($phrase2) . '<br />'; // affiche => 3 - Calcule la taille d'une chaîne en nombres d'octets plutôt que le nombre de caractères
echo mb_strlen($phrase2, "UTF-8") . '<br />'; // affiche => 2 - Retourne la taille d'une chaîne
echo iconv_strlen($phrase2, "UTF-8") . '<br />'; // affiche => 2 - Retourne le nombre de caractères d'une chaîne


// substr
echo "<h4>substr</h4>";
$texte = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus cupiditate laboriosam, sint. Accusantium cupiditate maiores error nulla ut quaerat placeat, eligendi consequuntur a aut culpa numquam veritatis quia fuga fugiat!";

echo substr($texte, 0, 14) . ' <a href="">... Lire la suite</a> ';
// 1er augument		chaine à couper
// 2ème argument 	position de départ
// 3ème argument 	nombre de caractères à renvoyer /!\ ce n'est pas la fin - le 3ème argument est facultatif et s'il n'est pas renseigné la sous-chaine retournée ira jusqu'à la fin

echo '<h2>IX- Fonctions utilisateur</h2>';
// fonction déclarée et exécutée par l'utilisateur !

function separation() // déclaration d'une fonction sans arguments
{
	echo '<hr /><hr /><hr />'; // instruction ici est echo donc afficher
}
separation(); // exécution de la fonction

// fonction avec arguments: les arguments sont des paramètres fournis à la fonction permettant de compléter ou modifier son comportement prévu.

function bonjour($qui) // ici l'argument est une variable de réception, puisqu'on ne connaîtra son contenu qu'au moment ou on exécute la fonction
{
	return 'Bonjour ' . $qui . '<br />';
	echo 'TEST<br />'; // cette ligne ne sera jamais exécutée
}
echo bonjour("Pseudo"); // avec un return, si l'on veut un affichage, il faudra mettre la fonction dans un echo

// /!\ quand on tombe sur un 'return' dans une fonction le programme sort tout de suite de la fonction et ne tient pas compte des instructions passées en-dessous du 'return' dans la fonction

// l'argument fourni peut être une variable :
$prenom = 'Mathieu';
echo bonjour($prenom);

//----------------
function calcul($valeur1, $valeur2)
{
	echo $valeur1 + $valeur2;
}
calcul(8, 54) + '<br />';
//----------------

//161104================================================================

// Appliquer la TVA sur une valeur
function applique_tva($nombre)
{
	$resultat = $nombre*1.2;
	return $resultat;
}
// dans une fonction on effectue un traitement
// pour rappel un return dans une fonction est exécuté comme la dernière instruction de la fonction donc ne rien mettre après
// /!\ dans une fonction avec des if/else on peut évidemment avoir plusieurs return mais dès que l'un sera exécuté on sortira de la fonction
// un return renvoie la fonction mais n'affiche rien

echo applique_tva(1000) . '<br />';
echo applique_tva(5000) . '<br />';
echo applique_tva(45443544) . '<br />';

echo "<h5>EXERCICE</h5>";
// EXERCICE améliorer cette fonction pour avoir plusieurs taux de TVA
function applique_tva_taux($prix, $vat)
{
	$prix_ttc = $prix * (($vat/100) + 1);
	return $prix_ttc;
}
echo applique_tva_taux(1000, 20) . '<br />';
echo applique_tva_taux(1000, 10) . '<br />';
echo applique_tva_taux(1000, 5.5) . '<br />';
echo applique_tva_taux(1000, 2.1) . '<br />';

function applique_tva_taux2($prix2, $vat2 = 20) // ici le 2eme argument ($vat2) est initialisé par défait. En effet, si on ne le fourni pas un deuxième argument alors sa valeur sera 20, si on fourni un deuxième argument alors $vat2 prendra la valeur de ce deuxième argument
{
	$prix_ttc2 = $prix2 * (($vat2/100) + 1);
	return $prix_ttc2;
}
echo applique_tva_taux2(1000) . '<br />';
echo applique_tva_taux2(1000, 10) . '<br />';
echo applique_tva_taux2(1000, 5.5) . '<br />';
echo applique_tva_taux2(1000, 2.1) . '<br />';

//---------------------------------- 
function meteo($saison, $temperature)
{
	echo 'Nous sommes en <span style = "color : darkgreen;">' . $saison . '</span> et il fait <span style = "color : red;">' . $temperature . '</span> degrés.<br />';
}
meteo('Hiver', 0);
meteo('Ete', 28);
meteo('Printemps', 14);
// la fonction contenant un echo on appelle la fonction sans remettre echo !!!
echo "<hr />";

echo "<h5>EXERCICE</h5>";
// EXERCICE: faire une fonction exo_meteo similaire à la fonction meteo mais ayant la prise en charge du pluriel de degré(s) et si l'on est au printemps il faut afficher "au" printemps.

function exo_meteo2($saison2, $temperature2)
{
	$en2 = 'en ';
	$sing = 's';
	if ($saison2 == 'printemps') {
		$en2 = 'au ';
	} 
	if (($temperature2 === 0) || ($temperature2 === -1) || ($temperature2 === 1)) {
		$sing = '';
	}
	echo 'Nous sommes ' . $en2 . $saison2 . ' et il fait ' . $temperature2 . ' degré' . $sing . '<br />';
}
exo_meteo2('hiver', 0);
exo_meteo2('été', 25);
exo_meteo2('printemps', 16);

function exo_meteo($saison1, $temperature1)
{
	$en = "en";
	$s = "s";

	if($saison1 == 'printemps') {
		$en = 'au';
	}
	if($temperature1 > -2 && $temperature1 < 2) {
		$s = "";
	}

	echo 'Nous sommes ' . $en .' <span style = "color : darkgreen;">' . $saison1 . '</span> et il fait <span style = "color : red;">' . $temperature1 . '</span> degré' . $s .'.<br />';
}
echo "<hr />";
exo_meteo('hiver', 0);
exo_meteo('été', 25);
exo_meteo('printemps', 16);
exo_meteo('hiver', -1);


//---------------------------
// /!\ PHP 7
// avec php 7 il est possible de préciser en amont le type attendu d'un argument (valeur de retour :
/*function identite(string $nom, int $age)
{
	return $nom . ' a ' . $age . ' ans.<br />';
}
echo identite('Mathieu', 40);*/


// avec php 7 il est possible de préciser en amont la valeur de retour :
/*function adulte(int $age) : bool 
{
	return $age >= 18;
}
var_dump(adulte(10));*/


//----------------------------
$pays = 'France';

function affichage_pays()
{
	global $pays; // le mot-clef global permet de récupérer une variable déclarée dans l'espace global (ici la variable pays) à l'intérieur de notre fonction ou nous sommes dans l'espace local
	echo 'Le pays est: ' . $pays . '<br />';
	$jour_semaine = 'vendredi'; // déclaration d'une variable dans l'espace local d'une fonction => impossible de l'appeler dans l'espace global A MOINS de la renvoyer via un RETURN
}
affichage_pays();
// echo $jour_semaine . '<br />'; // pas possible car on ne peut pas appeler une variable déclarée dans un espace local d'une focntion dans notre script (espace global)


echo '<h2>X- Structure itérative : les boucles</h2>';
// itération = incrémentation ou décrémentation

// WHILE
echo "<h4>Boucle WHILE</h4>";
// valeur de départ ($compteur)
// condition d'entrée dans la boucle
// comment incrémenter/décrémenter la boucle

/*$compteur = 0; // valeur de départ
while ($compteur < 5) // condition d'entrée dans la boucle : tant que la valeur de compteur est < 5
{
	echo $compteur . ' -- '; // /!\ si on oublie la ligne d'incrémentation on a une boucle infinie
	$compteur++; // équivaut à $compteur = $compteur + 1; // incrémentation ou décrémentation
}*/

$compteur = 0; // valeur de départ
while ($compteur < 5) // condition d'entrée dans la boucle : tant que la valeur de compteur est < 5
{
	if ($compteur == 4) 
	{
		echo $compteur . '<br />';
	} else {
		echo $compteur . ' -- ';
		}
	$compteur++; // équivaut à $compteur = $compteur + 1; // incrémentation ou décrémentation
}

// BOUCLE FOR
echo "<h4>Boucle FOR</h4>";
for($i = 0; $i < 10; $i++)
{
	print $i . '<br />';
}

// FORMULAIRE
echo "<h4>Formulaire</h4>";

echo "<form>";
echo "<select>";
/*for ($annee = 1930; $annee <= 2016 ; $annee++) 
{ 
	echo "<option>" . $annee . "</option>";
}*/ // classique
/*for ($annee = date("Y"); $annee >= 1930 ; $annee--) 
{ 
	echo "<option>" . $annee . "</option>";
}*/ // année en cours mais à chaque boucle le PC recherche à chaque fois l'année en cours donc code pas très optimisé
/*$annee_en_cours = date("Y");
for ($annee = $annee_en_cours; $annee >= 1930 ; $annee--) 
{ 
	echo "<option>" . $annee . "</option>";
}*/ // variable à l'extérieur qui optimise le code car l'année en cours n'est recherchée qu'une fois
$annee_en_cours = date("Y");
for ($annee = $annee_en_cours; $annee >= ($annee_en_cours - 100) ; $annee--) 
{ 
	echo "<option>" . $annee . "</option>";
} // code totalement dynamique il n'y aura pas de mise à jour pour les années
echo "</select>";
echo "</form>";

echo '<h2>XI- Mélange html / php</h2>';
// faire une boucle qui affiche de 0 à 9 sur une même ligne
for ($i = 0; $i < 10 ; $i++) 
{ 
	echo $i; 
}


echo "<h4>Tableau en html</h4>";

echo '<table border="1" style="border-collapse: collapse;">';
echo '<tr>'; // tr => row
for ($cases = 0; $cases < 10 ; $cases++)
{ 
	echo '<td>' . $cases . '</td>'; // td => data
}
echo '</tr>';
echo '</table>';

echo "<h5>EXERCICE</h5>";
// tableau de 10 lignes 
// dont chaque ligne contient 10 cellules
echo '<table border="1" style="border-collapse: collapse; color: fuchsia">';

$tours = 0;
for ($ligne = 0; $ligne < 10 ; $ligne++)
{
	echo '<tr>';
	for ($carre = 0; $carre < 10 ; $carre++)
	{ 
		echo '<td>' . $tours . '</td>'; // td => data
		$tours++;
	}
	echo '</tr>'; // tr => row
}

echo '</table>';
//-------------------------------------------
echo '<hr />';
echo "Le même avec un modulo";

echo '<table border="1" style="border-collapse: collapse; color: mediumslateblue">';

echo '<tr>';
for ($ligne1 = 0; $ligne1 < 100 ; $ligne1++)
{
	if ($ligne1 % 10 == 0)
	{
		echo '</tr><tr>'; // tr on ferme le rang en cours et on ouvre le suivant
	} 
	echo '<td>' . $ligne1 . '</td>'; // td => data
	
}
echo '</tr>'; // tr => row

echo '</table>';

//______________________________________________________________
echo '<h2>XII- Inclusion de fichier</h2>';
// créer un fichier exemple.inc.php dans le même dossier que celui-ci copier/coller du texte à l'intérieur

echo "<b>1er appel avec include:</b> <br />";
include('exemple.inc.php');
echo "<hr />";
echo "<b>2eme appel avec include_once:</b> <br />";
include_once('exemple.inc.php');
echo "<hr />";
echo "<b>3eme appel avec require:</b> <br />";
require('exemple.inc.php');
echo "<hr />";
echo "<b>4eme appel avec require_once:</b> <br />";
require_once('exemple.inc.php');

// include et require permettent d'appeler le contenu d'un fichier extérieur afin de le récupérer dans notre fichier en cours.
// avec un _once, on vérifie au préalable si le fichier a déjà été appelé. Si c'est le cas on ne le rappelle pas.
// différence entre include et require => dans le cas d'une erreur (sur le nom du fichier ou son chemin d'accès par exemple) include va provoquer une erreur mais le script va continuer à être exécuté. Avec require, dans le cas d'une erreur, l'exécution du script à la suite sera bloquée.

echo '<h2>XIII- Tableau de données ARRAY</h2>';
// un tableau est déclaré un peu comme une variable à la différence que l'on peut avoir un ensemble de valeurs au lieu d'une seule.
// un tableau array est un type de donnée comme les booleans, integer...

$tableau =  array("Grégoire", "Nathalie", "Georges", "Emilie", "François");
// déclaration d'un tableau array

// tableau array 
// toujours 2 colonnes pas plus, pas moins
// colonne 1 => indices
// colonne 2 => valeurs
// on peut imbriquer un tableau array dans un tableau array
// par défaut l'indice d'un tableau array démarre à 0
/*
		*************************
		*  INDICES	*  VALEURS	*
		*************************
		*			*			*
		*			*			*
		*************************
		*			*			*
		*			*			*
		*************************
		*			*			*
		*			*			*
		*************************	*/		

var_dump($tableau);
echo '<pre>'; var_dump($tableau); echo '</pre>';
// avec var_dump() nous pouvons voir tout le contenu d'un tableau array
// <pre></pre> est une balise html de formatage (meilleur affichage d'un tableau array)
echo '<pre>'; print_r($tableau); echo '</pre>';
// print_r est une autre instruction d'affichage améliorée ne fonctionne que sur un tableau
echo "<hr />";

$tableau =  array("Grégoire", "Nathalie", "Georges", "Emilie", "François", 123, true, false);
var_dump($tableau);
echo '<pre>'; var_dump($tableau); echo '</pre>';
echo '<pre>'; print_r($tableau); echo '</pre>';


echo '<h4>Boucle foreach pour les tableaux ARRAY</h4>';

// foreach est un moyen simple de parcourir un tableau ARRAY. Foreach fonctionne uniquement sur les array ou objets et renverra une erreur si nous tentons de l'utiliser sur une variable.

// autre moyen de déclarer un tableau array
$tab[] = "France"; // avec les crochets chaque ligne est un nouvel élément du tableau - sans donner de valeur à l'indice il est auto-incrémenté
$tab[] = "Espagne";
$tab[] = "Suisse";
$tab[] = "Italie";
$tab[] = "Portugal";

echo '<pre>'; var_dump($tab); echo '</pre>';

// extraire info depuis un tableau => on passe par l'indice via les crochets
// on ne paut pas afficher le tableau entier avec un echo
echo $tab[1] . '<br />';
echo '<hr />';

// une boucle foreach tourne autant de fois qu'il y a d'éléments dans notre tableau, c'est dynamique
foreach($tab AS $val) // le mot clé AS est obligatoire. A chaque tour de boucle $val récupère la valeur en cours
{
	echo $val . '<br />';
}
separation();
foreach($tab AS $ind => $val) // si l'on place deux variables aptès le mot clé AS, la première contient l'indice en cours, la deuxième contient la valeur en cours à chaque tour de boucle
{
	echo $ind . ' - ' . $val . '<br />';
}

// il est possible de choisir nous mêmes les indices du tableau
$tab_couleur = array('j' => 'jaune', 'b' => 'bleu', 'v' => 'violet' );
echo '<pre>'; var_dump($tab_couleur); echo '</pre>';

$tab_couleur['r'] = 'rose';
echo '<pre>'; var_dump($tab_couleur); echo '</pre>';

// pour connaitre la taille d'un tableau (nombre d'éléments):
echo "Taille du tableau avec count()" . count($tab_couleur) . '<br />';
echo "Taille du tableau avec sizeof()" . sizeof($tab_couleur) . '<br />';


// 161107

$taille = count($tab); // la variable à l'extérieur de la boucle n'est déclarée qu'une seule fois, si elle était dans le tableau elle serait recalculée à chaque tour de boucle
separation();
$tab = array();
$tab[] = "France"; // avec les crochets chaque ligne est un nouvel élément du tableau - sans donner de valeur à l'indice il est auto-incrémenté
$tab[] = "Espagne";
$tab[] = "Suisse";
$tab[] = "Italie";
$tab[] = "Portugal";
// pour une boucle FOR les indices sont numériques

echo "<ul>";
for($i = 0; $i < $taille ; $i++) 
{ 
	echo "<li>" . $i . " - " . $tab[$i] . "</li>";
}
echo "</ul>";


echo '<h2>XIV- Tableau ARRAY multidimensionnel</h2>';
// on parle de tableau array multidimensionnel quand un tableau est compris dans un autre tableau

// Utilité : dans un panier on a plusieurs valeurs pour chaque article (nom, prix, quantité, indice...)
// chaque produit correspondra à un seul tableau array

$tab_multi = array(
			0 => array('pseudo' => 'Audrey', 'email' => 'mail1@mail.fr', 'age' => 25), 
			1 => array('pseudo' => 'Georges', 'email' => 'mail2@mail.fr', 'age' => 42), 
			2 => array('pseudo' => 'Julien', 'email' => 'mail3@mail.fr', 'age' => 21));

echo '<pre>'; var_dump($tab_multi); echo '</pre>';
// pour appeler une information d'un sous tableau, il suffit de rajouter un niveau de crochets
echo $tab_multi[0]['email'] . '<br />';
echo $tab_multi[1]['pseudo'] . '<br />';
echo $tab_multi[2]['age'] . '<br />';


foreach($tab_multi[1] AS $val)
{
	echo '- ' . $val . '<br />';
}


//========= 161109

echo '<h2>XV- Objet</h2>';

// Un ARRAY est type de données, un OBJET est un autre type de données.
// Une variable conserve une valeur
// Un tableau Array conserve plusieurs valeurs
// Un objet va beaucoup plus loin car on peut y déclarer des fonctions (appelées méthodes de l'objet) et des variables (appelées ou attributs ou propriétés)
// Un objet est un espace mémoire qui contient ces informations

// Le modèle de construction d'un objet s'appelle class
class Etudiant // pas de () quand on déclare une class, mais on les mettre quand on les appelle
{
	public $prenom = "Georges"; // propriété - public permet de préciser que l'élément sera accessible depuis l'extérieur. (il existe aussi protected et private)
	public $age = 40; // propriété

	public function pays() // fonction/méthode
	{
		return 'France';
	}
}
// un objet est un conteneur symbolique qui possède sa propre existence et incorpore des informations (propriétés) et mécanismes (méthodes)
// pour instancier (générer) un objet on passe par la class avec le mot clé new
$objet = new Etudiant(); // new est un mot clé permettant d'instancier un objet depuis une class // on se sert de ce qui est dans la class via l'objet.
$objet2 = new Etudiant();

echo '<pre>'; var_dump($objet); echo '</pre>';
echo '<pre>'; var_dump(get_class_methods($objet)); echo '</pre>'; // pour voir les méthodes dans un objet
echo '<pre>'; var_dump($objet2); echo '</pre>';

echo $objet -> prenom . '<br />'; // pour appeler une propriété de l'objet
echo $objet->age . '<br />';

echo $objet->pays() . '<br />'; // pour appeler une méthode de l'objet


// http://php.net/manual/fr/class.mysqli.php
















