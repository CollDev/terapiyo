/* 
    Created on : 24/10/2013, 12:54:09 PM
    Author     : Joe Robles <joe.robles.pdj@gmail.com>
*/
$('span.ca-icon').on('click', function(e){
    e.preventDefault();
    var $this = this;
    $.get("/js/mustachejs-templates/" + $($this).attr('class').substr(8) + ".json", function(data){
        $.get("/js/mustachejs-templates/modal.html", function(modal){
            var $modal = $.mustache(modal, data);
            $('#terapiyoModal').html($modal).modal();
        });
    });
});
$('span.cat-icon').on('click', function(e){
    e.preventDefault();
    $.get("/js/mustachejs-templates/terapiyo.json", function(data){
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
$('.noticias').on('click', function(e){
    e.preventDefault();
    $.get("/js/mustachejs-templates/noticias.json", function(data){
        $.get("/js/mustachejs-templates/noticias-modal.html", function(modal){
            var $modal = $.mustache(modal, data);
            $('#terapiyoModal').html($modal).modal();
        });
    });
});