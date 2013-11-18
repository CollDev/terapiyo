$("[rel='tooltip']").tooltip();
$(document).on('ready', function(){
    $.getJSON('/admin/api/', function(data){
        var noticias = {
            noticia: data
        };
        $.get('/js/mustachejs-templates/noticias-list.html', function(template){
            var list = '<tr><td colspan="5"><h2>No hay noticias aún</h2></td></tr>';
            if (noticias != '') {
                list = $.mustache(template, noticias);
            }
            $('tbody.news-list').html(list);
            $("[rel='tooltip']").tooltip();
        });
    });
    $(document).on('click', 'a.entity', function(e){
        e.preventDefault();
        var $this = this;
        $('#terapiyoModal').html('')
        $.get('/js/mustachejs-templates/' + $($this).data('original-title') + '.html', function(template){
            $.getJSON($($this).attr('href'), function(data){
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
        datetimeRegex = /^((((19|20)([2468][048]|[13579][26]|0[48])|2000)-02-29|((19|20)[0-9]{2}-(0[469]|11)-(0[1-9]|[12][0-9]|30)|(19|20)[0-9]{2}-(0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01])|(19|20)[0-9]{2}-02-(0[1-9]|1[0-9]|2[0-8])))\s([01][0-9]|2[0-3]):([012345][0-9]):([012345][0-9]))$/,
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
            }
            $('#flash_message').html('<strong id="flash_title"></strong>&nbsp;&nbsp;').append(message).message(type, title, '#flash_title', top);
        });
    });
    $(document).on('click', '.editar-noticia', function(e){
        e.preventDefault();
        var titulo = $("form#edit-news input#titulo"),
        contenido = $("form#edit-news textarea#contenido"),
        inicio = $("form#edit-news input#inicio"),
        fin = $("form#edit-news #fin"),
        estado = $("form#edit-news #estado"),
        datetimeRegex = /^((((19|20)([2468][048]|[13579][26]|0[48])|2000)-02-29|((19|20)[0-9]{2}-(0[469]|11)-(0[1-9]|[12][0-9]|30)|(19|20)[0-9]{2}-(0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01])|(19|20)[0-9]{2}-02-(0[1-9]|1[0-9]|2[0-8])))\s([01][0-9]|2[0-3]):([012345][0-9]):([012345][0-9]))$/,
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
            var message = 'No se pudo editar la noticia.';
            if (data == 1) {
                type = 'success';
                title = 'Éxito';
                top = true;
                message = 'Noticia actualizada satisfactoriamente.';
                $form.each(function(){
                    this.reset();
                });
                $('button.close').trigger('click');
            }
            $('#flash_message').html('<strong id="flash_title"></strong>&nbsp;&nbsp;').append(message).message(type, title, '#flash_title', top);
        });
    });
});