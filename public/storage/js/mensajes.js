"use strict"

window.addEventListener("load", () => {

    const elements = document.querySelectorAll('.mostrarChatBoton');

    // Add an event listener to each element
    elements.forEach(element => {
        element.addEventListener('click', function () {
            var id = element.getAttribute('id');
            //  mostrarChat(id);
            mostrarDiv(id);
        });
    })
})
/* function mostrarChat(id) {
    var idChat = 'chat' + id.replace('_', '');
    // if()
    if ($('#' + idChat).hasClass('hidden')) {
        $('#' + idChat).removeClass('hidden');
       
    }
} */

function mostrarDiv(id) {
    var idChat = 'chat' + id.replace('_', '');
   // var chatDiv = $('#' + idChat);
    // create the main div
    var chatDiv = $("<div>").attr("id", idChat).addClass("oculto");

    // create the inner border div
    var borderDiv = $("<div>").addClass("border position-absolute px-2 mx-auto w-25 h-25")
        .css({
            "top": "0",
            "left": "0",
            "min-height": "25%",
            "background-color": "red",
            "z-index": "10"
        })
        .attr("title", "Cerrar");

    // create the button div
    var buttonDiv = $("<div>").addClass("bg-white position-absolute top-0 start-0")
        .css({
            "width": "25px",
            "height": "25px",
            "z-index": "30"
        })
        .click(function () {
            $('#' + idChat).addClass("oculto");
        });

    // create the SVG element
    var svg = $("<svg>").attr({
        "xmlns": "http://www.w3.org/2000/svg",
        "width": "25",
        "height": "25",
        "viewBox": "0 0 16 16"
    }).css("z-index", "35");

    // create the path element
    var path = $("<path>").attr({
        "fill": "#1F2937",
        "d": "M11.414 4.586a2 2 0 0 0-2.828 0L8 5.172 6.414 3.586a2 2 0 1 0-2.828 2.828L5.172 8l-1.586 1.586a2 2 0 1 0 2.828 2.828L8 10.828l1.586 1.586a2 2 0 1 0 2.828-2.828L10.828 8l1.586-1.586a2 2 0 0 0 0-2.828z"
    });

    // append the path element to the SVG element
    svg.append(path);

    // append the SVG element to the button div
    buttonDiv.append(svg);

    // append the button div to the inner border div
    borderDiv.append(buttonDiv);

    // append the inner border div to the main div
    chatDiv.append(borderDiv);

    // add the main div to the DOM
    $("#chat").append(chatDiv);

}
