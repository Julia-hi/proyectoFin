"use strict"
document.documentElement.scrollTop = 500;
window.onload = function() {
    var map = L.map('map').setView([40.416775, -3.703790], 12);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    mostrarMarcadores(map);
};

function mostrarMarcadores(map){
    
    ofertas_json.forEach(element => {
        var lat = element.lat;
        var lon = element.lon;
        console.log(element.lat+" long: "+element.lon);
          L.marker([lat, lon]).addTo(map);
    });
}
 //var marker = L.marker([51.5, -0.09], {icon: myIcon}).addTo(map);