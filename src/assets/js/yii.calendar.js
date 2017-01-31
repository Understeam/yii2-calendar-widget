(function ($) {
    $.fn.yiiCalendar = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.yiiCalendar');
            return false;
        }
    };

    var defaults = {
        itemSelector: '[data-cal-date]',
        futureClass: 'future',
        pastClass: 'past',
        activeClass: 'active',
        hoverClass: 'hover',
        onClick: undefined,
        onFutureClick: undefined,
        onPastClick: undefined
    };

    var calendarData = {};

    var methods = {
        init: function (options) {
            return this.each(function () {
                var $e = $(this);
                var settings = $.extend({}, defaults, options || {});
                var id = $e.attr('id');
                if (calendarData[id] === undefined) {
                    calendarData[id] = {};
                }

                calendarData[id] = $.extend(calendarData[id], {settings: settings});

                $(document)
                    .off('mouseover.yiiCalendar', settings.itemSelector)
                    .off('mouseleave.yiiCalendar', settings.itemSelector)
                    .off('click.yiiCalendar', settings.itemSelector)
                    .on('mouseover.yiiCalendar', settings.itemSelector, function (event) {
                        var item = $(this);
                        if (
                            item.hasClass(settings.activeClass)
                            ||
                            (typeof settings.onPastClick == 'function' && item.hasClass(settings.pastClass))
                            ||
                            (typeof settings.onFutureClick == 'function' && item.hasClass(settings.futureClass))
                        ) {
                            item.addClass(settings.hoverClass);
                            item.css('cursor', 'pointer');
                        }
                    })
                    .on('mouseleave.yiiCalendar', settings.itemSelector, function (event) {
                        var item = $(this);
                        item.removeClass(settings.hoverClass);
                        item.css('cursor', false);
                    })
                    .on('click.yiiCalendar', settings.itemSelector, function (event) {
                        event.preventDefault();
                        var item = $(this);
                        var date = item.attr('data-cal-date'); 
						var time = item.attr('data-cal-time') || undefined;
                        
                        if (!date) {
                            console.warn("data-cal-date attribute is not set");
                            return;
                        }
                       
                        if (typeof settings.onClick == 'function' && item.hasClass(settings.activeClass)) {
                            settings.onClick(date, time);
                        } else if (typeof settings.onFutureClick == 'function' && item.hasClass(settings.futureClass)) {
                            settings.onFutureClick(date, time);
                        } else if (typeof settings.onPastClick == 'function' && item.hasClass(settings.pastClass)) {
                            settings.onPastClick(date, time);
                        }
                    });
            });
        }
    };
})(window.jQuery);
