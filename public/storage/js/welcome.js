/*autor: Yulia Tropin Tropina, 3DAWd
    Proyecto fin del curso "Mi lorito"*/

"use strict";
window.addEventListener("load", () => {
    setDescripStyle;
    document.getElementById("ofertas").addEventListener("click", mostrarOfertas);
    document.getElementById("demandas").addEventListener("click", mostrarDemandas);

})

let mostrarOfertas = () => {
    let element1 = document.getElementById("ofertas-block");
    let element2 = document.getElementById("demandas-block");
    element1.classList.remove("d-none");
    element2.classList.add("d-none");

    if (!document.getElementById("ofertas").classList.contains('active')) {
        document.getElementById("ofertas").classList.add("active");
    }
    if (document.getElementById("demandas").classList.contains('active'))
        document.getElementById("demandas").classList.remove("active");
}

let mostrarDemandas = () => {
    let element1 = document.getElementById("ofertas-block");
    let element2 = document.getElementById("demandas-block");
    element2.classList.remove("d-none");
    element1.classList.add("d-none");
    if (!document.getElementById("demandas").classList.contains('active')) {
        document.getElementById("demandas").classList.add("active");
    }
    if (document.getElementById("ofertas").classList.contains('active'))
        document.getElementById("ofertas").classList.remove("active");
}

function setDescripStyle() {
    let elements = document.querySelectorAll('.descripcion');
    // Asignar event listener para cada elemento de clase "mostrarChatBoton"
    elements.forEach(element => {
        var element = document.querySelector('.container');
        var lineHeight = parseInt(window.getComputedStyle(element).getPropertyValue('line-height'));
        var lastVisibleLine = Math.floor(element.clientHeight / lineHeight);
        var blurHeight = element.clientHeight - (lastVisibleLine * lineHeight);
        element.style.backdropFilter = `blur(${blurHeight}px)`;
    })

}