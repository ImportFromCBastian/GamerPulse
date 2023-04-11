<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GamerPulse</title>
  <link rel="stylesheet" href="estilos.css"></link>
</head>
<body>
  <header> <img class="logo" src="./images/GamerPulse.jpg" alt="logo"></header>

  <form action="index.php" method="get">
    <div class="form">
        <input class ="inputFilter" type="text" name="inputName"  placeholder="Nombre">
        <input class ="inputFilter" type="text" name="inputGender"  placeholder="G&eacute;nero">
        <input class ="inputFilter" type="text" name="inputConsole"  placeholder="Plataforma">
        <span>      
          <input class ="inputs" type="submit" name="filter" value="Filtrar">
          <a class="inputs" href="altaJuego.php">Agregar Juego</a>
        </span>
      </div>


    </form>
    <div class="divBox">
      
        <div class ="staticData">
          <p ><a href="https://articulo.mercadolibre.com.ar/MLA-1291698023-juego-new-super-mario-2-3ds-_JM#position=6&search_layout=stack&type=item&tracking_id=6b9e8ebc-43f2-46b4-a764-9a2cf34cce41" target="_blank"><img class="img_in_box" src="./images/NewSuperMarioBros2.png" alt="logo"></a></p>
          <p>New Super Mario Bros 2 - 3DS</p>
          <p>Plataforma</p>
          <Strong><p>Juego nuevo de la saga super mario</p></Strong>
        </div>
      
        <div class ="staticData">
          <p><a href="https://store.steampowered.com/app/960090/Bloons_TD_6/" target="_blank"><img class="img_in_box" src="./images/BloonsTD6.jpg" alt="logo"></a></p>
          <p>Bloons TD6 - PC/Mobile</p> 
          <p>Tower Defense</p>
          <Strong><p>Crea la defensa perfecta</p>
          <p>con una combinación increíble de </p>
          <p>torres moneriles. </p></Strong>
        </div>

        <div class ="staticData">
          <p><a href="https://www.gog.com/game/hollow_knight?pp=7db6e65d0713f435da1a90d06da2c98465764f38" target="_blank"><img class="img_in_box" src="./images/HollowKnight.jpg" alt="logo"></a></p>
          <p>Hollow Knight - PC/Nintendo Switch</p> 
          <p>Aventura</p>
          <Strong><p>Juego Clasico de acci&oacute;n 2D </p>
            <p>en un vasto mundo interconectado.</p></Strong>
        </div>
      
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
