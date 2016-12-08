<?php
// connexion BDD
$mysqli = new mysqli("localhost", "root", "", "entreprise"); 
//TEST// echo '<pre>'; var_dump($mysqli); echo '</pre>';
echo $mysqli->error . '<br />';// affichage dernière erreur de requete SQL

$requete = "";
$bdd_selection = "";
$resultat = "";
$colonne = "";
$choix_bdd = "";
$elt = "";


//fonction pour les requetes mysql
function lance_requete($requete)
{
  global $mysqli; // on réupère la variable représentant la connexion BDD depuis le script global
  $resultat = $mysqli->query($requete); // on exécute la requete reçue en argument
  /*if(!$resultat) // si cela renvoie false, c'est qu'il y a une erreur
  {
    die ("Erreur sur la requete: " . $requete . "<br />Message : " . $mysqli->error . '<hr />'); // die créé une erreur fatale et entre () on lui demande le détail de l'erreur // si la requete échoue, die + affichage de l'erreur
  }*/
  return $resultat; // on retourne le résultat de la requete
}

// CHOIX BDD
$recup_bdd = lance_requete("SHOW DATABASES");
//TEST// echo '<pre>'; var_dump($recup_bdd); echo '</pre>';
//requete qui récupère les catégories de la BDD
while($base_d_d = $recup_bdd->fetch_assoc()) 
{
  if (isset($_POST['bdd_selection']) && $_POST['bdd_selection'] == $base_d_d['Database']) {
    $choix_bdd .= '<option selected="selected">' . $base_d_d['Database'] . '</option>';
  } else 
  {
    $choix_bdd .= '<option>' . $base_d_d['Database'] . '</option>';
  }
}

if(!empty($_POST['bdd_selection']))
{
  if($_POST['bdd_selection'] != 'toutes')
  {
    $elt = ($_POST['bdd_selection']);
    mysqli_select_db($mysqli, $elt);
    //TEST = true// var_dump(mysqli_select_db($mysqli, $elt));
  }
}

//TEST// echo '<pre>'; var_dump($_POST); echo '</pre>';
if (isset($_POST['requete']) && ($_POST['bdd_selection'] != 'toutes')) // si la zone du formulaire contient une saisie, récupérer la saisie et que la BDD a été sélectionnée
{
  //TEST// echo $_POST['requete'];
  extract($_POST); // créer une variable pour chaque indice du tableau. Ici nous aurons donc 2 variables: $requete, $envoi_requete - l'intérêt ici est uniquement en termes de saisie
  $requete = htmlentities($requete, ENT_NOQUOTES);
  $resultat = lance_requete($requete);
  //TEST// echo '<pre>'; var_dump($resultat); echo '</pre>';

  // affichage de messages OK ou erreur sur la requête saisie
  if (isset($resultat->num_rows)) {
    echo '<div style="padding: 10px; background-color: teal; color: white; text-align: center;">Votre requête ' . $requete . ' a réussi</div>';
  } else
  {
  echo '<div style="padding: 10px; background-color: #DC7575; color: white; text-align: center;">Votre requête ' . $requete . ' est incomplète ou contient une erreur de syntaxe : ' . $mysqli->error . '</div>';
  }

} 


?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Evaluation du 161123</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

  </head>
  <body>
    <div class="container">
    <h1 style="text-align: center;">Lance-Requête</h1>
    <h3 style="text-align: center;">...PHP / MySQL...</h3>

    <!-- DEBUT FORMULAIRE -->
    <form method="post" action="">

      <div class="form-group">
            <label for="requete">Requête</label>
            <textarea class="form-control" id="requete" name="requete" placeholder="Requête" style="height: 100px";><?php echo $requete ?></textarea><br />
      </div>
      <div class="form-group">
        <label for="bdd_selection">Bases de données</label>
        <select name="bdd_selection" class="form-control" style="width: 49%; display: inline-block;">
          <option value="toutes">Toutes les BDD</option>
          <?php echo $choix_bdd; ?>
        </select>
      </div>
      <input type="submit" class="form-control btn btn-danger" name="envoi_requete" value="OK" />
    </form><hr />
  <!-- FIN FORMULAIRE -->

    <div class="panel panel-danger">
      <div class="panel-heading form-control">
        <h3 class="panel-title">Requêtes</h3>
      </div>
      <div class="panel-body">
      <?php
// AFFICHAGE DES REQUETES
// on teste si une requete existe par le fait qu'il y ait bien des lignes de résultat
      if (!empty($resultat->num_rows)) 
      {
        echo '<div class="panel panel-info">';
          echo '<div class="panel-heading">Informations sur votre requête</div>';
          echo '<div class="panel-body">BDD : ' . $elt . '  -  Lignes affectées : ' . $resultat->num_rows . '<br />Requête : ' . $requete . '</div>';
        echo '</div>';


        // affichage des tables de la BDD
        $tables_dispo = lance_requete("SHOW TABLES");
        //echo '<pre>'; var_dump($tables_dispo); echo '</pre>';
        echo '<div class="panel panel-success">';
          echo '<div class="panel-heading">Informations sur les Tables de la BDD ' . $elt . '</div>';
          echo '<div class="panel-body">';
          echo '<ul>';
        while ($toutes_tables = $tables_dispo->fetch_assoc()) {
        //echo '<pre>'; var_dump($toutes_tables); echo '</pre>';
        echo '<li>' . $toutes_tables['Tables_in_'.$elt] . '</li>';
        }
        echo '</ul>';
        echo '</div></div>';
        //echo '<div class="panel panel-primary">Les tables de la BDD : ' . $elt . '<br />sont : ' . $tables_dispo . '</div><br />';

        echo '<div class="panel panel-warning">'; 
          echo '<div class="panel-heading">Tableau des résultats de votre requête</div>';
            echo '<div class="panel-body">';   
            echo '<table class="table table-striped">';
              echo '<tr>'; // affichage des champs
              while($colonne = $resultat->fetch_field())
              {
                echo '<th>' . $colonne->name . '</th>'; //titres des colonnes
              }
              echo '</tr>';

              while($resultat_requete = $resultat->fetch_assoc())
              {
                echo '<tr>';
                foreach ($resultat_requete AS $valeur) {
                  echo '<td>' . $valeur . '</td>'; // remplissage des champs du tableau avec une boucle
                }
                echo '</tr>';
              }
            echo '</table></div>';// fermeture table et div panel-body
        echo '</div>';//fermeture div panel-warning
      } // fermeture du if




      ?>
      </div>
    </div> <!-- fermeture panel bootstrap -->
    </div> <!-- fermeture container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>