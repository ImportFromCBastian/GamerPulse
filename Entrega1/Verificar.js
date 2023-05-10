function verificador(){    
  let alerta="";
  let fileInput = document.getElementById('img');
  let file = fileInput.files[0]; // Obtener el primer archivo seleccionado
  
   if (document.getElementById("nombre").value === ""){
      alerta += "El nombre es obligatorio. ";
    } 
  if (!file) {
    alerta += "Seleccione una imagen. ";
  } else if (!file.type.startsWith('image/')) {
    alerta += "El archivo seleccionado no es una imagen. ";
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
