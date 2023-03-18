

$(document).ready(function () {

    $("#crearMensaje").on("click", showFormulario);

    var draggable = document.getElementById('draggable');
    var isDragging = false;
    var dragX, dragY;

    draggable.addEventListener('mousedown', function (e) {
        isDragging = true;
        dragX = e.clientX - draggable.offsetLeft;
        dragY = e.clientY - draggable.offsetTop;
    });

    document.addEventListener('mousemove', function (e) {
        if (isDragging) {
            draggable.style.left = (e.clientX - dragX) + 'px';
            draggable.style.top = (e.clientY - dragY) + 'px';
        }
    });

    document.addEventListener('mouseup', function () {
        isDragging = false;
    });

});

function showDiv() {
    var button = document.getElementById('crearMensaje');
    button.addEventListener('click', function () {
        // Create a new div element
        var newDiv = document.createElement('div');

        // Set some properties for the new div element
        newDiv.innerHTML = 'This is a dynamically created div.';
        newDiv.style.backgroundColor = 'blue';
        newDiv.style.width = '100px';
        newDiv.style.height = '100px';
        newDiv.style.color = 'white';
        newDiv.style.padding = '20px';
        newDiv.style.margin = '10px';

        // Append the new div element to the document body
        document.body.appendChild(newDiv);
    });
}

function showFormulario() {
    var formulario = $("#draggable");
    if ($("#draggable").hasClass('hidden')) {
        $("#draggable").removeClass('hidden');
        const cerrarBotons = document.querySelectorAll('.cerrar_dragable');
        cerrarBotons.forEach(boton => {
            boton.addEventListener('click', function () {
                $("#draggable").addClass('hidden');
            })
        })
    } else {
        $("#draggable").addClass('hidden');
    }
}

