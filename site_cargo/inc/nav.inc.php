
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Ma Boutique</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php echo active(URL . 'boutique.php'); ?> ><a href="<?php echo URL; ?>boutique.php">Boutique</a></li>
            <li <?php echo active(URL . 'panier.php'); ?> ><a href="<?php echo URL; ?>panier.php">Panier</a></li>
            <?php
          if (utilisateur_est_connecte())
          {// menu connecté
            echo '
            <li' . active(URL . 'profil.php') . '><a href="' . URL . 'profil.php">Profil</a></li>
            <li><a href="' . URL . 'connexion.php?action=deconnexion">Déconnexion</a></li>';
          }
          else
          {// menu anonyme
            echo '
            <li' . active(URL . 'connexion.php') . '><a href="' . URL . 'connexion.php">Connexion</a></li>
            <li' . active(URL . 'inscription.php') . '><a href="' . URL . 'inscription.php">Inscription</a></li>';
          }

          if(utilisateur_est_connecte_et_est_admin())
          {// menu admin
            echo '
            <li' . active(URL . 'admin/gestion_boutique.php') . '><a href="' . URL . 'admin/gestion_boutique.php">Gestion boutique</a></li>
            <li' . active(URL . 'admin/gestion_membres.php') . '><a href="' . URL . 'admin/gestion_membres.php">Gestion membres</a></li>
            <li' . active(URL . 'admin/gestion_commandes.php') . '><a href="' . URL . 'admin/gestion_commandes.php">Gestion commandes</a></li>';
          }

      


            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    