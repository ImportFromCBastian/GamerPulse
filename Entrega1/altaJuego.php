<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Juego</title>
    <link rel="stylesheet" href="estilos.css"></link>
</head>
<body>
    <header> 
      <a href = 'index.php'><img class="logo" src="./images/GamerPulse.jpg" alt="logo"></header></a>
          <div class="alta" >
      <div>
        <h3>Agregar Juego</h3>
      </div>
        <form  action="altaJuego.php" method="get" id="formulario">

                <input class="inputFilter" type ="text" placeholder="Nombre del Juego" id ="nombre" name="nombre">

                <input class ="inputFilter" type ="file" placeholder="Imagen de la caratula " id ="img" name="img">

                <input class="inputFilter" type ="text" placeholder="Descripcion" id="descripcion" name="descripcion">

                <input class="inputFilter" type ="text" placeholder="URL del juego" id ="url" name="url">
                
                <select class="inputFilter"id="plataforma" name="plataforma">
                    <option value="defaultPlat">Seleccione una plataforma</option>
                    <option value="pc">PC</option>
                    <option value="ps4">PlayStation 4</option>
                    <option value="xbox">Xbox One</option>
                    <option value="switch">Nintendo Switch</option>
                </select>


              <select class="inputFilter" id="genero" name="genero">
                <option value="defaultGen">Seleccione un g&eacute;nero</option>
                <option value="accion">Accion</option>
                <option value="aventura">Aventura</option>
                <option value="fantasia">Fantasia</option>
                <option value="peleas">Peleas</option>
              </select>
            <span>
              <input class="inputs" type="submit" value="Validar">
              <input class="inputs" type="reset" value="Reset">
            </span>
        </form>
      <script> 
      function verificador(event){ 
        var alerta="";
        if (document.getElementById("nombre").value == ""){
          alerta += "El campo nombre es incorrecto. ";
        } 
        if (document.getElementById("img").value.length === 0) {
          alerta += "Seleccione una imagen. ";
        }
        if ((document.getElementById("descripcion").value == null) || (document.getElementById("descripcion").length>255)) {
          alerta += "El campo descripcion es incorrecto. ";
        }
        if (!["pc", "ps4", "xbox", "switch"].includes(document.getElementById('plataforma').value)) {
          alerta += "Seleccione la plataforma. ";
        }
        if (document.getElementById("url").length>80){
          alerta += "El campo url es incorrecto. ";
        }
        if (!["accion", "aventura", "fantasia", "peleas"].includes(document.getElementById('genero').value)) {
          alerta += "Advertencia: no eligió género ";
        }
       alert(alerta);
       document.getElementById('texto').innerHTML=alerta;
        if (alerta !==''){
          event.preventDefault();   
        }   
        }
        
        document.getElementById('formulario').addEventListener('submit', verificador); 
      </script>

    </div> 
    <div id="texto"> </div>
    <footer>
      <h3>Participantes:</h3>
      <ul>
        <strong><li><a href="https://github.com/GregoPonce">Gregorio Ponce 2023</a></li></strong>
        <strong><li><a href="https://github.com/ImportFromCBastian">Sebastian Hernandez 2023</a></li></strong>
      </ul>
    </footer>

</body>
</html>
