<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Juego</title>
    <link rel="stylesheet" href="estilo.css"></link>
</head>
<body>
    <header> <img class="logo" src=./images/GamerPulse.jpg" alt="logo"></header>
    <div class="alta" >
        <form  action="altaJuego.php" method="get">


                <input class="inputs" type ="text" placeholder="Nombre del Juego" id ="nombre" name="nombre">

                <input class ="inputs" type ="text" placeholder="Imagen de la caratula " id ="img" name="img">

                <input class="inputs" type ="text" placeholder="Descripcion" id="descripcion" name="descripcion">

                <input class="inputs" type ="text" placeholder="Plataforma" id ="plataforma" name="plataforma">

           <input class="inputs" type ="text" placeholder="URL del juego" id ="url" name="url">

        <input class="inputs" type ="text" placeholder="G&eacute;nero" id ="genero" name="genero">
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
