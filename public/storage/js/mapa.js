"use strict"
let datosGeoJson;
var map;
document.documentElement.scrollTop = 500;
window.onload = function () {
    map = L.map('map').setView([40.416775, -3.703790], 6.8);
    //console.log(ofertas_json[0].comunidad);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    mostrarMarcadores(map);
};

/**
 * mostrar marcadores de ubicación de los anuncios oferta
 * @param {Object} map 
 */
function mostrarMarcadores(map) {
    var marcadores = [];
    ofertas_json.forEach(element => {
        var lat = element.lat;
        var lon = element.lon;
        console.log(element.lat + " long: " + element.lon);
        //var marker = L.marker([51.5, -0.09], {icon: myIcon}).addTo(map);
        var marker = L.marker([lat, lon]).addTo(map);
        var marcador = [lon,lat];
        marcadores.push(marcador);
        marker.on('click', function (e) {
            // redirect to another page
            window.location.href = "/ofertas/" + element.id;
        });  
    });
    if (ofertas_json[0].comunidad != 'todo') {
      mostrarComunidad(marcadores);
    }
}

function mostrarComunidad(coordinados) {
   // console.log("mostrar comunidad");
   console.log(Object.keys(coordinados).length);
    let polygon = L.polygon(coordinados);
    let bounds = polygon.getBounds();
    let southWest = bounds.getSouthWest();
    let northEast = bounds.getNorthEast();
    let cSouthWest = L.latLng(southWest.lng, southWest.lat);
    let cNortEast = L.latLng(northEast.lng, northEast.lat);
    let newBounds = L.latLngBounds(cSouthWest, cNortEast);
    console.log(newBounds);
    map.fitBounds(newBounds);
}