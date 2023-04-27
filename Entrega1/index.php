<?php 
  require_once "conexionBDD.php";
  require_once "querys.php";
  $conexion = conectar();
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GamerPulse</title>
  <link rel="stylesheet" href="estilos.css"></link>
</head>
<body>
  <header> <a href="index.php"> <img class="logo" src="./images/GamerPulse.jpg" alt="logo">  </a>  </header>
  <form action="index.php" method="get">
    <div class="form">
      <input class ="inputFilter" type="text" name="inputName"  placeholder="Nombre">
      <!-- query for genders --> 
        <?php
          $sqlQueryGender = "SELECT * FROM generos";
          $genders = $conexion -> query($sqlQueryGender);

          ?>
        <select class ="inputFilter"  name="inputGender">
          <option value="defaultGen">Seleccione un G&eacute;nero</option>
          <?php while($rowGender = $genders -> fetch_assoc()){ ?>
          <option value="<?php echo $rowGender["id"]?>"> <?php echo $rowGender["nombre"] ?></option>  
          <?php 
          }
          ?>
        </select>
<!-- query for plataforms --> 
        <?php 
          $sqlQueryPlatform = "SELECT * FROM plataformas";
          $platforms = $conexion -> query($sqlQueryPlatform);

        ?>
        <select class ="inputFilter"  name="inputConsole">
          <option value="defaultPlat"> Seleccione una Plataforma</option>
          <?php while($rowPlatform = $platforms -> fetch_assoc()){ ?>
          <option value="<?php echo $rowPlatform["id"]?>"> <?php echo $rowPlatform["nombre"]?> </option>
          <?php
          }
          ?>
        </select>
        <span>      
          <input class ="inputs" type="submit" name="filter" value="Filtrar">
          <a class="inputs" href="altaJuego.php">Agregar Juego</a>
        </span>
      </div>
    </form>
  
    <div class="divBox">
    <!--query for games-->

    <?php 
      $sqlQueryGames = returnQuery();
      

      $games = $conexion -> query($sqlQueryGames);

      if($games-> num_rows > 0){
      while($rowGames = $games -> fetch_assoc()){
    ?>
        <div class ="staticData">
          <p><a href="<?php echo $rowGames["url"]?>" target="_blank"><img class="img_in_box" src="data:image/<?php $rowGames["tipo_imagen"] ?>;base64,<?php echo base64_encode($rowGames["imagen"]) ?>" alt="logo"/></a></p>
          <p><?php echo $rowGames["nombre"]." - ". $rowGames["nombrePlataforma"]?></p>
          <p><?php echo $rowGames["nombreGenero"] ?></p>
          <Strong><p><?php echo $rowGames["descripcion"] ?></p></Strong>
        </div>
    <?php
        }
      }else{
    ?>
    </div>
    <div class ="divBox" style="justify-content:center; grid-template-columns:auto;">
      <p><img class="img_in_box" src="./images/CallOfDuty.jpg" alt="CallOfDuty"></p>
      <p>No se encontraron resultados.</p>
    <?php
      } 
    ?>
    </div>
    <footer>
      <h3>Participantes:</h3>
      <ul>
        <strong><li><a href="https://github.com/GregoPonce">Gregorio Ponce 2023</a></li></strong>   
        <strong><li><a href="https://github.com/ImportFromCBastian">Sebastian Hernandez 2023</a></li></strong>   
      </ul>
    </footer>
  </body>
</html>
<?php
 
  $conexion-> close();
?>
