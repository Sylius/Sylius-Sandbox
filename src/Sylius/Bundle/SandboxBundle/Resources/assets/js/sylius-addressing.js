/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
; // Temporary fix for live environment
(function ( $ ) {
    $(document).ready(function() {
        $("select.country-select").each(function () {
            var $this = $(this);

            $this.on('change', function() {
                provinceContainer = $('div.province-container');

                $.get(provinceContainer.attr('data-url'), {countryId: $this.val()}, function (response) {
                    if (!response.content) {
                        provinceContainer.fadeOut('slow', function () {
                            provinceContainer.html('');
                        });
                    } else {
                        provinceContainer.fadeOut('slow', function () {
                            provinceContainer.html(response.content.replace('name="sylius_addressing_address_province"', 'name="sylius_addressing_address[province]"'));
                            provinceContainer.fadeIn();
                        });
                    }
                });
            });
        });

        if($.trim($('div.province-container').text()) === '') {
            $("select.country-select").trigger("change");
        }
    });
})( jQuery );

