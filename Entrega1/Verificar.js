function verificador(event){ 
    var alerta="";
    if (document.getElementById("nombre").value === ""){
      alerta += "El nombre es obligatorio. ";
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

   document.getElementById('error').innerHTML=alerta;
    if (alerta !==''){
      event.preventDefault();   
    }   
    }
