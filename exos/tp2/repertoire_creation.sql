CREATE DATABASE repertoire;

USE repertoire;

CREATE TABLE annuaire (
	id_annuaire int(3) NOT NULL auto_increment,
	nom varchar(30) NOT NULL,
	prenom varchar(30) NOT NULL,
	telephone int(10) ZEROFILL NOT NULL,
	profession varchar(30) NOT NULL,
	ville varchar(30) NOT NULL,
	code_postal int(5) ZEROFILL NOT NULL,
	adresse varchar(30) NOT NULL,
	date_de_naissance DATE NOT NULL,
	sexe ENUM('m','f') NOT NULL,
	description text,
	PRIMARY KEY (id_annuaire)
)	ENGINE=InnoDB DEFAULT CHARSET=latin1;