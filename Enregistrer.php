<!DOCTYPE html>
<html>
<head>
	<title>Enregistrement d'une note</title>
	<meta charset="utf-8" />
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
  
  if(isset($_POST["note"])) 	$note=mysqli_real_escape_string($mysqli,$_POST["note"]); 		
  else { echo 'Paramètre "note" absent';     $ok=false;}
  
  // tests des valeurs reçues
  if( ($note<0) || ($note>20) ) { echo "Erreur : Les notes doivent être entre 0 et 20"; $ok=false; }
    
  $resultat=query($mysqli,"SELECT eleve FROM `ELEVE` WHERE id_eleve='$eleve'");
  if($nuplet=mysqli_fetch_row($resultat)) $Prenom=$nuplet[0];
  else { echo "Erreur : élève [id='$eleve'] non trouvé"; $ok=false; }
  
  $resultat=query($mysqli,"SELECT matiere FROM MATIERE WHERE id_matiere='$matiere'");
  if($nuplet=mysqli_fetch_row($resultat)) $Matiere=$nuplet[0];
  else { echo "Erreur : matière [id='$matiere'] non trouvée"; $ok=false; }
  		
  if ($ok)
    { 
	  //$resultat=query($mysqli,	"SELECT * 
	  //							 FROM RESULTAT
	  //							 WHERE id_eleve='$eleve'
	  //							 AND id_matiere='$matiere'");
	  //							 
	    query($mysqli,"REPLACE INTO resultat (`id_eleve`, `id_matiere`,  `note`)
	  							      VALUES ('$eleve',   '$matiere',   '$note');");
		
	  /* query($mysqli,"INSERT INTO resultat (`id_eleve`, `id_matiere`,  `note`)
								      VALUES ('$eleve',   '$matiere',   '$note')
									  ON DUPLICATE KEY UPDATE `note`='$note'
									  ;");
		*/
		

	  if(mysqli_affected_rows($mysqli)==2)
  	    {  echo "Modification de la note de $Prenom en $Matiere : $note<br />\n"; 	                       
	    }
	  else // 1er enregistrement de la note pour ces matiere et eleve			
		{ echo "Enregistrement de la note de $Prenom en $Matiere : $note<br />\n"; 	                       
		}
	  
	  //
	  // Alternative avec une instruction UPDATE
	  //
	  
	  /*
	 
		if(mysqli_num_rows($resultat)>0)
		{ // modification de la note
		  query($mysqli,"UPDATE RESULTAT 
						set note='$note'  
						WHERE id_eleve='$eleve' 
						AND id_matiere='$matiere';");
		  echo 'Modification de la note de '.$Prenom.' en '.$Matiere.' : '.$note; 	                       
		}
	  else
		{ // 1er enregistrement de la note pour ces matiere et eleve
		  query($mysqli,"INSERT INTO resultat (`id_eleve`, `id_matiere`, `note`)
		           					   VALUES ('$eleve',   '$matiere',   '$note');");
	
		  echo 'Enregistrement de la note de '.$Prenom.' en '.$Matiere.' : '.$note; 	                       
		}
	  
      */	  
	}  
   mysqli_close($mysqli);	
?>
</body>
</html>
