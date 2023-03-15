/**
 * autor: Yulia Tropin Tropina, 3DAWd IES "Trassierra"
 * Proyecto fin del curso "Mi lorito"
 * 
 * jQuery required
 * */

"use strict";

let anuncio;
let xmlHttp;

/**
 * Datos de la comunidad seleccionada (json)
 * @var Object
 */
let datos;

window.addEventListener("load", () => {
    //obtener valores actuales del anuncio (string)
    anuncio = JSON.parse($("#anuncio_actuale").text());
    setTitulo(anuncio);
    setRaza(anuncio);
    setGenero(anuncio);
    setFecha(anuncio);
    let selectedComunidad = setComunidad(anuncio);
    xmlHttp = crearConexion();
    if (selectedComunidad != "todo") {
        mostrarProvincias();
    }
    $("#comunidad").on("change", mostrarProvincias);
})

/**
 * Titulo actual del anuncio
 * @param {Object} anuncio 
 */
function setTitulo(anuncio) {
    var titulo = $('#titulo_actual').val(anuncio.titulo);
    $("#titulo").on("change", function () {
        $("#titulo_nuevo").val($("#titulo_actual").val());
        anuncio_editado['titulo'] = ($("#titulo_actual").val());
    });
}

/**
 * Descripcion actual del anuncio
 * @param {Object} anuncio 
 */
function setDescripcion(anuncio) {
    var optionsRaza = $('#descripcion').val(anuncio.descripcion);
}

/**
 * Raza elegida inicialmente
 * @param {Object} anuncio 
 */
function setRaza(anuncio) {
    var optionsRaza = $('#raza').find('option');
    //añadir atributo "selected" para opcion seleccionada anteriormente
    optionsRaza.each(function () {
        if ($(this).val() == anuncio.raza) {
            $(this).attr('selected', 'selected');
        }
    });
}

/**
 * Genero elegido inicialmente
 * @param {Object} anuncio 
 */
function setGenero(anuncio) {
    var optionsGenero = $('#genero').find('option');
    //añadir atributo "selected" para opcion seleccionada anteriormente
    optionsGenero.each(function () {
        if ($(this).val() == anuncio.genero) {
            $(this).attr('selected', 'selected');
        }
    });
}

/**
 * Añade fecha elegida anteriormente
 * @param {Object} anuncio 
 */
function setFecha(anuncio) {
    //añadir valor para fecha de nacimiento
    $("#fecha_nac").val(anuncio.fecha_nac);
}

/**
 * Comunidad elegida inicialmente
 * @param {Object} anuncio 
 * @returns String
 */
function setComunidad(anuncio) {
    let selectedComunidad;
    var optionsComunidad = $("#comunidad").find('option');
    optionsComunidad.each(function () {
        if ($(this).val() == anuncio.comunidad) {
            selectedComunidad = $(this).attr('selected', 'selected');
        }
    })
    return selectedComunidad;
}

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
        $("#provincia").append("<option value='todo'>Seleccione provincia ...</option>");
        $("#poblacion").append("<option value='todo'>Seleccione poblacion ...</option>");
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

/**
 * Mostrar poblaciones para provincia elegida
 * @param {Object} datos 
 */
let mostrarPoblaciones = (datos) => {
    let lat, lon, selectedProv;
    $("#poblacion").empty();
    if ($("#provincia").value == "todo" || $("#comunidad").value == "todo") {
        $("#poblacion").innerHTML = '';
        $("#poblacion").append("<option value='todo' selected>Seleccione poblacion ...</option>");
    } else {
        $("#poblacion").append("<option value='todo' selected>Seleccione poblacion ...</option>");
        if ($("#provincia option:selected").text()) {
            selectedProv = $("#provincia option:selected").text();
        } else {
            // selectedProv = anuncio.provincia;
            var optionsProvincia = $("#provincia").find('option');
            optionsProvincia.each(function () {
                if ($(this).val() == anuncio.provincia) {
                    selectedProv = $(this).attr('selected', 'selected');
                }
            })
        }

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

                    //obtener opciones de poblacion select
                    let optionsPueblo = $("#poblacion").find('option');
                    //añadir atributo "selected" para opcion seleccionada anteriormente
                    optionsPueblo.each(function () {
                        if ($(this).val() == anuncio.poblacion) {
                            $(this).attr('selected', 'selected');
                        }
                    });
                });
            }
        });

        //set latitude y longitude del pueblo elegido -> para mostrar marker del ubicación en mapa
        var selectedPueblo = $("#poblacion option:selected").val();
        lat = $("#lat_" + selectedPueblo).text();
        lon = $("#lon_" + selectedPueblo).text();
        $("#lat_pueblo").text(lat);
        $("#lat_pueblo").val(lat);
        $("#lon_pueblo").text(lon);
        $("#lon_pueblo").val(lon);
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

/**
 * cargar provincias desde JSON de la comunidad elegida
 * @param {String} com 
 */
let cargarProvincias = (com) => {
    xmlHttp.open("GET", "/storage/comunidades/" + com + ".json", true);
    xmlHttp.onreadystatechange = () => {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            datos = JSON.parse(xmlHttp.responseText);
            //ordenar las provincias
            datos.Provincia.sort();

            $("#provincia").innerHTML = "";
            $("#provincia").append("<option value='todo'>Seleccione provincia ...</option>")
            $(datos.Provincia).each((ind, elemento) => {
                $('#provincia').append($('<option>', {
                    value: Object.keys(elemento),
                    text: Object.keys(elemento)
                }));
            })

            // var selectedProv = $("#provincia").val();
            //  $('#provincia option[value="' + selectedProv + '"]').attr('selected', 'selected');
            var optionsProvincia = $("#provincia").find('option');

            optionsProvincia.each(function () {
                let selectedProv;
                if ($(this).text() == anuncio.provincia) {
                    selectedProv = $(this).attr('selected', 'selected');
                } else {
                    selectedProv = $("#provincia").val();
                }
            })
            mostrarPoblaciones(datos);
            $('#provincia').on('change', mostrarPoblaciones(datos));
        }
    };
    xmlHttp.send(); //comienza la petición de respuesta al servidor
}

/**
 * crear conexión asincrona
 * @returns Object
 */
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