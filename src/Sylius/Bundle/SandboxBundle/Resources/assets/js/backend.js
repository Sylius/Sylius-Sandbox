/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
(function ( $ ) {
    $(document).ready(function() {
        $("a.confirmer").each(function () {
            $(this).data('confirmerLink', this.href);
            $(this).click(function (e) {
                e.preventDefault();
                $("#confirmer-modal").modal('show');
                $("#confirmer-modal p.confirmer-modal-question").html($(this).data('confirmerQuestion'));
                $("#confirmer-modal a.confirmer-modal-confirm").attr('href', $(this).data('confirmerLink'));
            });
        });

        $("a.collection-add-btn").each(function () {
            var $this = $(this);

            $this.on('click', function () {
                addCollectionItem($this.data('collection'));
            });
        });
        $("a.collection-remove-btn").each(function () {
            var $this = $(this);

            $this.on('click', function () {
                removeCollectionItem($this);
            });
        });
    });

    function addCollectionItem(name) {
        var $collectionContainer = $("#" + name);
        var prototype = $collectionContainer.attr('data-prototype');
        var item = prototype.replace(/__name__/g, $collectionContainer.children().length);
        $collectionContainer.append(item);
    }

    function removeCollectionItem(btn) {
        btn.closest('collection-item').remove();
    }
})( jQuery );
