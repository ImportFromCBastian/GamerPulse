<?php 
function returnQuery(){
      $sqlQuery = "SELECT j.nombre,j.imagen,j.tipo_imagen,j.url,j.descripcion,p.id, p.nombre AS nombrePlataforma , g.id, g.nombre AS nombreGenero FROM juegos j INNER JOIN plataformas p  ON j.id_plataforma = p.id INNER JOIN generos g ON j.id_genero = g.id";
      
    if(($_GET == null) || (($_GET['inputName'] == "")) && ($_GET['inputGender'] == "defaultGen") && ($_GET['inputConsole']) == "defaultPlat"){

    }else if(($_GET['inputName'] != "") && ($_GET['inputGender'] == "defaultGen") && ($_GET['inputConsole'] == "defaultPlat")){

      $input = $_GET['inputName'];
      $sqlQuery = $sqlQuery." WHERE j.nombre  LIKE '%$input%'";

    }else if(($_GET['inputName'] == "") && ($_GET['inputGender'] != "defaultGen") && ($_GET['inputConsole'] == "defaultPlat")){

      $input = $_GET['inputGender'];
      $sqlQuery = $sqlQuery." WHERE j.id_genero  LIKE '$input'";

    }else if(($_GET['inputName'] == "") && ($_GET['inputGender'] == "defaultGen") && ($_GET['inputConsole'] != "defaultPlat")){

      $input = $_GET['inputConsole'];
      $sqlQuery = $sqlQuery." WHERE j.id_plataforma  LIKE '$input'";

    }else if(($_GET['inputName'] != "") && ($_GET['inputGender'] != "defaultGen") && ($_GET['inputConsole'] == "defaultPlat")){

      $inputName = $_GET['inputName'];
      $inputGender = $_GET['inputGender'];
      $sqlQuery = $sqlQuery . " WHERE j.nombre LIKE '%$inputName%' AND j.id_genero LIKE '$inputGender'";
    }else if(($_GET['inputName'] != "") && ($_GET['inputGender'] == "defaultGen") && ($_GET['inputConsole'] != "defaultPlat")){

      $inputName = $_GET['inputName'];
      $inputConsole = $_GET['inputConsole'];
      $sqlQuery = $sqlQuery . " WHERE j.nombre LIKE '%$inputName%' AND j.id_plataforma LIKE '$inputConsole'";

    }else if(($_GET['inputName'] == "") && ($_GET['inputGender'] != "defaultGen") && ($_GET['inputConsole'] != "defaultPlat")){

      $inputGender = $_GET['inputGender'];
      $inputConsole = $_GET['inputConsole'];
      $sqlQuery = $sqlQuery . " WHERE j.id_genero LIKE '$inputGender' AND j.id_plataforma LIKE '$inputConsole'";

    }
    return $sqlQuery." ORDER BY j.nombre ASC";
  }
?>