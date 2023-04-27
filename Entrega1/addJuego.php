<?php 
require_once "conexionBDD.php";
$conexion = conectar();
if (isset($_POST['nombre']) && isset($_POST['url']) && isset($_POST['genero']) && isset($_POST['descripcion']) && isset($_POST['plataforma']) && isset($_FILES['imagen'])) {
    echo "boca";
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
        echo "boca";    
        if (($nombre !=='') && (strlen($url)<80) && (strlen($descripcion)<255) &&($genero>-1) && ($plataforma>-1) && (!empty($imagenblob))){
            $queryInsersion= "INSERT INTO juegos (nombre, imagen, tipo_imagen,descripcion, url, id_genero, id_plataforma ) VALUES ('$nombre', '$imagenblob','$tipo','$descripcion','$url','$genero','$plataforma')";
            $insertar= $conexion -> query($queryInsersion); 
            echo "boca";
        }
        if($insertar === TRUE && $conexion->affected_rows > 0){
            $conexion-> close();
            header ("Location: index.php");
        }
        else{  
            $conexion-> close();
        }
        }
        else{  
            $conexion-> close();
        }
    }
    else{  
        $conexion-> close();
    }
?>
