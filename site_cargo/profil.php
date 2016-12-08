<?php
  require_once("inc/init.inc.php");
  if(!utilisateur_est_connecte()) // différent de => je rentre dans cette condition si la fonction me renvoie false
  {
    header("location:connexion.php");
    exit();
  }
  // Faire un affichage de toutes les informations de l'utilisateur.
  // mettre en forme la page


  include("inc/header.inc.php");
  include("inc/nav.inc.php");
?>

    <div class="container">

      <div class="starter-template">
        <h1><span class="glyphicon glyphicon-map-marker"></span> Bonjour <?php echo $_SESSION["utilisateur"]["prenom"]; ?></h1>
       <!--  <?php echo $msg; debug($_SESSION); // variable initialisée dans init.inc.php, qui permettra d'afficher les messages d'erreur ?> -->
      </div>

      <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
          <div class="panel panel-primary">
            <div class="panel-heading">Profil</div>
            <div class="panel-body">
              <div class="col-sm-6">
                <p><span class="info-profil">Pseudo :</span>
                <?php echo $_SESSION['utilisateur']['pseudo']; ?></p>
                <p><span class="info-profil">Prénom :</span>
                <?php echo $_SESSION['utilisateur']['prenom']; ?></p>
                <p><span class="info-profil">Nom :</span>
                <?php echo $_SESSION['utilisateur']['nom']; ?></p>
                <p><span class="info-profil">Email :</span>
                <?php echo $_SESSION['utilisateur']['email']; ?></p>
                <p><span class="info-profil">Sexe :</span>
                <?php echo $_SESSION['utilisateur']['sexe']; ?></p>
                <p><span class="info-profil">Adresse :</span>
                <?php echo $_SESSION['utilisateur']['adresse']; ?></p>
                <p><span class="info-profil">Code Postal :</span>
                <?php echo $_SESSION['utilisateur']['cp']; ?></p>
                <p><span class="info-profil">Ville :</span>
                <?php echo $_SESSION['utilisateur']['ville']; ?></p>
              </div>
              <div class="col-sm-6">
                <img src="img/profil.png" class="img-responsive" alt="image profil" />
                <?php if (utilisateur_est_connecte_et_est_admin()) 
                  {
                    /*echo '<p style="text-align: center; color: #428bca; margin-top: 10px;">Vous êtes administrateur</p>';*/
                    echo '<span class="label label-danger">Vous etes administrateur</span>';
                  } ?>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container -->

<?php
  include("inc/footer.inc.php");

  
?>