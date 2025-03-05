<html>
<head>
	<title>Suppression d'une note</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>


<?php

  include("Parametres.php");
  include("Fonctions.inc.php");

    $mysqli=mysqli_connect($host,$user,$pass,$base) or die("Erreur de connexion/s�lection: ".mysqli_error($mysqli)); 
  
  $ok=true;
  // tests des variables re�ues
  if(isset($_POST["eleve"])) 	$eleve=mysqli_real_escape_string($mysqli,$_POST["eleve"]); 		
  else { echo 'Param�tre "eleve" absent';    $ok=false; }
  
  if(isset($_POST["matiere"])) 	$matiere=mysqli_real_escape_string($mysqli,$_POST["matiere"]); 	
  else { echo 'Param�tre "matiere" absent';  $ok=false; }

  // recherche du pr�nom de l'�l�ve et de l'intitul� de la mati�re  
  $resultat=query($mysqli,"SELECT eleve FROM ELEVE WHERE id_eleve='$eleve'");
  if($nuplet=mysqli_fetch_row($resultat)) $Prenom=$nuplet[0];
  else { echo "Erreur : �l�ve [id='$eleve'] non trouv�"; $ok=false; }
  
  $resultat=query($mysqli,"SELECT matiere FROM MATIERE WHERE id_matiere='$matiere'");
  if($nuplet=mysqli_fetch_row($resultat)) $Matiere=$nuplet[0];
  else { echo "Erreur : mati�re [id='$matiere'] non trouv�e"; $ok=false; }
  
  // Suppression de la note  
  if($ok) query($mysqli,"DELETE FROM resultat 
                         WHERE id_eleve='$eleve' 
                           AND id_matiere='$matiere';");

  if(mysqli_affected_rows($mysqli)==1)
    { echo "Suppression de la note de $Prenom en $Matiere.<br />\n"; }
  else 	
    { echo "Pas de note pour $Prenom en $Matiere : suppression impossible <br />\n"; }
 	
  mysqli_close($mysqli);	
?>
</body>
</html>