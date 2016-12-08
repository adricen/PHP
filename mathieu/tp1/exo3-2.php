<?php

// echo '<pre>'; var_dump($_POST); echo '</pre>';
$contenu = "";
for($i = 1; $i <= 100; $i++)
{
	if($i == 50)
	{
		$contenu .= ' <span>' . $i . '</span>';
	}else {
		$contenu .= ' ' . $i;
	}
	
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<style>
			* { font-family: arial, sans-serif; }
			h1 { background-color: DodgerBlue; color: white; padding: 10px; }			
			span { color: red; font-size: 28px; font-style: italic; }
		</style>
	</head>
	
	<body>
		<h1>Afficher 1 à 100 avec le chiffre 50 de couleur rouge</h1>

		<?php 
			echo $contenu;
		?>
		

	</body>
</html>