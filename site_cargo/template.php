<?php
require_once("inc/init.inc.php");



// affichages HTML (tout le reste du code doit venir avant)
include("inc/header.inc.php");
include("inc/nav.inc.php");

?>

    <div class="container">

      <div class="starter-template">
        <h1><span class="blueviolet glyphicon glyphicon-share"></span> Connect</h1>
        <?php echo $msg;  // variable initialisée dans le fichier init.inc.php
        ?> 
      </div>

    </div><!-- /.container -->

<?php
include("inc/footer.inc.php");
