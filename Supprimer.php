<html>
<head>
	<title>Suppression d'une note</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>


<?php

  include("Parametres.php");
  include("Fonctions.inc.php");

    $mysqli=mysqli_connect($host,$user,$pass,$base) or die("Erreur de connexion/sélection: ".mysqli_error($mysqli)); 
  
  $ok=true;
  // tests des variables reçues
  if(isset($_POST["eleve"])) 	$eleve=mysqli_real_escape_string($mysqli,$_POST["eleve"]); 		
  else { echo 'Paramètre "eleve" absent';    $ok=false; }
  
  if(isset($_POST["matiere"])) 	$matiere=mysqli_real_escape_string($mysqli,$_POST["matiere"]); 	
  else { echo 'Paramètre "matiere" absent';  $ok=false; }

  // recherche du prénom de l'élève et de l'intitulé de la matière  
  $resultat=query($mysqli,"SELECT eleve FROM ELEVE WHERE id_eleve='$eleve'");
  if($nuplet=mysqli_fetch_row($resultat)) $Prenom=$nuplet[0];
  else { echo "Erreur : élève [id='$eleve'] non trouvé"; $ok=false; }
  
  $resultat=query($mysqli,"SELECT matiere FROM MATIERE WHERE id_matiere='$matiere'");
  if($nuplet=mysqli_fetch_row($resultat)) $Matiere=$nuplet[0];
  else { echo "Erreur : matière [id='$matiere'] non trouvée"; $ok=false; }
  
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