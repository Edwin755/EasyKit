(function ($) {
    $.fn.accordion = function (options) {
        return this.each(function () {
            var me = $(this),
                subitem = me.next('ul'),
                settings = $.extend({
                    duration: 300
                }, options);

            subitem.hide();

            me.on('click', function (e) {
                e.preventDefault();

                if (!subitem.hasClass('enabled') && !subitem.hasClass('animating')) {
                    subitem.addClass('enabled');
                    subitem.slideDown({
                        duration: settings.duration,
                        start: function () {
                            subitem.addClass('animating')
                        },
                        complete: function () {
                            subitem.removeClass('animating');
                        }
                    });

                    count = 0;
                    subitem.find('.item').each(function () {
                        var link = $(this).find('a');

                        link.css({
                            'padding-left': 0
                        });

                        link.delay(count * 50).animate({
                            'padding-left': '45px'
                        }, settings.duration);
                        count++;
                    });
                } else if (!subitem.hasClass('animating')) {
                    subitem.removeClass('enabled');
                    subitem.slideUp({
                        duration: settings.duration,
                        start: function () {
                            subitem.addClass('animating')
                        },
                        complete: function () {
                            subitem.removeClass('animating');
                        }
                    });

                    count = 0;
                    subitem.find('.item').each(function () {
                        var link = $(this).find('a');

                        link.delay(count * 50).animate({
                            'padding-left': 0
                        }, settings.duration);
                        count++;
                    });
                }
            });
        });
    };

    $('[data-subitem]').accordion();
})(jQuery);