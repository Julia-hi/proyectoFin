/**
 * autor: Yulia Tropin Tropina, 3DAWd IES "Trassierra"
 * Proyecto fin del curso "Mi lorito"
 * 
 * jQuery required
 * */

"use strict"
let xmlHttp;

/**
 * Datos de la comunidad seleccionada (json)
 * @var Object
 */
let datos;

/**
 * Provincia seleccionada
 * @var String 
 */
let selectedProv;

window.addEventListener("load", () => {

    /* $("#comunidad").val(selectedCom);
    console.log($("#comunidad").val());
    if (selectedCom != "todo") {
        mostrarProvincias();
    } */
    xmlHttp = crearConexion();
    $("#comunidad").on("change", mostrarProvincias);
});

/**
 * Mostrar provincias (opciones del select)
 * 
 */
function mostrarProvincias() {
    //limpiar opciones seleccionados anteriormente 
    $("#provincia").empty();
    $("#poblacion").empty();
    let selectedComunidad = $("#comunidad").val();
    if (selectedComunidad == "todo" || $("#provincia").val() == "todo") {
        $("#provincia").append("<option value='todo' selected>Seleccione provincia ...</option>");
        $("#poblacion").append("<option value='todo' selected>Seleccione poblacion ...</option>");
    } else {
        if (xmlHttp != undefined && selectedComunidad != "todo") {
            cargarProvincias(selectedComunidad);
            $('#provincia').on("change", function () {
                $('#poblacion').empty();
                mostrarPoblaciones(datos);
            });
        } else {
            console.log("El navegador no soporta AJAX. Debe actualizar el navegador");
        }
    }
}

let mostrarPoblaciones = (datos) => {
    let lat, lon;
    $("#poblacion").empty();
    if ($("#provincia").value == "todo" || $("#comunidad").value == "todo") {
        $("#poblacion").innerHTML = '';
        $("#poblacion").append("<option value='todo' selected>Seleccione poblacion ...</option>");
    } else {
        $("#poblacion").append("<option value='todo' selected>Seleccione poblacion ...</option>");
        selectedProv = $("#provincia option:selected").text();

        //obtener latitud and longitude del pueblo
        $.each(datos.Provincia, function (i, element) {
            if (Object.keys(element)[0] == selectedProv) {
                $.each(element[selectedProv], function (j, innerItem) {
                    $('#poblacion').append($('<option>', {
                        value: innerItem.Poblacion,
                        text: innerItem.Poblacion
                    }));
                    //valor of latitud de la poblacion
                    $('#poblacion').append($('<span>', {
                        value: innerItem.Latitud,
                        text: innerItem.Latitud,
                        id: 'lat_' + innerItem.Poblacion
                    }));
                    //valor of longitud de la poblacion
                    $('#poblacion').append($('<span>', {
                        value: innerItem.Longitud,
                        text: innerItem.Longitud,
                        id: 'lon_' + innerItem.Poblacion
                    }));
                    
                });
            }
        });
        var selectedPueblo = $("#poblacion option:selected").val();
        lat = $("#lat_" + selectedPueblo).text();
        lon = $("#lon_" + selectedPueblo).text();
        $("#lat_pueblo").text(lat);
        $("#lat_pueblo").val(lat);
        $("#lon_pueblo").text(lon);
        $("#lon_pueblo").val(lon);
        //set latitude y longitude del pueblo elegido -> para mostrar marker del ubicación en mapa
        $('#poblacion').on("change", function () {
            var selectedPueblo = $("#poblacion option:selected").val();
            lat = $("#lat_" + selectedPueblo).text();
            lon = $("#lon_" + selectedPueblo).text();
            $("#lat_pueblo").text(lat);
            $("#lat_pueblo").val(lat);
            $("#lon_pueblo").text(lon);
            $("#lon_pueblo").val(lon);
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
            })

            selectedProv = $("#provincia option:selected").val();
            console.log(selectedProv);
            //  $('#provincia option[value="' + selectedProv + '"]').attr('selected', 'selected');
            mostrarPoblaciones(datos);
            $('#provincia').on('change', mostrarPoblaciones(datos));
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





