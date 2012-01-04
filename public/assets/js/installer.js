/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$(document).ready(function() {
  $("#generate-secret-btn").click(function () {
    var result = '';
    for (i=0; i < 32; i++) {
      result += Math.round(Math.random()*16).toString(16);
    }

    $('#sylius_sandbox_installer_parameters_secret').val(result);
  });
});
