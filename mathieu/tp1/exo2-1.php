<?php

// echo '<pre>'; var_dump($_POST); echo '</pre>';

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<style>
			* { font-family: arial, sans-serif; }
			h1 { background-color: Teal; color: white; padding: 10px; }
			li a { text-decoration: none; color: SlateBlue; }
			li a:hover { text-decoration: underline; color: fuchsia; }
			span { color: teal; font-size: 28px; font-style: italic; }
		</style>
	</head>
	
	<body>
		<h1>Choississez votre langue</h1>
		<ul>
			<li><a href="?choix=fr">France</a></li>
			<li><a href="?choix=es">Espagne</a></li>
			<li><a href="?choix=it">Italie</a></li>
			<li><a href="?choix=en">Angleterre</a></li>
		</ul>
		<hr />
		<?php
			if(isset($_GET['choix']))
			{
				switch($_GET['choix'])
				{
					case 'fr':
						echo '<span>Vous êtes Français \o/</span>';
					break;
					case 'es':
						echo '<span>Vous êtes Espagnol \o/</span>';
					break;
					case 'it':
						echo '<span>Vous êtes Italien \o/</span>';
					break;
					case 'en':
						echo '<span>Sorry, vous êtes Anglais :-(</span>';
					break;
					default:
						echo '<span style="color: red;">Pays inconnu !</span>';
					break;
				}
			}
		?>
		

	</body>
</html>