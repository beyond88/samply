;(function($) {

    $('table.wp-list-table.contacts').on('click', 'a.submitdelete', function(e) {
        e.preventDefault();

        if (!confirm(samply.confirm)) {
            return;
        }

        var self = $(this),
            id = self.data('id');

        wp.ajax.post('samply-delete-contact', {
            id: id,
            _wpnonce: samply.nonce
        })
        .done(function(response) {

            self.closest('tr')
                .css('background-color', 'red')
                .hide(400, function() {
                    $(this).remove();
                });

        })
        .fail(function() {
            alert(samply.error);
        });
    });

})(jQuery);
