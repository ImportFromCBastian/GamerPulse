<?php 
require_once "conexionBDD.php";

$conexion = conectar();
if (isset($_POST['nombre']) && isset($_POST['url']) && isset($_POST['genero']) && isset($_POST['descripcion']) && isset($_POST['plataforma']) && isset($_FILES['imagen'])) {
    if ( (!empty($_POST['nombre'])) && (!empty($_POST['url'])) && (!empty($_POST['genero'])) && (!empty($_POST['descripcion'])) && (!empty($_POST['plataforma'])) && (!empty($_FILES['imagen']))){ 
        
        $insertar=FALSE;
        $nombre = $_POST['nombre'];
        $url = $_POST['url'];
        $genero = $_POST['genero'];
        $descripcion = $_POST['descripcion'];
        $plataforma = $_POST['plataforma'];
        $img = $_FILES ['imagen']["tmp_name"]; 
        $tipo= $_FILES["imagen"]["type"];
        $imagenblob= base64_encode((file_get_contents($img)));   
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
        if ($genero === -1){
            $alerta.="No se selecciono un genero. ";
        }
        if ($plataforma === -1){
            $alerta.="No se selecciono una plataforma. ";
        }
        if ((empty($imagenblob))&&(strpos($tipo,"image/")) === false){
            $alerta.="La imagen no es correcta. ";
        }
        if ($alerta === ""){
            $queryInsersion= "INSERT INTO juegos (nombre, imagen, tipo_imagen,descripcion, url, id_genero, id_plataforma ) VALUES ('$nombre', '$imagenblob','$tipo','$descripcion','$url','$genero','$plataforma')";
            $insertar= $conexion -> query($queryInsersion); 
        }
        else{
            session_start();
            $_SESSION["mensaje"] = $alerta;
            $conexion->close();
            header("Location: index.php");
        }
        if ($insertar === TRUE && $conexion->affected_rows > 0){
            session_start();
            $_SESSION["mensaje"] = "Juego cargado con éxito";
            $conexion->close();
            header("Location: index.php");
        } else {  
            session_start();
            $_SESSION["mensaje"] = "Ha ocurrido un error";
            $conexion->close();
            header("Location: index.php");
        }
    }else{  
        session_start();
        $_SESSION["mensaje"] = "Ha ocurrido un error";
        $conexion->close();
        header("Location: index.php");
    }
}else{  
    session_start();
    $_SESSION["mensaje"] = "Ha ocurrido un error";
    $conexion->close();
    header("Location: index.php");
}
?>
