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
    document.getElementById('error').innerHTML=alerta; }
    else {
      document.getElementById('error').innerHTML="valido";
     var dataForm = new FormData();

     dataForm.append('nombre', document.getElementById('nombre').value);

     dataForm.append('descripcion', document.getElementById('descripcion').value);

     dataForm.append('url', document.getElementById('url').value);

     dataForm.append('plataforma', document.getElementById('plataforma').value);

     dataForm.append('genero', document.getElementById('genero').value);

     var inputFile = document.getElementById('img');
     dataForm.append('img', inputFile.files[0]);

     fetch('addJuego.php', {
       method: 'POST',
       body: dataForm
     })
    //  .then(function(response) {
    //     if(response) {
    //         return response.text()
    //     } else {
    //         throw "Error en la llamada Ajax";
    //     } 
    //  })
    //  .then(function(texto) {
    //   if(texto=='ok')
      
    //     console.log(texto);
    //     //
    //  })
    //  .catch(function(err) {
    //     console.log(err);
    //  });
     
   }
    }
