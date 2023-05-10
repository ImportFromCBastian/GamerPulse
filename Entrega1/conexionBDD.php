<?php
function conectar(){ 
  $conexion = new mySqli("localhost","root","","gamerpulse");

  if($conexion->connect_errno){
    echo "Fallo al conectar con SQL: " .$conexion->connect_errno;
  }
  return $conexion;
}
?>