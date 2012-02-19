/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$(document).ready(function () {
  $("a.confirmer").each(function () {
    $(this).data('confirmerLink', this.href);
    this.href = null;

    $(this).click(function () {
      $("#confirmer-modal").modal('show');
      $("#confirmer-modal p.confirmer-modal-question").html($(this).data('confirmerQuestion'));
      $("#confirmer-modal a.confirmer-modal-confirm").attr('href', $(this).data('confirmerLink'));
    });
  });
});
