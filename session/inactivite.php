<?php
session_start(); // lance une session

echo'<h3>Temps actuel: ' . time() . '</h3>';

echo '<pre>'; var_dump($_SESSION); echo '</pre>';

if(!isset($_SESSION['temps'])) // si l'indice temps n'existe pas
{
	$_SESSION['temps'] = time();	// la valeur actuelle du timestamp
	$_SESSION['limite'] = 10; // on met en place une limite en secondes
	echo '<h1>Connexion</h1>';
}
else // l'indice temps existe dans la session
{
	// on vérifie si le temps actuel (timestamp) est supérieur au temps enregistré +  la limite
	if(time() > $_SESSION['temps'] + $_SESSION['limite'])
	{
		session_destroy(); // si le timestamp est supérieur alors on détruit la session
		echo '<h1>Déconnexion</h1>';
	}	
	else // l'utilisateur n'a pas dépassé la limite de temps
	{
		$_SESSION['temps'] = time(); // on met à jour le temps actuel
		echo '<h1>Connexion mise à jour</h1>';
	}
	

}	
