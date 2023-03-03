/**
 * autor: Yulia Tropin Tropina, 3DAWd
 * Proyecto fin del curso "Mi lorito"
 * 
 * jQuery required
 * */

"use strict"
let xmlHttp;
//parametros del query
const urlParams = new URLSearchParams(window.location.search);

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

    var selectedRaza = urlParams.get('raza'); //obtener seleccionada opcion de raza desde query
    var selectedGenero = urlParams.get('genero'); //obtener seleccionada opcion del genero desde query
    var selectedCom = urlParams.get('comunidad');
    var selectedProv = urlParams.get('provincia');
    var selectedPueblo = urlParams.get('poblacion');
    // ofertas-filter?comunidad=todo&provincia=todo&poblacion=todo&raza=todo&genero=todo
    var mapaLink = "mapa?comunidad=" + selectedCom + "&provincia=" + selectedProv + "&poblacion=" +
        selectedPueblo + "&raza=" + selectedRaza + "&genero=" + selectedGenero;
    //set enlace para botón della vista del mapa
    $("#mapaFilter").attr('href', mapaLink);

    var listaLink = "ofertas-filter?comunidad=" + selectedCom + "&provincia=" + selectedProv + "&poblacion=" +
        selectedPueblo + "&raza=" + selectedRaza + "&genero=" + selectedGenero;
    //set enlace para botón della vista de lista
    $("#linkFilter").attr('href', listaLink);

    //set selected attribute para opción seleccionada
    $('#raza option[value="' + selectedRaza + '"]').attr('selected', 'selected');


    //set selected attribute para opción seleccionada
    $('#genero option[value="' + selectedGenero + '"]').attr('selected', 'selected');
    xmlHttp = crearConexion();

    $('#comunidad option[value="' + selectedCom + '"]').attr('selected', 'selected');
    $("#comunidad").val(selectedCom);
    console.log($("#comunidad").val());
    if (selectedCom != "todo") {
        mostrarProvincias();
    }
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
            Swal.fire("El navegador no soporta AJAX. Debe actualizar el navegador");
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
                    lat = innerItem.Latitud;
                    lon = innerItem.Longitud;
                    //obtener selected poblacion desde query
                    var selectedPueblo = urlParams.get('poblacion');
                    //set selected attribute para opción seleccionada
                    $('#poblacion option[value="' + selectedPueblo + '"]').attr('selected', 'selected');
                });
            }
        });

        //set latitude y longitude del pueblo elegido -> para mostrar marker del ubicación en mapa
        $('#poblacion').on("change", function () {
            $("#lat_pueblo").val(lat);
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

            var selectedProv = urlParams.get('provincia');
            $('#provincia option[value="' + selectedProv + '"]').attr('selected', 'selected');
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





