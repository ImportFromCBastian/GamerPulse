<?php 

  require_once "conexionBDD.php";
  $conexion = conectar();

  session_start();

  if(isset($_SESSION['alerta'])) {
    $mensaje = $_SESSION['alerta'];
    ?> 
    <script type="text/javascript" > 
      window.onload = function() {
            var mensaje = "<?php echo $mensaje; ?>";
            alert(mensaje);
        }
        </script>
    <?php
    unset($_SESSION['alerta']);
  }

  if (isset ($_SESSION['datos'])){
    $nombre = isset($_SESSION['datos']['nombre']) ? $_SESSION['datos']['nombre'] : '';
    $url = isset($_SESSION['datos']['url']) ? $_SESSION['datos']['url'] : '';
    $descripcion = isset($_SESSION['datos']['descripcion']) ? $_SESSION['datos']['descripcion'] : '';
    $genero = isset($_SESSION['datos']['genero']) ? $_SESSION['datos']['genero'] : '';
    $plataforma = isset($_SESSION['datos']['plataforma']) ? $_SESSION['datos']['plataforma'] : '';
    unset($_SESSION['datos']);
    }
  else{
    $nombre = '';
    $url = '';
    $descripcion = '';
    $genero = -1;
    $plataforma = -1;
    }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamerPulse</title>
    <link rel="stylesheet" href="estilos.css"></link>
    <script src = 'Verificar.js'> </script>    
</head>
<body>
    <header> 
      <a href='index.php'><img class="logo" src="./images/GamerPulse.png" alt="logo"></a>
    </header>
    <div class="alta" >
      <div>
        <h3>Agregar Juego</h3>
      </div>
       <form action='addJuego.php' method="post" id="formulario" onSubmit="return verificador()" enctype="multipart/form-data">

         <input class="inputFilter" type ="text" placeholder="Nombre del Juego" id ="nombre" name="nombre" value="<?php echo $nombre; ?>" >
      
         <textArea class="inputFilter"  placeholder="Descripcion" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>"></textArea>
                  
         <input class="inputFilter" type ="text" placeholder="URL del juego" id ="url" name="url" value="<?php echo $url; ?>">

          <select class="inputFilter" id="plataforma" name="plataforma">
              <option value="-1">Seleccione una plataforma</option>
              <?php
                  $sqlQueryPlatform = "SELECT * FROM plataformas";
                  $platforms = $conexion -> query($sqlQueryPlatform);          
                  while ($rowPlatform = $platforms ->fetch_assoc()){
                    $selected = ($rowPlatform['id'] == $plataforma) ? "selected" : "";                 
                  ?>
                  <option value="<?php echo $rowPlatform['id'];?>" <?php echo $selected;?> > <?php echo $rowPlatform['nombre'];?></option>
          </select>
              <?php 
                  } 
              ?>

          <select class="inputFilter" name="genero" id='genero'>
              <option value="-1">Seleccione un G&eacute;nero</option>
              <?php
                  $sqlQueryGender = "SELECT * FROM generos";
                  $genders = $conexion -> query($sqlQueryGender);
                  while ($rowGender = $genders ->fetch_assoc()){
                    $selected = ($rowGender['id'] == $genero) ? "selected" : "";                  
              ?>
              <option value="<?php echo $rowGender['id'];?>" <?php echo $selected;?> > <?php echo $rowGender['nombre'];?></option>
              <?php
                  } 
              ?>
          </select>

        <input  type ="file" accept="image/*" id ="img" name="imagen">  
         
       <input class="inputs" type="submit" value="Validar">
       <div id='error' class="msjError">
       </div>
      </form>
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

  $conexion -> close();
 

?>
