/* 
    Created on : 24/10/2013, 12:54:09 PM
    Author     : Joe Robles <joe.robles.pdj@gmail.com>
*/
var $modal = '<div class="modal-dialog">\n\
    <div class="modal-content">\n\
        <div class="modal-body">\n\
            <p>{{ body }}</p>\n\
        </div>\n\
    </div>\n\
</div>';

$('span.ca-icon').on('click', function(e){
        e.preventDefault();
        var $this = this;
        var data = {
            body: '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>',
        };
        var modal = $.mustache($modal, data);
        $('#terapiyoModal').html(modal).modal();
    });