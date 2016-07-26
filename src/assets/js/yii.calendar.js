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
        onClick: undefined
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
                    .off('click.yiiCalendar', settings.itemSelector)
                    .on('click.yiiCalendar', settings.itemSelector, function (event) {
                        if (settings.onClick === undefined) {
                            return;
                        }
                        event.preventDefault();
                        var item = $(this);
                        var isActive = item.hasClass('active');
                        if (!isActive) {
                            return;
                        }
                        var date = item.attr('data-cal-date');
                        if (!date) {
                            console.warn("data-cal-date attribute is not set");
                            return;
                        }
                        var parts = date.split(' ');
                        date = parts[0];
                        var time = parts[1] || undefined;
                        settings.onClick(date, time);
                    });
            });
        }
    };
})(window.jQuery);
