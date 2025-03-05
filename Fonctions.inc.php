<?php

  function query($link,$query)
  { 
    $resultat=mysqli_query($link,$query) or die("$query : ".mysqli_error($link));
	return($resultat);
  }
  
  function array_escape($link, $array) {
    return array_map(function($value) use($link) {
        return mysqli_real_escape_string($link,$value);
    }, $array);
}


?>