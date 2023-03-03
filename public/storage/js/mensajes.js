"use strict"

window.addEventListener("load", () => {

    const elements = document.querySelectorAll('.mostrarChatBoton');
    // Asignar event listener para cada elemento de clase "mostrarChatBoton"
    elements.forEach(element => {
        element.addEventListener('click', function () {
            var id = element.getAttribute('id');
            mostrarChat(id);
        });
    })

})

/**
 * Mostrar chat
 * 
 * @param {String} id 
 */
function mostrarChat(id) {
    //cerrar todos bloques chat primero de abrir nuevo
    $('.chat').each(function () { //cada elemento de clase "chat"
        if (!$(this).hasClass('hidden')) {
            // eliminar formularios de chat anterior
            $('#message_form').remove();
            $(this).addClass('hidden');
        }

    });
    var anuncio_id = id.replace('_', '');
    var idChat = 'chat' + anuncio_id; //'chat1', 'chat2' ...
    $('#' + idChat).removeClass('hidden'); //muestra bloque del dialogo elegido
    $("#cruce").on('click', function () {
        $('#' + idChat).addClass('hidden');
        $('#message_form').remove();
    })
    $('#chat_body' + anuncio_id).scrollTop($('#chat_body' + anuncio_id)[0].scrollHeight);

    createForm(anuncio_id, idChat, anuncio_id);

    //evento para submit formulario
    $('#message_form').submit(function (event) {
        event.preventDefault();
        var user_id = $("#user_id").val(); //id del autor del mansaje desde formulario
        var anuncio_id = $("#anuncio_id").val(); //anuncio id desde formulario
        var mensaje = $("#texto").val(); //texto del mensaje desde formulario
        console.log(anuncio_id);
        var url = "/user/" + user_id + "/mensaje"; //route para post request (Controller enviarMensajeController.php)
        //obtener respuesta 
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                texto: mensaje,
                anuncio_id: anuncio_id,
                user_id: user_id
            })
        })
            .then(response => {
                return response.json();
            })
            .then(data => {
                console.log(data);
                mostrarUltimo(data, anuncio_id);
            })
            .catch(error => console.error(error));
    });
}

/**
 * Mostrar ultimo mensaje despues del submit
 * @param {Object} data 
 * @param {String} idChat 
 */
function mostrarUltimo(data, idChat, anuncio_id) {
    if (data.success) {
        console.log(data.message.texto);
        // Create a new <li> element with class and attributes
        var li = $("<li>", {
            "class": "d-flex justify-content-end w-100 mb-2 mt-0"
        });

        // Create a new <div> element with class and attributes
        var div = $("<div>", {
            "class": "bg-white rounded px-3 py-2",
            "text": data.message.texto
        });

        // Append the <div> element to the <li> element
        li.append(div);

        // Add the new <li> element to a parent element, e.g. <ul>
        var ult_id = "ultimo_mensaje" + idChat;
        console.log("ultimo: " + ult_id);
        $("#" + ult_id).append(li);
        //  $('#chat_body' + anuncio_id).append('<div class="bg-white rounded px-3 py-2">' + data.message.texto + '</div>'); //mostrar ultimo mensaje
        $("#texto").val(''); //limpiar campo de textarea
    }
}

function createForm(id, idChat) {

    // Crear nuevo elemento <form>
    var form = $('<form>').attr({
        id: 'message_form'
    });

    // Añadir CSRF token al formulario
    form.append($('<input>').attr({
        type: 'hidden',
        name: '_token',
        value: '{{ csrf_token() }}'
    }));

    // Añadir textarea campo al formulario
    form.append($('<textarea>').attr({
        id: 'texto',
        name: 'texto',
        placeholder: 'Escribe mensaje aqui...',
        class: 'form-control',
        rows: '2'
    }));

    // Añadir input campo para anuncio_id 
    form.append($('<input>').attr({
        type: 'hidden',
        name: 'anuncio_id',
        id: 'anuncio_id',
        value: id
    }));
    var userId = window.location.href.match(/\/user\/(\d+)/)[1];
    console.log(userId);
    // Añadir input campo para anuncio_id  user_id 
    form.append($('<input>').attr({
        type: 'hidden',
        name: 'user_id',
        id: 'user_id',
        value: userId
    }));


    // Añadir input campo para anuncio_id  chat_id 
    form.append($('<input>').attr({
        type: 'hidden',
        name: 'chat_id',
        id: 'chat_id',
        value: idChat
    }));

    // Crear div para botones
    var buttons = $('<div>').attr({
        class: 'd-flex items-center justify-content-end my-2'
    });

    // Añadir reset button para formulario
    buttons.append($('<button>').attr({
        type: 'reset',
        class: 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    }).text('Limpiar'));

    // Añadir submit button para formulario
    buttons.append($('<button>').attr({
        type: 'submit',
        class: 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    }).text('Enviar'));

    // Aladir buttons div al formulario
    form.append(buttons);

    // Añadir formulario despues bloque del chat
    $('#chat_body' + id).after(form);
}

