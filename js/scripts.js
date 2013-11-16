/* 
    Created on : 24/10/2013, 12:54:09 PM
    Author     : Joe Robles <joe.robles.pdj@gmail.com>
*/
$('span.ca-icon').on('click', function(e){
    e.preventDefault();
    var $this = this;
    $.getJSON("/js/mustachejs-templates/" + $($this).attr('class').substr(8) + ".json", function(data){
        $.get("/js/mustachejs-templates/modal.html", function(modal){
            var $modal = $.mustache(modal, data);
            $('#terapiyoModal').html($modal).modal();
        });
    });
});
$('span.cat-icon').on('click', function(e){
    e.preventDefault();
    $.getJSON("/js/mustachejs-templates/terapiyo.json", function(data){
        $.get("/js/mustachejs-templates/terapiyo-modal.html", function(modal){
            var $modal = $.mustache(modal, data);
            $('#terapiyoModal').html($modal).modal();
        });
    });
});
$('.contacto').on('click', function(e){
    initialize();
});
$('.noticias').on('click', function(e){
    e.preventDefault();
    $.getJSON("/js/mustachejs-templates/noticias.json", function(data){
        $.get("/js/mustachejs-templates/noticias-modal.html", function(modal){
            var $modal = $.mustache(modal, data);
            $('#terapiyoModal').html($modal).modal();
        });
    });
});
var myCenter=new google.maps.LatLng(53, -1.33);
var marker=new google.maps.Marker({
    position:myCenter
});

function initialize() {
    var mapProp = {
        center:myCenter,
        zoom: 14,
        draggable: false,
        scrollwheel: false,
        mapTypeId:google.maps.MapTypeId.ROADMAP,
    };

    var map=new google.maps.Map(document.getElementById("map-canvas"),mapProp);
    marker.setMap(map);

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString);
        infowindow.open(map, marker);
    });

};
