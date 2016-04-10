(function ($) {

    "use strict";

    $(document).ready(function() {
        $('#test-connection-modal').on('shown.bs.modal', function (event) {
            var modalBody = $(this).find('.modal-body');

            $.ajax({
                url: $(event.relatedTarget).data('test-url')
            }).done(function (data) {
                modalBody.html(data);
            }).fail(function (jqXHR, textStatus) {
                modalBody.html('<p class="error">Erreur de Traitement : Error ' + textStatus + '</p>');
            });
        });

        $('#test-connection-modal').on('hide.bs.modal', function () {
            $(this).find('.modal-body').html('<p>Veuillez patienter</p>');
        });
    });
})(jQuery);