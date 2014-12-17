(function ($) {
    $.fn.slide = function () {
        return this.each(function () {
            var me = $(this),
                delay = me.data('delay');

            setInterval(function () {
                me.find('.item:first-child:not(:last-child)').animate({opacity: 0}, 200, function () { $(this).appendTo(me); });
                me.find('.item').animate({opacity: 1}, 200);
            }, delay);
        });
    };

    $('[data-slide]').slide();
})(jQuery);