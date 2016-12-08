--- Création d'une BDD : tic_identification

CREATE TABLE utilisateur (
  id_utilisateur int(11) NOT NULL AUTO_INCREMENT,
  pseudo varchar(255) NOT NULL,
  mdp varchar(255) NOT NULL,
  nom varchar(20) NOT NULL,
  prenom varchar(20) NOT NULL,
  email varchar(30) NOT NULL,
  PRIMARY KEY (id_utilisateur),
  UNIQUE KEY pseudo (pseudo)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


INSERT INTO utilisateur (id_utilisateur, pseudo, mdp, nom, prenom, email) VALUES
(1, 'julien', 'soleil', 'Cottet', 'julien', 'contact@julien.com'),
(2, 'marie', 'planete', 'aaa', 'aaa', 'aaa'),
(3, 'laurence', 'mars1980', 'bbb', 'bbb', 'bbb');