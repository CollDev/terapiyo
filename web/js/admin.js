/* 
    Created on : 20/11/2013, 09:32:14 AM
    Author     : Joe Robles <joe.robles.pdj@gmail.com>
*/
$("[rel='tooltip']").tooltip();
$(document).on('click', 'a.entity', function(e){
    e.preventDefault();
    var $this = this;
    $('#terapiyoModal').html('')
    $.get('/js/mustachejs-templates/' + $($this).data('original-title') + '.html', function(template){
        if ($($this).data('original-title') === 'Leer') {
            $($this)
                .attr('data-original-title', 'Responder')
                .removeClass('btn-primary')
                .addClass('btn-success')
                .find('span')
                .removeClass('glyphicon-book')
                .addClass('glyphicon-send');
        }
        $.getJSON($($this).attr('href'), function(data){
            $.each(data, function(key, value) {
                if (key === 'estado') {
                    switch (value) {
                        case "0":
                            data[key] = 'Borrador';
                            template = template.replace('option value="0"', 'option value="1" selected')
                            break;
                        case "1":
                            data[key] = 'Activo';
                            template = template.replace('option value="1"', 'option value="1" selected')
                            break;
                        case "2":
                            data[key] = 'Papelera';
                            template = template.replace('<option value="0">Borrador</option>', '<option value="0">Borrador</option><option value="2" selected>Borrador</option>')
                            break;
                    }
                }
            });
            modal = $.mustache(template, data);
            $('#terapiyoModal').html(modal).modal();
        });
    });
});
$(document).on('click', '.crear-noticia', function(e){
    e.preventDefault();
    var titulo = $("form#new-news input#titulo"),
    contenido = $("form#new-news textarea#contenido"),
    inicio = $("form#new-news input#inicio"),
    fin = $("form#new-news #fin"),
    estado = $("form#new-news #estado"),
    datetimeRegex = /^([2][0]\d{2}[\/-]([0]\d|[1][0-2])[\/-]([0-2]\d|[3][0-1]))$|^([2][0]\d{2}[\/-]([0]\d|[1][0-2])[\/-]([0-2]\d|[3][0-1])\s([0-1]\d|[2][0-3])\:[0-5]\d\:[0-5]\d)$/,
    integerRegex = /^\d+$/;

    if (titulo.val() == "") {
        inlineMsg('titulo','Debe ingresar un título.',3);
        titulo.focus();
        return false;
    } else if (contenido.val() == "") {
        inlineMsg('contenido','Debe ingresar un contenido.',3);
        contenido.focus();
        return false;
    } else if (inicio.val() == "") {
        inlineMsg('inicio','Debe ingresar una fecha de inicio de la publicación.',3);
        inicio.focus();
        return false;
    } else if (!inicio.val().match(datetimeRegex)) {
        inlineMsg('inicio','Ha ingresado una fecha de inicio no válida.',3);
        inicio.focus();
        return false;
    } else if (fin.val() == "") {
        inlineMsg('fin','Debe ingresar una fecha de caducidad de la publicación.',3);
        fin.focus();
        return false;
    } else if (!fin.val().match(datetimeRegex)) {
        inlineMsg('fin','Ha ingresado una fecha de caducidad no válida.',3);
        fin.focus();
        return false;
    } else if (!estado.val().match(integerRegex)) {
        inlineMsg('fin','Debe ingresar una fecha de caducidad de la publicación.',3);
        fin.focus();
        return false;
    }
    $form = $('form#new-news');
    $.ajax({
        type: "POST",
        url: $form.attr("action"),
        data: $form.serialize(),
        dataType: "json"
    }).done(function(data){
        var type = 'danger';
        var title = 'Error';
        var top = false;
        var reload = false;
        var message = 'No se pudo crear la noticia.';
        if (data == 1) {
            type = 'success';
            title = 'Éxito';
            top = true;
            message = 'Noticia creada satisfactoriamente.';
            $form.each(function(){
                this.reset();
            });
            $('button.close').trigger('click');
            reload = true;
        }
        $('#flash_message').html('<strong id="flash_title"></strong>&nbsp;&nbsp;').append(message).message(type, title, '#flash_title', top, reload);
    });
});
$(document).on('click', '.editar-noticia', function(e){
    e.preventDefault();
    var titulo = $("form#edit-news input#titulo"),
    contenido = $("form#edit-news textarea#contenido"),
    inicio = $("form#edit-news input#inicio"),
    fin = $("form#edit-news #fin"),
    estado = $("form#edit-news #estado"),
    datetimeRegex = /^([2][0]\d{2}[\/-]([0]\d|[1][0-2])[\/-]([0-2]\d|[3][0-1]))$|^([2][0]\d{2}[\/-]([0]\d|[1][0-2])[\/-]([0-2]\d|[3][0-1])\s([0-1]\d|[2][0-3])\:[0-5]\d\:[0-5]\d)$/,
    integerRegex = /^\d+$/;

    if (titulo.val() == "") {
        inlineMsg('titulo','Debe ingresar un título.',3);
        titulo.focus();
        return false;
    } else if (contenido.val() == "") {
        inlineMsg('contenido','Debe ingresar un contenido.',3);
        contenido.focus();
        return false;
    } else if (inicio.val() == "") {
        inlineMsg('inicio','Debe ingresar una fecha de inicio de la publicación.',3);
        inicio.focus();
        return false;
    } else if (!inicio.val().match(datetimeRegex)) {
        inlineMsg('inicio','Ha ingresado una fecha de inicio no válida.',3);
        inicio.focus();
        return false;
    } else if (fin.val() == "") {
        inlineMsg('fin','Debe ingresar una fecha de caducidad de la publicación.',3);
        fin.focus();
        return false;
    } else if (!fin.val().match(datetimeRegex)) {
        inlineMsg('fin','Ha ingresado una fecha de caducidad no válida.',3);
        fin.focus();
        return false;
    } else if (!estado.val().match(integerRegex)) {
        inlineMsg('fin','Debe ingresar una fecha de caducidad de la publicación.',3);
        fin.focus();
        return false;
    }
    $form = $('form#edit-news');
    $.ajax({
        type: "POST",
        url: $form.attr("action"),
        data: $form.serialize(),
        dataType: "json"
    }).done(function(data){
        var type = 'danger';
        var title = 'Error';
        var top = false;
        var reload = false;
        var message = 'No se pudo editar la noticia.';
        if (data == 1) {
            $('#flash_message').remove();
            type = 'success';
            title = 'Éxito';
            top = true;
            reload = true;
            message = 'Noticia actualizada satisfactoriamente.';
            $form.each(function(){
                this.reset();
            });
            $('button.close').trigger('click');
        }
        $('#flash_message').html('<strong id="flash_title"></strong>&nbsp;&nbsp;').append(message).message(type, title, '#flash_title', top, reload);
    });
});
$(document).on('click', '.eliminar-noticia', function(e){
    e.preventDefault();
    $form = $('form#delete-news');
    $.ajax({
        type: "POST",
        url: $form.attr("action")
    }).done(function(data){
        var type = 'danger';
        var title = 'Error';
        var top = false;
        var reload = false;
        var message = 'No se pudo eliminar la noticia.';
        if (data == 1) {
            $('#flash_message').remove();
            type = 'success';
            title = 'Éxito';
            top = true;
            reload = true;
            message = 'Noticia eliminada satisfactoriamente.';
            $form.each(function(){
                this.reset();
            });
            $('button.close').trigger('click');
        }
        $('#flash_message').html('<strong id="flash_title"></strong>&nbsp;&nbsp;').append(message).message(type, title, '#flash_title', top, reload);
    });
});
$(document).on('click', '.purgar-noticia', function(e){
    e.preventDefault();
    $form = $('form#purge-news');
    $.ajax({
        type: "POST",
        url: $form.attr("action"),
        data: $form.serialize(),
        dataType: "json"
    }).done(function(data){
        var type = 'danger';
        var title = 'Error';
        var top = false;
        var reload = false;
        var message = 'No se pudo purgar la noticia.';
        if (data == 1) {
            $('#flash_message').remove();
            type = 'success';
            title = 'Éxito';
            top = true;
            reload = true;
            message = 'Noticia purgada satisfactoriamente.';
            $form.each(function(){
                this.reset();
            });
            $('button.close').trigger('click');
        }
        $('#flash_message').html('<strong id="flash_title"></strong>&nbsp;&nbsp;').append(message).message(type, title, '#flash_title', top, reload);
    });
});
$(document).on('click', '.recuperar-noticia', function(e){
    e.preventDefault();
    $form = $('form#recycle-news');
    $.ajax({
        type: "POST",
        url: $form.attr("action")
    }).done(function(data){
        var type = 'danger';
        var title = 'Error';
        var top = false;
        var reload = true;
        var message = 'No se pudo recuperar la noticia.';
        if (data == 1) {
            $('#flash_message').remove();
            type = 'success';
            title = 'Éxito';
            top = true;
            reload = true;
            message = 'Noticia recuperada satisfactoriamente.';
            $form.each(function(){
                this.reset();
            });
            $('button.close').trigger('click');
        }
        $('#flash_message').html('<strong id="flash_title"></strong>&nbsp;&nbsp;').append(message).message(type, title, '#flash_title', top, reload);
    });
});
$(document).on('click', '.responder-consulta', function(e){
    e.preventDefault();
    $form = $('form#answer-comment');
    $.ajax({
        type: "POST",
        url: $form.attr("action"),
        data: $form.serialize(),
        dataType: "json"
    }).done(function(data){
        var type = 'danger';
        var title = 'Error';
        var top = false;
        var reload = true;
        var message = 'No se pudo responder la consulta.';
        if (data.responseCode == 200) {
            $('#flash_message').remove();
            type = 'success';
            title = 'Éxito';
            top = true;
            reload = true;
            message = 'Consulta respondida satisfactoriamente.';
            $form.each(function(){
                this.reset();
            });
            $('button.close').trigger('click');
        }
        $('#flash_message').html('<strong id="flash_title"></strong>&nbsp;&nbsp;').append(message).message(type, title, '#flash_title', top, reload);
    });
});
$(document).on('mouseover', '.datetimepicker', function() {
    $('.datetimepicker').datetimepicker({
        language: 'es'
    });
    $(function () {
        $('#inicio-div').datetimepicker();
        $('#fin-div').datetimepicker();
        $("#inicio-div").on("change.dp",function (e) {
            $('#fin-div').data("DateTimePicker").setStartDate(e.date);
        });
        $("#fin-div").on("change.dp",function (e) {
            $('#inicio-div').data("DateTimePicker").setEndDate(e.date);
        });
    });
});