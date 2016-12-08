<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<style>
			* { font-family: arial, sans-serif; }
			h1 { background-color: DodgerBlue; color: white; padding: 10px; }	
			fieldset { width: 500px; margin: 0 auto; border: 1px solid dodgerblue; text-align: center;}
			legend { color: dodgerblue; font-size: 28px; font-style: italic; }
			span { color: red; font-size: 28px; font-style: italic; }
		</style>
	</head>
	
	<body>
		<h1>Formulaire calculatrice</h1>
		<form method="post" action="">
			<fieldset>
				<legend>Calculatrice</legend>
				<input type="text" name="valeur1" />
				<select name="operateur">
					<option>+</option>
					<option>-</option>
					<option>*</option>
					<option>/</option>
					<option>%</option>
				<select>
				<input type="text" name="valeur2" />
				<input type="submit" name="calculer" value="Calculer" />
			</fieldset>
		</form>
		<hr />
		<?php
		if(isset($_POST['valeur1']) && isset($_POST['operateur']) && isset($_POST['valeur2']))
		{
			extract($_POST);
			$operation = "$valeur1 $operateur $valeur2";
			switch($operateur)
			{
				case '+':
					$resultat = $valeur1 + $valeur2;
				break;
				case '-':
					$resultat = $valeur1 - $valeur2;
				break;
				case '*':
					$resultat = $valeur1 * $valeur2;
				break;
				case '/':
					$resultat = $valeur1 / $valeur2;
				break;
				case '%':
					$resultat = $valeur1 % $valeur2;
				break;
				default:
					$resultat = '<span>Attention, une erreur est survenue, veuillez recommencer !</span>';
				break;
			}
		?>
			<fieldset>
				<legend>Résultat</legend>
				<?= 'Opération: ' . $operation . '<br />Résultat: <span>' . $resultat . '</span>'; ?>				
			</fieldset>
			<script>
				alert("<?= 'Opération: ' . $operation; ?>");
				alert("<?= 'Résultat: ' . $resultat; ?>");
			</script>
		<?php
		}
		?>
	</body>
</html>