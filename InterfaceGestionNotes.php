<!DOCTYPE html>
<html>

<head>
    <title>Interface de gestion de notes</title>
	<meta charset="utf-8" />
	<style type="text/css"> 
	input[type='submit'] {width: 120px}
	select {width: 150px}
	</style>
</head>

<?php 

  include("Parametres.php");
  include("Fonctions.inc.php");

  // Connexion au serveur MySQL
  $mysqli=mysqli_connect($host,$user,$pass,$base) or die("Erreur de connexion/sélection: ".mysqli_error($mysqli)); 
 
 
  // Chargement des matières dans un tableau
  $resultat=query($mysqli,"select * FROM MATIERE ORDER BY id_matiere;");
  // une autre facon de parcourir les résultats de la requête
  while($nuplet=mysqli_fetch_assoc($resultat))
    { $TabMatieres[$nuplet['id_matiere']]=$nuplet["matiere"];
    }

  // Si $resultat est "Traversable" alors on peut utiliser 
  // Version PHP > 5.4
  //
  // foreach($resultat as $ligne) { ... $ligne['matiere']; ... }	
  //
	  
 // Chargement des élèves dans un tableau
  $resultat=query($mysqli,"select * FROM ELEVE ORDER BY id_eleve;");
  while($nuplet=mysqli_fetch_assoc($resultat))
    { $TabEleves[$nuplet['id_eleve']]=$nuplet['eleve'];
    }

 	
  mysqli_close($mysqli);
  
  // Remarques :
  // L'utilisation de mysqli_data_seek($resultat,0) permet de repositionner un "pointeur"
  // en début de résultat d'une interrogation Mysql et permet de re-parcourir les résultats
  // --> utile si le résultat d'une interrogation doit être parcouru plusieurs fois
  //     (comme c'est le cas pour la liste des élèves et des matières
  
?>



<body>
<h1>Gestion de notes</h1>
	

<h2>Fonctionnalités d'accès</h2>
		
<!-- 1ere ligne -->
<fieldset>
    <legend>Initialisation de la base de données</legend>
	<form target="Resultat" action="Initialiser.php">
	    <input type="submit" value="Initialiser">	
	</form>
</fieldset>
<br />

<!-- 2eme ligne -->
<fieldset>
    <legend>Enregistrement d'une note</legend>
	<form method="post" target="Resultat" action="Enregistrer.php">
	<select name="eleve" size="1">
<?php				
/*		<option value="1">Pierre</option> 
		<option value="2">Paul</option> 
		<option value="3">Jean</option> 
		<option value="4">Jacques</option>
*/

  foreach($TabEleves as $IdEleve => $Eleve) 
    { echo' 
		<option value="'.$IdEleve.'">'.$Eleve.'</option>';
    }
?>
	</select>
	<br />
	<select name="matiere" size="1">

<?php				
/*		<option value="1">Maths</option> 
		<option value="2">Bases de données</option> 
		<option value="3">PHP</option> 
		<option value="4">Allemand</option>
*/

  foreach($TabMatieres as $IdMatiere => $Matiere) 
    { echo' 
		<option value="'.$IdMatiere.'">'.$Matiere.'</option>';
    }
?>
	</select>
	<br />
	Note : <input type="text" size="2" maxlength="2" name="note" />	
	<br /> <input type="submit" value="Enregistrer">		
	</form>
</fieldset>		
<br />

<!-- 3eme ligne -->
<fieldset>
    <legend>Suppression d'une note</legend>
	<form method="post" target="Resultat" action="Supprimer.php">
	<select name="eleve" size="1">
<?php				
  foreach($TabEleves as $IdEleve => $Eleve) 
    { echo' 
		<option value="'.$IdEleve.'">'.$Eleve.'</option>';
    }
?>
	</select>
	<br />
	<select name="matiere" size="1">
<?php				
  foreach($TabMatieres as $IdMatiere => $Matiere) 
    { echo' 
		<option value="'.$IdMatiere.'">'.$Matiere.'</option>';
    }
?>

	</select>
	<br /> <input type="submit" value="Supprimer">		
	</form>
</fieldset>		
<br />

<!-- 4eme ligne -->
<fieldset>
    <legend>Afficher les résultats</legend>
	<form method="post" target="Resultat" action="Afficher.php">
	
	<strong>&Eacute;lèves :</strong><br />
<?php				
  /*
	<input type="checkbox" name="ListeEleves[]" value="1" />Pierre<br />
	<input type="checkbox" name="ListeEleves[]" value="2" />Paul<br /> 
	<input type="checkbox" name="ListeEleves[]" value="3" />Jean<br /> 
	<input type="checkbox" name="ListeEleves[]" value="4" />Jacques<br />
  */
  
  foreach($TabEleves as $IdEleve => $Eleve) 
    { echo' 
		<input type="checkbox" name="ListeEleves[]" value="'.$IdEleve.'" />'.$Eleve.'<br />';
    }
?>

	<strong>Matières :</strong><br />
<?php				
/*
	<input type="checkbox" name="ListeMatieres[]" value="1" />Maths<br /> 
	<input type="checkbox" name="ListeMatieres[]" value="2" />Bases de données<br /> 
	<input type="checkbox" name="ListeMatieres[]" value="3" />PHP<br /> 
	<input type="checkbox" name="ListeMatieres[]" value="4" />Allemand<br />
  */

  foreach($TabMatieres as $IdMatiere => $Matiere) 
    { echo' 
				<input type="checkbox" name="ListeMatieres[]" value="'.$IdMatiere.'" />'.$Matiere.'<br />';
    }
?>

	<strong>Trié par :</strong><br />
	<input name="tri" type="radio" value="eleve"    checked="checked">&Eacute;lèves<br />
	<input name="tri" type="radio" value="matiere"         >Matières 

	<br /><input type="submit" value="Afficher">		
	</form>
</fieldset>		

</body>
</html>
