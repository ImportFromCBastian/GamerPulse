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

    <form action="altaJuego.php" method="get">
        <label for ="nombre"> Nombre:</label>
        <input type ="text" id ="nombre" name="nombre"> <br>
        <label for ="img"> Imagen:</label>
        <input type ="text" id ="img" name="img"> <br>
        <label for ="descripcion"> Descripcion:</label>
        <input type ="text" id ="descripcion" name="descripcion"> <br>
        <label for ="plataforma"> Plataforma:</label>
        <input type ="text" id ="plataforma" name="plataforma"> <br>
        <label for ="url"> URL:</label>
        <input type ="text" id ="url" name="url"> <br>
        <label for ="genero"> Genero:</label>
        <input type ="text" id ="genero" name="genero"> <br>
    </form> 
    <footer>
      <h3>Participantes:</h3>
      <ul>
        <strong><li><a href="https://github.com/GregoPonce">Gregorio Ponce 2023</a></li></strong>
        <strong><li><a href="https://github.com/ImportFromCBastian">Sebastian Hernandez 2023</a></li></strong>
      </ul>
    </footer>

</body>
</html>
