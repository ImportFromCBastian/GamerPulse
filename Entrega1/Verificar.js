function verificador(){
    if (form.getElementById("nombre").value!== null) 
    && (form.getElementById("img").value!== null) 
    && ((form.getElementById("plataforma").value!== null) || (form.getElementById("plataforma").Lenght>255)) 
    && ((form.getElementById("plataforma").value!=="PS5")||(form.plataforma.get()!=="Wii"))
    && (form.getElementById("url").Lenght()>80)
    &&((form.getElementById("genero").value==="Accion") ||(form.getElementById("genero").value==="Aventura")) {
        return true;
    }

}
