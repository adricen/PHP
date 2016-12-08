<?php
// la session est côté serveur (le cookie est sur le PC utilisateur) et d'office créé un cookie sur le poste utilisateur avec un identifiant qui correspond au fichier de session créé côté serveur pour reconnaître l'utilisateur
// c'est dans la session que sont enregistrées les données utilisateur (on ne se reconnecte pas d'une page à l'autre quand on navigue sur le site)
// quand on demande une déconnexion les cookies de la session sont effacés

session_start(); // fonction qui créé une session ou l'ouvre si déjà existante mais sans l'écraser
//$_SESSION est une superglobale de type array

$_SESSION['pseudo'] = 'Monpseudo'; // $_SESSION étant un tableau ARRAY comme toutes les superglobales, il est possible de créer des indices à l'intérieur
$_SESSION['mdp'] = 'password';
$_SESSION['email'] = 'mail@mail.fr';

echo '<hr />1er var_dump: ';
echo '<pre>', var_dump($_SESSION); echo '</pre>';

unset($_SESSION['mdp']); // nous pouvons supprimer un élément de la session
// /!\ si on ne donne pas d'indice -unset($_SESSION)- on supprime toute la session
// unset($_SESSION); s'éxécute là où il est dans le script

echo '<hr />2ème var_dump: ';
echo '<pre>', var_dump($_SESSION); echo '</pre>';

echo $_SESSION['pseudo'] . '<br />';

// session_destroy(); // pour détruire une session - ne sera exécuté que à la fin du script // suppression de la session, en revanche il faut savoir que session_destroy ne sera exécuté qu'à la fin du script. Les lignes suivantes afficheront toujours les informationds der la session et ensuite elle sera supprimée/
// pour une suppression immédiate: unset($_SESSION);

echo '<hr />3ème var_dump: ';
echo '<pre>', var_dump($_SESSION); echo '</pre>';






