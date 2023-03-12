/**
 * Yulia Tropin Tropina 3DAW Distancia IES Trassierra
 * Proyecto fin del curso "MiLorito" 2023
 * 
 * Script para control deslizante de las fotos del anuncio
 * paginas anunc.oferta.blade y ofertas-filter.blade
 */
"use strict"

let slideIndex;
//evento para mostrar previos foto
let i=0;
$('.carousel-control-prev').each(function () {
    let carousel_inner = 'carousel-inner' + i;
    let carousel_item = $('.' + carousel_inner + ' > *');
    // console.log(carousel_inner);
    slideIndex = 1;
    i++;
    $(this).click(function () {
        plusSlides(-1, carousel_item);
    });
})

//evento para mostrar siguiente foto
let j=0;
$('.carousel-control-next').each(function () {
    let carousel_inner = 'carousel-inner' + j;
    let carousel_item = $('.' + carousel_inner + ' > *');
    // console.log(carousel_inner);
    slideIndex = 1;
    j++;
    $(this).click(function () {
        plusSlides(+1, carousel_item);
    });
})


// Next/previous controls
function plusSlides(n, slides) {
    showSlides(slideIndex += n, slides);
}

function showSlides(n, slides) {
    let i;
    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slides[slideIndex - 1].style.display = "block";
}

