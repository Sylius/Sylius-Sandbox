
/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
(function ($) {
    $(document).ready(function() {
        $('#sylius_shipping_method_calculator').handlePrototypes();
    });
})( jQuery );

(function ($) {
    var methods = {
        init: function(options) {
            return this.each(function() {
                show($(this), false);
                $(this).change(function() {
                    show($(this), true);
                });

                function show(element, replace) {
                    var id = element.attr('id');
                    var selectedValue = element.val();
                    var prototypeElement = $('#' + id + '_' + selectedValue);
                    var container = $(prototypeElement.data('container'));

                    if (replace) {
                        container.html('<hr />' + prototypeElement.data('prototype'));
                    } else if (!container.html().trim()) {
                        container.html('<hr />' + prototypeElement.data('prototype'));
                    }
                };
            });
        }
    };

    $.fn.handlePrototypes = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.handlePrototypes' );
        }
    };
})(jQuery);
