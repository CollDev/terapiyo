(function($){
    $.fn.extend({
        message: function(type, title, title_id, top){
            $(title_id).html('').append(title);
            var del = 0;
            if ($(window).scrollTop() !== 0) {
                if (top) {
                    $("html, body").animate({ scrollTop: 0 }, 600);
                }
                del = 600;
            }
            $(this).removeClass().addClass('alert').addClass('alert-' + type).delay(del).slideDown().delay(3000).slideUp();
        }
    });
})(jQuery);