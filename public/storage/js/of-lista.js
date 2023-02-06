/**
 * autor: Yulia Tropin Tropina, 3DAWd
 * Proyecto fin del curso "Mi lorito"
 * */

"use strict"
let xmlHttp;
const firstSelect = document.getElementById("comunidad");
const secondSelect = document.getElementById("provincia");
const thirdSelect = document.getElementById("poblacion");
let datos;
let selectedProv;

window.addEventListener("load", () => {
    firstSelect.addEventListener("change", mostrarProvincias);
})

let mostrarProvincias = () => {
    secondSelect.innerHTML = "";
    thirdSelect.innerHTML = "";
    xmlHttp = crearConexion();
    if (firstSelect.value == "todo" || $("#provincia").value == "todo") {
        $("#provincia").innerHTML = '';
        $("#provincia").append("<option value='todo' selected>Seleccione provincia ...</option>");
        $("#poblacion").innerHTML = '';
        $("#poblacion").append("<option value='todo' selected>Seleccione poblacion ...</option>");
    } else {
        if (xmlHttp != undefined && comunidad != "todo") {
            cargarProvincias(comunidad.value);
            secondSelect.addEventListener("change", function () {
                thirdSelect.innerHTML = "";
                mostrarPoblaciones(datos);
            });
        } else {
            Swal.fire("El navegador no soporta AJAX. Debe actualizar el navegador");
        }
    }
}

let mostrarPoblaciones = (datos) => {
    $("#poblacion").innerHTML = '';
    if ($("#provincia").value == "todo" || $("#comunidad").value == "todo") {
        $("#poblacion").innerHTML = '';
        $("#poblacion").append("<option value='todo' selected>Seleccione poblacion ...</option>");
    } else {
        $("#poblacion").innerHTML = '';
        $("#poblacion").append("<option value='todo' selected>Seleccione poblacion ...</option>");
        selectedProv = $("#provincia option:selected").text();

        $.each(datos.Provincia, function (i, element) {
            if (Object.keys(element)[0] == selectedProv) {
                $.each(element[selectedProv], function (j, innerItem) {
                    $('#poblacion').append($('<option>', {
                        value: innerItem.Poblacion,
                        text: innerItem.Poblacion
                    }));
                    $('#poblacion').append('<span hidden id="lat-' + innerItem.Poblacion + '">' + innerItem.Latitud + "</span>")
                    $('#poblacion').append('<span hidden id="lon-' + innerItem.Poblacion + '">' + innerItem.Longitud + "</span>")
                });
            }
        });
        thirdSelect.addEventListener("change", function () {
            let selectedPoblacion = $("#poblacion option:selected").text();
            // let lat = document.getElementById("lat-"+selectedPoblacion).innerText;
            //  let lon = document.getElementById("lon-"+selectedPoblacion).innerText;
            //console.log("latitude: "+lat);
            $("#lat-pueblo").value = document.getElementById("lat-" + selectedPoblacion).innerText;
            $("#lon-pueblo").value = document.getElementById("lon-" + selectedPoblacion).innerText;
        });
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

let cargarProvincias = (com) => {

    xmlHttp.open("GET", "/storage/comunidades/" + com + ".json", true);
    xmlHttp.onreadystatechange = () => {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            datos = JSON.parse(xmlHttp.responseText);
            //ordenar las provincias
            datos.Provincia.sort();

            $("#provincia").innerHTML = "";
            $("#provincia").append("<option value='todo' selected>Seleccione provincia ...</option>")
            $(datos.Provincia).each((ind, elemento) => {
                $('#provincia').append($('<option>', {
                    value: Object.keys(elemento),
                    text: Object.keys(elemento)
                }));
                //  thirdSelect.innerHTML = "";
                //console.log("I am in third nivel, provincia elegida: " + $("#provincia option:selected").text());
                //  thirdSelect.append("<option value='todo'>Seleccione poblacion ...</option>");
            })
        }
    };
    xmlHttp.send(); //comienza la petición de respuesta al servidor
}

/**
 * Reemplaza espacios en blanco de u string al signo de guion 
 * 
 * @param String optValor 
 * @returns String
 */
function eliminateSpacesString(optValor) {
    let newValor = "";
    for (let i = 0; i < optValor.length; i++) {
        if (optValor[i] == " ") {
            optValor = "-";
        }
        newValor = newValor + optValor[i]
    }
    return newValor.toLowerCase();
}