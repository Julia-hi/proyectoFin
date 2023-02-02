/*autor: Yulia Tropin Tropina, 3DAWd
    Proyecto fin del curso "Mi lorito"*/
  
"use strict"
let xmlHttp;
window.addEventListener("load", () => {
    document.getElementById("comunidad").addEventListener("change", mostrarProvincias);
    document.getElementById("provincia").addEventListener("change", mostrarPoblaciones);
})

let mostrarProvincias = () => {
    let comunidad = document.getElementById("comunidad");
    console.log(comunidad.value);
    xmlHttp = crearConexion();
    if (xmlHttp != undefined && comunidad !="todo") {
        //funcionalidad
        cleanOptions(comunidad.value);
        cargarProvincias(comunidad.value);
        
    } else {
        Swal.fire("El navegador no soporta AJAX. Debe actualizar el navegador");
    }
}

let mostrarPoblaciones = () => {
    let provincia = document.getElementById("provincia");
    let comunidad = document.getElementById("comunidad");
    console.log(provincia.value );
    xmlHttp = crearConexion();
    if (xmlHttp != undefined && comunidad !="todo") {
        //funcionalidad
        cleanOptions(comunidad.value);
        cargarProvincias(comunidad.value);
    } else {
        Swal.fire("El navegador no soporta AJAX. Debe actualizar el navegador");
    }
}

let crearConexion = () => {
    let objeto;
    if (window.XMLHttpRequest) {
        objeto = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try {
            objeto = new ActiveXObject("MSXML2.XMLHTTP");
        } catch (e) {
            objeto = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return objeto;
}

let cleanOptions =(com) =>{

    $("#provincia").innerHTML = '';

}

let cargarProvincias = (com) => {
    
    xmlHttp.open("GET","/storage/comunidades/"+com+".json", true);
    xmlHttp.onreadystatechange = () => {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            let datos = JSON.parse(xmlHttp.responseText);
            console.log(Object.keys(datos.Provincia) );
            //ordenar las provincias
            /* datos.Provincia.sort((a, b) => {
                return a.nm.localeCompare(b.nm)
            }); */

            $(datos.Provincia).each((ind,elemento) => {
                $("#provincia").append("<option id='" +ind + "' value="+Object.keys(elemento)+">" + Object.keys(elemento)+ "</option>")
            })
            //establecer el evento change al select provincias
            $("#provincias").on("change", function () {
                Swal.fire("el código de la provincia es " + $("#provincias option:selected").attr("id"));
            })

        }
    };

    xmlHttp.send(); //comienza la petición de respuesta al servidor
}