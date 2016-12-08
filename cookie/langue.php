<?php
//chaque session est liée aux cookies qui sont propres à chaque navigateur
//cookie : nom - valeur associée - durée de vie (basée sur le timestamp = nb secondes écoulées depuis 01/01/1970)

// /!\ PAS D'AFFICHAGE HTML (echo...) AVANT DE GENERER LES COOKIES sinon on aura une erreur

// pour rappel dans une condition IF un seul cas est possible
if(isset($_GET['langue'])) // si l'utilisateur a cliqué sur un des liens proposés
{
	$pays = $_GET['langue'];
}
elseif(isset($_COOKIE['pays'])) // on ne met le cookie en 2nd dans le IF pour tenir compte du choix de l'utilisateur. Att si on le met en 1er dans le IF l'utilisateur ne pourra plus changer de langue // que l'utilisateur ait cliqué ou non quand il revient sur le site c'est le elseif qui primera puisqu'un cookie aura été généré à la 1ère visite
{
	$pays = $_COOKIE['pays'];
}
else // cas par défaut - jamais venu sur le site ou pas cliqué sur choix de la langue
{
	$pays = 'fr';
}

$un_an = 365*24*3600; // nombre de secondes dans une année

// pour créer un cookie => 3 informations: son nom / sa valeur / sa durée de vie (basée sur le timestamp)

setCookie("pays", $pays, time()+$un_an);
// /!\ la fonction setCookie() doit être exécutée avant tout code HTML
// si on met que 2 valeurs (pas de durée de vie) le cookie sera supprimé à la fermeture de la page

/*echo '<pre>'; var_dump($_SERVER); echo '</pre>';*/
// il est possible de récuprer la langue du navigateur
echo $_SERVER['HTTP_ACCEPT_LANGUAGE'] . '<br />';
// les 2 premières lettres dans le navigateur sont toujours le code langue
echo substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . '<br />';

echo time() . '<hr />';

?>
<meta charset="utf-8" />
<h1>Votre langue:</h1>
<?php
	switch ($pays) {
		case 'fr':
			echo '<p>Bonjour,<br /> vous consultez actuellement le site en langue française</p>';
			break;
		case 'es':
			echo '<p>Holà,<br /> vous consultez actuellement le site en langue espagnole</p>';
			break;
		case 'it':
			echo '<p>Bongiorno,<br /> vous consultez actuellement le site en langue italien</p>';
			break;
		case 'en':
			echo '<p>Hello,<br /> vous consultez actuellement le site en langue anglaise</p>';
			break;
	}

?>
<ul>
	<li><a href="?langue=fr">France</a></li>
	<li><a href="?langue=es">Espagne</a></li>
	<li><a href="?langue=it">Italie</a></li>
	<li><a href="?langue=en">Angleterre</a></li>
</ul>











