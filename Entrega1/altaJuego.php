<?php 
  require_once "conexionBDD.php";
  $conexion = conectar();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamerPulse</title>
    <link rel="stylesheet" href="estilos.css"></link>
    <script src = 'Verificar.js'> </script>    
</head>
<body>
    <header> 
      <a href = 'index.php'><img class="logo" src="./images/GamerPulse.jpg" alt="logo"></a>
    </header>
          <div class="alta" >
      <div>
        <h3>Agregar Juego</h3>
      </div>
        <form  action="altaJuego.php" method="get" id="formulario">

                <input class="inputFilter" type ="text" placeholder="Nombre del Juego" id ="nombre" name="nombre">
     
                <input class="inputFilter" type ="text" placeholder="Descripcion" id="descripcion" name="descripcion">
                
                <input class="inputFilter" type ="text" placeholder="URL del juego" id ="url" name="url">
                

                <?php
                  $sqlQueryPlatform = "SELECT * FROM plataformas";
                  $platforms = $conexion -> query($sqlQueryPlatform);
                ?>
                <select class="inputFilter"id="plataforma" name="plataforma">
                <option value="defaultPlat">Seleccione una plataforma</option>
                <?php       
                    while ($rowPlatform = $platforms ->fetch_assoc()){?>
                    <option value = "<?php echo $rowPlatform ["id"]?>">
                    <?php echo $rowPlatform["nombre"]?></option>


                 <?php   } ?>
                </select>
                
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
            
                  <input  type ="file" placeholder="Imagen de la caratula " id ="img" name="img">  
            <span>
              <input class="inputs" type="submit" value="Validar">
              <input class="inputs" type="reset" value="Reset">
            </span>
              <div id='error' class="msjError" ></div> 
            
          </form>
         
      <script>
        document.getElementById('formulario').addEventListener('submit', verificador); 
      </script>

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
