jQuery(function ($) {
    const ajax = this;

    // Set the request handler
    $.requestHandler(ajax);

    const ajaxContainer = $('.cwremote-ajax');

    if (ajaxContainer.length) {
        $(window).load(async function () {
            const request = await ajax.request('get_entries', []);
            $('.cwremote-ajax').html(request.data);
        });
    }

    $('.cwremote-fetch-force').on('click', async function (e) {
        e.preventDefault();

        $(this).off('click');
        $(this).html('Refreshing...').attr('disabled', 'disabled');

        await ajax.request('get_entries', {force: true});
        window.location.reload();
    })
});