/* 
    Created on : 24/10/2013, 12:54:09 PM
    Author     : Joe Robles <joe.robles.pdj@gmail.com>
*/

$('span.adul').on('click', function(e){
    e.preventDefault();
    var $this = this;
    var course = $($this).attr('class').substr(8);
    $.getJSON("/includes/" + course.substring(0, course.length - 5) + ".json", function(data){
        $.get("/js/mustachejs-templates/modal.html", function(modal){
            var $modal = $.mustache(modal, data);
            $('#terapiyoModal').html($modal).modal();
        });
    });
});
$('span.ter').on('click', function(e){
    e.preventDefault();
    $.getJSON("/includes/terapiyo.json", function(data){
        $.get("/js/mustachejs-templates/terapiyo-modal.html", function(modal){
            var $modal = $.mustache(modal, data);
            $('#terapiyoModal').html($modal).modal();
        });
    });
});
$('.contacto').on('click', function(e){
    e.preventDefault();
        $.get("/js/mustachejs-templates/contacto-modal.html", function(modal){
            $('#terapiyoModal').html(modal).modal();
    });
});
$(document).on('click', ".btn-secondary", function(e) {
    e.preventDefault();
    var nombre       = $("form#contact input#nombre"),
        email        = $("form#contact input#email"),
        telefono     = $("form#contact input#telefono"),
        comentario   = $("form#contact #consulta"),
        nameRegex    = /^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/,
        phoneRegex   = /[0-9-()+]{3,20}/,
        emailRegex   = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    if (nombre.val() == "") {
        inlineMsg('nombre','Debe ingresar su nombre.',3);
        nombre.focus();
        return false;
    } else if(!nombre.val().match(nameRegex)) {
        inlineMsg('nombre','Ha ingresado un nombre no válido.',3);
        nombre.focus();
        return false;
    } else if (telefono.val() != '' && !telefono.val().match(phoneRegex)) {
        inlineMsg('telefono','Ha ingresado un teléfono no válido.',3);
        telefono.focus();
        return false;
    } else if (email.val() == "") {
        inlineMsg('email','Debe ingresar su correo electrónico.',3);
        email.focus();
        return false;
    } else if (!email.val().match(emailRegex)) {
        inlineMsg('email','Ha ingresado un correo no válido.',3);
        email.focus();
        return false;
    } else if (comentario.val() == "") {
        inlineMsg('consulta','Debe ingresar un comentario.',3);
        comentario.focus();
        return false;
    }
    $form = $('form#contact');
    $.ajax({
        type: "POST",
        url: $form.attr("action"),
        data: $form.serialize(),
        dataType: "json"
    }).done(function(data){
        var type = 'danger';
        var title = 'Error';
        var top = false;
        if (data.responseCode == 200) {
            $('#flash_message').remove();
            type = 'success';
            title = 'Éxito';
            top = true;
            $form.each(function(){
                this.reset();
            });
            $('a.volver').trigger('click');
        }
        $('#flash_message').html('<strong id="flash_title"></strong>&nbsp;&nbsp;').append(data.response).message(type, title, '#flash_title', top);
    });
});
$(document).on('ready', function(){
    $.getJSON('/api/', function(data){
        var noticias = {
            noticia: data
        };
        $.get("/js/mustachejs-templates/noticias-scroll.html", function(modal){
            var $scroll = '<tr><td colspan="5"><h2>No hay noticias aún</h2></td></tr>';
            if (data != '') {
                $scroll = $.mustache(modal, noticias);
            }
            $('.news-footer').html($scroll);
            $('.scroll-pane').jScrollPane({
                verticalDragMaxHeight: 56,
                verticalDragMinHeight: 56,
                showArrows: false
            });
            $(document).on('click', '.news-footer', function(e){
                var target = $(e.target);
                target.attr('href');
                if (target.attr('class') === 'jspDrag jspHover') {
                    return false;
                }
                if (typeof target.attr('href') === "undefined") {
                    $.getJSON('/api/', function(data){
                        var noticia = {
                            noticias: data
                        };
                        $.get("/js/mustachejs-templates/noticias-modal.html", function(modal){
                            var $modal = '<tr><td colspan="5"><h2>No hay noticias aún</h2></td></tr>';
                            if (data != '') {
                                $modal = $.mustache(modal, noticia);
                            }
                            $('#terapiyoModal').html($modal).modal();
                        });
                    });
                } else {
                    e.preventDefault();
                    $.getJSON(target.attr('href'), function(data){
                        $.get("/js/mustachejs-templates/noticia-modal.html", function(modal){
                            var $modal = '<tr><td colspan="5"><h2>Error en noticia</h2></td></tr>';
                            if (data != '') {
                                $modal = $.mustache(modal, data);
                            }
                            $('#terapiyoModal').html($modal).modal();
                        });
                    });
                }
            });
        });
    });
});