<html>
<head>
	<title>Initialisation de la base de données</title>
	<meta charset="utf-8" />
</head>

<body>
<?php

  include("Parametres.php");
  include("Fonctions.inc.php");

  // Connexion au serveur MySQL
  $mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error());

  // Suppression / Création / Sélection de la base de données : $base
  query($mysqli,'DROP DATABASE IF EXISTS '.$base);
  query($mysqli,'CREATE DATABASE '.$base);
  mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");


  // Création de la table MATIERE
  // Remarque : il est inutile de supprimer la table au préalable,
  //            la base de données venant juste d'être créée
  //            [ mysql_query("DROP TABLE IF EXISTS MATIERE;",$id); ] 
  
  query($mysqli,
  
  "	CREATE TABLE IF NOT EXISTS `MATIERE` (
					  `id_matiere` int(11) NOT NULL,
					  `matiere` varchar(20) NOT NULL,
					  PRIMARY KEY (`id_matiere`),
					  UNIQUE KEY `matiere` (`matiere`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				");

				
  // Insertions des 4 matières
  query($mysqli,"INSERT INTO MATIERE VALUES ('1','Maths');");
  query($mysqli,"INSERT INTO MATIERE VALUES ('2','Bases de données');");
  query($mysqli,"INSERT INTO MATIERE VALUES ('3','PHP');");
  query($mysqli,"INSERT INTO MATIERE VALUES ('4','Allemand');");
  
  
  // Création de la table ELEVE
  query($mysqli,"	CREATE TABLE IF NOT EXISTS `ELEVE` (
					  `id_eleve` int(11) NOT NULL,
					  `eleve` varchar(20) NOT NULL,
					  PRIMARY KEY (`id_eleve`),
					  UNIQUE KEY `matier` (`eleve`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");
	
	
  // Insertions des 4 eleves avec une iterative sur un tableau
  query($mysqli,"	INSERT INTO ELEVE 
					VALUES 	('1','Pierre'),
							('2','Paul'),
							('3','Jean'),
							('4','Jacques');");
  
  // Création de la table RESULTAT
  query($mysqli,"CREATE TABLE RESULTAT 
                         ( 	id_eleve   int(11) NOT NULL ,
							id_matiere int(11) NOT NULL ,
							note    int(2)   NOT NULL default '0',
  			   PRIMARY KEY  (id_eleve,id_matiere)
		       ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  
  mysqli_close($mysqli);			
?>

Initialisation réussie
</body>
</html>