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
console.log(userId);
window.addEventListener("load", () => {
    const elements = document.querySelectorAll('.mostrarChatBoton');
    // Asignar event listener para cada elemento de clase "mostrarChatBoton"
    elements.forEach(element => {
      /*   if(userId ==$("#user1").html()){
            remitente = $("#user1").html();
            recipiente =$("#user2").html();
        }else{
            remitente = $("#user2").html();
            recipiente =$("#user1").html();
        } */
       
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
    var numChat = id.replace('_', '');
    var idChat = 'chat' + numChat; //'chat1', 'chat2' ...

    $('#' + idChat).removeClass('hidden'); //muestra bloque del dialogo elegido
    $(".cruce").on('click', function () {
        $('#' + idChat).addClass('hidden');
        $('#message_form').remove();
    })
    $(".cerrar_form").on('click', function () {
        $('#' + idChat).addClass('hidden');
        $('#message_form').remove();
    })
    $('#chat_body' + numChat).scrollTop($('#chat_body' + numChat)[0].scrollHeight);
    // crear formulario
   // createForm(numChat, idChat);
}
    //evento para submit formulario
    function addEventformulario(idChat){
    $('#message_form').submit(function (event) {
        event.preventDefault();
        
        var user_id = remitente;// $("#user_id").val(); //id del autor del mansaje desde formulario
        
       // anuncio_id = $("#anuncio_id").val(); //anuncio id desde formulario
        var mensaje = $("#texto").val(); //texto del mensaje desde formulario
        anuncio_id = $('#'+idChat).children().first().html();

        var url = "/user/" + user_id + "/mensaje"; //route para post request (Controller enviarMensajeController.php)
        console.log("Remitente: -"+remitente);
       console.log("Recipiente: -"+recipiente);
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

/**
 * Crear formulario 
 * Se crea nuevo formulario cada vez cuando se abre el bloque del dialogo
 * para poder enviar nuevo mensaje desde area privada del usuario
 * 
 * @param {int} id 
 * @param {String} idChat 
 */
function createForm(id, idChat) {
    console.log("Remitente: -"+remitente);
       console.log("Recipiente: -"+recipiente);
    anuncio_id = $('#'+idChat).children().first().html();
    // Crear nuevo elemento <form>
    var form = $('<form>').attr({
        id: 'message_form',
        method:'post',
        action:"/user/"+remitente+"/mensajes"
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
        value: anuncio_id
    }));
   
     // Añadir input campo para remitente_id 
     form.append($('<input>').attr({
        type: 'hidden',
        name: 'user_id',
        id: 'user_id',
        value: remitente
    }));

    // Añadir input campo para remitente_id 
    form.append($('<input>').attr({
        type: 'hidden',
        name: 'remitente_id',
        id: 'remitente_id',
        value: remitente
    }));
    
   
    // Añadir input campo para remitente_id 
    form.append($('<input>').attr({
        type: 'hidden',
        name: 'recipiente_id',
        id: 'recipiente_id',
        value: recipiente
    }));


    // Añadir input campo para anuncio_id  chat_id 
    form.append($('<input>').attr({
        type: 'hidden',
        name: 'chat_id',
        id: 'chat_id',
        value: idChat
    }));

    // Crear <div> para botones
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

    // Añadir buttons div al formulario
    form.append(buttons);

    // Añadir formulario despues bloque del chat
    $('#chat_body' + id).after(form);
  //  addEventformulario(idChat);
}

