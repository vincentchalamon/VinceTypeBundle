/**
 * Author: Vincent Chalamon <vincentchalamon@gmail.com>
 */
(function ($) {
    $.listInput = function (element, options) {
        var defaults = {
            separator: ','
        }

        var plugin      = this;
        plugin.settings = {}

        plugin.init = function () {
            plugin.settings = $.extend({}, defaults, options);

            $('<ul>').addClass('listInput')
                .append($('<li>').addClass('input')
                    .append($('<input>', {type: 'text'}).on('keyup', function (event) {
                        if (event.which == 188 && $.trim($(this).val().substring(0, $.trim($(this).val()).length-1))) {
                            plugin.add($.trim($(this).val().substring(0, $.trim($(this).val()).length-1)));
                            $(this).val('');
                        }
                        if (event.which == 13 && $.trim($(this).val())) {
                            plugin.add($.trim($(this).val()));
                            $(this).val('');
                        }
                        if (event.which == 8) {
                            if ($('li.selected', $(this).closest('.listInput')).length) {
                                $('li.selected a', $(this).closest('.listInput')).trigger('click');
                            } else {
                                $('li:not(.input):last', $(this).closest('.listInput')).addClass('selected');
                            }
                        }
                    }).on('focus', function () {
                        $('li.selected', $(this).closest('.listInput')).removeClass('event');
                    }))
                ).insertBefore($(element)).width($(element).width());

            $.each($(element).val().split(plugin.settings.separator), function (key, value) {
                if ($.trim(value)) {
                    plugin.add(value);
                }
            });

            $(element).hide();
        }

        plugin.add = function (value) {
            $('<li>').append($('<span>').text($.trim(value)))
                .append($('<a>', {href: '#'}).text('×').on('click', function (event) {
                    event.preventDefault();
                    $(this).closest('li').remove();
                })).insertBefore($('li.input', $(element).prev('ul.listInput')));
        }

        plugin.init();
    }

    $.fn.listInput = function (options) {
        return this.each(function () {
            if (undefined == $(this).data('listInput')) {
                var plugin = new $.listInput(this, options);
                $(this).data('listInput', plugin);
            }
        });
    }
})(jQuery);