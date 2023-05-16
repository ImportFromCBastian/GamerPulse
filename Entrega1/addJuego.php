<?php 
require_once "conexionBDD.php";

    $conexion = conectar();
    $insertar=FALSE;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre']:"";
    $url = isset($_POST['url'])? $_POST['url']:"";
    $genero = isset($_POST['genero']) ? $_POST['genero']:"-1";
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] :"";
    $plataforma = isset($_POST['plataforma']) ? $_POST['plataforma']: "-1";
    $img = !empty($_FILES ['imagen']["tmp_name"]) ? $_FILES ['imagen']["tmp_name"] : null; 
    $tipo= !empty($_FILES["imagen"]["type"]) ? $_FILES["imagen"]["type"] : "";
    $imagenblob = null;
    if($img != null){
        $imagenblob= base64_encode((file_get_contents($img)));
    }

    $alerta="";
    if ($nombre ===''){
        $alerta.="El nombre es obligatorio. ";
    }
    if (strlen($url)>80){
        $alerta.="La URL es demasiado larga. ";
    }

    if (strlen($descripcion)>255){
        $alerta.="La descripcion es demasiado larga. ";
    }
    if ($genero == -1){
        $alerta.="No se selecciono un genero. ";
    }
    if ($plataforma == -1){
        $alerta.="No se selecciono una plataforma. ";
    }
    if (empty($imagenblob)){
        $alerta.="No se selecciono imagen.";
    }else{
        if(strpos($tipo,"image/") === false){
            $alerta.= "El documento seleccionado no es imagen.";
        }
    }
    if ($alerta === ""){
        $queryInsersion= "INSERT INTO juegos (nombre, imagen, tipo_imagen,descripcion, url, id_genero, id_plataforma ) VALUES ('$nombre', '$imagenblob','$tipo','$descripcion','$url','$genero','$plataforma')";
        $insertar= $conexion -> query($queryInsersion); 
    }
    else{
        session_start();
        $_SESSION["alerta"] = $alerta;
        $_SESSION["datos"] = array(
            "nombre" => $nombre,
            "url" => $url,
            "genero" => $genero,
            "descripcion" => $descripcion,
            "plataforma" => $plataforma,
        );
        $conexion->close();
        header("Location: altaJuego.php");
        exit();
    }
    
    if ($insertar === TRUE && $conexion->affected_rows > 0){
        session_start();
        $_SESSION["mensaje"] = "Juego cargado con éxito";
        $conexion->close();
        header("Location: index.php");
    } else{
        session_start();
        $_SESSION["mensaje"] = "ERROR FATAL";
        $conexion->close();
        header("Location: altaJuego.php");
    }
?>