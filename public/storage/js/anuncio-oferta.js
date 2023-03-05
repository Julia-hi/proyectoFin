

$(document).ready(function () {

    $("#crearMensaje").on("click", showFormulario);

    // showFormulario();
    // showDiv();
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

/* function showFormulario() {

    document.getElementById('crearMensaje').addEventListener('click', function() {
        // Open a new window with the form
        var messageWindow = window.open('', 'messageWindow', 'width=400,height=400');

        // Create the form elements
        var form = messageWindow.document.createElement('form');
        var label = messageWindow.document.createElement('label');
        var input = messageWindow.document.createElement('input');
        var submit = messageWindow.document.createElement('input');

        // Set attributes for the form elements
        form.setAttribute('method', 'post');
        form.setAttribute('action', 'submit-form.php');
        label.innerHTML = 'Message:';
        input.setAttribute('type', 'text');
        input.setAttribute('name', 'message');
        submit.setAttribute('type', 'submit');
        submit.setAttribute('value', 'Send');

        // Add the form elements to the form and the form to the window
        form.appendChild(label);
        form.appendChild(input);
        form.appendChild(submit);
        messageWindow.document.body.appendChild(form);
    })
} */