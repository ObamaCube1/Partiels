<!DOCTYPE html>
<html>
<head>
	<title>Affichage des notes</title>
	<meta charset="utf-8" />
</head>

<body>

<?php
  print_r($_POST);
  include("Parametres.php");
  include("Fonctions.inc.php");
  
   
  // Traitement des paramètres 
  $ok=true;
  if(  (!isset($_POST["ListeMatieres"]))
	 ||(count($_POST["ListeMatieres"])==0)
    ) {
    echo "Vous devez sélectionner au moins une matière<br />\n";
	$ok=false;
  }
	
  if(  (!isset($_POST["ListeEleves"]))
	 ||(count($_POST["ListeEleves"])==0)
    ) {
    echo "Vous devez sélectionner au moins un élève<br />\n";
    $ok=false;
  }
  
  if(  (!isset($_POST["tri"]))
	 ||(($_POST["tri"]!='eleve')&&($_POST["tri"]!='matiere'))
    ) { 
	echo "Problème dans le paramètre de tri<br />\n";
    $ok=false;
  }

  if($ok)
    {
	  $mysqli=mysqli_connect($host,$user,$pass,$base) or die("Erreur de connexion/sélection: ".mysqli_error($mysqli)); 
 	  $ListeMatieres=array_escape($mysqli,$_POST['ListeMatieres']); 
 	  $ListeEleves=array_escape($mysqli,$_POST['ListeEleves']); 
	  // construction de la requête avec la 1ère matière sélectionnée
      $requete="SELECT * 
				FROM RESULTAT R, ELEVE E, MATIERE M 
	            WHERE R.id_matiere=M.id_matiere
				AND	  R.id_eleve=E.id_eleve
				AND ( R.id_matiere='".$ListeMatieres[0]."'";
      
      // ajout de toutes les autres matières sélectionnées
      for($i=1;$i<count($ListeMatieres);$i++)
        { $requete.=" OR R.id_matiere='$ListeMatieres[$i]'";
        }
        
      // ajout du 1er élève sélectionné
      $requete.=") AND ( 0 ";
      
      // ajout de toutes les autres matières sélectionnées
      for($i=0;$i<count($ListeEleves);$i++)
        { $requete.=" OR E.id_eleve='$ListeEleves[$i]'";
        }
        
      // ajout de l'élément de tri
      $requete.=") ORDER BY `".$_POST['tri']."` ASC;";
      
	  // Remarque : il y a plus simple en utilisant les "IN"
	  /* $requete="SELECT * 
				FROM RESULTAT R, ELEVE E, MATIERE M 
	            WHERE R.id_matiere=M.id_matiere
				AND	  R.id_eleve=E.id_eleve
				AND   R.id_eleve   IN ('".implode("','",$ListeEleves)."') 
				AND   R.id_matiere IN ('".implode("','",$ListeMatieres)."')
				ORDER BY `".$_POST['tri']."` ASC;";
      */
	  
	 
      // lancement de la requête,  
      $resultat=query($mysqli,$requete);
      if(mysqli_num_rows($resultat)>0)
      {     
        echo '
		<table border="1"> 
			<tr><th>Élève</th><th>Matière</th><th>Note</th></tr>';
      	while($nuplet=mysqli_fetch_assoc($resultat))
 		  { echo '
			<tr>
				<td>'.$nuplet['eleve'].'</td>
				<td>'.$nuplet['matiere'].'</td>
				<td>'.$nuplet['note'].'</td>
			</tr>';
        }
      	echo '
		</table>';
	  }
	  else
	  {
	  	echo "
		Il n'y a pas de résultat pour les élève(s) et matière(s) sélectionnés.";
	  }
    }  
  mysqli_close($mysqli);
?>

</body>
</html>