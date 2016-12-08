<?php
require_once("inc/init.inc.php");

$pseudo = "";
$mdp = "";
$nom = "";
$prenom = "";
$email = "";
$sexe = "f";
$adresse = "";
$cp = "";
$ville = "";

if(isset($_POST['pseudo']) && isset($_POST['mdp']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['sexe']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['ville']))
{
  extract($_POST); // transforme chaque indice du tableau array en variable qui contient la valeur correspondante
  // fair un controle sur la taille du pseudo (entre 4 et 14 caractères)
  // echo 'TEST';
  if(strlen($pseudo) < 4 || strlen($pseudo) > 14)// si erreur de taille sur le pseudo
  {
    $msg .= '<div class="erreur">Erreur sur la taille du pseudo:<br />Le pseudo doit contenir entre 4 et 14 caractères (inclus).</div>';
  }

  // expression régulière - on défini les cractères qu'on n'accepte pas
  if(!preg_match('#^[a-zA-Z0-9.ç_-]+$#', $pseudo))
  {
    /*
    les signes # indiquent le début et la fin de l'expression régulière
    le ^ indique le début de la chaine, sinon la chaine pourrait commencer par autre chose
    le $ indique la fin de la chaine, sinon la chaine pourrait finir par autre chose
    le + indique qu'on peyt retrouver plusieurs fois le même caractère, sinon on ne pourrait le trouver qu'une seule fois

    preg_match() renvoie false si un caractère non autorisé par l'expression régulière se trouve dans la chaine testée (ici $pseudo)
    */
    $msg .= '<div class="erreur">Erreur sur le pseudo:<br />Caractères autorisés: de a - z et de 0 - 9.</div>';
  }

  // on protège les saisies contre les injections de code
  $pseudo = htmlentities($pseudo, ENT_QUOTES);
  $mdp = htmlentities($mdp, ENT_QUOTES);
  $nom = htmlentities($nom, ENT_QUOTES);
  $prenom = htmlentities($prenom, ENT_QUOTES);
  $email = htmlentities($email, ENT_QUOTES);
  $sexe = htmlentities($sexe, ENT_QUOTES);
  $adresse = htmlentities($adresse, ENT_QUOTES);
  $cp = htmlentities($cp, ENT_QUOTES);
  $ville = htmlentities($ville, ENT_QUOTES);

  // avant l'enregistrement en BDD on vérifie que le pseudo est unique (cf modélisation BDD ou le pseudo est unique)
  $controle_pseudo = execute_requete("SELECT * FROM membre WHERE pseudo='$pseudo'");

  if($controle_pseudo->num_rows >= 1) // s'il y a au moins une ligne affectée par la requete le pseudo existe déjà
  {
    $msg .= '<div class="erreur">Erreur sur le pseudo:<br />Pseudo indisponible.</div>';
  }

  // validation et inscription en BDD
  if(empty($msg)) // s'il n'y a pas de message d'erreur ($msg est vide) on peut lancer l'inscription
  {
    // $mdp = password_hash($mdp, PASSWORD_DEFAULT); // cryptage du mdp
    execute_requete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, sexe, adresse, cp, ville) VALUES ('$pseudo', '$mdp', '$nom', '$prenom', '$email', '$sexe', '$adresse', '$cp', '$ville')");

    // à l'enregistrement du formulaire en BDD on redirige l'utilisateur sur une autre page
    // pas de HTML avant
    header("location:connexion.php"); // 
    // $msg .= '<div class="succes">Inscription OK.</div>';
  }

  /*else
  {
    $msg .= '<div class="succes">Votre Pseudo est : ' . $pseudo . '</div>';
  }*/
}



// affichages HTML (tout le reste du code -les traitements- doit venir avant)
include("inc/header.inc.php");
include("inc/nav.inc.php");

?>

    <div class="container">
      <div class="starter-template">
        <h1><span class="blueviolet glyphicon glyphicon-share"></span> Inscription</h1>
        <?php echo $msg; // variable initialisée dans le fichier init.inc.php
        ?>
      </div>
  
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
        <?php
        

        //debug($_POST); // vérification des informations provenant du formulaire
        ?>
          <form method="post" action="">
              <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" id="pseudo"  placeholder="Pseudo" name="pseudo" value="<?php 
                  if(isset($_POST['pseudo']))
                  {
                    echo $_POST['pseudo'];
                  }
                ?>" />
              </div>
              <div class="form-group">
                <label for="mdp">Mot de Passe</label>
                <input type="text" class="form-control" id="mdp"  placeholder="Mot de passe" name="mdp" value="<?php 
                  if(isset($_POST['mdp']))
                  {
                    echo $_POST['mdp'];
                  }
                ?>" />
              </div>
              <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom"  placeholder="Nom" name="nom" value="<?php 
                  if(isset($_POST['nom']))
                  {
                    echo $_POST['nom'];
                  }
                ?>" />
              </div>
              <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom"  placeholder="Prénom" name="prenom" value="<?php 
                  if(isset($_POST['prenom']))
                  {
                    echo $_POST['prenom'];
                  }
                ?>" />
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" id="email"  placeholder="E-mail" name="email" value="<?php 
                  if(isset($_POST['email']))
                  {
                    echo $_POST['email'];
                  }
                ?>" />
              </div>
              <div class="radio">
                <label class="radio-inline">
                <input type="radio" name="sexe" value="h" 
                <?php 
                if ($sexe == 'h') 
                {
                  echo 'checked';
                }  
                ?>
                > Homme
                </label>
                <label class="radio-inline">
                <input type="radio" name="sexe" value="f"
                <?php
                if ($sexe == 'f')
                {
                  echo 'checked';
                }
                ?>  
                > <i class="fa fa-female fa-x3" aria-hidden="true"></i>
                </label>
              </div>
              <div class="form-group">
                <label for="adresse">Adresse</label>
                <textarea type="text" class="form-control" id="adresse"  placeholder="Adresse" name="adresse"><?php 
                  if(isset($_POST['adresse']))
                  {
                    echo $_POST['adresse'];
                  }
                ?></textarea>
              </div>
              <div class="form-group">
                <label for="ville">Ville</label>
                <input type="text" class="form-control" id="ville"  placeholder="Ville" name="ville" value="<?php 
                  if(isset($_POST['ville']))
                  {
                    echo $_POST['ville'];
                  }
                ?>" />
              </div>
              <div class="form-group">
                <label for="cp">Code Postal</label>
                <input type="text" class="form-control" id="cp"  placeholder="Code Postal" name="cp" value="<?php 
                  if(isset($_POST['cp']))
                  {
                    echo $_POST['cp'];
                  }
                ?>" />
              </div>

              <hr />

              <input type="submit" class="form-control btn btn-warning" id="inscription" name="inscription" value="Inscription" />
          </form>
        </div>      
      </div>



    </div><!-- /.container -->

<?php
include("inc/footer.inc.php");
