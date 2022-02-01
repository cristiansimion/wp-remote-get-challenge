(function ($) {
    // Promisify requests
    $.requestHandler = function (_this) {
        _this.request = ($action, $data) => {
            /** Send AJAX request **/
            const data = {
                'action': $action,
                'data': $data,
                'security_action': ajax_object.ajax_security
            };

            const sendingData = {
                'type': 'POST',
                'url': ajax_object.ajax_url,
                'data': data
            };

            return Promise.resolve($.ajax(sendingData));
        };

        _this.getFormData = function ($form) {
            const unindexed_array = $form.serializeArray();
            const indexed_array = {};

            $.map(unindexed_array, function (n, i) {
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        };
    }
}(jQuery));