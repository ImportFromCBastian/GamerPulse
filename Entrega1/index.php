<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GamerPulse</title>
  <link rel="stylesheet" href="estilo.css"></link>
</head>
<body>
  <header> <img class="logo" src="./images/GamerPulse.jpg" alt="logo"></header>

  <form action="index.php">
  <select size="1px">
    <option value="Name">Nombre</option>
    <option value="Gender">Genero</option>
    <option value="Console">Plataforma</option>
  </select>
  

  <input class ="button" type="submit" name ="filter" value="Filtrar" >
  <output type="text" name="">
  </form>


    <div>

      <footer>
        <h3>Participantes:</h3>
        <ul>
          <li>Gregorio Ponce</li> <span> 2023 </span>
          <li>Sebastian Hernandez</li> <span> 2023 </span>
        </ul>
      </footer>
    </div>
  </body>
</html>

<?php 

  $inputName = $_GET['inputName'];
  $inputGender = $_GET['inputGender'];
  $inputConsole = $_GET['inputConsole'];

  $hashGames = array('Name' => "Mario Bros", 'Gender' => "Platforming" , 'Console' => "3DS" );

  if($hashGames['Name'] == $inputName && $hashGames['Gender'] == $inputGender && $hashGames['Console'] == $inputConsole){
    echo ":D";
  }

 ?>