<?php 
require_once "conexionBDD.php";
$conexion = conectar();

if (isset($_POST) && isset($_FILES)) {
    $insertar=FALSE;
    $nombre = $_POST['nombre'];
    $url = $_POST['url'];
    $genero = $_POST['genero'];
    $descripcion = $_POST['descripcion'];
    $plataforma = $_POST['plataforma'];
    $img = $_FILES ['img']["tmp_name"]; 
    $imagenblob=base64_encode((file_get_contents($img)));

    if (($nombre !=='') && (strlen($url)<80) && (strlen($descripcion)<255) &&($genero>-1) && ($plataforma>-1) && (!empty($imagenblob))){
        $queryInsersion= "INSERT INTO juegos (nombre, imagen, descripcion, url, id_genero, id_plataforma ) VALUES ('$nombre', '$imagenblob','$descripcion','$url','$genero','$plataforma')";
        $insertar= $conexion -> query($queryInsersion); 
    }
    if($insertar === TRUE && $conexion->affected_rows > 0){
        $conexion-> close();
        echo "Operación realizada con éxito";
    }
    else{  
        $conexion-> close();
        echo "No se pudo realizar la operación";
    }
}
?>
