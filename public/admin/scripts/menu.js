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

    $.fn.menu = function () {
        return this.each(function () {
            var me = $(this),
                subitem = me.next('ul'),
                height = subitem.css('height');
                width = subitem.css('width');

            subitem.hide();

            subitem.addClass('hidden');

            me.on('click', function (e) {
                e.preventDefault();


                if (subitem.hasClass('hidden') && !subitem.hasClass('animating')) {
                    subitem.css({
                        'width': 0,
                        'height': 0,
                        'display': 'block'
                    });

                    subitem.find('.item').css({
                        'opacity': 0
                    });

                    subitem.addClass('animating');
                    subitem.removeClass('hidden');

                    subitem.animate({
                        'width': width,
                        'height': height
                    }, {
                        'duration': 200,
                        complete: function () {
                            count = 0;
                            subitem.find('.item').each(function () {
                                $(this).delay(count * 50).animate({
                                    'opacity': 1
                                }, 100);
                                count++;
                            });
                            subitem.removeClass('animating');
                            subitem.addClass('visible');
                        }
                    });
                }
            });

            function close() {
                subitem.addClass('animating');
                subitem.removeClass('visible');

                subitem.find('.item').animate({
                    'opacity': 0
                }, {
                    duration: 50,
                    queue: true
                });

                subitem.animate({
                    'width': 0,
                    'height': 0
                }, {
                    'duration': 200,
                    'queue': true,
                    complete: function () {
                        subitem.removeClass('animating');
                        subitem.addClass('hidden');

                        subitem.css({
                            'width': width,
                            'height': height,
                            'display': 'none'
                        });
                    }
                });
            }

            $(document).on('click', function (e) {
                if (subitem.hasClass('visible') && !subitem.hasClass('animating')) {
                    close();
                }
            });
        });
    };

    $('[data-toggle]').menu();
    $('[data-subitem]').accordion();
})(jQuery);