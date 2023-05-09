<?php 
  require_once "conexionBDD.php";
  $conexion = conectar();
?>
<DOCTYPE html>
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

         <input class="inputFilter" type ="text" placeholder="Nombre del Juego" id ="nombre" name="nombre">
      
         <textarea class="inputFilter" placeholder="Descripci&oacute;n" id="descripcion" name="descripcion"></textarea>
                  
         <input class="inputFilter" type ="text" placeholder="URL del juego" id ="url" name="url">

         <!--QUERY PARA OBTENER ID Y NOMBRE DE LAS PLATAFORMAS-->
         <?php
           $sqlQueryPlatform = "SELECT * FROM plataformas";
           $platforms = $conexion -> query($sqlQueryPlatform);          
           $platformResults = array(); // Array para almacenar los nombres de las plataformas
           while ($rowPlatform = $platforms ->fetch_assoc()){
             $platformResults [] = $rowPlatform ; // Añadir el nombre de la plataforma al array
           }         
          ?>

         <select class="inputFilter"id="plataforma" name="plataforma">
           <option value="-1">Seleccione una plataforma</option>
           <?php       
             foreach($platformResults as $platform){
           ?>
           <option value="<?php echo $platform['id'] ?>"><?php echo $platform['nombre'] ?></option>
           <?php   
             } 
           ?>
         </select>

         <!--QUERY PARA OBTENER ID Y NOMBRE DE LOS GENEROS-->
         <?php
           $sqlQueryGender = "SELECT * FROM generos";
           $genders = $conexion -> query($sqlQueryGender);
           $genderResults = array(); // Array para almacenar los nombres de las plataformas
           while ($rowGender = $genders ->fetch_assoc()){
             $genderResults [] = $rowGender; // Añadir el nombre de la plataforma al array
           }
         ?>

         <select class ="inputFilter"  name="genero" id='genero'>
           <option value="-1">Seleccione un G&eacute;nero</option>
           <?php foreach ($genderResults as $gender) { ?>
           <option value="<?php echo $gender['id'] ?>"><?php echo $gender['nombre'] ?></option>
           <?php 
             } 
           ?>
         </select>

         <input  type ="file" accept="image/*" id ="img" name="imagen">  
         
         <span>
           <input class="inputs" type="submit" value="Validar">
           <input class="inputs" type="reset" value="Reset">
         </span>
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
