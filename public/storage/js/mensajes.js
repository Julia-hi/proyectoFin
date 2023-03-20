/**
 * Proyecto fin del curso "MiLorito"
 * @autor Yulia Tropin tropina 3DAWD IES Trassierra
 * 
 * Notación importante: jQuery required!
 */
"use strict"
let recipiente;
let remitente;
let userId = window.location.href.match(/\/user\/(\d+)/)[1];
var anuncio_id;
var chat_id;

window.addEventListener("load", () => {
    if (window.location.hash != '') {
        chat_id = window.location.hash.substring(1);
        console.log(chat_id);
        mostrarOpenedChat(chat_id);
    }
    const elements = document.querySelectorAll('.mostrarChatBoton');
    // Asignar event listener para cada elemento de clase "mostrarChatBoton"
    elements.forEach(element => {
        element.addEventListener('click', function () {
            var id = element.getAttribute('id');
            mostrarChat(id);
        });
    })
}
)

/**
 * Mostrar chat se chat era abierto
 * 
 * @param {String} idchat
 */
function mostrarOpenedChat(idChat) {
    var numChat = idChat.replace('chat', '');
    // var idChat = 'chat' + numChat; //'chat1', 'chat2' ...

    $('#' + idChat).removeClass('hidden'); //muestra bloque del chat elegido
    $(".cruce").on('click', function () {
        $('#' + idChat).addClass('hidden');
        $('#message_form').remove();
        window.location.hash = ""; // eliminar valor hash
    })
    $(".cerrar_form").on('click', function () {
        $('#' + idChat).addClass('hidden');
        $('#message_form').remove();
        window.location.hash = ""; // eliminar valor hash
    })
    $('#chat_body' + numChat).scrollTop($('#chat_body' + numChat)[0].scrollHeight);
}

/**
 * Mostrar chat al pulsar boton
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
    var numChat = id.replace('_', '');
    var idChat = 'chat' + numChat; //'chat1', 'chat2' ...

    $('#' + idChat).removeClass('hidden'); //muestra bloque del chat elegido
    $(".cruce").on('click', function () {
        $('#' + idChat).addClass('hidden');
        $('#message_form').remove();
        window.location.hash = ""; // eliminar valor hash
    })
    $(".cerrar_form").on('click', function () {
        $('#' + idChat).addClass('hidden');
        $('#message_form').remove();
        window.location.hash = ""; // eliminar valor hash
    })
    $('#chat_body' + numChat).scrollTop($('#chat_body' + numChat)[0].scrollHeight);
}
//evento para submit formulario
function addEventformulario(idChat) {
    $('#message_form').submit(function (event) {
        event.preventDefault();

        var user_id = remitente;//id del autor del mansaje desde formulario

        var mensaje = $("#texto").val(); //texto del mensaje desde formulario
        anuncio_id = $('#' + idChat).children().first().html();

        var url = "/user/" + user_id + "/mensaje"; //route para post request (Controller enviarMensajeController.php)
        //obtener respuesta 
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                anuncio_id: anuncio_id,
                user_id: remitente,
                remitente_id: remitente,
                recipiente_id: recipiente,
                texto: mensaje
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
 * 
 * @param {Object} data - respuesta de query
 * @param {String} idChat - anuncio ID
 */
function mostrarUltimo(data, idChat) {
    if (data.success) {
        console.log(data.message.texto);
        // Crear nuevo elemento <li> con clases y attributos
        var li = $("<li>", {
            "class": "d-flex justify-content-end w-100 mb-2 mt-0"
        });

        // Crear nuevo <div> elemento con clases y attributos
        var div = $("<div>", {
            "class": "bg-white rounded px-3 py-2",
            "text": data.message.texto
        });

        // Añadir elemento <div> al elemento <li>
        li.append(div);

        // Añadir elemento <li> a su padre <ul>
        var ult_id = "ultimo_mensaje" + idChat;
        $("#" + ult_id).append(li);
        $("#texto").val(''); //limpiar campo de textarea
    }
}


