function verificador(){    
  var alerta="";
    if (document.getElementById("nombre").value === ""){
      alerta += "El nombre es obligatorio. ";
    } 
    if (document.getElementById("img").value.length === 0) {
      alerta += "Seleccione una imagen. ";
    }
    if ((document.getElementById("descripcion").value.length>255)) {
      alerta += "El campo descripcion es incorrecto. ";
    }
    if (document.getElementById("url").value.length>80){
      alerta += "El campo url es incorrecto. ";
    } 
     if ( document.getElementById('plataforma').value== -1) {
      alerta += "Seleccione una plataforma válida. ";
    }
    if (document.getElementById('genero').value == -1) {
      alerta += "Seleccione un genero válido. ";
    }
     
  if (alerta !==''){
    document.getElementById('error').innerHTML=alerta; 
    return false
  }else {
    return true ;
  }
 }
